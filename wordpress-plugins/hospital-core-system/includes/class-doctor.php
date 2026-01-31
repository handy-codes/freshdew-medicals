<?php
/**
 * Doctor Management Class
 *
 * @package Hospital_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class Hospital_Doctor {
    
    /**
     * Get doctor by user ID
     */
    public static function get_by_user_id($user_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'hospital_doctors';
        
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table WHERE user_id = %d",
            $user_id
        ));
    }
    
    /**
     * Get all doctors
     */
    public static function get_all($args = array()) {
        global $wpdb;
        $table = $wpdb->prefix . 'hospital_doctors';
        
        $where = '1=1';
        if (!empty($args['specialty'])) {
            $where .= $wpdb->prepare(" AND specialty = %s", $args['specialty']);
        }
        if (!empty($args['accepting_patients'])) {
            $where .= " AND is_accepting_patients = 1";
        }
        
        return $wpdb->get_results("SELECT * FROM $table WHERE $where ORDER BY created_at DESC");
    }
}

