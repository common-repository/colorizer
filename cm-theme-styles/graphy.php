<?php
/**
 * Theme: graphy
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
					'graphy_link_color',
					'box_background',
					'header_textcolor',
					//'graphy_link_hover_color',
					);

add_theme_support( 'colorizer', array( 
	'colors' => array(// these are the control elements that will be displayed on customizer front Panel other then color Scheme
		$cm_color_sample[0] => array( 
			'label' => __( 'Inner Background', 'colorizer' ),
			'default' => '#21759b',
		),
		$cm_color_sample[2] => array(
			'label' => __( 'Post background', 'colorizer' ),
			'default' => '#2cd6d6',
		),
		$cm_color_sample[4] => array( 
			'label' => __( 'Header color', 'colorizer' ),
			'default' => '#111111',
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
	
	
	body, body.custom-background,.site {
		background: {$colors['inner_background']};
		}
	.site-title, .menu li a {
		color: {$colors['header_textcolor']};
		}
	.post {
		background: {$colors['box_background']};
		color: {$colors['header_textcolor']};
	}
	.nav-menu {
		background: {$colors['graphy_link_color']};
	}
	.nav-menu li a{
		color: {$colors['graphy_link_color']};
	}
	aa {
		color: {$colors['graphy_link_color']};
	}
	aa:hover {
		color: {$colors['box_background']};
	}
	.main-navigation li a:hover{
		color: {$colors['box_background']};
	}
	 
CSS;
    
	return $css;
		
}


