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
 * Init setting setup
 *
 * @return void
 */
function thaos_settings_init()
{
    // register new settings
    register_setting( 'thaos', 'thaos_settings_cdn_awesome' );
    register_setting( 'thaos', 'thaos_setting_main_color' );
    register_setting( 'thaos', 'thaos_setting_border_color_hover' );
 
    // Font Colors
    add_settings_section(
        'thaos_settings_section_font_color',
        __('Color shema','thaos'),
        'thaos_settings_section_color',
        'thaos'
    );

    //Main Color Field
    add_settings_field(
        'thaos_settings_main_color',
        __('Choose a main color:','thaos'),
        'thaos_settings_field_main_color_cb',
        'thaos',
        'thaos_settings_section_font_color'
    );

     //Border Hover Color Field
     add_settings_field(
        'thaos_settings_hover_color',
        __('Choose a color for bottom border:','thaos'),
        'thaos_settings_field_hover_color_cb',
        'thaos',
        'thaos_settings_section_font_color'
    );

    // Font Awesome CDN
    add_settings_section(
        'thaos_settings_section_font_cdn',
        'Font Awesome CDN',
        'thaos_settings_cdn_section_cb',
        'thaos'
    );

    //Social Media Style CDN Field
    add_settings_field(
        'thaos_settings_cdn_awesome',
        __('Use Font Awesome CDN?','thaos'),
        'thaos_settings_field_cdn_cb',
        'thaos',
        'thaos_settings_section_font_cdn'
    );
}

/**
 * register thaos_settings_init to the admin_init action hook
 */
add_action('admin_init', 'thaos_settings_init');

/**
 * section Color Description
 */
function thaos_settings_section_color()
{
    echo __('This color will use for the service section','thaos');
}


/**
 * section CDN Description
 */
function thaos_settings_cdn_section_cb()
{
    echo __('Want to use the CDN for Font Awesome Icons?','thaos');
}

/**
 * section Style Description
 */
function thaos_settings_section_cb()
{
    /* translators: %s is replaced with the link */
    printf(__('Service Settings Section. Here you can edit the Social Media Icons styles for the front/content. By default the plugin used and needed the font awesome icon libary(%s).','thaos'),
        '<a target="_blank" href="https://fontawesome.com/">more infos</a>'
    );
}
 

/**
 * Main Color CP
 *
 * @param array $args
 * @return void
 */
function thaos_settings_field_main_color_cb( array $args ){
    $old_setting_value = ( !empty( get_option( 'thaos_setting_main_color' ) ) ? get_option( 'thaos_setting_main_color' ) : '#237dd1');
    ?>
    <input type="text" id="thaos-main-color-field" class="thaos-main-color-field" name="thaos_setting_main_color" value="<?php echo $old_setting_value; ?>">

    <?php
}

/**
 * Hover Color CP
 *
 * @param array $args
 * @return void
 */
function thaos_settings_field_hover_color_cb( array $args ){
    $old_setting_value = ( !empty( get_option( 'thaos_setting_border_color_hover' ) ) ? get_option( 'thaos_setting_border_color_hover' ) : '#237dd1');
    ?>
    <input type="text" id="thaos-hover-color-field" class="thaos-hover-color-field" name="thaos_setting_border_color_hover" value="<?php echo $old_setting_value; ?>">
    <?php
}


/**
 * Social Media CDN
 *
 * @param array $args
 * @return void
 */
function thaos_settings_field_cdn_cb( array $args ){
    $old_setting_value = ( !empty( get_option( 'thaos_settings_cdn_awesome' ) ) ? get_option( 'thaos_settings_cdn_awesome' ) : 'yes');
    ?>
    <fieldset>
        <input type="radio" id="field_cdn_yes" class="thaos-field-setting-cdn" name="thaos_settings_cdn_awesome" value="yes" <?php echo ($old_setting_value === 'yes' ? 'checked' : '' ); ?>>
        <label for="field_cdn_yes"> <?php echo __('yes','thaos'); ?></label> 
        <input type="radio" id="field_cdn_no" class="thaos-field-setting-cdn" name="thaos_settings_cdn_awesome" value="no" <?php echo ($old_setting_value === 'no' ? 'checked' : '' ); ?>>
        <label for="field_cdn_no"> <?php echo __('no','thaos'); ?></label> 
    </fielset>
    
    <?php
}

/**
 * top level menu
 */
function thaos_option_menue(){

    add_options_page( 
        __('TH Service options','thaos'), 
        __('TH Service options','thaos'),
        'manage_options',
        'thaos',
        'thaos_options_page_html'
    );
}

/**
* register our thaos_options_page to the admin_menu action hook
*/
add_action( 'admin_menu', 'thaos_option_menue' );

/**
 * top level menu:
 * callback functions
 */
function thaos_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
    return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
            <?php
                // output security fields for the registered setting "thaos"
                settings_fields( 'thaos' );

                // output setting sections and their fields
                // (sections are registered for "thaos", each field is registered to a specific section)
                do_settings_sections( 'thaos' );

                // output save settings button
                submit_button( __( 'Save Settings', 'thaos' ) );
            ?>
            <div class="thaos-wrap-option-page">
            <a href="https://paypal.me/triopsi" target="_blank" class="button-secondary">❤️ <?php _e('Donate', 'thaos'); ?></a> 
            <a href="https://wiki.profoxi.de/" target="_blank" class="button-secondary"><?php _e('Help', 'thaos'); ?></a> 
            </div>
        </form>
        <?php if(WP_DEBUG){ ?>
            <div class="debug-info">
                <h3><?php _e('Debug information','thaos'); ?></h3>
                <p><?php _e('You are seeing this because your WP_DEBUG variable is set to true.','thaos'); ?></p>
                <pre>thaos_plugin_version: <?php print_r(get_option( 'thaos_plugin_version' )) ?></pre>
                <pre>thaos_settings_cdn_awesome: <?php print_r(get_option( 'thaos_settings_cdn_awesome' )) ?></pre>
                <pre>thaos_setting_main_color: <?php print_r(get_option( 'thaos_setting_main_color' )) ?></pre>
                <pre>thaos_setting_border_color_hover: <?php print_r(get_option( 'thaos_setting_border_color_hover' )) ?></pre>
            </div><!-- /.debug-info -->
        <?php } ?>
    </div>
    <?php
}