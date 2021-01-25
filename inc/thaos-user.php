<?php
/**
* Author: triopsi
* Author URI: http://wiki.profoxi.de
* License: GPL3
* License URI: https://www.gnu.org/licenses/gpl-3.0
*
* thaos is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 2 of the License, or
* any later version.
*  
* thaos is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*  
* You should have received a copy of the GNU General Public License
* along with thaos. If not, see https://www.gnu.org/licenses/gpl-3.0.
**/

/* Add CSS Class to the front */
add_action( 'wp_enqueue_scripts', 'add_thaos_front_css', 99 );
function add_thaos_front_css() {
  wp_enqueue_style( 'thaos', plugins_url('../assets/css/front-style.css', __FILE__));
}

/* Get option - Style Font Awesome */
$option_cdn = ( empty( get_option( 'thaos_settings_cdn_awesome') ) ? 'yes' : get_option('thaos_settings_cdn_awesome') );
if( 'yes' === $option_cdn ){
    add_action( 'wp_enqueue_scripts', 'add_ththaos_cdn_font_awesome', 99 );
}

/**
 * CDN Function FOnt Awesome include
 */
function add_ththaos_cdn_font_awesome() {
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.css', __FILE__);
}