<?php
/*
 * Theme: Twenty Twelve
 */
 
global $cm_color_sample;  // corresponds to color scheme control UI object
global $cm_color_setting; // corresponds to other control UI objects

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
					'header_textcolor', //this control is already included in the theme by default
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
					
function mm_cm_get_color_scheme_css( $colors ) {

	$css = <<<CSS
	/* Color Scheme */
		
	body.custom-background {
		background: {$colors['outer_background']};
		}
		
	.site {
		background: {$colors['inner_background']};
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
		
	aa {
		color: {$colors['box_background']};
	}
	aa:hover {
		color: {$colors['box_background']};
	}
	.main-navigation li a:hover{
		color: {$colors['outer_background']};
	}
	
CSS;
   
	return $css;

}



