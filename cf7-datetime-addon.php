<?php
/**
 * Plugin Name:       CF7 DateTime Addon
 * Plugin URI:        https://github.com/tylerdrobinson/cf7-datetime-addon
 * Description:       Adds modern date and time picker form tags to Contact Form 7 with Flatpickr enhancement and admin settings.
 * Version:           1.0.0
 * Author:            Tyler Robinson
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cf7-datetime-addon
 * Domain Path:       /languages
 * Requires at least: 5.0
 * Tested up to:      6.1.2
 * Requires PHP:      7.2
 * Network:           false
 *
 * @package           CF7_DateTime_Addon
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CF7_DATETIME_ADDON_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cf7-datetime-addon-activator.php
 */
function activate_cf7_datetime_addon() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-cf7-datetime-addon-activator.php';
    CF7_DateTime_Addon_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cf7-datetime-addon-deactivator.php
 */
function deactivate_cf7_datetime_addon() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-cf7-datetime-addon-deactivator.php';
    CF7_DateTime_Addon_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cf7_datetime_addon' );
register_deactivation_hook( __FILE__, 'deactivate_cf7_datetime_addon' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cf7-datetime-addon.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function run_cf7_datetime_addon() {
    $plugin = new CF7_DateTime_Addon();
    $plugin->run();
}

run_cf7_datetime_addon();
