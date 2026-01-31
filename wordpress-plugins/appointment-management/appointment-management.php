<?php
/**
 * Plugin Name: Appointment Management System
 * Plugin URI: https://www.freshdewmedicalclinic.com
 * Description: Comprehensive appointment booking and management system for FreshDew Medical Clinic.
 * Version: 1.0.0
 * Author: FreshDew Medical Clinic
 * Author URI: https://www.freshdewmedicalclinic.com
 * License: Proprietary
 * Text Domain: appointment-management
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('APPOINTMENT_MANAGEMENT_VERSION', '1.0.0');
define('APPOINTMENT_MANAGEMENT_PLUGIN_DIR', plugin_dir_path(__FILE__));

/**
 * Main Plugin Class
 */
class Appointment_Management {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->init();
    }
    
    private function init() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_book_appointment', array($this, 'handle_booking'));
        add_action('wp_ajax_nopriv_book_appointment', array($this, 'handle_booking'));
        add_shortcode('appointment_booking_form', array($this, 'render_booking_form'));
        add_shortcode('appointment_calendar', array($this, 'render_calendar'));
    }
    
    public function enqueue_scripts() {
        wp_enqueue_script('appointment-management', plugin_dir_url(__FILE__) . 'assets/js/appointment.js', array('jquery'), APPOINTMENT_MANAGEMENT_VERSION, true);
        wp_enqueue_style('appointment-management', plugin_dir_url(__FILE__) . 'assets/css/appointment.css', array(), APPOINTMENT_MANAGEMENT_VERSION);
        
        wp_localize_script('appointment-management', 'appointmentAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('appointment_nonce'),
        ));
    }
    
    public function handle_booking() {
        check_ajax_referer('appointment_nonce', 'nonce');
        
        $patient_id = get_current_user_id();
        $doctor_id = intval($_POST['doctor_id']);
        $appointment_date = sanitize_text_field($_POST['appointment_date']);
        $appointment_time = sanitize_text_field($_POST['appointment_time']);
        $type = sanitize_text_field($_POST['type']);
        $reason = sanitize_text_field($_POST['reason']);
        
        $datetime = $appointment_date . ' ' . $appointment_time;
        
        // Check availability
        if (!Hospital_Appointment::is_available($doctor_id, $datetime)) {
            wp_send_json_error(array('message' => 'This time slot is not available.'));
            return;
        }
        
        // Create appointment
        $appointment_id = Hospital_Appointment::create(array(
            'patient_id' => $patient_id,
            'doctor_id' => $doctor_id,
            'appointment_date' => $datetime,
            'type' => $type,
            'reason' => $reason,
            'status' => 'SCHEDULED',
        ));
        
        if ($appointment_id) {
            // Send notification email
            $this->send_booking_confirmation($appointment_id);
            wp_send_json_success(array('message' => 'Appointment booked successfully!', 'appointment_id' => $appointment_id));
        } else {
            wp_send_json_error(array('message' => 'Failed to book appointment. Please try again.'));
        }
    }
    
    private function send_booking_confirmation($appointment_id) {
        // Email notification implementation
        $to = get_userdata(get_current_user_id())->user_email;
        $subject = 'Appointment Confirmation - FreshDew Medical Clinic';
        $message = 'Your appointment has been confirmed.';
        wp_mail($to, $subject, $message);
    }
    
    public function render_booking_form($atts) {
        ob_start();
        include APPOINTMENT_MANAGEMENT_PLUGIN_DIR . 'templates/booking-form.php';
        return ob_get_clean();
    }
    
    public function render_calendar($atts) {
        ob_start();
        include APPOINTMENT_MANAGEMENT_PLUGIN_DIR . 'templates/calendar.php';
        return ob_get_clean();
    }
}

Appointment_Management::get_instance();

