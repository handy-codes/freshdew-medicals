<?php
/**
 * Authentication Handling
 *
 * @package FreshDewClinicSystem
 */

if (!defined('ABSPATH')) {
    exit;
}

class FDCS_Auth {

    public function __construct() {
        // Handle login form submission
        add_action('admin_post_nopriv_fdcs_login', array($this, 'handle_login'));
        add_action('admin_post_fdcs_login', array($this, 'handle_login'));

        // Handle patient registration form submission
        add_action('admin_post_nopriv_fdcs_patient_register', array($this, 'handle_patient_register'));
        add_action('admin_post_fdcs_patient_register', array($this, 'handle_patient_register'));

        // Handle password reset
        add_action('admin_post_nopriv_fdcs_forgot_password', array($this, 'handle_forgot_password'));

        // Handle staff creation (Head Admin only)
        add_action('admin_post_fdcs_create_staff', array($this, 'handle_create_staff'));
    }

    /**
     * Handle login form submission
     */
    public function handle_login() {
        // Verify nonce
        if (!isset($_POST['fdcs_login_nonce']) || !wp_verify_nonce($_POST['fdcs_login_nonce'], 'fdcs_login_action')) {
            wp_redirect(add_query_arg('error', 'security', home_url('/clinic-login')));
            exit;
        }

        $username = sanitize_user($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = !empty($_POST['remember']);

        if (empty($username) || empty($password)) {
            wp_redirect(add_query_arg('error', 'empty', home_url('/clinic-login')));
            exit;
        }

        // Allow login with email
        if (is_email($username)) {
            $user = get_user_by('email', $username);
            if ($user) {
                $username = $user->user_login;
            }
        }

        $credentials = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => $remember,
        );

        $user = wp_signon($credentials, is_ssl());

        if (is_wp_error($user)) {
            // Log failed attempt
            FDCS_Audit_Log::log('login_failed', 'user', 0, 'Username: ' . $username);

            wp_redirect(add_query_arg('error', 'invalid', home_url('/clinic-login')));
            exit;
        }

        // Log successful login
        FDCS_Audit_Log::log('login_success', 'user', $user->ID, 'User logged in');

        // Redirect based on role
        if (in_array('clinic_patient', $user->roles)) {
            wp_redirect(home_url('/patient-portal'));
        } else {
            wp_redirect(home_url('/clinic-dashboard'));
        }
        exit;
    }

    /**
     * Handle patient self-registration
     */
    public function handle_patient_register() {
        // Verify nonce
        if (!isset($_POST['fdcs_register_nonce']) || !wp_verify_nonce($_POST['fdcs_register_nonce'], 'fdcs_register_action')) {
            wp_redirect(add_query_arg('error', 'security', home_url('/clinic-register')));
            exit;
        }

        $first_name = sanitize_text_field($_POST['first_name'] ?? '');
        $last_name = sanitize_text_field($_POST['last_name'] ?? '');
        $email = sanitize_email($_POST['email'] ?? '');
        $phone = sanitize_text_field($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        $date_of_birth = sanitize_text_field($_POST['date_of_birth'] ?? '');
        $gender = sanitize_text_field($_POST['gender'] ?? '');
        $family_history = sanitize_textarea_field($_POST['family_history'] ?? '');
        $drug_history = sanitize_textarea_field($_POST['drug_history'] ?? '');
        $allergy_history = sanitize_textarea_field($_POST['allergy_history'] ?? '');
        $medical_surgical_history = sanitize_textarea_field($_POST['medical_surgical_history'] ?? '');
        $pap_smear_status = sanitize_text_field($_POST['pap_smear_status'] ?? '');
        $last_mammogram = sanitize_text_field($_POST['last_mammogram'] ?? '');
        $other_information = sanitize_textarea_field($_POST['other_information'] ?? '');

        // Validate
        $errors = array();
        if (empty($first_name)) $errors[] = 'First name is required.';
        if (empty($last_name)) $errors[] = 'Last name is required.';
        if (empty($email) || !is_email($email)) $errors[] = 'Valid email is required.';
        if (empty($phone)) $errors[] = 'Phone number is required.';
        if (empty($password) || strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';
        if ($password !== $password_confirm) $errors[] = 'Passwords do not match.';
        if (empty($date_of_birth)) $errors[] = 'Date of birth is required.';
        if (empty($family_history)) $errors[] = 'Family history is required.';
        if (empty($drug_history)) $errors[] = 'Drug history is required.';
        if (empty($allergy_history)) $errors[] = 'Allergy history is required.';
        if (empty($medical_surgical_history)) $errors[] = 'Medical and surgical history is required.';
        if (empty($pap_smear_status)) $errors[] = 'Pap smear status is required.';
        if (empty($last_mammogram)) $errors[] = 'Last mammogram information is required.';

        if (email_exists($email)) $errors[] = 'An account with this email already exists.';
        if (username_exists($email)) $errors[] = 'An account with this email already exists.';

        if (!empty($errors)) {
            $error_string = urlencode(implode('|', $errors));
            wp_redirect(add_query_arg('error', $error_string, home_url('/clinic-register')));
            exit;
        }

        // Set transient to identify this as our registration form
        // This helps the ensure_patient_role_on_registration hook identify our registrations
        $temp_user_id = 0; // Will be set after user creation
        
        // Create WordPress user with clinic_patient role
        $user_id = wp_insert_user(array(
            'user_login'   => $email,
            'user_email'  => $email,
            'user_pass'   => $password,
            'first_name'  => $first_name,
            'last_name'   => $last_name,
            'display_name' => $first_name . ' ' . $last_name,
            'role'        => 'clinic_patient', // Explicitly set role
        ));
        
        if (is_wp_error($user_id)) {
            wp_redirect(add_query_arg('error', 'create_failed', home_url('/clinic-register')));
            exit;
        }

        // Mark this user as registered via our form
        update_user_meta($user_id, 'fdcs_registered_via_form', '1');
        
        // Ensure role is set (double-check)
        $user = new WP_User($user_id);
        if (!in_array('clinic_patient', $user->roles)) {
            $user->set_role('clinic_patient');
        }
        
        // Set additional user meta
        update_user_meta($user_id, 'phone', $phone);

        // Create patient profile in custom table
        global $wpdb;
        $table = FDCS_Database::table('patients');
        $wpdb->insert($table, array(
            'user_id'                => $user_id,
            'date_of_birth'          => $date_of_birth,
            'gender'                 => $gender,
            'family_history'         => $family_history,
            'drug_history'           => $drug_history,
            'allergy_history'       => $allergy_history,
            'medical_surgical_history' => $medical_surgical_history,
            'pap_smear_status'       => $pap_smear_status,
            'last_mammogram'         => $last_mammogram,
            'other_information'      => $other_information,
            'registration_status'    => 'waitlist',
            'created_at'             => current_time('mysql'),
        ), array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));

        // Log registration
        FDCS_Audit_Log::log('patient_registered', 'patient', $user_id, $first_name . ' ' . $last_name . ' registered');

        // Send notification email to clinic
        $contact_info = function_exists('freshdew_get_contact_info') ? freshdew_get_contact_info() : array('email' => get_option('admin_email'));
        $clinic_email = $contact_info['email'] ?? get_option('admin_email');

        wp_mail(
            $clinic_email,
            'New Patient Registration – ' . $first_name . ' ' . $last_name,
            "A new patient has registered on the clinic portal.\n\n" .
            "Name: $first_name $last_name\n" .
            "Email: $email\n" .
            "Phone: $phone\n" .
            "Date of Birth: $date_of_birth\n\n" .
            "Please review their profile in the clinic dashboard.",
            array('Content-Type: text/plain; charset=UTF-8')
        );

        // Auto-login the new patient
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, true);

        wp_redirect(add_query_arg('registered', '1', home_url('/patient-portal')));
        exit;
    }

    /**
     * Handle forgot password request
     */
    public function handle_forgot_password() {
        if (!isset($_POST['fdcs_forgot_nonce']) || !wp_verify_nonce($_POST['fdcs_forgot_nonce'], 'fdcs_forgot_action')) {
            wp_redirect(add_query_arg('error', 'security', home_url('/clinic-login')));
            exit;
        }

        $email = sanitize_email($_POST['email'] ?? '');
        if (empty($email) || !is_email($email)) {
            wp_redirect(add_query_arg(array('tab' => 'forgot', 'error' => 'invalid_email'), home_url('/clinic-login')));
            exit;
        }

        $user = get_user_by('email', $email);
        if ($user) {
            // Generate reset key
            $reset_key = get_password_reset_key($user);
            if (!is_wp_error($reset_key)) {
                $reset_url = network_site_url("wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode($user->user_login), 'login');

                wp_mail(
                    $email,
                    'Password Reset – FreshDew Medical Clinic',
                    "Hello " . $user->display_name . ",\n\n" .
                    "You requested a password reset. Click the link below to set a new password:\n\n" .
                    $reset_url . "\n\n" .
                    "If you did not request this, please ignore this email.\n\n" .
                    "– FreshDew Medical Clinic",
                    array('Content-Type: text/plain; charset=UTF-8')
                );
            }
        }

        // Always show success to prevent email enumeration
        wp_redirect(add_query_arg(array('tab' => 'forgot', 'success' => 'sent'), home_url('/clinic-login')));
        exit;
    }

    /**
     * Handle staff creation (Clinic Admin, Doctor) - Head Admin only
     */
    public function handle_create_staff() {
        // Check user is logged in and has permission
        if (!is_user_logged_in()) {
            wp_redirect(home_url('/clinic-login'));
            exit;
        }

        $current_user = wp_get_current_user();
        if (!current_user_can('fdcs_create_admins') && !current_user_can('fdcs_create_doctors')) {
            wp_redirect(add_query_arg('error', 'permission_denied', home_url('/clinic-dashboard')));
            exit;
        }

        // Verify nonce
        if (!isset($_POST['fdcs_staff_nonce']) || !wp_verify_nonce($_POST['fdcs_staff_nonce'], 'fdcs_create_staff')) {
            wp_redirect(add_query_arg('error', 'security', home_url('/clinic-dashboard')));
            exit;
        }

        $first_name = sanitize_text_field($_POST['first_name'] ?? '');
        $last_name = sanitize_text_field($_POST['last_name'] ?? '');
        $email = sanitize_email($_POST['email'] ?? '');
        $phone = sanitize_text_field($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = sanitize_text_field($_POST['role'] ?? '');

        // Validate role
        $allowed_roles = array();
        if (current_user_can('fdcs_create_admins')) {
            $allowed_roles[] = 'clinic_admin';
        }
        if (current_user_can('fdcs_create_doctors')) {
            $allowed_roles[] = 'clinic_doctor';
        }

        if (!in_array($role, $allowed_roles)) {
            wp_redirect(add_query_arg('error', 'invalid_role', home_url('/clinic-dashboard')));
            exit;
        }

        // Validate
        $errors = array();
        if (empty($first_name)) $errors[] = 'First name is required.';
        if (empty($last_name)) $errors[] = 'Last name is required.';
        if (empty($email) || !is_email($email)) $errors[] = 'Valid email is required.';
        if (empty($phone)) $errors[] = 'Phone number is required.';
        if (empty($password) || strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';

        if (email_exists($email)) $errors[] = 'An account with this email already exists.';

        if (!empty($errors)) {
            $error_string = urlencode(implode('|', $errors));
            wp_redirect(add_query_arg('error', $error_string, home_url('/clinic-dashboard')));
            exit;
        }

        // Create WordPress user with specified role
        $user_id = wp_insert_user(array(
            'user_login'   => $email,
            'user_email'  => $email,
            'user_pass'   => $password,
            'first_name'  => $first_name,
            'last_name'   => $last_name,
            'display_name' => $first_name . ' ' . $last_name,
            'role'        => $role, // Explicitly set role (clinic_admin or clinic_doctor)
        ));
        
        if (is_wp_error($user_id)) {
            wp_redirect(add_query_arg('error', 'create_failed', home_url('/clinic-dashboard')));
            exit;
        }

        // Ensure role is set (double-check)
        $user = new WP_User($user_id);
        if (!in_array($role, $user->roles)) {
            $user->set_role($role);
        }
        
        // Set additional user meta
        update_user_meta($user_id, 'phone', $phone);

        // Log creation
        $role_name = $role === 'clinic_admin' ? 'Clinic Admin' : 'Doctor';
        FDCS_Audit_Log::log('staff_created', 'user', $user_id, "Created $role_name: $first_name $last_name", $current_user->ID);

        // Send welcome email
        wp_mail(
            $email,
            'Welcome to FreshDew Medical Clinic – ' . $role_name . ' Account',
            "Hello $first_name,\n\n" .
            "Your $role_name account has been created at FreshDew Medical Clinic.\n\n" .
            "Login URL: " . home_url('/clinic-login') . "\n" .
            "Email: $email\n" .
            "Password: (the password you set)\n\n" .
            "Please log in and change your password after your first login.\n\n" .
            "– FreshDew Medical Clinic",
            array('Content-Type: text/plain; charset=UTF-8')
        );

        wp_redirect(add_query_arg('success', 'staff_created', home_url('/clinic-dashboard')));
        exit;
    }
}

// Initialize
new FDCS_Auth();

