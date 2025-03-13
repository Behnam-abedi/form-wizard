<?php
/**
 * Plugin Name: Custom Wizard Form
 * Plugin URI: https://example.com/plugins/custom-wizard-form
 * Description: A customizable wizard form with multi-step functionality for WordPress.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: custom-wizard-form
 * Domain Path: /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('CUSTOM_WIZARD_FORM_VERSION', '1.0.0');
define('CUSTOM_WIZARD_FORM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CUSTOM_WIZARD_FORM_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Enqueue scripts and styles for the frontend
 */
function custom_wizard_form_enqueue_scripts() {
    // Only load if our shortcode is present
    global $post;
    if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'wizard_form')) {
        // Enqueue CSS
        wp_enqueue_style(
            'custom-wizard-form-styles',
            CUSTOM_WIZARD_FORM_PLUGIN_URL . 'assets/css/wizard-form.css',
            array(),
            CUSTOM_WIZARD_FORM_VERSION
        );

        // Enqueue JavaScript
        wp_enqueue_script(
            'custom-wizard-form-script',
            CUSTOM_WIZARD_FORM_PLUGIN_URL . 'assets/js/wizard-form.js',
            array('jquery'),
            CUSTOM_WIZARD_FORM_VERSION,
            true
        );

        // Add localized script data if needed
        wp_localize_script(
            'custom-wizard-form-script',
            'wizard_form_params',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('wizard_form_nonce')
            )
        );
    }
}
add_action('wp_enqueue_scripts', 'custom_wizard_form_enqueue_scripts');

/**
 * Register the wizard form shortcode
 */
function custom_wizard_form_shortcode($atts) {
    // Extract shortcode attributes with defaults
    $atts = shortcode_atts(
        array(
            'id' => 'default',
            'title' => 'Wizard Form'
        ),
        $atts,
        'wizard_form'
    );

    // Start output buffering to capture the HTML
    ob_start();

    // Include the template file
    include CUSTOM_WIZARD_FORM_PLUGIN_DIR . 'templates/wizard-form-template.php';

    // Return the buffered output
    return ob_get_clean();
}
add_shortcode('wizard_form', 'custom_wizard_form_shortcode');

/**
 * AJAX handler for form submissions
 */
function custom_wizard_form_ajax_submit() {
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'wizard_form_nonce')) {
        wp_send_json_error(array('message' => 'Security check failed.'));
    }

    // Get form data
    $form_data = isset($_POST['form_data']) ? $_POST['form_data'] : '';
    parse_str($form_data, $submission_data);

    // Simple validation
    if (empty($submission_data['first_name']) || empty($submission_data['last_name']) || empty($submission_data['email'])) {
        wp_send_json_error(array('message' => 'Please fill in all required fields.'));
    }

    // Process the form data
    // In a real plugin, you might want to:
    // 1. Save to database
    // 2. Send email notification
    // 3. Register user
    // 4. Connect to external API
    // etc.

    // Example: Save as a custom post type (you would need to register this CPT elsewhere)
    /*
    $post_id = wp_insert_post(array(
        'post_title'    => sanitize_text_field($submission_data['first_name'] . ' ' . $submission_data['last_name']),
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_type'     => 'form_submission',
    ));

    if ($post_id) {
        // Save all the form fields as post meta
        foreach ($submission_data as $key => $value) {
            if ($key !== 'wizard_form_nonce' && $key !== 'action') {
                update_post_meta($post_id, 'wizard_form_' . $key, sanitize_text_field($value));
            }
        }
    }
    */

    // For now, just return success
    wp_send_json_success(array(
        'message' => 'Thank you for your submission! We will get back to you soon.',
        'data' => $submission_data
    ));
}
add_action('wp_ajax_wizard_form_submit', 'custom_wizard_form_ajax_submit');
add_action('wp_ajax_nopriv_wizard_form_submit', 'custom_wizard_form_ajax_submit');

/**
 * Plugin activation hook
 */
function custom_wizard_form_activate() {
    // Activation tasks if needed
}
register_activation_hook(__FILE__, 'custom_wizard_form_activate');

/**
 * Plugin deactivation hook
 */
function custom_wizard_form_deactivate() {
    // Deactivation tasks if needed
}
register_deactivation_hook(__FILE__, 'custom_wizard_form_deactivate');

/**
 * Load plugin textdomain for translations
 */
function custom_wizard_form_load_textdomain() {
    load_plugin_textdomain('custom-wizard-form', false, basename(dirname(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'custom_wizard_form_load_textdomain'); 