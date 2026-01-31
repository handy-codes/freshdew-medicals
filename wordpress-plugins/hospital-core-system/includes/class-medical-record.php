<?php
/**
 * Medical Record Management Class
 *
 * @package Hospital_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class Hospital_Medical_Record {
    
    /**
     * Create medical record
     */
    public static function create($data) {
        global $wpdb;
        $table = $wpdb->prefix . 'hospital_medical_records';
        
        $data['created_at'] = current_time('mysql');
        $data['updated_at'] = current_time('mysql');
        
        $wpdb->insert($table, $data);
        return $wpdb->insert_id;
    }
    
    /**
     * Get medical records by patient ID
     */
    public static function get_by_patient($patient_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'hospital_medical_records';
        
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table WHERE patient_id = %d ORDER BY created_at DESC",
            $patient_id
        ));
    }
}

