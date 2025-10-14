<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    CF7_DateTime_Addon
 * @subpackage CF7_DateTime_Addon/includes
 * @author     Tyler Robinson <support@example.com>
 */
class CF7_DateTime_Addon_Activator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since 1.0.0
     */
    public static function activate() {
        // Check if Contact Form 7 is active
        if ( ! defined( 'WPCF7_VERSION' ) ) {
            deactivate_plugins( plugin_basename( __FILE__ ) );
            wp_die(
                __( 'Sorry, but this plugin requires Contact Form 7 to be installed and active.', 'cf7-datetime-addon' ),
                __( 'Plugin Activation Error', 'cf7-datetime-addon' ),
                array( 'back_link' => true )
            );
        }
    }

}
