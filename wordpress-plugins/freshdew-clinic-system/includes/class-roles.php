<?php
/**
 * Custom Roles and Capabilities
 *
 * @package FreshDewClinicSystem
 */

if (!defined('ABSPATH')) {
    exit;
}

class FDCS_Roles {

    /**
     * Create all custom roles on plugin activation
     */
    public static function create_roles() {
        // Head Admin / CMO — full control
        add_role('head_admin', __('Head Admin (CMO)', 'freshdew-clinic'), array(
            'read'                      => true,
            'edit_posts'                => true,
            'edit_pages'                => true,
            'edit_others_posts'         => true,
            'edit_others_pages'         => true,
            'publish_posts'             => true,
            'publish_pages'             => true,
            'delete_posts'              => true,
            'delete_pages'              => true,
            'manage_options'            => false, // WordPress core options — keep false for safety
            'upload_files'              => true,
            // Custom capabilities
            'fdcs_manage_users'         => true,
            'fdcs_create_admins'        => true,
            'fdcs_create_doctors'       => true,
            'fdcs_create_staff'         => true,
            'fdcs_view_all_patients'    => true,
            'fdcs_edit_all_patients'    => true,
            'fdcs_delete_patients'      => true,
            'fdcs_manage_appointments'  => true,
            'fdcs_view_reports'         => true,
            'fdcs_export_data'          => true,
            'fdcs_manage_settings'      => true,
            'fdcs_view_audit_log'       => true,
            'fdcs_manage_content'       => true,
            'fdcs_access_dashboard'     => true,
        ));

        // Clinic Admin / Office Manager
        add_role('clinic_admin', __('Clinic Admin', 'freshdew-clinic'), array(
            'read'                      => true,
            'edit_posts'                => true,
            'edit_pages'                => true,
            'publish_posts'             => true,
            'upload_files'              => true,
            // Custom capabilities
            'fdcs_manage_users'         => true,
            'fdcs_create_staff'         => true,
            'fdcs_view_all_patients'    => true,
            'fdcs_edit_all_patients'    => true,
            'fdcs_manage_appointments'  => true,
            'fdcs_view_reports'         => true,
            'fdcs_manage_content'       => true,
            'fdcs_access_dashboard'     => true,
        ));

        // Doctor
        add_role('clinic_doctor', __('Doctor', 'freshdew-clinic'), array(
            'read'                      => true,
            'upload_files'              => true,
            // Custom capabilities
            'fdcs_view_own_patients'    => true,
            'fdcs_edit_own_patients'    => true,
            'fdcs_manage_own_appointments' => true,
            'fdcs_write_medical_notes'  => true,
            'fdcs_write_prescriptions'  => true,
            'fdcs_create_referrals'     => true,
            'fdcs_access_telehealth'    => true,
            'fdcs_access_dashboard'     => true,
        ));

        // Patient
        add_role('clinic_patient', __('Patient', 'freshdew-clinic'), array(
            'read'                      => true,
            // Custom capabilities
            'fdcs_view_own_profile'     => true,
            'fdcs_edit_own_profile'     => true,
            'fdcs_book_appointments'    => true,
            'fdcs_view_own_records'     => true,
            'fdcs_send_messages'        => true,
            'fdcs_access_telehealth'    => true,
            'fdcs_access_patient_portal' => true,
        ));

        // Also grant head_admin caps to the default administrator role
        $admin = get_role('administrator');
        if ($admin) {
            $admin->add_cap('fdcs_manage_users');
            $admin->add_cap('fdcs_create_admins');
            $admin->add_cap('fdcs_create_doctors');
            $admin->add_cap('fdcs_create_staff');
            $admin->add_cap('fdcs_view_all_patients');
            $admin->add_cap('fdcs_edit_all_patients');
            $admin->add_cap('fdcs_delete_patients');
            $admin->add_cap('fdcs_manage_appointments');
            $admin->add_cap('fdcs_view_reports');
            $admin->add_cap('fdcs_export_data');
            $admin->add_cap('fdcs_manage_settings');
            $admin->add_cap('fdcs_view_audit_log');
            $admin->add_cap('fdcs_manage_content');
            $admin->add_cap('fdcs_access_dashboard');
        }
    }

    /**
     * Remove custom roles on plugin uninstall (not deactivation)
     */
    public static function remove_roles() {
        remove_role('head_admin');
        remove_role('clinic_admin');
        remove_role('clinic_doctor');
        remove_role('clinic_patient');

        // Remove custom caps from administrator
        $admin = get_role('administrator');
        if ($admin) {
            $caps = array(
                'fdcs_manage_users', 'fdcs_create_admins', 'fdcs_create_doctors',
                'fdcs_create_staff', 'fdcs_view_all_patients', 'fdcs_edit_all_patients',
                'fdcs_delete_patients', 'fdcs_manage_appointments', 'fdcs_view_reports',
                'fdcs_export_data', 'fdcs_manage_settings', 'fdcs_view_audit_log',
                'fdcs_manage_content', 'fdcs_access_dashboard',
            );
            foreach ($caps as $cap) {
                $admin->remove_cap($cap);
            }
        }
    }

    /**
     * Check if current user has a specific clinic role
     */
    public static function is_clinic_staff($user = null) {
        if (!$user) {
            $user = wp_get_current_user();
        }
        $staff_roles = array('head_admin', 'clinic_admin', 'clinic_doctor', 'administrator');
        return !empty(array_intersect($staff_roles, (array) $user->roles));
    }

    /**
     * Check if current user is a patient
     */
    public static function is_patient($user = null) {
        if (!$user) {
            $user = wp_get_current_user();
        }
        return in_array('clinic_patient', (array) $user->roles);
    }

    /**
     * Get the highest clinic role for a user
     */
    public static function get_clinic_role($user = null) {
        if (!$user) {
            $user = wp_get_current_user();
        }
        $role_priority = array('head_admin', 'administrator', 'clinic_admin', 'clinic_doctor', 'clinic_patient');
        foreach ($role_priority as $role) {
            if (in_array($role, (array) $user->roles)) {
                return $role;
            }
        }
        return 'none';
    }
}

