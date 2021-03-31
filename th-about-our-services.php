<?php
/**
 * Plugin Name: About our services
 * Plugin URI: https://www.wiki.profoxi.de
 * Description: A simple about our services plugin. Create items and copy-paste the shortcode everywhere in your post or site.
 * Version: 1.1.0
 * Author: triopsi
 * Author URI: http://wiki.profoxi.de
 * Text Domain: thaos
 * Domain Path: /lang/
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl-3.0
 *
 * Thaos is free software: you can redistribute it and/or modify
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
 *
 * @package thaos
 * @version 1.0.0
 **/

// Definie plugin version.
if ( ! defined( 'THAOS_VERSION' ) ) {
	define( 'THAOS_VERSION', '1.1.0' );
}

// Loads plugin's text domain.
add_action( 'init', 'thaos_load_plugin_textdomain' );

// Admin.
require_once 'inc/thaos-admin.php';
require_once 'inc/thaos-types.php';
require_once 'inc/thaos-post-metabox.php';
require_once 'inc/thaos-settings.php';
require_once 'inc/thaos-help.php';

// Shortcode.
require_once 'inc/thaos-user.php';
require_once 'inc/thaos-shortcode.php';

/**
 * Init Script. Load languages
 *
 * @return void
 */
function thaos_load_plugin_textdomain() {
	load_plugin_textdomain( 'thaos', '', 'th-about-our-services/lang/' );
}
