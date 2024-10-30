<?php
/**
 * Theme: Default
 * 
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

add_action( 'customize_register', 'm_cm_customizer_setup' , 13); //important: priority of hook here MUST be lower then the
																 //priority of same action hook defind in main file mm-cm-customizer.php 	
function m_cm_customizer_setup($wp_customize){

/**
 * Class to create a custom  control
 */

class cm_theme_support_message extends WP_Customize_Control 
{
	public $type = 'text';
	public function __construct($manager, $id, $args = array()) {
		parent::__construct($manager, $id, $args);
	}
	
	public function render_content() {
		?>
		<div style = "border:1px solid black; padding-left:2px">
		<span >
		 <em><strong>Note:Colorizer is not yet tested with your theme therefore might not give desired result.</em></strong>
		 <!--<a href = "http://charmeem.com/request" target = "_blank">
		  Click here and send request to test and add your theme.
		  <br><br>
		 </a>
		 -->
		</span>
		</div>
		<?php
	}
}


// Add color scheme setting and control.
	$wp_customize->add_setting('notice', array(
		'default'           => '',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control(	
		new cm_theme_support_message(
			$wp_customize,
			'notice', array(
				'label' => __( 'notice', 'mm_cm' ),
				//'type'  => 'text',
				'section'  => 'colors',
				'settings' => 'notice',
				'priority' => 0,  // to give notice top place in the section
	 ) ) );
}
					
function mm_cm_get_color_scheme_css( $colors ) {


	$css = <<<CSS
	/* Color Scheme */
	
	
	body, body.custom-background,#secondary, .header-main {
		background: {$colors['outer_background']};
		}
		
	.post {
		background: {$colors['box_background']};
		color: {$colors['text']};
	}
	.nav-menu {
		background: {$colors['text']};
	}
	.nav-menu li a{
		color: {$colors['sidebar']};
	}
	
	.site-title,.site-description { 
		color: {$colors['header_textcolor']};
	}
	
CSS;
    
	return $css;
	
}


