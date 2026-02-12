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

        // Template redirects for dashboards
        add_action('template_redirect', array($this, 'dashboard_template_redirect'));

        // Login/Logout redirects
        add_filter('login_redirect', array($this, 'role_based_login_redirect'), 10, 3);
        add_action('wp_logout', array($this, 'logout_redirect'));
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
     * Route users to dashboard templates based on query vars
     */
    public function dashboard_template_redirect() {
        if (get_query_var('fdcs_login')) {
            if (is_user_logged_in()) {
                $this->redirect_to_dashboard();
                exit;
            }
            include FDCS_PLUGIN_DIR . 'templates/login.php';
            exit;
        }

        if (get_query_var('fdcs_register')) {
            if (is_user_logged_in()) {
                $this->redirect_to_dashboard();
                exit;
            }
            include FDCS_PLUGIN_DIR . 'templates/register-patient.php';
            exit;
        }

        if (get_query_var('fdcs_dashboard')) {
            if (!is_user_logged_in()) {
                wp_redirect(home_url('/clinic-login'));
                exit;
            }
            $user = wp_get_current_user();
            $roles = $user->roles;

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

        if (get_query_var('fdcs_patient_portal')) {
            if (!is_user_logged_in()) {
                wp_redirect(home_url('/clinic-login'));
                exit;
            }
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
     * After logout, redirect to homepage
     */
    public function logout_redirect() {
        wp_redirect(home_url('/'));
        exit;
    }
}

// Initialize plugin
function fdcs() {
    return FreshDew_Clinic_System::instance();
}
add_action('plugins_loaded', 'fdcs');

