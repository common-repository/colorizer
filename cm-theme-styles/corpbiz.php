<?php
/**
 * Theme: corpbiz
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
					'text',
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
		
		$cm_color_sample[3] => array(
			'label' => __( 'Text Color', 'colorizer' ),
			'default' => '#000',
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
					
function mm_cm_get_color_scheme_css( $colors ) {


	$css = <<<CSS
	/* Color Scheme */
	
	
	.home {
		background: {$colors['outer_background']};
		}
		
	#menu-header, #main-header{
		background: {$colors['inner_background']};
		}
	.navbar .navbar-nav > li > a{
		color: {$colors['text']};
	}
	.service_heading_title h1, .corpo_heading_title h1 {
		color: {$colors['text']};
	}
	
CSS;
    
	return $css;
	
}


