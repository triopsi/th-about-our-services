<?php
/**
 * Author: triopsi
 * Author URI: http://wiki.profoxi.de
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
 * @version 1.1.0
 **/

/* Shortcode on the Page */
add_shortcode( 'thaos', 'thaos_sh' );

/**
 * Show the Shortcode in the post/site/content.
 *
 * @param Array $atts Attribute.
 * @return String HTML Output
 */
function thaos_sh( $atts ) {

	// Data of the current Post.
	global $post;

	// Shortcode Parameter.
	extract(
		shortcode_atts(
			array(
				'link_target' => 'self',
				'show_title'  => 'true',
				'orderby'     => 'date',
				'order'       => 'ASC',
				'servicename' => '',
			),
			$atts
		)
	);

	$link_target = ( 'blank' === $link_target ) ? '_blank' : '_self';
	$show_title  = ( 'false' === $show_title ) ? false : true;
	$order       = ( 'asc' === strtolower( $order ) ) ? 'ASC' : 'DESC';
	$orderby     = ! empty( $orderby ) ? $orderby : 'date';
	$servicename = ! empty( $servicename ) ? $servicename : '';

	// WP Query Parameters.
	$query_args = array(
		'post_type'      => 'thaos',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => -1,
		'order'          => $order,
		'orderby'        => $orderby,
	);

	// search single service.
	if ( ! empty( $servicename ) ) {
		$query_args['name'] = $servicename;
	}

	// WP Query Parameters.
	$thaos_query = new WP_Query( $query_args );

	// Output.
	$htmlout = '<!-- Start Triopsi Hosting Service List -->';

	// Style.
	$main_color   = get_option( 'thaos_setting_main_color', '#237dd1' );
	$border_color = get_option( 'thaos_setting_border_color_hover', '#237dd1' );

	// Buffer Start.
	ob_start();

	// Show Services CSS.
	if ( $thaos_query->have_posts() ) {
		?>
	<style>
		.thaos .thaos-txt {
			color: <?php echo esc_attr( $main_color ); ?>;
		}
		.thaos .border-bottom-hover:hover {
				border-bottom-color: <?php echo esc_attr( $border_color ); ?>;
			}
	</style>
		<?php
		// Output Buffer and Clen Buffer.
		$o = ob_get_clean();

		// itteration.
		$i = 0;

		// Outputt all Services.
		while ( $thaos_query->have_posts() ) :
			$thaos_query->the_post();

			// itteration high.
			$i++;

			$htmlout .= '<!--' . ( $i % 4 ) . '-->';

			if ( $i % 4 === 1 ) {
				// Output.
				$htmlout .= '<div class="thaos-container thaos">';
			}

			// Set default.
			$nolink = true;

			// Get the title.
			$title_service = get_the_title();

			// get the output.
			$thecontent = get_the_content();

			// Get links.
			$service_url_page_id = (int) get_post_meta( $post->ID, '_thaos_service_url_page_id', true );
			$service_url_post_id = (int) get_post_meta( $post->ID, '_thaos_service_url_post_id', true );
			$service_url_link    = get_post_meta( $post->ID, '_thaos_service_url_link', true );

			// Default url.
			$htmlurl = '';

			// Set the url.
			if ( 0 !== $service_url_page_id ) {
				$htmlurl = get_page_link( $service_url_page_id );
			}

			if ( 0 !== $service_url_post_id ) {
				$htmlurl = get_page_link( $service_url_page_id );
			}

			if ( '' !== $service_url_link ) {
				$htmlurl = $service_url_link;
			}

			if ( 0 === $service_url_page_id && 0 === $service_url_post_id && empty( $service_url_link ) ) {
				$nolink = false;
			}

			// Get icon.
			$service_icon = get_post_meta( $post->ID, '_thaos_service_icon', true );

			// Start List.
			$htmlout .= '<div class="thaos-item">';
			if ( $nolink ) {
				$htmlout .= '<a target="' . esc_html( $link_target ) . '" href="' . $htmlurl . '">';
			}
			$htmlout .= '<div class="thboxservice" style="">
              <div class="thserviceitem border-bottom-hover">
                <div class="angebot-icon thaos-txt">
                  <i class="fas ' . $service_icon . '"></i>
                </div>';
			if ( $show_title ) {
				$htmlout .= '<h3 class="thaos-txt">' . $title_service . '</h3>';
			}

			if ( ! empty( $thecontent ) ) {
				$htmlout .= '<p>' . $thecontent . '</p>';
			}

			$htmlout .= '</div>
            </div>';
			if ( $nolink ) {
				$htmlout .= '</a>';
			}
			$htmlout .= '</div>';

			if ( $i % 4 === 0 ) {
				$htmlout .= '</div><!-- END DIV FLEX -->';
			}

endwhile;

		if ( $i % 4 !== 0 ) {
			$htmlout .= '</div><!-- END DIV FLEX -->';
		}
	}
	$htmlout .= '<!-- End Triopsi Hosting Service List -->';
	wp_reset_postdata(); // Reset WP Query.
	return $o . $htmlout;

}
