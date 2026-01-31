<?php
/**
 * Appointment Management Class
 *
 * @package Hospital_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class Hospital_Appointment {
    
    /**
     * Create appointment
     */
    public static function create($data) {
        global $wpdb;
        $table = $wpdb->prefix . 'hospital_appointments';
        
        $data['scheduled_at'] = current_time('mysql');
        $data['created_at'] = current_time('mysql');
        
        $wpdb->insert($table, $data);
        return $wpdb->insert_id;
    }
    
    /**
     * Get appointments by patient ID
     */
    public static function get_by_patient($patient_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'hospital_appointments';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table WHERE patient_id = %d ORDER BY appointment_date DESC",
            $patient_id
        ));
    }
    
    /**
     * Get appointments by doctor ID
     */
    public static function get_by_doctor($doctor_id, $date = null) {
        global $wpdb;
        $table = $wpdb->prefix . 'hospital_appointments';
        
        $where = $wpdb->prepare("doctor_id = %d", $doctor_id);
        if ($date) {
            $where .= $wpdb->prepare(" AND DATE(appointment_date) = %s", $date);
        }
        
        return $wpdb->get_results("SELECT * FROM $table WHERE $where ORDER BY appointment_date ASC");
    }
    
    /**
     * Check if time slot is available
     */
    public static function is_available($doctor_id, $datetime, $duration = 30) {
        global $wpdb;
        $table = $wpdb->prefix . 'hospital_appointments';
        
        $end_time = date('Y-m-d H:i:s', strtotime($datetime . " +{$duration} minutes"));
        
        $conflicts = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table 
            WHERE doctor_id = %d 
            AND status NOT IN ('CANCELLED', 'NO_SHOW')
            AND (
                (appointment_date <= %s AND DATE_ADD(appointment_date, INTERVAL duration MINUTE) > %s)
                OR (appointment_date < %s AND DATE_ADD(appointment_date, INTERVAL duration MINUTE) >= %s)
            )",
            $doctor_id,
            $datetime,
            $datetime,
            $end_time,
            $end_time
        ));
        
        return $conflicts == 0;
    }
}

