<?php
/**
 * Plugin Name: EMR Integration - Juno (Pending Government Approval)
 * Plugin URI: https://www.freshdewmedicalclinic.com
 * Description: EMR integration with Juno/OSCAR systems for FreshDew Medical Clinic. Features are pending government approval and API access.
 * Version: 1.0.0
 * Author: FreshDew Medical Clinic
 * Author URI: https://www.freshdewmedicalclinic.com
 * License: Proprietary
 * Text Domain: emr-integration-juno
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('EMR_JUNO_VERSION', '1.0.0');
define('EMR_JUNO_PLUGIN_DIR', plugin_dir_path(__FILE__));

/**
 * Main Plugin Class
 */
class EMR_Integration_Juno {
    
    private static $instance = null;
    private $api_endpoint;
    private $api_key;
    private $api_secret;
    private $is_approved = false; // Set to true when government approval is received
    
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
        // Load configuration
        $this->load_config();
        
        // Register admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Register settings
        add_action('admin_init', array($this, 'register_settings'));
        
        // Register REST API endpoints (will be activated when approved)
        if ($this->is_approved) {
            add_action('rest_api_init', array($this, 'register_rest_routes'));
        }
        
        // Add admin notice if not approved
        if (!$this->is_approved) {
            add_action('admin_notices', array($this, 'show_pending_notice'));
        }
    }
    
    private function load_config() {
        $this->api_endpoint = get_option('emr_juno_api_endpoint', '');
        $this->api_key = get_option('emr_juno_api_key', '');
        $this->api_secret = get_option('emr_juno_api_secret', '');
        $this->is_approved = get_option('emr_juno_approved', false);
    }
    
    public function add_admin_menu() {
        add_menu_page(
            __('EMR Integration (Juno)', 'emr-integration-juno'),
            __('EMR Juno', 'emr-integration-juno'),
            'manage_options',
            'emr-juno-settings',
            array($this, 'render_settings_page'),
            'dashicons-cloud',
            35
        );
    }
    
    public function register_settings() {
        register_setting('emr_juno_settings', 'emr_juno_api_endpoint');
        register_setting('emr_juno_settings', 'emr_juno_api_key');
        register_setting('emr_juno_settings', 'emr_juno_api_secret');
        register_setting('emr_juno_settings', 'emr_juno_approved');
    }
    
    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('EMR Integration - Juno Settings', 'emr-integration-juno'); ?></h1>
            
            <?php if (!$this->is_approved) : ?>
            <div class="notice notice-warning">
                <p><strong><?php esc_html_e('Status: Pending Government Approval', 'emr-integration-juno'); ?></strong></p>
                <p><?php esc_html_e('EMR integration features are currently disabled pending government approval and API access. Once approval is received, update the settings below and enable the integration.', 'emr-integration-juno'); ?></p>
            </div>
            <?php endif; ?>
            
            <form method="post" action="options.php">
                <?php settings_fields('emr_juno_settings'); ?>
                <?php do_settings_sections('emr_juno_settings'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="emr_juno_api_endpoint"><?php esc_html_e('API Endpoint', 'emr-integration-juno'); ?></label>
                        </th>
                        <td>
                            <input type="url" name="emr_juno_api_endpoint" id="emr_juno_api_endpoint" 
                                   value="<?php echo esc_attr($this->api_endpoint); ?>" 
                                   class="regular-text" 
                                   <?php echo !$this->is_approved ? 'disabled' : ''; ?>>
                            <p class="description"><?php esc_html_e('Juno/OSCAR EMR API endpoint URL', 'emr-integration-juno'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="emr_juno_api_key"><?php esc_html_e('API Key', 'emr-integration-juno'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="emr_juno_api_key" id="emr_juno_api_key" 
                                   value="<?php echo esc_attr($this->api_key); ?>" 
                                   class="regular-text" 
                                   <?php echo !$this->is_approved ? 'disabled' : ''; ?>>
                            <p class="description"><?php esc_html_e('API key provided by EMR vendor', 'emr-integration-juno'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="emr_juno_api_secret"><?php esc_html_e('API Secret', 'emr-integration-juno'); ?></label>
                        </th>
                        <td>
                            <input type="password" name="emr_juno_api_secret" id="emr_juno_api_secret" 
                                   value="<?php echo esc_attr($this->api_secret); ?>" 
                                   class="regular-text" 
                                   <?php echo !$this->is_approved ? 'disabled' : ''; ?>>
                            <p class="description"><?php esc_html_e('API secret for authentication', 'emr-integration-juno'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="emr_juno_approved"><?php esc_html_e('Government Approval Received', 'emr-integration-juno'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" name="emr_juno_approved" id="emr_juno_approved" 
                                   value="1" <?php checked($this->is_approved, true); ?>>
                            <p class="description"><?php esc_html_e('Check this box once government approval and API access have been received', 'emr-integration-juno'); ?></p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>
            </form>
            
            <?php if ($this->is_approved) : ?>
            <div class="card" style="margin-top: 20px;">
                <h2><?php esc_html_e('Integration Status', 'emr-integration-juno'); ?></h2>
                <p><?php esc_html_e('EMR integration is active. The following features are available:', 'emr-integration-juno'); ?></p>
                <ul>
                    <li><?php esc_html_e('Patient data synchronization', 'emr-integration-juno'); ?></li>
                    <li><?php esc_html_e('Medical record import/export', 'emr-integration-juno'); ?></li>
                    <li><?php esc_html_e('Prescription management', 'emr-integration-juno'); ?></li>
                    <li><?php esc_html_e('Lab results integration', 'emr-integration-juno'); ?></li>
                    <li><?php esc_html_e('Appointment synchronization', 'emr-integration-juno'); ?></li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
        <?php
    }
    
    public function show_pending_notice() {
        ?>
        <div class="notice notice-info">
            <p><strong><?php esc_html_e('EMR Integration Status:', 'emr-integration-juno'); ?></strong> 
            <?php esc_html_e('Features are pending government approval. Integration will be activated once approval is received.', 'emr-integration-juno'); ?></p>
        </div>
        <?php
    }
    
    /**
     * Register REST API Routes (Active when approved)
     */
    public function register_rest_routes() {
        register_rest_route('hospital-emr/v1', '/sync-patient', array(
            'methods' => 'POST',
            'callback' => array($this, 'sync_patient'),
            'permission_callback' => array($this, 'check_permissions'),
        ));
        
        register_rest_route('hospital-emr/v1', '/sync-record', array(
            'methods' => 'POST',
            'callback' => array($this, 'sync_record'),
            'permission_callback' => array($this, 'check_permissions'),
        ));
        
        register_rest_route('hospital-emr/v1', '/lab-results/(?P<patient_id>\d+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_lab_results'),
            'permission_callback' => array($this, 'check_permissions'),
        ));
    }
    
    public function check_permissions() {
        return current_user_can('manage_options');
    }
    
    /**
     * Sync patient data with EMR (Implementation pending approval)
     */
    public function sync_patient($request) {
        if (!$this->is_approved) {
            return new WP_Error('not_approved', 'EMR integration is pending government approval.', array('status' => 403));
        }
        
        $patient_id = $request->get_param('patient_id');
        // Implementation will be added once API access is available
        return new WP_REST_Response(array('message' => 'Patient sync feature will be available after API access is configured.'), 200);
    }
    
    /**
     * Sync medical record with EMR (Implementation pending approval)
     */
    public function sync_record($request) {
        if (!$this->is_approved) {
            return new WP_Error('not_approved', 'EMR integration is pending government approval.', array('status' => 403));
        }
        
        $record_id = $request->get_param('record_id');
        // Implementation will be added once API access is available
        return new WP_REST_Response(array('message' => 'Record sync feature will be available after API access is configured.'), 200);
    }
    
    /**
     * Get lab results from EMR (Implementation pending approval)
     */
    public function get_lab_results($request) {
        if (!$this->is_approved) {
            return new WP_Error('not_approved', 'EMR integration is pending government approval.', array('status' => 403));
        }
        
        $patient_id = $request->get_param('patient_id');
        // Implementation will be added once API access is available
        return new WP_REST_Response(array('message' => 'Lab results feature will be available after API access is configured.'), 200);
    }
}

EMR_Integration_Juno::get_instance();

