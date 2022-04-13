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

/* Hooks the metabox */
add_action( 'admin_init', 'thaos_add_service', 1 );

function thaos_add_service() {
	add_meta_box(
		'thaos-service-url',
		__( 'Service details', 'thaos' ),
		'thaos_add_service_url_display',
		'thaos',
		'normal'
	);
	add_meta_box(
		'thaos-service-icon',
		__( 'Service icon', 'thaos' ),
		'thaos_add_servoice_icon_display',
		'thaos',
		'normal'
	);
}

/**
 * Show the add/edit postpage in admin
 *
 * @return void
 */
function thaos_add_service_url_display( $post ) {

	// get post meta data
	$serviceurlpageid = (int) get_post_meta( $post->ID, '_thaos_service_url_page_id', true );
	$serviceurlpostid = (int) get_post_meta( $post->ID, '_thaos_service_url_post_id', true );
	$serviceurllink   = get_post_meta( $post->ID, '_thaos_service_url_link', true );

	$serviceurlpageid = ( empty( $serviceurlpageid ) ) ? 0 : $serviceurlpageid;
	$serviceurlpostid = ( empty( $serviceurlpostid ) ) ? 0 : $serviceurlpostid;
	$serviceurllink   = ( empty( $serviceurllink ) ) ? '' : $serviceurllink;

	// Hidden field.
	wp_nonce_field( 'thaos_meta_box_nonce', 'thaos_meta_box_nonce' );

	?>
	
	<div class="thaos_field">
		<div class="thaos_field_title">
			<?php echo __( 'More information URL', 'thaos' ); ?>
		</div>
		<div class="thaos_field_title">
			<?php echo __( 'Site', 'thaos' ); ?>
		</div>
		<?php
		wp_dropdown_pages(
			array(
				'selected'          => $serviceurlpageid,
				'name'              => 'thaos_info_url_page_id',
				'show_option_none'  => __( 'Please Choose', 'thaos' ),
				'option_none_value' => 0,
				'hierarchical'      => true,
				'id'                => 'infoLinkInputId',
				'selected'          => $serviceurlpageid,
			)
		);
		?>
		<br>
		<small> - <?php echo __( 'or', 'thaos' ); ?> - </small>
		<br>
		<div class="thaos_field_title">
			<?php echo __( 'Post', 'thaos' ); ?>
		</div>
		<select name="thaos_info_url_post_id" id="page_id">
			<option value="0"><?php echo __( 'Please Choose', 'thaos' ); ?></option>
			<?php

			global $post;
			$args  = array( 'numberposts' => -1 );
			$posts = get_posts( $args );
			foreach ( $posts as $post ) :
				setup_postdata( $post );
				if ( $serviceurlpostid == $post->ID ) {
					?>
					<option value="<?php echo $post->ID; ?>" selected><?php the_title(); ?></option>
					<?php
				} else {
					?>
				<option value="<?php echo $post->ID; ?>"><?php the_title(); ?></option>
					<?php
				}
			endforeach;
			?>
		</select>
		<br>
		<small> - <?php echo __( 'or', 'thaos' ); ?> - </small>
		<br>
		<div class="thaos_field_title">
			URL
		</div>
			<input class="thaos-field regular-text" id="infoLinkInputLink" name="thaos_info_url" type="text" value="<?php echo esc_url( $serviceurllink ); ?>" placeholder="<?php echo __( 'e.g. https://example.com', 'thaos' ); ?>">
		</br>
		<em><?php echo __( 'Empty Value = No Link', 'thaos' ); ?></em>
	</div>

	<?php
}

/**
 * Show the add/edit postpage in admin
 *
 * @return void
 */
function thaos_add_servoice_icon_display( $post ) {

	// get post meta data
	$serviceicon = get_post_meta( $post->ID, '_thaos_service_icon', true );
	$serviceicon = ( empty( $serviceicon ) ) ? '' : $serviceicon;
	?>
	<div class="thaos_field">
		<div class="thaos_field_title">
			<?php echo __( 'Icon name', 'thaos' ); ?><span style="color:red;">*</span>
		</div>
		<input class="thaos-field regular-text" id="thaos-icon" name="thaos_info_icon" type="text" value="<?php echo esc_attr( $serviceicon ); ?>" placeholder="fas fa-sync">
		</br>
		<em>
		<?php
		/* translators: %s is replaced with the link */
		printf(
			__( 'By default the plugin used and needed the font awesome icon libary (%s). Choose one and copy the name in this field. Important! Without first css part (.fas).', 'thaos' ),
			'<a target="_blank" href="https://fontawesome.com/">more infos</a>'
		);
		?>
		</em>
		<br>
		<div class="thiconReview">
		</div>
		<em><span style="color:red;">*</span> <?php echo __( 'Required fields', 'thaos' ); ?></em>
	</div>

	<?php
}


/**
 * Post Data Form
 */
add_action( 'save_post', 'thaos_save_meta_box_data' );

function thaos_save_meta_box_data( $post_id ) {

	if ( ! isset( $_POST['thaos_meta_box_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['thaos_meta_box_nonce'], 'thaos_meta_box_nonce' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( isset( $_POST['post_type'] ) && 'thaos' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	if ( ! isset( $_POST['thaos_info_icon'] ) ) {
		return;
	}

	// Site Link
	$service_url_page_id = stripslashes( strip_tags( sanitize_text_field( $_POST['thaos_info_url_page_id'] ) ) );
	$service_url_post_id = stripslashes( strip_tags( sanitize_text_field( $_POST['thaos_info_url_post_id'] ) ) );
	$service_url_link    = stripslashes( strip_tags( sanitize_text_field( $_POST['thaos_info_url'] ) ) );

	if ( $service_url_page_id != 0 ) {
		update_post_meta( $post_id, '_thaos_service_url_page_id', $service_url_page_id );
		update_post_meta( $post_id, '_thaos_service_url_post_id', 0 );
		update_post_meta( $post_id, '_thaos_service_url_link', '' );
	}

	if ( $service_url_post_id != 0 ) {
		update_post_meta( $post_id, '_thaos_service_url_page_id', 0 );
		update_post_meta( $post_id, '_thaos_service_url_post_id', $service_url_post_id );
		update_post_meta( $post_id, '_thaos_service_url_link', '' );
	}

	if ( ! empty( $service_url_link ) ) {
		update_post_meta( $post_id, '_thaos_service_url_page_id', 0 );
		update_post_meta( $post_id, '_thaos_service_url_post_id', 0 );
		update_post_meta( $post_id, '_thaos_service_url_link', $service_url_link );
	}

	if ( $service_url_page_id == 0 && $service_url_post_id == 0 && empty( $service_url_link ) ) {
		update_post_meta( $post_id, '_thaos_service_url_page_id', 0 );
		update_post_meta( $post_id, '_thaos_service_url_post_id', 0 );
		update_post_meta( $post_id, '_thaos_service_url_link', '' );
	}

	// Icon
	$serviceicon = stripslashes( strip_tags( sanitize_text_field( $_POST['thaos_info_icon'] ) ) );
	update_post_meta( $post_id, '_thaos_service_icon', $serviceicon );
}
