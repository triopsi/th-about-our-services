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

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Add Menue.
add_action( 'admin_menu', 'thaos_register_help_page' );

/**
 * Add help page function
 *
 * @return void
 */
function thaos_register_help_page() {
	add_submenu_page(
		'edit.php?post_type=thaos',
		__( 'How It Works', 'thaos' ),
		__( 'Help', 'thaos' ),
		'manage_options',
		'thaos_help',
		'thaos_help_page'
	);
}

/**
 * Text HTML
 *
 * @return void
 */
function thaos_help_page() { ?>
	<style type="text/css">
		.thaos-shortcode-preview{background-color: #e7e7e7; font-weight: bold; padding: 2px 5px; display: inline-block; margin:0 0 2px 0;}
	</style>

	<div class="post-box-container">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<!--How it workd HTML -->
				<div id="post-body-content">
					<div class="metabox-holder">
						<div class="meta-box-sortables ui-sortable">
							<div class="postbox">
								<h3 class="hndle">
									<span><?php esc_html_e( 'How It Works - Display and shortcode', 'thaos' ); ?></span>
								</h3>
								<div class="inside">
									<table class="form-table">
										<tbody>
											<tr>
												<th>
													<label><?php esc_html_e( 'Geeting Started with TH Services', 'thaos' ); ?>:</label>
												</th>
												<td>
													<ul>
														<li><?php esc_html_e( 'Step 1. Go to "All Services --> Add New Service"', 'thaos' ); ?></li>
														<li><?php esc_html_e( 'Step 2. Add Service title, a descriptions, choose a icon and insert optimal a page link.', 'thaos' ); ?></li>
														<li><?php esc_html_e( 'Step 3a. Copy-paste the shortcode [thaos] anywhere in your post or site for show a row of services.', 'thaos' ); ?></li>
														<li><b><?php esc_html_e( 'or', 'thaos' ); ?></b></li>
														<li><?php esc_html_e( 'Step 3b. Copy-paste the shortcode [thaos servicename="&lt;slug-name&gt;"] anywhere in your post or site for show a single service.', 'thaos' ); ?></li>
													</ul>
												</td>
											</tr>

											<tr>
												<th>
													<label><?php esc_html_e( 'All Shortcodes', 'thaos' ); ?>:</label>
												</th>
												<td>
													<span class="thaos-shortcode-preview">[thaos]</span> – <?php esc_html_e( 'Services Shortcode. Show all services in a row.', 'thaos' ); ?><br />
													<span class="thaos-shortcode-preview">[thaos servicename="&lt;slug-name&gt;"]</span> – <?php esc_html_e( 'Show a single service.', 'thaos' ); ?> <br />
												</td>
											</tr>			
											<tr>
												<th>
													<label><?php esc_html_e( 'All Shortcodes parameters', 'thaos' ); ?>:</label>
												</th>
												<td>
													<span class="thaos-shortcode-preview">link_target="self"</span> – <?php esc_html_e( 'Service link target. Value=self or blank, Default=self', 'thaos' ); ?> <br />													
													<span class="thaos-shortcode-preview">orderby="date"</span> – <?php esc_html_e( 'Orderby the atribute of services Value=date, ID, title, name or rand, Default=date', 'thaos' ); ?> <br />
													<span class="thaos-shortcode-preview">order="asc"</span> – <?php esc_html_e( 'Sort the services in ascending or descending order. Value=asc or desc, Default=ASC', 'thaos' ); ?> <br />
													<span class="thaos-shortcode-preview">servicename="&lt;slug-name&gt;"</span> – <?php esc_html_e( 'Show a service - single view', 'thaos' ); ?> <br />
													<span class="thaos-shortcode-preview">class_boxes="&lt;classnames&gt;"</span> – <?php esc_html_e( 'Add css classnames to the item.', 'thaos' ); ?> <br />
													<br />
													<?php esc_html_e( 'e.g.', 'thaos' ); ?>
													<span class="thaos-shortcode-preview">[thaos link_target="blank" order="desc"]</span>
												</td>
											</tr>
											<tr>
												<th>
													<label><?php esc_html_e( 'Need Support?', 'thaos' ); ?></label>
												</th>
												<td>
													<p><?php esc_html_e( 'Check plugin document for shortcode parameters.', 'thaos' ); ?></p> <br/>
													<a class="button button-primary" href="http://wiki.profoxi.de" target="_blank"><?php esc_html_e( 'Documentation', 'thaos' ); ?></a>									
													<a class="button button-secondary" href="http://paypal.me/triopsi" target="_blank">❤️ <?php esc_html_e( 'Donate', 'thaos' ); ?></a>
												</td>
											</tr>
										</tbody>
									</table>
								</div><!-- .inside -->
							</div><!-- #general -->
						</div><!-- .meta-box-sortables ui-sortable -->
					</div><!-- .metabox-holder -->
				</div><!-- #post-body-content -->
			</div><!-- #post-body -->
		</div><!-- #poststuff -->
	</div><!-- #post-box-container -->
	<?php
}
