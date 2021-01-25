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

/**
 * Version Check
 *
 * @return void
 */
function thaos_check_version() {
  if (thaos_VERSION !== get_option('thaos_plugin_version'))
  thaos_activation();
}

/* Loaded Plugin */
add_action('plugins_loaded', 'thaos_check_version');

/* Add Admin panel */
add_action( 'admin_enqueue_scripts', 'add_admin_thaos_style_js' );

/**
 * Undocumented function
 *
 * @return void
 */
function add_admin_thaos_style_js() {

  /* Gets the post type. */
  global $post_type;

  if( 'thaos' == $post_type ) {

    //Remove Attachment/Media Button
    remove_action('media_buttons', 'media_buttons');

    /* CSS for metaboxes. */
    wp_enqueue_style( 'thaos_admin_styles', plugins_url('../assets/css/editor-admin.css', __FILE__));

    /* WP color picker Style and scripts */
    wp_enqueue_style( 'wp-color-picker' );

    /* Add all JS, CSS and settings for the media js */
    wp_enqueue_media();

    /* JS for metaboxes */
    wp_enqueue_script( 'logic-form', plugins_url('../assets/js/logic-form.js', __FILE__));

    /* Font Awesome */
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.css', __FILE__);
    
  }else{
    
    /* CSS for metaboxes. */
    wp_enqueue_style( 'thaos_admin_styles', plugins_url('../assets/css/editor-admin.css', __FILE__));   

    /* Color JS */
    wp_enqueue_script( 'thaos-admin-script-color', plugins_url('../assets/js/thaos-admin-script-color.js', __FILE__), array( 'jquery', 'wp-color-picker'  ) );
  }

}

/**
 * Update Version Number
 *
 * @return void
 */
function thaos_activation(){
  update_option('thaos_plugin_version', thaos_VERSION);
}