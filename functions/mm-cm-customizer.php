<?php

		
/**
 * mm_cm plugin Customizer Main File
 * This plugin is tested on Twenty twelve, Twenty thirteen, Twenty fourteen, Graphy and Customizr themes
 */
 
/**
 * Detects current theme
 * 
 * Check active theme and include  theme style file
 *
 * @package colorizer
 * @since 1.0
 * @uses wp_get_theme() To fetche information about the active theme
 */
	 
function mm_cm_check_theme() {

	$current_theme = wp_get_theme();

	$theme_name = $current_theme->get( 'Name' );
	$theme_name = strtolower( $theme_name );
		
	$theme_name = str_replace( ' ', '-', $theme_name );//replace space in theme name with '-'
		
	return $theme_name;
}

add_action( 'after_setup_theme', 'mm_cm_include_file' ); 		
function mm_cm_include_file() {
	
	$cm_theme_name = mm_cm_check_theme();

	$file = plugin_dir_path( __FILE__ ) . '../cm-theme-styles/' . $cm_theme_name . '.php';
	// if there's no template file for the current theme then load the default
	if ( ! file_exists( $file ) ) {
		$file = plugin_dir_path( __FILE__ ) . '../cm-theme-styles/default.php';
	}

	include( $file );
		
	}

  
/**
 * Setting UI for the Customizer 
 *
 * Create settings and control UI for the Customizer
 * Modifies parameters for some existing controls
 * Bypasses setup in case of Theme 'customizr'
 * 
 * @ uses wp_get_theme()  To check if theme is not 'customizr'
 * @ uses mm_cm_get_color_scheme()   Get the current color scheme
 * @ uses get_setting()   A function that fetches names of setting/control UI from a separate theme file
 * @ 
 * @since Colorizer 1.1
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
add_action( 'customize_register', 'mm_cm_customizer_setup' , 11);
function mm_cm_customizer_setup( $wp_customize ) {
	
	$cm_theme_name = mm_cm_check_theme();
		
	if ( $cm_theme_name !== 'customizr')
			// Adaptation for Theme 'customizr' which has its own customize function  in a separate theme file
	
	$wp_customize->get_setting( 'blogname' )		 ->transport  = 'postMessage'; // Changing to fast preview
	$wp_customize->get_setting( 'blogdescription' )  ->transport  = 'postMessage'; //   '''''
	$wp_customize->get_section( 'colors' )           ->title      = 'Colorizer'; // Changing name of Section 'colors' to 'colorizer'
	$wp_customize->remove_control( 'background_color' ); // Remove the core background control UI from all the themes
		
	// Add color scheme setting and control.
	$wp_customize->add_setting( 'color_scheme', array(
		'default'           => 'default',
		'sanitize_callback' => 'mm_cm_sanitize_color_scheme',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'color_scheme', array(
		'label'    => __( 'Base Color Scheme', 'mm_cm' ),
		'section'  => 'colors',
		'type'     => 'select',
		'choices'  =>  mm_cm_get_color_scheme_choices(),
		'priority' => 1,
	) );
	
	$settings =  get_setting(); // A function defined below 
	
	if ( $settings ) {
		// include custom controls if any
		//include_once( 'custom-controls.php' );
		$priority = 30;
		
		if ( ! empty( $settings[ 'colors' ] ) ) {
			foreach( $settings[ 'colors' ] as $key => $color ) {
			
				$wp_customize->add_setting( $key, array(
					'default' => $color[ 'default' ],
					'capability' => 'edit_theme_options',
					'transport' => 'postMessage', // change to postMessage if using js
					'sanitize_callback' => 'colorizer_sanitize_hex_color', // function defined in helper.php file
					) );
				$wp_customize->add_control(
					new WP_Customize_Color_Control(
					$wp_customize,
					$key,
					array(
					'label' => __($color[ 'label' ]),
					'section' => 'colors',
					'settings' => $key,
					'priority' => $priority,
						)
					)
				);

					$priority ++;
			}
		}
	}
	if ( $cm_theme_name == 'graphy') {
		$wp_customize->get_setting( 'graphy_link_color' )->transport  = 'postMessage'; // for graphy theme
		$wp_customize->remove_control( 'graphy_link_hover_color' ); // remove buit in Graphy control UI
		//$wp_customize->remove_control( 'inner_background' );
	}
		// modifications for twentythirteen and fourteen themes
		 if ( $cm_theme_name == 'twenty-fourteen') {
			$wp_customize->get_control( 'inner_background' )	->label = 'Post divider color';	//Twenty Fourteen
		}
		if ( $cm_theme_name == 'twenty-thirteen') {
			$wp_customize->remove_control( 'outer_background' );								//Twenty thirteen
		}
	 	
	} // end of function	
	


/**
 * Register color schemes for Colorizer.
 *
 * Can be filtered with {@see 'mm_cm_color_schemes'}.
 *
 * The order of colors in a colors array:
 * 1. Inner Background Color.
 * 2. Outer Background Color.
 * 3. Box Background Color.
 * 4. Main Text and Link Color.
 * 5. Header Text.
 * 6. Sidebar Color.
 *
 * @since Colorizer 1.0
 *
 * @return array An associative array of color scheme options.
 */
function mm_cm_get_color_schemes() {
	return apply_filters( 'mm_cm_color_schemes', array(
		'default' => array(
			'label'  => __( 'Default', 'mm_cm' ),
			'colors' => array(
				'#f1f1f1',
				'#ffffff',
				'#ffffff',
				'#333333',
				'#333333',
				'#f7f7f7',
			),
		),
		'dark'    => array(
			'label'  => __( 'Dark', 'mm_cm' ),
			'colors' => array(
				'#111111',
				'#202020',
				'#202020',
				'#bebebe',
				'#bebebe',
				'#1b1b1b',
			),
		),
		'yellow'  => array(
			'label'  => __( 'Yellow', 'mm_cm' ),
			'colors' => array(
				'#f4ca16',
				'#ffdf00',
				'#ffffff',
				'#111111',
				'#111111',
				'#f1f1f1',
			),
		),
		'pink'    => array(
			'label'  => __( 'Pink', 'mm_cm' ),
			'colors' => array(
				'#ffe5d1',
				'#e53b51',
				'#ffffff',
				'#352712',
				'#111111',
				'#f1f1f1',
			),
		),
		'purple'  => array(
			'label'  => __( 'Purple', 'mm_cm' ),
			'colors' => array(
				'#674970',
				'#2e2256',
				'#ffffff',
				'#2e2256',
				'#ffffff',
				'#f1f1f1',
			),
		),
		'blue'   => array(
			'label'  => __( 'Blue', 'mm_cm' ),
			'colors' => array(
				'#e9f2f9',
				'#55c3dc',
				'#ffffff',
				'#22313f',
				'#111111',
				'#f1f1f1',
			),
		),
	) );
}

if ( ! function_exists( 'mm_cm_get_color_scheme' ) ) :
/**
 * Get current color scheme from control UI.
 *
 * @uses get_theme_mod()            To fetch option value stored for color_scheme
 * @uses mm_cm_get_color_schemes    Fetches colors array for the selected color_scheme option
 * @return $color_schemes           Returns colors array for the selected option
 *
 * @since mm_cm 1.0
 *
 * @return array An associative array of either the current or default color scheme hex values.
 */
function mm_cm_get_color_scheme() {
	$color_scheme_option = get_theme_mod( 'color_scheme', 'default' );// fetches setting value from control panel
		
	$color_schemes =  mm_cm_get_color_schemes();
	
	if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
	return $color_schemes[ $color_scheme_option ]['colors'];
		
	}
	
	return $color_schemes['default']['colors'];
}
endif; // mm_cm_get_color_scheme


if ( ! function_exists( 'mm_cm_get_color_scheme_choices' ) ) :
/**
 * Returns an array of color scheme choices registered for Colorizer.
 *
 * @since Colorizer 1.0
 *
 * @return array Array of color schemes.
 */
function mm_cm_get_color_scheme_choices() {
	$color_schemes =  mm_cm_get_color_schemes();
	$color_scheme_control_options = array();

	foreach ( $color_schemes as $color_scheme => $value ) {
		$color_scheme_control_options[ $color_scheme ] = $value['label'];
	}
	
	return $color_scheme_control_options;
}
endif; // mm_cm_get_color_scheme_choices

if ( ! function_exists( 'mm_cm_sanitize_color_scheme' ) ) :
/**
 * Sanitization callback for color schemes.
 *
 * @since Colorizer 1.0
 *
 * @param string $value Color scheme name value.
 * @return string Color scheme name.
 */
function mm_cm_sanitize_color_scheme( $value ) {
	$color_schemes = mm_cm_get_color_scheme_choices();

	if ( ! array_key_exists( $value, $color_schemes ) ) {
		$value = 'default';
	}

	return $value;
}
endif; // mm_cm_sanitize_color_scheme



/**
 * Enqueues front-end CSS for color scheme.
 * Triggers during page reload
 * @since colorizer  1.0
 *
 * @uses mm_cm_get_color_scheme()	 	To fetch color scheme option
 * @uses mm_cm_get_color_scheme_css() 	A function defined in separate theme file to create CSS
 * @uses wp_enqueue_style   			Enqueues CSS file from the active theme
 * @uses wp_add_inline_style   			Enqueues additional CSS style for color scheme control UI
 * @param global $cm_color_sample 		Color scheme array defined in external theme file
 * @param $colors 						An associative array to be used in creating CSS
 *
 */

function mm_cm_color_scheme_css() {

global $cm_color_sample;

	$color_scheme = mm_cm_get_color_scheme();
	$colors = array_combine($cm_color_sample,$color_scheme); // Combines two index arrays to form one associative array.
	
	$color_scheme_css = mm_cm_get_color_scheme_css( $colors );
	
	wp_enqueue_style( 'mm_cm-style', get_stylesheet_uri() );
	
	//Adding extra CSS on top of default CSS of the current theme.
	wp_add_inline_style( 'mm_cm-style', $color_scheme_css );
	
}
add_action( 'wp_enqueue_scripts', 'mm_cm_color_scheme_css', 888 );
	
/**
 * Enqueues front-end CSS for other control elements UI.
 * Triggers during page reload
 * @since Colorizer 1.0
 *
 * @uses get_theme_mod()	 			A WP function to fetch values from control UI
 * @uses mm_cm_get_color_scheme_css() 	A function defined in separate theme file to create CSS
 * @uses wp_enqueue_style   			Enqueues CSS file to give additional style touches to all the tested themes
 * @uses wp_add_inline_style   			Enqueues additional CSS style for other control UIs 
 * @param global $cm_color_setting 		Other control element array defined in separate theme file
 */
 
function mm_cm_other_controls_css() {

global $cm_color_setting;  // custom global var defined in theme file
foreach ($cm_color_setting as $setting) {
	$colors[$setting] = get_theme_mod ($setting, 'default');
	}
	
	$color_scheme_css = mm_cm_get_color_scheme_css( $colors );
    
	//Adding some additional paddings. important to give unique name
	wp_enqueue_style( 'more-style', plugins_url('../styles/cm-colorizer.css', __FILE__) );
	
	//Adding extra CSS on top of default CSS of the current theme.
	wp_add_inline_style( 'mm_cm-style', $color_scheme_css );
	
}
add_action( 'wp_enqueue_scripts', 'mm_cm_other_controls_css', 999 );	

/**
 * Binds JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as colorScheme global.
 *
 * @uses wp_enqueue_script	 Enqueues js file
 * @uses wp_localize_script	 Creates an object that is used to transfer php data to Java script 
 * @since Colorizer 1.0
 */
function mm_cm_customize_control_js() {
	
	wp_enqueue_script( 'color-scheme-control', plugins_url('../js/cm-color-scheme-control.js', __FILE__), array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '20141216', true);
	wp_localize_script( 'color-scheme-control', 'colorScheme',  mm_cm_get_color_schemes() );
	
	global $cm_color_setting, $cm_color_sample ;
	
	wp_localize_script( 'color-scheme-control', 'colorSetting',  $cm_color_setting );
	wp_localize_script( 'color-scheme-control', 'colorSample',  $cm_color_sample );
	
	//wp_localize_script is used to transfer data from php file into javascript file.
	// here colorScheme is new object created while its parametres are fetched from mm_cm-get_color_schemes
}
add_action( 'customize_controls_enqueue_scripts', 'mm_cm_customize_control_js');

/**
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 * @ uses wp_enqueue_script
 * @since Colorizer 1.0
 */
function mm_cm_customize_preview_js() {
	
	wp_enqueue_script( 'color-scheme-control', plugins_url('../js/cm-customize-preview.js', __FILE__), array( 'customize-preview' ), '20141216', true);

	}
add_action( 'customize_preview_init', 'mm_cm_customize_preview_js' );



/**
 * get name of setting/controls to be used in customizer UI from the file in theme-styles directory
 * @uses get_theme_support()  Fetches color element from array defined by add_theme_support in respective theme file
 * @param string $key
 */
	function get_setting( $key = null ) {

		$settings = get_theme_support( 'colorizer' );
		if ( isset( $settings[0] ) ) {
			$settings = $settings[0];
		
		}
		
		// check request for key
		if ( null !== $key ) {
		
			if ( isset( $settings[ $key ] ) ) {
				return $settings[ $key ];
			} else {
				return false;
			}
		}

		return $settings;

	}

	
	
/**
 * Output an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the Customizer preview
 * 
 *
 * @since Colorizer 1.0
 */
function mm_cm_color_scheme_css_template() {

	$settings =  get_setting();
	$colors = $settings['template']; // I have customized the theme style by moving the templete array into
									// respective theme file , e.g. in twenty-twelve.php
	
	
	?>
	<script type="text/html" id="tmpl-mm-cm-color-scheme">
		<?php echo  mm_cm_get_color_scheme_css( $colors ); ?>
	</script>
		
	<?php
	
}
add_action( 'customize_controls_print_footer_scripts', 'mm_cm_color_scheme_css_template' );
// This is an action hook defined in wp-admin/customize.php

	