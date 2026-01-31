<?php
/**
 * Patient Management Class
 *
 * @package Hospital_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class Hospital_Patient {
    
    /**
     * Get patient by user ID
     */
    public static function get_by_user_id($user_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'hospital_patients';
        
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table WHERE user_id = %d",
            $user_id
        ));
    }
    
    /**
     * Create or update patient profile
     */
    public static function save($user_id, $data) {
        global $wpdb;
        $table = $wpdb->prefix . 'hospital_patients';
        
        $existing = self::get_by_user_id($user_id);
        
        $data['user_id'] = $user_id;
        $data['updated_at'] = current_time('mysql');
        
        if ($existing) {
            $wpdb->update($table, $data, array('user_id' => $user_id));
            return $existing->id;
        } else {
            $data['created_at'] = current_time('mysql');
            $wpdb->insert($table, $data);
            return $wpdb->insert_id;
        }
    }
}

