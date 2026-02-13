<?php
/**
 * Plugin Name: FreshDew Clinic System
 * Plugin URI: https://freshdewmedicalclinic.com
 * Description: Authentication, Role-Based Access Control, and Dashboard system for FreshDew Medical Clinic.
 * Version: 1.0.0
 * Author: FreshDew Medical Clinic
 * Author URI: https://freshdewmedicalclinic.com
 * License: Proprietary
 * Text Domain: freshdew-clinic
 * Requires at least: 6.0
 * Requires PHP: 8.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Plugin constants
define('FDCS_VERSION', '1.0.0');
define('FDCS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FDCS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('FDCS_TABLE_PREFIX', 'fd_');

/**
 * Main Plugin Class
 */
final class FreshDew_Clinic_System {

    private static $instance = null;

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->load_dependencies();
        $this->init_hooks();
    }

    private function load_dependencies() {
        require_once FDCS_PLUGIN_DIR . 'includes/class-roles.php';
        require_once FDCS_PLUGIN_DIR . 'includes/class-database.php';
        require_once FDCS_PLUGIN_DIR . 'includes/class-auth.php';
        require_once FDCS_PLUGIN_DIR . 'includes/class-patient.php';
        require_once FDCS_PLUGIN_DIR . 'includes/class-appointment.php';
        require_once FDCS_PLUGIN_DIR . 'includes/class-audit-log.php';

        if (is_admin()) {
            require_once FDCS_PLUGIN_DIR . 'admin/class-admin-dashboard.php';
        }

        require_once FDCS_PLUGIN_DIR . 'api/rest-endpoints.php';
    }

    private function init_hooks() {
        // Activation / Deactivation
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        // Init
        add_action('init', array($this, 'init'), 5);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));

        // Catch requests early - before WordPress processes them
        add_action('parse_request', array($this, 'catch_custom_routes'), 1);
        
        // Template redirects for dashboards - use early priority as backup
        add_action('template_redirect', array($this, 'dashboard_template_redirect'), 1);
        
        // Prevent WordPress from loading page templates for our custom routes
        add_filter('template_include', array($this, 'prevent_page_template'), 1);

        // Login/Logout redirects
        add_filter('login_redirect', array($this, 'role_based_login_redirect'), 10, 3);
        add_action('wp_logout', array($this, 'logout_redirect'));

        // Set default role for new user registrations to clinic_patient
        add_filter('pre_option_default_role', array($this, 'set_default_user_role'));
        
        // Ensure users created through our registration form get clinic_patient role
        add_action('user_register', array($this, 'ensure_patient_role_on_registration'), 10, 1);

        // Patient management actions
        add_action('admin_post_fdcs_update_patient_status', array($this, 'handle_update_patient_status'));
        add_action('admin_post_fdcs_assign_doctor', array($this, 'handle_assign_doctor'));
    }

    public function activate() {
        // Create custom roles
        FDCS_Roles::create_roles();

        // Create database tables
        FDCS_Database::create_tables();

        // Flush rewrite rules
        flush_rewrite_rules();

        // Log activation
        update_option('fdcs_version', FDCS_VERSION);
        update_option('fdcs_activated', current_time('mysql'));
    }

    public function deactivate() {
        flush_rewrite_rules();
    }

    public function init() {
        // Register custom rewrite rules for dashboard pages
        add_rewrite_rule('^clinic-dashboard/?$', 'index.php?fdcs_dashboard=1', 'top');
        add_rewrite_rule('^patient-portal/?$', 'index.php?fdcs_patient_portal=1', 'top');
        add_rewrite_rule('^clinic-login/?$', 'index.php?fdcs_login=1', 'top');
        add_rewrite_rule('^clinic-register/?$', 'index.php?fdcs_register=1', 'top');

        // Register query vars
        add_filter('query_vars', function ($vars) {
            $vars[] = 'fdcs_dashboard';
            $vars[] = 'fdcs_patient_portal';
            $vars[] = 'fdcs_login';
            $vars[] = 'fdcs_register';
            return $vars;
        });
        
        // Flush rewrite rules if needed (only once)
        if (!get_option('fdcs_rewrite_rules_flushed')) {
            flush_rewrite_rules();
            update_option('fdcs_rewrite_rules_flushed', true);
        }
    }

    public function enqueue_frontend_assets() {
        wp_enqueue_style(
            'fdcs-frontend',
            FDCS_PLUGIN_URL . 'assets/css/dashboard.css',
            array(),
            FDCS_VERSION
        );
    }

    public function enqueue_admin_assets($hook) {
        if (strpos($hook, 'fdcs') === false && strpos($hook, 'freshdew') === false) {
            return;
        }
        wp_enqueue_style(
            'fdcs-admin',
            FDCS_PLUGIN_URL . 'assets/css/dashboard.css',
            array(),
            FDCS_VERSION
        );
        wp_enqueue_script(
            'fdcs-admin',
            FDCS_PLUGIN_URL . 'assets/js/dashboard.js',
            array('jquery'),
            FDCS_VERSION,
            true
        );
        wp_localize_script('fdcs-admin', 'fdcsAdmin', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'restUrl' => rest_url('fdcs/v1/'),
            'nonce' => wp_create_nonce('fdcs_nonce'),
        ));
    }

    /**
     * Catch custom routes early in parse_request
     */
    public function catch_custom_routes($wp) {
        if (!isset($_SERVER['REQUEST_URI'])) {
            return;
        }
        
        $request_uri = strtok($_SERVER['REQUEST_URI'], '?');
        $request_uri = trim($request_uri, '/');
        $home_path = trim(parse_url(home_url(), PHP_URL_PATH), '/');
        
        if ($home_path && strpos($request_uri, $home_path) === 0) {
            $request_uri = trim(substr($request_uri, strlen($home_path)), '/');
        }
        
        $custom_routes = array('clinic-login', 'clinic-register', 'clinic-dashboard', 'patient-portal');
        
        foreach ($custom_routes as $route) {
            if ($request_uri === $route || strpos($request_uri, $route . '/') === 0) {
                // Set query vars so template_redirect can catch them
                $wp->query_vars[$this->get_route_query_var($route)] = '1';
                break;
            }
        }
    }
    
    /**
     * Get query var name for a route
     */
    private function get_route_query_var($route) {
        $map = array(
            'clinic-login' => 'fdcs_login',
            'clinic-register' => 'fdcs_register',
            'clinic-dashboard' => 'fdcs_dashboard',
            'patient-portal' => 'fdcs_patient_portal',
        );
        return isset($map[$route]) ? $map[$route] : '';
    }
    
    /**
     * Route users to dashboard templates based on query vars or direct URL matching
     */
    public function dashboard_template_redirect() {
        // Get the request URI - handle both with and without query strings
        $request_uri = strtok($_SERVER['REQUEST_URI'], '?');
        $request_uri = trim($request_uri, '/');
        $home_path = trim(parse_url(home_url(), PHP_URL_PATH), '/');
        
        // Remove home path from request URI if present
        if ($home_path && strpos($request_uri, $home_path) === 0) {
            $request_uri = trim(substr($request_uri, strlen($home_path)), '/');
        }
        
        // Check query vars first (for rewrite rules), then direct URI matching
        $is_login = get_query_var('fdcs_login') || $request_uri === 'clinic-login' || strpos($request_uri, 'clinic-login') === 0;
        $is_register = get_query_var('fdcs_register') || $request_uri === 'clinic-register' || strpos($request_uri, 'clinic-register') === 0;
        $is_dashboard = get_query_var('fdcs_dashboard') || $request_uri === 'clinic-dashboard' || strpos($request_uri, 'clinic-dashboard') === 0;
        $is_patient_portal = get_query_var('fdcs_patient_portal') || $request_uri === 'patient-portal' || strpos($request_uri, 'patient-portal') === 0;
        
        if ($is_login) {
            if (is_user_logged_in()) {
                $this->redirect_to_dashboard();
                exit;
            }
            // Prevent WordPress from loading theme templates
            global $wp_query;
            $wp_query->is_404 = false;
            $wp_query->is_page = false;
            $wp_query->is_singular = false;
            status_header(200);
            include FDCS_PLUGIN_DIR . 'templates/login.php';
            exit;
        }

        if ($is_register) {
            if (is_user_logged_in()) {
                $this->redirect_to_dashboard();
                exit;
            }
            global $wp_query;
            $wp_query->is_404 = false;
            $wp_query->is_page = false;
            $wp_query->is_singular = false;
            status_header(200);
            include FDCS_PLUGIN_DIR . 'templates/register-patient.php';
            exit;
        }

        if ($is_dashboard) {
            if (!is_user_logged_in()) {
                wp_redirect(home_url('/clinic-login'));
                exit;
            }
            $user = wp_get_current_user();
            $roles = $user->roles;

            global $wp_query;
            $wp_query->is_404 = false;
            $wp_query->is_page = false;
            $wp_query->is_singular = false;
            status_header(200);
            if (in_array('head_admin', $roles) || in_array('administrator', $roles)) {
                include FDCS_PLUGIN_DIR . 'admin/dashboard-head-admin.php';
            } elseif (in_array('clinic_admin', $roles)) {
                include FDCS_PLUGIN_DIR . 'admin/dashboard-admin.php';
            } elseif (in_array('clinic_doctor', $roles)) {
                include FDCS_PLUGIN_DIR . 'admin/dashboard-doctor.php';
            } else {
                // Fallback — patients go to patient portal
                wp_redirect(home_url('/patient-portal'));
            }
            exit;
        }

        if ($is_patient_portal) {
            if (!is_user_logged_in()) {
                wp_redirect(home_url('/clinic-login'));
                exit;
            }
            global $wp_query;
            $wp_query->is_404 = false;
            $wp_query->is_page = false;
            $wp_query->is_singular = false;
            status_header(200);
            include FDCS_PLUGIN_DIR . 'patient/dashboard.php';
            exit;
        }
    }

    /**
     * Redirect user to their appropriate dashboard based on role
     */
    public function redirect_to_dashboard() {
        $user = wp_get_current_user();
        if (in_array('clinic_patient', $user->roles)) {
            wp_redirect(home_url('/patient-portal'));
        } else {
            wp_redirect(home_url('/clinic-dashboard'));
        }
    }

    /**
     * After login, redirect user to role-appropriate dashboard
     */
    public function role_based_login_redirect($redirect_to, $requested_redirect_to, $user) {
        if (is_wp_error($user)) {
            return $redirect_to;
        }

        if (in_array('clinic_patient', $user->roles)) {
            return home_url('/patient-portal');
        }

        if (in_array('head_admin', $user->roles) || in_array('administrator', $user->roles) ||
            in_array('clinic_admin', $user->roles) || in_array('clinic_doctor', $user->roles)) {
            return home_url('/clinic-dashboard');
        }

        return $redirect_to;
    }

    /**
     * After logout, redirect to clinic login page
     */
    public function logout_redirect() {
        wp_redirect(home_url('/clinic-login'));
        exit;
    }
    
    /**
     * Set default role for new user registrations to clinic_patient
     * This ensures that any new user registration defaults to patient role
     */
    public function set_default_user_role($default_role) {
        // Don't change default role if user is being created from WordPress admin
        // Check if we're in the admin area and user has permission to create users
        if (is_admin() && current_user_can('create_users')) {
            return $default_role;
        }
        
        // For frontend registrations, default to clinic_patient
        return 'clinic_patient';
    }

    /**
     * Ensure users registered through our form get clinic_patient role
     * This is a safety net in case role assignment fails during registration
     */
    public function ensure_patient_role_on_registration($user_id) {
        // Check if this registration came from our form
        if (get_user_meta($user_id, 'fdcs_registered_via_form', true)) {
            $user = new WP_User($user_id);
            $roles = $user->roles;
            
            // If user doesn't have clinic_patient role, assign it
            if (!in_array('clinic_patient', $roles)) {
                $user->set_role('clinic_patient');
            }
        }
    }

    /**
     * Handle patient status update (waitlist to active, etc.)
     */
    public function handle_update_patient_status() {
        if (!is_user_logged_in() || (!current_user_can('fdcs_view_all_patients') && !current_user_can('fdcs_edit_all_patients'))) {
            wp_redirect(add_query_arg('error', 'permission_denied', home_url('/clinic-dashboard')));
            exit;
        }

        if (!isset($_POST['fdcs_patient_status_nonce']) || !wp_verify_nonce($_POST['fdcs_patient_status_nonce'], 'fdcs_update_patient_status')) {
            wp_redirect(add_query_arg('error', 'security', home_url('/clinic-dashboard')));
            exit;
        }

        $patient_id = (int) ($_POST['patient_id'] ?? 0);
        $new_status = sanitize_text_field($_POST['status'] ?? '');

        if (!$patient_id || !in_array($new_status, array('waitlist', 'active'))) {
            wp_redirect(add_query_arg('error', 'invalid_data', home_url('/clinic-dashboard')));
            exit;
        }

        $result = FDCS_Patient::update($patient_id, array('registration_status' => $new_status));

        if ($result !== false) {
            $patient = FDCS_Patient::get($patient_id);
            $user = get_user_by('ID', $patient->user_id);
            
            // Log action
            FDCS_Audit_Log::log('patient_status_changed', 'patient', $patient_id, "Status changed to: $new_status", get_current_user_id());
            
            // Send email notification if activated
            if ($new_status === 'active' && $user) {
                wp_mail(
                    $user->user_email,
                    'Account Activated – FreshDew Medical Clinic',
                    "Hello " . $user->display_name . ",\n\n" .
                    "Your patient account has been activated. You can now access all features of the patient portal.\n\n" .
                    "Login: " . home_url('/clinic-login') . "\n\n" .
                    "Thank you for choosing FreshDew Medical Clinic!",
                    array('Content-Type: text/plain; charset=UTF-8')
                );
            }
            
            wp_redirect(add_query_arg('success', 'patient_status_updated', home_url('/clinic-dashboard')));
        } else {
            wp_redirect(add_query_arg('error', 'update_failed', home_url('/clinic-dashboard')));
        }
        exit;
    }

    /**
     * Handle doctor assignment to patient
     */
    public function handle_assign_doctor() {
        if (!is_user_logged_in() || (!current_user_can('fdcs_view_all_patients') && !current_user_can('fdcs_edit_all_patients'))) {
            wp_redirect(add_query_arg('error', 'permission_denied', home_url('/clinic-dashboard')));
            exit;
        }

        if (!isset($_POST['fdcs_assign_doctor_nonce']) || !wp_verify_nonce($_POST['fdcs_assign_doctor_nonce'], 'fdcs_assign_doctor')) {
            wp_redirect(add_query_arg('error', 'security', home_url('/clinic-dashboard')));
            exit;
        }

        $patient_id = (int) ($_POST['patient_id'] ?? 0);
        $doctor_id = (int) ($_POST['doctor_id'] ?? 0);

        if (!$patient_id) {
            wp_redirect(add_query_arg('error', 'invalid_patient', home_url('/clinic-dashboard')));
            exit;
        }

        // Verify doctor exists and has clinic_doctor role
        if ($doctor_id > 0) {
            $doctor = get_user_by('ID', $doctor_id);
            if (!$doctor || !in_array('clinic_doctor', $doctor->roles)) {
                wp_redirect(add_query_arg('error', 'invalid_doctor', home_url('/clinic-dashboard')));
                exit;
            }
        }

        $result = FDCS_Patient::update($patient_id, array('assigned_doctor_id' => $doctor_id > 0 ? $doctor_id : null));

        if ($result !== false) {
            $patient = FDCS_Patient::get($patient_id);
            $doctor_name = $doctor_id > 0 ? get_user_by('ID', $doctor_id)->display_name : 'Unassigned';
            
            FDCS_Audit_Log::log('doctor_assigned', 'patient', $patient_id, "Assigned to: $doctor_name", get_current_user_id());
            
            wp_redirect(add_query_arg('success', 'doctor_assigned', home_url('/clinic-dashboard')));
        } else {
            wp_redirect(add_query_arg('error', 'assignment_failed', home_url('/clinic-dashboard')));
        }
        exit;
    }

    /**
     * Prevent WordPress from loading page templates for our custom routes
     */
    public function prevent_page_template($template) {
        $request_uri = trim($_SERVER['REQUEST_URI'], '/');
        $home_path = trim(parse_url(home_url(), PHP_URL_PATH), '/');
        
        if ($home_path && strpos($request_uri, $home_path) === 0) {
            $request_uri = trim(substr($request_uri, strlen($home_path)), '/');
        }
        
        $custom_routes = array('clinic-login', 'clinic-register', 'clinic-dashboard', 'patient-portal');
        
        foreach ($custom_routes as $route) {
            if ($request_uri === $route || strpos($request_uri, $route . '/') === 0) {
                // Return a minimal template to prevent WordPress from loading page.php
                return get_template_directory() . '/index.php';
            }
        }
        
        return $template;
    }
}

// Initialize plugin
function fdcs() {
    return FreshDew_Clinic_System::instance();
}
add_action('plugins_loaded', 'fdcs');

