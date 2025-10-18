<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/tylerdrobinson/cf7-datetime-addon
 * @since      1.0.2
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
     * Register the stylesheets for the public-facing side of the site.
     *
     * Note: CSS styling should be handled by the theme. Only Flatpickr CSS
     * is enqueued for proper date picker functionality.
     *
     * @since 1.0.2
     */
    public function enqueue_styles() {
        // CSS is handled by the theme - only Flatpickr is enqueued
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * Note: Actual enqueuing is handled by enqueue_datetime_assets() method
     * to ensure proper CF7 dependency loading.
     *
     * @since 1.0.2
     */
    public function enqueue_scripts() {
        // Assets are enqueued conditionally in enqueue_datetime_assets()
    }

    /**
     * Register Contact Form 7 form tags
     *
     * @since 1.0.2
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
            array( 'name-attr' => true )
        );

        // Register the date-time picker form tag
        wpcf7_add_form_tag(
            array( 'datetime', 'datetime*' ),
            array( $this, 'render_datetimepicker' ),
            array( 'name-attr' => true )
        );

        // Server-side validation for all picker types
        add_filter( 'wpcf7_validate_time', array( $this, 'validate_time' ), 10, 2 );
        add_filter( 'wpcf7_validate_time*', array( $this, 'validate_time' ), 10, 2 );
        add_filter( 'wpcf7_validate_datetime', array( $this, 'validate_date_time' ), 10, 2 );
        add_filter( 'wpcf7_validate_datetime*', array( $this, 'validate_date_time' ), 10, 2 );

        // Enqueue assets only when CF7 is present
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_datetime_assets' ) );
    }


    /**
     * Render the timepicker form tag
     *
     * @since 1.0.2
     * @param WPCF7_FormTag $tag The form tag object.
     * @return string The rendered HTML.
     */
    public function render_timepicker( $tag ) {
        if ( empty( $tag->name ) ) {
            return '';
        }

        $tag = new WPCF7_FormTag( $tag );
        error_log('CF7 DateTime: TIME render_timepicker called for: ' . $tag->name);
        error_log('CF7 DateTime: TIME tag content: ' . $tag->content);

        // Base classes
        $classes = wpcf7_form_controls_class( $tag->type );
        $classes .= ' wpcf7-time';

        // Get class options
        foreach ( (array) $tag->get_class_option() as $cl ) {
            $classes .= ' ' . sanitize_html_class( $cl );
        }

        // Get interval option or use default
        $interval = $tag->get_option('interval', 'int', true);
        if (!$interval) {
            $interval = get_option('cf7_datetime_default_interval', 5);
        }

        $atts = array(
            'class'       => $classes,
            'id'          => $tag->get_id_option(),
            'name'        => $tag->name,
            'type'        => 'time',
            'inputmode'   => 'numeric',
            'step'        => $interval * 60, // Convert minutes to seconds
            'data-time' => '1',
        );

        // Handle placeholder - extract directly from tag content
        $placeholder = '';
        // Get the original tag content from CF7's internal storage
        $tag_content = $tag->content;
        error_log('CF7 DateTime: TIME tag content: ' . $tag_content);

        // Extract placeholder from the tag content using regex
        if (preg_match('/placeholder\s*"([^"]*)"/', $tag_content, $matches)) {
            $placeholder = $matches[1];
            error_log('CF7 DateTime: TIME extracted placeholder: ' . $placeholder);
        }

        if ($placeholder) {
            $atts['data-placeholder'] = $placeholder;
            error_log('CF7 DateTime: TIME Set data-placeholder to: ' . $placeholder);
        }

        // CRITICAL: Do NOT set placeholder attribute - Flatpickr treats it as initial value
        // We handle placeholder setting in JavaScript after Flatpickr initializes

        if ( $tag->is_required() ) {
            $atts['aria-required'] = 'true';
            $atts['required'] = 'required';
        }

        // Default value - but don't set placeholder text as value
        $value = $tag->get_default_option( null );
        if ( ! $value ) {
            $vals = (array) $tag->values;
            if ( ! empty( $vals ) ) {
                $value = reset( $vals );
            }
        }

        // NEVER set value attribute for datetime/time inputs - Flatpickr handles values
        // This prevents placeholder text from being set as initial values

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
     * @since 1.0.2
     * @param WPCF7_FormTag $tag The form tag object.
     * @return string The rendered HTML.
     */
    public function render_datetimepicker( $tag ) {
        if ( empty( $tag->name ) ) {
            return '';
        }

        $tag = new WPCF7_FormTag( $tag );
        error_log('CF7 DateTime: DATETIME render_datetimepicker called for: ' . $tag->name);

        // Base classes
        $classes = wpcf7_form_controls_class( $tag->type );
        $classes .= ' wpcf7-date-time';

        // Get class options
        foreach ( (array) $tag->get_class_option() as $cl ) {
            $classes .= ' ' . sanitize_html_class( $cl );
        }

        // Get interval option or use default
        $interval = $tag->get_option('interval', 'int', true);
        if (!$interval) {
            $interval = get_option('cf7_datetime_default_interval', 5);
        }

        $atts = array(
            'class'       => $classes,
            'id'          => $tag->get_id_option(),
            'name'        => $tag->name,
            'type'        => 'datetime-local',
            'inputmode'   => 'numeric',
            'step'        => $interval * 60, // Convert minutes to seconds
            'data-date-time' => '1',
        );

        // Handle placeholder - extract directly from tag content
        $placeholder = '';
        // Get the original tag content from CF7's internal storage
        $tag_content = $tag->content;
        error_log('CF7 DateTime: DATETIME tag content: ' . $tag_content);

        // Extract placeholder from the tag content using regex
        if (preg_match('/placeholder\s*"([^"]*)"/', $tag_content, $matches)) {
            $placeholder = $matches[1];
            error_log('CF7 DateTime: DATETIME extracted placeholder: ' . $placeholder);
        }

        if ($placeholder) {
            $atts['data-placeholder'] = $placeholder;
            error_log('CF7 DateTime: DATETIME Set data-placeholder to: ' . $placeholder);
        }

        // CRITICAL: Do NOT set placeholder attribute - Flatpickr treats it as initial value
        // We handle placeholder setting in JavaScript after Flatpickr initializes

        if ( $tag->is_required() ) {
            $atts['aria-required'] = 'true';
            $atts['required'] = 'required';
        }

        // Default value - but don't set placeholder text as value
        $value = $tag->get_default_option( null );
        if ( ! $value ) {
            $vals = (array) $tag->values;
            if ( ! empty( $vals ) ) {
                $value = reset( $vals );
            }
        }

        // NEVER set value attribute for datetime/time inputs - Flatpickr handles values
        // This prevents placeholder text from being set as initial values

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
     * @since 1.0.2
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
     * @since 1.0.2
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

        // Must be in datetime format (YYYY-MM-DD HH:MM)
        if ( ! preg_match( '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $value ) ) {
            $result->invalidate( $tag, __( 'Please enter a valid date and time.', 'cf7-datetime-addon' ) );
            return $result;
        }

        return $result;
    }

    /**
     * Enqueue datetime picker assets
     *
     * @since 1.0.2
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

        // Plugin scripts only (CSS should be added to theme)
        wp_register_script(
            'cf7-datetime-addon-public',
            plugin_dir_url( __FILE__ ) . 'js/cf7-datetime-addon-public.js',
            array( 'flatpickr' ),
            $this->version,
            true
        );

        // Pass settings to JavaScript
        $time_format = get_option( 'cf7_datetime_time_format', '12' );
        $default_interval = get_option( 'cf7_datetime_default_interval', 5 );
        wp_localize_script(
            'cf7-datetime-addon-public',
            'cf7_datetime_settings',
            array(
                'time_format' => $time_format,
                'default_interval' => $default_interval
            )
        );

        // Enqueue assets
        wp_enqueue_style( 'flatpickr' );
        wp_enqueue_script( 'flatpickr' );
        wp_enqueue_script( 'cf7-datetime-addon-public' );
    }

}
