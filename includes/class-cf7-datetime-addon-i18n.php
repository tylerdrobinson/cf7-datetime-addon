<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/tylerdrobinson/cf7-datetime-addon
 * @since      1.0.0
 *
 * @package    CF7_DateTime_Addon
 * @subpackage CF7_DateTime_Addon/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    CF7_DateTime_Addon
 * @subpackage CF7_DateTime_Addon/includes
 * @author     Tyler Robinson
 */
class CF7_DateTime_Addon_i18n {


    /**
     * Load the plugin text domain for translation.
     *
     * @since 1.0.0
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
            'cf7-datetime-addon',
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
        );

    }

}
