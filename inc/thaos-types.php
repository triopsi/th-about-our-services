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

/* Registers the teams post type. */
add_action( 'init', 'register_thaos_type' );

/**
 * Function about the ini of the Plugin
 *
 * @return void
 */
function register_thaos_type() {
	
  	/* Defines labels */
  	$labels = array(
		'name'               => __( 'Services', 'thaos' ),
		'singular_name'      => __( 'Service', 'thaos' ),
		'menu_name'          => __( 'Services', 'thaos' ),
		'name_admin_bar'     => __( 'Services', 'thaos' ),
		'add_new'            => __( 'Add New Service', 'thaos' ),
		'add_new_item'       => __( 'Add New Service', 'thaos' ),
		'new_item'           => __( 'New Service', 'thaos' ),
		'edit_item'          => __( 'Edit Service', 'thaos' ),
		'view_item'          => __( 'View Service', 'thaos' ),
		'all_items'          => __( 'All Services', 'thaos' ),
		'search_items'       => __( 'Search Service', 'thaos' ),
		'not_found'          => __( 'No Services found.', 'thaos' ),
		'not_found_in_trash' => __( 'No Services found in Trash.', 'thaos' )
	);

  	/* Defines permissions. */
	$args = array(
		'labels'             	=> $labels,
		'public'             	=> true,
		'publicly_queryable' 	=> false,
		'show_ui'            	=> true,
    	'show_in_admin_bar'  	=> true,
		'capability_type'    	=> 'post',
		'has_archive'        	=> false,
		'hierarchical'       	=> false,
		'supports' 				=> array( 'title', 'editor'),
		'menu_icon'          	=> 'dashicons-admin-settings',
		'query_var'             => true,
        'rewrite'               => false,
	);

  	/* Registers post type. */
	register_post_type( 'thaos', $args );  

}


/* Add update messages */
add_filter( 'post_updated_messages', 'thaos_updated_messages' );

/**
 * Update post message functions
 *
 * @param [type] $messages
 * @return void
 */
function thaos_updated_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
    $post_type_object = get_post_type_object( $post_type );
	$messages['thaos'] = array(
		1  => __( 'Service updated.', 'thaos' ),
		4  => __( 'Service updated.', 'thaos' ),
		6  => __( 'Service published.', 'thaos' ),
		7  => __( 'Services saved.', 'thaos' ),
		10 => __( 'Services draft updated.', 'thaos' )
	);

	return $messages;

}

/**
 * Shortcodestyle function
 *
 * @param [type] $column
 * @param [type] $post_id
 * @return void
 */
function thaos_custom_columns( $column, $post_id ) {
	switch ( $column ) {
	  case 'thaos_shortcode' :
		global $post;
		$slug = '' ;
		$slug = $post->post_name;
		$shortcode = '<span class="shortcode"><input type="text" onfocus="this.select();" readonly="readonly" value="[thaos servicename=&quot;'.$slug.'&quot;]" class="large-text code"></span>';
		echo $shortcode;
		break;
	}
  }
  
  /* Handles shortcode column display. */
  add_action( 'manage_thaos_posts_custom_column' , 'thaos_custom_columns', 10, 2 );



/**
 * AdminCollumnBar function
 *
 * @param [type] $columns
 * @return void
 */
function add_thaos_columns( $columns ) {
	$columns['title'] = __('Service name','thaos');
	unset( $columns['author'] );
	unset( $columns['date'] );
	return array_merge( $columns, array('thaos_shortcode' => 'Shortcode') );
  }
  
  /* Adds the shortcode column in the postslistbar */
  add_filter( 'manage_thaos_posts_columns' , 'add_thaos_columns' );