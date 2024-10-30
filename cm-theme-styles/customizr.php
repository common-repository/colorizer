<?php
/*
 * Theme: Customizr
 */
 
global $cm_color_sample;
global $cm_color_setting;

 $cm_color_sample = array(					// 6 colors of Color Scheme in control panel
					'inner_background',
					'outer_background',
					'box_background',
					'text',
					'header_textcolor',
					'sidebar',
					);
 $cm_color_setting = array(                // other control elements in customizer panel
					'inner_background',
					'outer_background',
					'box_background',
					);

add_theme_support( 'colorizer', array( 
	'colors' => array(// these are the control elements that will be displayed on customizer front Panel other then color Scheme
		$cm_color_sample[0] => array( 
			'label' => __( 'Inner Background', 'colorizer' ),
			'default' => '#21759b',
		),
		$cm_color_sample[1] => array(
			'label' => __( 'Outer Background', 'colorizer' ),
			'default' => '#26b5b0',
		),
		$cm_color_sample[2] => array(
			'label' => __( 'Post background', 'colorizer' ),
			'default' => '#2cd6d6',
		),
	),
	'template' => array(
		$cm_color_sample[0] => '{{ data.inner_background }}',
		$cm_color_sample[1] => '{{ data.outer_background}}',
		$cm_color_sample[2] => '{{ data.box_background }}',
		$cm_color_sample[3] => '{{ data.text }}',
		$cm_color_sample[4] => '{{ data.header_textcolor }}',
		$cm_color_sample[5] => '{{ data.sidebar }}',		
		),

) );

/* adding color SECTION in Customizr Theme Panel
 */

add_action( 'customize_register', 'mm_cm_customizr_setup' , 999);	
//IMPORTANT: This priority must be lower then rest of register functions defined elsewhere
 
function mm_cm_customizr_setup( $wp_customize ) {

$wp_customize->add_section( 'colors' , array(
		'title'		=> __( 'Colorizer' ),
		'priority' 	=> 90,
		'panel'   	=> '',
) );

$wp_customize->add_setting( 'color_scheme', array(
		'default'           => 'default',
		'sanitize_callback' => 'mm_cm_sanitize_color_scheme',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'color_scheme', array(
		'label'    => __( 'Base Color Scheme', 'charmeem' ),
		'section'  => 'colors',
		'type'     => 'select',
		'choices'  =>  mm_cm_get_color_scheme_choices(),
		'priority' => 1,
	) );
	
	$settings =  get_setting(); // A function defined below that fetches the settings of current theme
	                                   // from respective file in theme-styles directory
	
		if ( $settings ) {

			$priority = 90;
			
			if ( ! empty( $settings[ 'colors' ] ) ) {

			
				/**
				 * loop through colour keys defined in respective theme file
				 * add additional color controls from 'add_theme_support' function in respective theme file 
				 */
				 
				foreach( $settings[ 'colors' ] as $key => $color ) {
			
			//var_dump($key);		
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
} //End function 'mm_cm_customizr_setup'
					
function mm_cm_get_color_scheme_css( $colors ) {


	$css = <<<CSS
	/* Color Scheme */
	
	
	.tc-header {
		background: {$colors['outer_background']};
		}
		
	.container {
		background: {$colors['inner_background']};
		}
	
	.post {
		background: {$colors['box_background']};
		color: {$colors['text']};
	}
	.site-title {
		color: {$colors['header_textcolor']};
	}
	
	 
CSS;
    //var_dump($css);
	return $css;
	
}



