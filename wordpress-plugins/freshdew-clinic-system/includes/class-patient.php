<?php
/**
 * Patient Data Management
 *
 * @package FreshDewClinicSystem
 */

if (!defined('ABSPATH')) {
    exit;
}

class FDCS_Patient {

    /**
     * Get patient profile by user ID
     */
    public static function get_by_user_id($user_id) {
        global $wpdb;
        $table = FDCS_Database::table('patients');
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE user_id = %d", $user_id));
    }

    /**
     * Get patient profile by patient ID
     */
    public static function get($patient_id) {
        global $wpdb;
        $table = FDCS_Database::table('patients');
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $patient_id));
    }

    /**
     * Get all patients with optional filters
     */
    public static function get_all($args = array()) {
        global $wpdb;
        $table = FDCS_Database::table('patients');

        $defaults = array(
            'status'    => '',
            'doctor_id' => 0,
            'search'    => '',
            'orderby'   => 'created_at',
            'order'     => 'DESC',
            'limit'     => 20,
            'offset'    => 0,
        );
        $args = wp_parse_args($args, $defaults);

        $where = array('1=1');
        $values = array();

        if (!empty($args['status'])) {
            $where[] = 'p.registration_status = %s';
            $values[] = $args['status'];
        }

        if (!empty($args['doctor_id'])) {
            $where[] = 'p.assigned_doctor_id = %d';
            $values[] = (int) $args['doctor_id'];
        }

        if (!empty($args['search'])) {
            $like = '%' . $wpdb->esc_like($args['search']) . '%';
            $where[] = '(u.display_name LIKE %s OR u.user_email LIKE %s)';
            $values[] = $like;
            $values[] = $like;
        }

        $where_sql = implode(' AND ', $where);
        $orderby = sanitize_sql_orderby($args['orderby'] . ' ' . $args['order']) ?: 'p.created_at DESC';

        $sql = "SELECT p.*, u.display_name, u.user_email
                FROM $table p
                JOIN {$wpdb->users} u ON p.user_id = u.ID
                WHERE $where_sql
                ORDER BY $orderby
                LIMIT %d OFFSET %d";

        $values[] = (int) $args['limit'];
        $values[] = (int) $args['offset'];

        if (!empty($values)) {
            $sql = $wpdb->prepare($sql, ...$values);
        }

        return $wpdb->get_results($sql);
    }

    /**
     * Count patients with optional filters
     * Counts all WordPress users with clinic_patient role, optionally filtered by custom table status
     */
    public static function count($args = array()) {
        global $wpdb;
        $table = FDCS_Database::table('patients');

        // If filtering by status, we need to join with the custom table
        if (!empty($args['status'])) {
            $where = array('um.meta_value = %s', 'um.meta_key = %s');
            $values = array('clinic_patient', $wpdb->get_blog_prefix() . 'capabilities');
            
            $where[] = 'p.registration_status = %s';
            $values[] = $args['status'];
            
            $where_sql = implode(' AND ', $where);
            $sql = "SELECT COUNT(DISTINCT u.ID) 
                    FROM {$wpdb->users} u
                    INNER JOIN {$wpdb->usermeta} um ON u.ID = um.user_id
                    LEFT JOIN $table p ON u.ID = p.user_id
                    WHERE $where_sql";
            
            if (!empty($values)) {
                $sql = $wpdb->prepare($sql, ...$values);
            }
        } else {
            // Count all users with clinic_patient role
            $sql = $wpdb->prepare(
                "SELECT COUNT(DISTINCT u.ID) 
                 FROM {$wpdb->users} u
                 INNER JOIN {$wpdb->usermeta} um ON u.ID = um.user_id
                 WHERE um.meta_key = %s AND um.meta_value LIKE %s",
                $wpdb->get_blog_prefix() . 'capabilities',
                '%clinic_patient%'
            );
        }

        return (int) $wpdb->get_var($sql);
    }

    /**
     * Update patient profile
     */
    public static function update($patient_id, $data) {
        global $wpdb;
        $table = FDCS_Database::table('patients');

        $allowed_fields = array(
            'date_of_birth', 'gender', 'health_card_number',
            'emergency_contact_name', 'emergency_contact_phone',
            'family_history', 'drug_history', 'allergy_history',
            'medical_surgical_history', 'pap_smear_status',
            'last_mammogram', 'other_information', 'blood_type',
            'assigned_doctor_id', 'registration_status',
        );

        $update_data = array();
        $formats = array();
        foreach ($allowed_fields as $field) {
            if (isset($data[$field])) {
                $update_data[$field] = $data[$field];
                $formats[] = is_int($data[$field]) ? '%d' : '%s';
            }
        }

        if (empty($update_data)) {
            return false;
        }

        return $wpdb->update($table, $update_data, array('id' => $patient_id), $formats, array('%d'));
    }

    /**
     * Get patients assigned to a specific doctor
     */
    public static function get_by_doctor($doctor_user_id, $limit = 50) {
        global $wpdb;
        $table = FDCS_Database::table('patients');
        return $wpdb->get_results($wpdb->prepare(
            "SELECT p.*, u.display_name, u.user_email
             FROM $table p
             JOIN {$wpdb->users} u ON p.user_id = u.ID
             WHERE p.assigned_doctor_id = %d
             ORDER BY u.display_name ASC
             LIMIT %d",
            $doctor_user_id,
            $limit
        ));
    }
}

