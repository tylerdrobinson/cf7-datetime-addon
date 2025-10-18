<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/tylerdrobinson/cf7-datetime-addon
 * @since      1.0.2
 *
 * @package    CF7_DateTime_Addon
 * @subpackage CF7_DateTime_Addon/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    CF7_DateTime_Addon
 * @subpackage CF7_DateTime_Addon/admin
 * @author     Tyler Robinson
 */
class CF7_DateTime_Addon_Admin {

    /**
     * The ID of this plugin.
     *
     * @since  1.0.2
     * @access private
     * @var    string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.2
     * @access private
     * @var    string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since 1.0.2
     * @param string $plugin_name The name of this plugin.
     * @param string $version     The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since 1.0.2
     */
    public function enqueue_styles() {
        // Admin styles are not needed for this plugin
        // CF7 provides all necessary styling for tag generators
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * Only loads on CF7 admin pages where tag generators are needed.
     *
     * @since 1.0.2
     */
    public function enqueue_scripts() {
        // Admin scripts are not needed for this plugin
        // Tag generation is handled entirely by CF7's built-in JavaScript
    }

    /**
     * Register CF7 tag generators
     *
     * @since 1.0.2
     */
    public function register_tag_generators() {
        // Check if CF7 is active and tag generator class exists
        if (!defined('WPCF7_VERSION') || !class_exists('WPCF7_TagGenerator')) {
            return;
        }

        // Register time picker tag generator
        $tag_generator = WPCF7_TagGenerator::get_instance();
        $tag_generator->add(
            'time',
            __('time', 'cf7-datetime-addon'),
            array($this, 'tag_generator_time'),
            array('version' => '2')
        );

        // Register date-time picker tag generator
        $tag_generator->add(
            'datetime',
            __('datetime', 'cf7-datetime-addon'),
            array($this, 'tag_generator_date_time'),
            array('version' => '2')
        );
    }

    /**
     * Add plugin admin menu
     *
     * @since 1.0.2
     */
    public function add_plugin_admin_menu() {
        add_submenu_page(
            'wpcf7', // Parent menu slug (CF7's menu)
            __( 'CF7 DateTime Settings', 'cf7-datetime-addon' ),
            __( 'DateTime', 'cf7-datetime-addon' ),
            'manage_options',
            'cf7-datetime-settings',
            array( $this, 'display_plugin_setup_page' )
        );
    }

    /**
     * Register settings
     *
     * @since 1.0.2
     */
    public function register_settings() {
        register_setting(
            'cf7_datetime_settings',
            'cf7_datetime_time_format',
            array(
                'type' => 'string',
                'default' => '12',
                'sanitize_callback' => array( $this, 'sanitize_time_format' )
            )
        );

        register_setting(
            'cf7_datetime_settings',
            'cf7_datetime_default_interval',
            array(
                'type' => 'integer',
                'default' => 5,
                'sanitize_callback' => array( $this, 'sanitize_default_interval' )
            )
        );
    }

    /**
     * Sanitize the time format setting
     *
     * @since 1.0.2
     * @param string $value The value to sanitize.
     * @return string The sanitized value.
     */
    public function sanitize_time_format( $value ) {
        return in_array( $value, array( '12', '24' ), true ) ? $value : '12';
    }

    /**
     * Sanitize the default interval setting
     *
     * @since 1.0.3
     * @param mixed $value The value to sanitize.
     * @return int The sanitized value.
     */
    public function sanitize_default_interval( $value ) {
        $int_value = (int) $value;
        return max(1, min(60, $int_value)); // Between 1 and 60 minutes
    }

    /**
     * Display the plugin setup page
     *
     * @since 1.0.2
     */
    public function display_plugin_setup_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( isset( $_GET['settings-updated'] ) ) {
            add_settings_error(
                'cf7_datetime_messages',
                'cf7_datetime_message',
                __( 'Settings Saved', 'cf7-datetime-addon' ),
                'updated'
            );
        }

        settings_errors( 'cf7_datetime_messages' );
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields( 'cf7_datetime_settings' );
                do_settings_sections( 'cf7-datetime-settings' );
                ?>

                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Time Format', 'cf7-datetime-addon' ); ?></th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text">
                                    <span><?php esc_html_e( 'Time Format', 'cf7-datetime-addon' ); ?></span>
                                </legend>
                                <label>
                                    <input type="radio" name="cf7_datetime_time_format" value="12"
                                        <?php checked( get_option( 'cf7_datetime_time_format', '12' ), '12' ); ?> />
                                    <span><?php esc_html_e( '12-hour format (AM/PM)', 'cf7-datetime-addon' ); ?></span>
                                </label>
                                <br>
                                <label>
                                    <input type="radio" name="cf7_datetime_time_format" value="24"
                                        <?php checked( get_option( 'cf7_datetime_time_format', '12' ), '24' ); ?> />
                                    <span><?php esc_html_e( '24-hour format', 'cf7-datetime-addon' ); ?></span>
                                </label>
                            </fieldset>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Default Time Interval', 'cf7-datetime-addon' ); ?></th>
                        <td>
                            <input type="number" name="cf7_datetime_default_interval" min="1" max="60" step="1"
                                value="<?php echo esc_attr( get_option( 'cf7_datetime_default_interval', '5' ) ); ?>" />
                            <span><?php esc_html_e( 'minutes', 'cf7-datetime-addon' ); ?></span>
                            <p class="description"><?php esc_html_e( 'Default time interval for picker controls. Can be overridden per form field using the interval option.', 'cf7-datetime-addon' ); ?></p>
                        </td>
                    </tr>
                </table>

                <?php submit_button( __( 'Save Settings', 'cf7-datetime-addon' ) ); ?>
            </form>
        </div>
        <?php
    }


    /**
     * Time picker tag generator callback
     *
     * @since 1.0.2
     * @param WPCF7_ContactForm $contact_form The contact form object.
     * @param array             $options       The options array.
     */
    public function tag_generator_time($contact_form, $options) {
        $field_types = array(
            'time' => array(
                'display_name' => __('Time picker', 'cf7-datetime-addon'),
                'heading' => __('Time picker form-tag generator', 'cf7-datetime-addon'),
                'description' => __('Generates a form-tag for a time picker field.', 'cf7-datetime-addon'),
            ),
        );

        $basetype = $options['id'];

        if ( ! in_array( $basetype, array_keys( $field_types ), true ) ) {
            $basetype = 'time';
        }

        $tgg = new WPCF7_TagGeneratorGenerator( $options['content'] );

        $formatter = new WPCF7_HTMLFormatter();

        $formatter->append_start_tag( 'header', array(
            'class' => 'description-box',
        ) );

        $formatter->append_start_tag( 'h3' );

        $formatter->append_preformatted(
            esc_html( $field_types[$basetype]['heading'] )
        );

        $formatter->end_tag( 'h3' );

        $formatter->append_start_tag( 'p' );

        $formatter->append_preformatted(
            wp_kses_data( $field_types[$basetype]['description'] )
        );

        $formatter->end_tag( 'header' );

        $formatter->append_start_tag( 'div', array(
            'class' => 'control-box',
        ) );

        $formatter->call_user_func( static function () use ( $tgg, $field_types, $basetype ) {
            $tgg->print( 'field_type', array(
                'with_required' => true,
                'select_options' => array(
                    $basetype => $field_types[$basetype]['display_name'],
                ),
            ) );

            $tgg->print('field_name');

            $tgg->print('min_max', array(
                'type' => 'time',
                'title' => __('Range', 'cf7-datetime-addon'),
                'min_option' => 'min:',
                'max_option' => 'max:',
            ));
            $tgg->print('step', array(
                'type' => 'number',
                'title' => __('Interval (minutes)', 'cf7-datetime-addon'),
                'default' => '5',
                'min' => '1',
                'max' => '60',
                'option' => 'interval:',
            ));
            $tgg->print('default_value', array(
                'type' => 'time',
                'with_placeholder' => true,
            ));
            $tgg->print('id_attr');
            $tgg->print('class_attr');
        } );

        $formatter->end_tag( 'div' );

        $formatter->append_start_tag( 'footer', array(
            'class' => 'insert-box',
        ) );

        $formatter->call_user_func( static function () use ( $tgg, $field_types ) {
            $tgg->print( 'insert_box_content' );

            $tgg->print( 'mail_tag_tip' );
        } );

        $formatter->print();
    }

    /**
     * DateTime picker tag generator callback
     *
     * @since 1.0.2
     * @param WPCF7_ContactForm $contact_form The contact form object.
     * @param array             $options       The options array.
     */
    public function tag_generator_date_time($contact_form, $options) {
        $field_types = array(
            'datetime' => array(
                'display_name' => __('Date-Time picker', 'cf7-datetime-addon'),
                'heading' => __('Date-Time picker form-tag generator', 'cf7-datetime-addon'),
                'description' => __('Generates a form-tag for a date and time picker field.', 'cf7-datetime-addon'),
            ),
        );

        $basetype = $options['id'];

        if ( ! in_array( $basetype, array_keys( $field_types ), true ) ) {
            $basetype = 'datetime';
        }

        $tgg = new WPCF7_TagGeneratorGenerator( $options['content'] );

        $formatter = new WPCF7_HTMLFormatter();

        $formatter->append_start_tag( 'header', array(
            'class' => 'description-box',
        ) );

        $formatter->append_start_tag( 'h3' );

        $formatter->append_preformatted(
            esc_html( $field_types[$basetype]['heading'] )
        );

        $formatter->end_tag( 'h3' );

        $formatter->append_start_tag( 'p' );

        $formatter->append_preformatted(
            wp_kses_data( $field_types[$basetype]['description'] )
        );

        $formatter->end_tag( 'header' );

        $formatter->append_start_tag( 'div', array(
            'class' => 'control-box',
        ) );

        $formatter->call_user_func( static function () use ( $tgg, $field_types, $basetype ) {
            $tgg->print( 'field_type', array(
                'with_required' => true,
                'select_options' => array(
                    $basetype => $field_types[$basetype]['display_name'],
                ),
            ) );

            $tgg->print('field_name');

            $tgg->print('min_max', array(
                'type' => 'datetime-local',
                'title' => __('Range', 'cf7-datetime-addon'),
                'min_option' => 'min:',
                'max_option' => 'max:',
            ));
            $tgg->print('step', array(
                'type' => 'number',
                'title' => __('Interval (minutes)', 'cf7-datetime-addon'),
                'default' => '5',
                'min' => '1',
                'max' => '60',
                'option' => 'interval:',
            ));
            $tgg->print('default_value', array(
                'type' => 'datetime-local',
                'with_placeholder' => true,
            ));
            $tgg->print('id_attr');
            $tgg->print('class_attr');
        } );

        $formatter->end_tag( 'div' );

        $formatter->append_start_tag( 'footer', array(
            'class' => 'insert-box',
        ) );

        $formatter->call_user_func( static function () use ( $tgg, $field_types ) {
            $tgg->print( 'insert_box_content' );

            $tgg->print( 'mail_tag_tip' );
        } );

        $formatter->print();
    }

}
