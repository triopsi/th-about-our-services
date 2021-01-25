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

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 
/* Delete plugin options */
$option_version = 'thaos_plugin_version';
$option_setting_main_color = 'thaos_setting_main_color';
$option_setting_border_color_hover = 'thaos_setting_border_color_hover';
$option_settings_cdn = 'thaos_settings_cdn_awesome';

delete_option($option_version);
delete_site_option($option_version);

delete_option($option_setting_main_color);
delete_site_option($option_setting_main_color);

delete_option($option_setting_border_color_hover);
delete_site_option($option_setting_border_color_hover);

delete_option($option_settings_cdn);
delete_site_option($option_settings_cdn);

// Delete metadata and posts
$post_type_arg = array('post_type' => 'thaos', 'posts_per_page' => -1);
$getpostsentries = get_posts($post_type_arg);
foreach ($getpostsentries as $post) {
	wp_delete_post($post->ID, true);
}

