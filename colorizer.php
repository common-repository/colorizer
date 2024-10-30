<?php

/*
Plugin Name: Colorizer
Plugin URI: https://github.com/charmeem/wordpress/tree/colorizer
Description: Make your themes colourful by utilizing easy to use Customizer feature of WP. Multiple themes supports, so far tested with Customizr, twenty twelve, twentythirteen, twentyfourteen and Graphy.
Version: 1.2
Author: Mubashir Mufti
Author URI: http://www.charmeem.com
License: GPLv2 or later. 
*/

/*	
Copyright 2016  Mubashir Mufti  (email : mmufti@hotmail.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2,
as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

The license for this software can likely be found here:
http://www.gnu.org/licenses/gpl-2.0.html
If not, write to the Free Software Foundation Inc.
51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/


/********************************************
* Security for preventig direct access to files
*********************************************/
if ( !defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/********************************************
* TRANSLATION FUNCTION
*********************************************/

add_action( 'plugins_loaded', 'charmeem_colorpicker_translation' ); //Add the translation function after the plugins loaded hook.

function charmeem_colorpicker_translation() {
if ( !is_admin() ) 											//If we’re not in the admin, load any translation of our plugin.
	load_plugin_textdomain( 'charmeem-plugins', false, 'charmeem-plugins/languages' );
	
}
	
/********************************************
* GLOBAL VARIABLES
********************************************/
$plugin_version = '1.2';											// for use on admin pages
$plugin_file = plugin_basename(__FILE__);							// plugin file for reference
define( 'THEME_COLOR_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );	// define the absolute plugin path for includes

/********************************************
* INCLUDES - keeping it modular
********************************************/
include_once( THEME_COLOR_PLUGIN_PATH . 'functions/mm-cm-customizer.php' );	// Adds control settings in customizer menu
include_once( THEME_COLOR_PLUGIN_PATH . 'functions/mm-cm-helpers.php' );			// Sanitizing
?>
