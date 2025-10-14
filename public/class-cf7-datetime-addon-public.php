<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/tylerdrobinson/cf7-datetime-addon
 * @since      1.0.0
 *
 * @package    CF7_DateTime_Addon
 * @subpackage CF7_DateTime_Addon/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    CF7_DateTime_Addon
 * @subpackage CF7_DateTime_Addon/public
 * @author     Tyler Robinson
 */
class CF7_DateTime_Addon_Public {

    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since 1.0.0
     * @param string $plugin_name The name of this plugin.
     * @param string $version     The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * Note: Actual enqueuing is handled by enqueue_datetime_assets() method
     * to ensure proper CF7 dependency loading.
     *
     * @since 1.0.0
     */
    public function enqueue_styles() {
        // Assets are enqueued conditionally in enqueue_datetime_assets()
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * Note: Actual enqueuing is handled by enqueue_datetime_assets() method
     * to ensure proper CF7 dependency loading.
     *
     * @since 1.0.0
     */
    public function enqueue_scripts() {
        // Assets are enqueued conditionally in enqueue_datetime_assets()
    }

    /**
     * Register Contact Form 7 form tags
     *
     * @since 1.0.0
     */
    public function register_form_tags() {
        // Check if CF7 is active
        if ( ! defined( 'WPCF7_VERSION' ) ) {
            return;
        }

        // Register the time picker form tag
        wpcf7_add_form_tag(
            array( 'time', 'time*' ),
            array( $this, 'render_timepicker' ),
            array( 'name-attr' => true, 'do-not-store' => false )
        );

        // Register the date-time picker form tag
        wpcf7_add_form_tag(
            array( 'date-time', 'date-time*' ),
            array( $this, 'render_datetimepicker' ),
            array( 'name-attr' => true, 'do-not-store' => false )
        );

        // Server-side validation for all picker types
        add_filter( 'wpcf7_validate_time', array( $this, 'validate_time' ), 10, 2 );
        add_filter( 'wpcf7_validate_time*', array( $this, 'validate_time' ), 10, 2 );
        add_filter( 'wpcf7_validate_date-time', array( $this, 'validate_date_time' ), 10, 2 );
        add_filter( 'wpcf7_validate_date-time*', array( $this, 'validate_date_time' ), 10, 2 );

        // Enqueue assets only when CF7 is present
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_datetime_assets' ) );
    }


    /**
     * Render the timepicker form tag
     *
     * @since 1.0.0
     * @param WPCF7_FormTag $tag The form tag object.
     * @return string The rendered HTML.
     */
    public function render_timepicker( $tag ) {
        if ( empty( $tag->name ) ) {
            return '';
        }

        $tag = new WPCF7_FormTag( $tag );

        // Base classes
        $classes = wpcf7_form_controls_class( $tag->type );
        $classes .= ' wpcf7-time';

        // Get class options
        foreach ( (array) $tag->get_class_option() as $cl ) {
            $classes .= ' ' . sanitize_html_class( $cl );
        }

        $atts = array(
            'class'       => $classes,
            'id'          => $tag->get_id_option(),
            'name'        => $tag->name,
            'type'        => 'time',
            'inputmode'   => 'numeric',
            'data-time' => '1',
        );

        if ( $tag->is_required() ) {
            $atts['aria-required'] = 'true';
            $atts['required'] = 'required';
        }

        // Default value
        $value = $tag->get_default_option( null );
        if ( ! $value ) {
            $vals = (array) $tag->values;
            if ( ! empty( $vals ) ) {
                $value = reset( $vals );
            }
        }
        if ( $value ) {
            $atts['value'] = esc_attr( $value );
        }

        // Build attributes
        $attr_html = '';
        foreach ( $atts as $k => $v ) {
            if ( $v !== '' && $v !== null ) {
                $attr_html .= sprintf( ' %s="%s"', esc_attr( $k ), esc_attr( $v ) );
            }
        }

        return sprintf(
            '<span class="wpcf7-form-control-wrap %1$s"><input%2$s /></span>',
            esc_attr( $tag->name ),
            $attr_html
        );
    }

    /**
     * Render the datetimepicker form tag
     *
     * @since 1.0.0
     * @param WPCF7_FormTag $tag The form tag object.
     * @return string The rendered HTML.
     */
    public function render_datetimepicker( $tag ) {
        if ( empty( $tag->name ) ) {
            return '';
        }

        $tag = new WPCF7_FormTag( $tag );

        // Base classes
        $classes = wpcf7_form_controls_class( $tag->type );
        $classes .= ' wpcf7-date-time';

        // Get class options
        foreach ( (array) $tag->get_class_option() as $cl ) {
            $classes .= ' ' . sanitize_html_class( $cl );
        }

        $atts = array(
            'class'       => $classes,
            'id'          => $tag->get_id_option(),
            'name'        => $tag->name,
            'type'        => 'datetime-local',
            'inputmode'   => 'numeric',
            'data-date-time' => '1',
        );

        if ( $tag->is_required() ) {
            $atts['aria-required'] = 'true';
            $atts['required'] = 'required';
        }

        // Default value
        $value = $tag->get_default_option( null );
        if ( ! $value ) {
            $vals = (array) $tag->values;
            if ( ! empty( $vals ) ) {
                $value = reset( $vals );
            }
        }
        if ( $value ) {
            $atts['value'] = esc_attr( $value );
        }

        // Build attributes
        $attr_html = '';
        foreach ( $atts as $k => $v ) {
            if ( $v !== '' && $v !== null ) {
                $attr_html .= sprintf( ' %s="%s"', esc_attr( $k ), esc_attr( $v ) );
            }
        }

        return sprintf(
            '<span class="wpcf7-form-control-wrap %1$s"><input%2$s /></span>',
            esc_attr( $tag->name ),
            $attr_html
        );
    }


    /**
     * Validate the timepicker field
     *
     * @since 1.0.0
     * @param WPCF7_Validation $result The validation result object.
     * @param WPCF7_FormTag    $tag    The form tag object.
     * @return WPCF7_Validation The validation result.
     */
    public function validate_time( $result, $tag ) {
        $name  = $tag->name;
        $value = isset( $_POST[ $name ] ) ? sanitize_text_field( wp_unslash( $_POST[ $name ] ) ) : '';

        $is_required = $tag->is_required();

        if ( $is_required && $value === '' ) {
            $result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
            return $result;
        }

        if ( $value === '' ) {
            return $result; // Optional & empty → OK
        }

        // Must be in time format (HH:MM)
        if ( ! preg_match( '/^\d{2}:\d{2}$/', $value ) ) {
            $result->invalidate( $tag, __( 'Please enter a valid time.', 'cf7-datetime-addon' ) );
            return $result;
        }

        return $result;
    }

    /**
     * Validate the datetimepicker field
     *
     * @since 1.0.0
     * @param WPCF7_Validation $result The validation result object.
     * @param WPCF7_FormTag    $tag    The form tag object.
     * @return WPCF7_Validation The validation result.
     */
    public function validate_date_time( $result, $tag ) {
        $name  = $tag->name;
        $value = isset( $_POST[ $name ] ) ? sanitize_text_field( wp_unslash( $_POST[ $name ] ) ) : '';

        $is_required = $tag->is_required();

        if ( $is_required && $value === '' ) {
            $result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
            return $result;
        }

        if ( $value === '' ) {
            return $result; // Optional & empty → OK
        }

        // Must be in datetime-local format (YYYY-MM-DDTHH:MM)
        if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $value ) ) {
            $result->invalidate( $tag, __( 'Please enter a valid date and time.', 'cf7-datetime-addon' ) );
            return $result;
        }

        return $result;
    }

    /**
     * Enqueue datetime picker assets
     *
     * @since 1.0.0
     */
    public function enqueue_datetime_assets() {
        // Only load if CF7 assets are being loaded
        if ( ! function_exists( 'wpcf7_enqueue_scripts' ) || ! wpcf7_load_js() ) {
            return;
        }

        // Flatpickr library
        wp_register_style(
            'flatpickr',
            'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css',
            array(),
            '4.6.13'
        );

        wp_register_script(
            'flatpickr',
            'https://cdn.jsdelivr.net/npm/flatpickr',
            array(),
            '4.6.13',
            true
        );

        // Plugin styles and scripts
        wp_register_style(
            'cf7-datetime-addon-public',
            plugin_dir_url( __FILE__ ) . 'css/cf7-datetime-addon-public.css',
            array( 'flatpickr' ),
            $this->version,
            'all'
        );

        wp_register_script(
            'cf7-datetime-addon-public',
            plugin_dir_url( __FILE__ ) . 'js/cf7-datetime-addon-public.js',
            array( 'flatpickr' ),
            $this->version,
            true
        );

        // Pass settings to JavaScript
        $time_format = get_option( 'cf7_datetime_time_format', '12' );
        wp_localize_script(
            'cf7-datetime-addon-public',
            'cf7_datetime_settings',
            array( 'time_format' => $time_format )
        );

        // Enqueue assets
        wp_enqueue_style( 'flatpickr' );
        wp_enqueue_style( 'cf7-datetime-addon-public' );
        wp_enqueue_script( 'flatpickr' );
        wp_enqueue_script( 'cf7-datetime-addon-public' );
    }

}
