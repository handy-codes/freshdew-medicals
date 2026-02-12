<?php
/**
 * Audit Log System
 *
 * @package FreshDewClinicSystem
 */

if (!defined('ABSPATH')) {
    exit;
}

class FDCS_Audit_Log {

    /**
     * Log an action
     */
    public static function log($action, $entity_type = null, $entity_id = null, $details = '') {
        global $wpdb;
        $table = FDCS_Database::table('audit_log');

        $wpdb->insert($table, array(
            'user_id'     => get_current_user_id() ?: 0,
            'action'      => sanitize_text_field($action),
            'entity_type' => $entity_type ? sanitize_text_field($entity_type) : null,
            'entity_id'   => $entity_id ? (int) $entity_id : null,
            'details'     => sanitize_textarea_field($details),
            'ip_address'  => self::get_client_ip(),
            'created_at'  => current_time('mysql'),
        ), array('%d', '%s', '%s', '%d', '%s', '%s', '%s'));
    }

    /**
     * Get recent audit log entries
     */
    public static function get_recent($limit = 50, $offset = 0) {
        global $wpdb;
        $table = FDCS_Database::table('audit_log');

        return $wpdb->get_results($wpdb->prepare(
            "SELECT a.*, u.display_name as user_name
             FROM $table a
             LEFT JOIN {$wpdb->users} u ON a.user_id = u.ID
             ORDER BY a.created_at DESC
             LIMIT %d OFFSET %d",
            $limit,
            $offset
        ));
    }

    /**
     * Get audit log for a specific entity
     */
    public static function get_for_entity($entity_type, $entity_id) {
        global $wpdb;
        $table = FDCS_Database::table('audit_log');

        return $wpdb->get_results($wpdb->prepare(
            "SELECT a.*, u.display_name as user_name
             FROM $table a
             LEFT JOIN {$wpdb->users} u ON a.user_id = u.ID
             WHERE a.entity_type = %s AND a.entity_id = %d
             ORDER BY a.created_at DESC",
            $entity_type,
            $entity_id
        ));
    }

    /**
     * Get client IP address
     */
    private static function get_client_ip() {
        $ip_keys = array('HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR');
        foreach ($ip_keys as $key) {
            if (!empty($_SERVER[$key])) {
                $ip = $_SERVER[$key];
                // Handle comma-separated IPs (X-Forwarded-For)
                if (strpos($ip, ',') !== false) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
        return '0.0.0.0';
    }

    /**
     * Count total log entries
     */
    public static function count() {
        global $wpdb;
        $table = FDCS_Database::table('audit_log');
        return (int) $wpdb->get_var("SELECT COUNT(*) FROM $table");
    }
}

