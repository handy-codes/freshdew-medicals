<?php
/**
 * Appointment Management
 *
 * @package FreshDewClinicSystem
 */

if (!defined('ABSPATH')) {
    exit;
}

class FDCS_Appointment {

    /**
     * Create a new appointment
     */
    public static function create($data) {
        global $wpdb;
        $table = FDCS_Database::table('appointments');

        $result = $wpdb->insert($table, array(
            'patient_id'       => (int) $data['patient_id'],
            'doctor_id'        => (int) $data['doctor_id'],
            'appointment_date' => sanitize_text_field($data['appointment_date']),
            'appointment_time' => sanitize_text_field($data['appointment_time']),
            'duration_minutes' => (int) ($data['duration_minutes'] ?? 30),
            'type'             => sanitize_text_field($data['type'] ?? 'scheduled'),
            'status'           => 'scheduled',
            'reason'           => sanitize_textarea_field($data['reason'] ?? ''),
            'symptoms'         => sanitize_textarea_field($data['symptoms'] ?? ''),
            'created_by'       => get_current_user_id(),
            'created_at'       => current_time('mysql'),
        ), array('%d', '%d', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%d', '%s'));

        if ($result) {
            $appointment_id = $wpdb->insert_id;
            FDCS_Audit_Log::log('appointment_created', 'appointment', $appointment_id, 'New appointment scheduled');
            return $appointment_id;
        }

        return false;
    }

    /**
     * Get appointment by ID
     */
    public static function get($appointment_id) {
        global $wpdb;
        $table = FDCS_Database::table('appointments');
        $patients = FDCS_Database::table('patients');

        return $wpdb->get_row($wpdb->prepare(
            "SELECT a.*, 
                    pat_user.display_name as patient_name, 
                    pat_user.user_email as patient_email,
                    doc_user.display_name as doctor_name
             FROM $table a
             LEFT JOIN $patients p ON a.patient_id = p.id
             LEFT JOIN {$wpdb->users} pat_user ON p.user_id = pat_user.ID
             LEFT JOIN {$wpdb->users} doc_user ON a.doctor_id = doc_user.ID
             WHERE a.id = %d",
            $appointment_id
        ));
    }

    /**
     * Get appointments for a specific date
     */
    public static function get_by_date($date, $doctor_id = 0) {
        global $wpdb;
        $table = FDCS_Database::table('appointments');
        $patients = FDCS_Database::table('patients');

        $where = 'a.appointment_date = %s';
        $values = array($date);

        if ($doctor_id) {
            $where .= ' AND a.doctor_id = %d';
            $values[] = $doctor_id;
        }

        return $wpdb->get_results($wpdb->prepare(
            "SELECT a.*, 
                    pat_user.display_name as patient_name,
                    doc_user.display_name as doctor_name
             FROM $table a
             LEFT JOIN $patients p ON a.patient_id = p.id
             LEFT JOIN {$wpdb->users} pat_user ON p.user_id = pat_user.ID
             LEFT JOIN {$wpdb->users} doc_user ON a.doctor_id = doc_user.ID
             WHERE $where
             ORDER BY a.appointment_time ASC",
            ...$values
        ));
    }

    /**
     * Get upcoming appointments for a patient
     */
    public static function get_patient_upcoming($patient_id, $limit = 10) {
        global $wpdb;
        $table = FDCS_Database::table('appointments');

        return $wpdb->get_results($wpdb->prepare(
            "SELECT a.*, doc_user.display_name as doctor_name
             FROM $table a
             LEFT JOIN {$wpdb->users} doc_user ON a.doctor_id = doc_user.ID
             WHERE a.patient_id = %d 
             AND (a.appointment_date > CURDATE() OR (a.appointment_date = CURDATE() AND a.appointment_time >= CURTIME()))
             AND a.status NOT IN ('cancelled', 'completed')
             ORDER BY a.appointment_date ASC, a.appointment_time ASC
             LIMIT %d",
            $patient_id,
            $limit
        ));
    }

    /**
     * Get today's appointments for a doctor
     */
    public static function get_doctor_today($doctor_user_id) {
        global $wpdb;
        $table = FDCS_Database::table('appointments');
        $patients = FDCS_Database::table('patients');

        return $wpdb->get_results($wpdb->prepare(
            "SELECT a.*, pat_user.display_name as patient_name
             FROM $table a
             LEFT JOIN $patients p ON a.patient_id = p.id
             LEFT JOIN {$wpdb->users} pat_user ON p.user_id = pat_user.ID
             WHERE a.doctor_id = %d AND a.appointment_date = CURDATE()
             ORDER BY a.appointment_time ASC",
            $doctor_user_id
        ));
    }

    /**
     * Update appointment status
     */
    public static function update_status($appointment_id, $status) {
        global $wpdb;
        $table = FDCS_Database::table('appointments');

        $valid_statuses = array('scheduled', 'confirmed', 'in_progress', 'completed', 'cancelled', 'no_show');
        if (!in_array($status, $valid_statuses)) {
            return false;
        }

        $result = $wpdb->update(
            $table,
            array('status' => $status, 'updated_at' => current_time('mysql')),
            array('id' => $appointment_id),
            array('%s', '%s'),
            array('%d')
        );

        if ($result !== false) {
            FDCS_Audit_Log::log('appointment_status_changed', 'appointment', $appointment_id, 'Status → ' . $status);
        }

        return $result;
    }

    /**
     * Count appointments with optional filters
     */
    public static function count($args = array()) {
        global $wpdb;
        $table = FDCS_Database::table('appointments');

        $where = array('1=1');
        $values = array();

        if (!empty($args['date'])) {
            $where[] = 'appointment_date = %s';
            $values[] = $args['date'];
        }
        if (!empty($args['doctor_id'])) {
            $where[] = 'doctor_id = %d';
            $values[] = (int) $args['doctor_id'];
        }
        if (!empty($args['status'])) {
            $where[] = 'status = %s';
            $values[] = $args['status'];
        }
        if (!empty($args['patient_id'])) {
            $where[] = 'patient_id = %d';
            $values[] = (int) $args['patient_id'];
        }

        $where_sql = implode(' AND ', $where);
        $sql = "SELECT COUNT(*) FROM $table WHERE $where_sql";

        if (!empty($values)) {
            $sql = $wpdb->prepare($sql, ...$values);
        }

        return (int) $wpdb->get_var($sql);
    }
}

