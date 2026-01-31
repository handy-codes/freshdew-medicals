<?php
/**
 * Plugin Name: Hospital Core System
 * Plugin URI: https://www.freshdewmedicalclinic.com
 * Description: Core hospital management system for FreshDew Medical Clinic. Handles patients, doctors, appointments, and medical records.
 * Version: 1.0.0
 * Author: FreshDew Medical Clinic
 * Author URI: https://www.freshdewmedicalclinic.com
 * License: Proprietary
 * Text Domain: hospital-core
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define plugin constants
define('HOSPITAL_CORE_VERSION', '1.0.0');
define('HOSPITAL_CORE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('HOSPITAL_CORE_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main Plugin Class
 */
class Hospital_Core_System {
    
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
        // Activation hook
        register_activation_hook(__FILE__, array($this, 'activate'));
        
        // Deactivation hook
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
        
        // Load plugin files
        $this->load_dependencies();
        
        // Initialize components
        add_action('init', array($this, 'register_post_types'));
        add_action('init', array($this, 'register_taxonomies'));
        add_action('init', array($this, 'register_user_roles'));
        add_action('rest_api_init', array($this, 'register_rest_routes'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }
    
    private function load_dependencies() {
        require_once HOSPITAL_CORE_PLUGIN_DIR . 'includes/class-database.php';
        require_once HOSPITAL_CORE_PLUGIN_DIR . 'includes/class-patient.php';
        require_once HOSPITAL_CORE_PLUGIN_DIR . 'includes/class-doctor.php';
        require_once HOSPITAL_CORE_PLUGIN_DIR . 'includes/class-appointment.php';
        require_once HOSPITAL_CORE_PLUGIN_DIR . 'includes/class-medical-record.php';
    }
    
    /**
     * Register Custom Post Types
     */
    public function register_post_types() {
        // Patients
        register_post_type('patient', array(
            'labels' => array(
                'name' => __('Patients', 'hospital-core'),
                'singular_name' => __('Patient', 'hospital-core'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => 'hospital-dashboard',
            'capability_type' => 'post',
            'supports' => array('title', 'editor', 'custom-fields'),
        ));
        
        // Doctors
        register_post_type('doctor', array(
            'labels' => array(
                'name' => __('Doctors', 'hospital-core'),
                'singular_name' => __('Doctor', 'hospital-core'),
            ),
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => 'hospital-dashboard',
            'capability_type' => 'post',
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        ));
        
        // Appointments
        register_post_type('appointment', array(
            'labels' => array(
                'name' => __('Appointments', 'hospital-core'),
                'singular_name' => __('Appointment', 'hospital-core'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => 'hospital-dashboard',
            'capability_type' => 'post',
            'supports' => array('title', 'editor', 'custom-fields'),
        ));
        
        // Medical Records
        register_post_type('medical_record', array(
            'labels' => array(
                'name' => __('Medical Records', 'hospital-core'),
                'singular_name' => __('Medical Record', 'hospital-core'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => 'hospital-dashboard',
            'capability_type' => 'post',
            'supports' => array('title', 'editor', 'custom-fields'),
        ));
    }
    
    /**
     * Register Custom Taxonomies
     */
    public function register_taxonomies() {
        // Specialties
        register_taxonomy('specialty', 'doctor', array(
            'labels' => array(
                'name' => __('Specialties', 'hospital-core'),
                'singular_name' => __('Specialty', 'hospital-core'),
            ),
            'public' => true,
            'hierarchical' => true,
        ));
        
        // Conditions
        register_taxonomy('condition', 'medical_record', array(
            'labels' => array(
                'name' => __('Conditions', 'hospital-core'),
                'singular_name' => __('Condition', 'hospital-core'),
            ),
            'public' => false,
            'hierarchical' => true,
        ));
    }
    
    /**
     * Register Custom User Roles
     */
    public function register_user_roles() {
        // Hospital Admin
        add_role('hospital_admin', __('Hospital Admin', 'hospital-core'), array(
            'read' => true,
            'edit_posts' => true,
            'manage_hospital' => true,
        ));
        
        // Doctor
        add_role('doctor', __('Doctor', 'hospital-core'), array(
            'read' => true,
            'edit_posts' => true,
            'manage_patients' => true,
            'manage_appointments' => true,
        ));
        
        // Nurse
        add_role('nurse', __('Nurse', 'hospital-core'), array(
            'read' => true,
            'edit_posts' => true,
            'view_patients' => true,
        ));
        
        // Staff
        add_role('staff', __('Staff', 'hospital-core'), array(
            'read' => true,
            'edit_posts' => true,
        ));
        
        // Patient
        add_role('patient', __('Patient', 'hospital-core'), array(
            'read' => true,
        ));
        
        // Caregiver
        add_role('caregiver', __('Caregiver', 'hospital-core'), array(
            'read' => true,
        ));
    }
    
    /**
     * Register REST API Routes
     */
    public function register_rest_routes() {
        register_rest_route('hospital/v1', '/patients', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_patients'),
            'permission_callback' => array($this, 'check_permissions'),
        ));
        
        register_rest_route('hospital/v1', '/appointments', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_appointments'),
            'permission_callback' => array($this, 'check_permissions'),
        ));
    }
    
    public function check_permissions() {
        return current_user_can('read');
    }
    
    public function get_patients($request) {
        // Implementation for getting patients
        return new WP_REST_Response(array('patients' => array()), 200);
    }
    
    public function get_appointments($request) {
        // Implementation for getting appointments
        return new WP_REST_Response(array('appointments' => array()), 200);
    }
    
    /**
     * Add Admin Menu
     */
    public function add_admin_menu() {
        add_menu_page(
            __('Hospital Dashboard', 'hospital-core'),
            __('Hospital', 'hospital-core'),
            'manage_hospital',
            'hospital-dashboard',
            array($this, 'render_dashboard'),
            'dashicons-heart',
            30
        );
    }
    
    public function render_dashboard() {
        include HOSPITAL_CORE_PLUGIN_DIR . 'admin/dashboard.php';
    }
    
    /**
     * Activation
     */
    public function activate() {
        $this->register_post_types();
        $this->register_taxonomies();
        $this->register_user_roles();
        flush_rewrite_rules();
        
        // Create database tables
        Hospital_Database::create_tables();
    }
    
    /**
     * Deactivation
     */
    public function deactivate() {
        flush_rewrite_rules();
    }
}

// Initialize plugin
Hospital_Core_System::get_instance();

