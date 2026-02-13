<?php
/**
 * Database Table Creation and Management
 *
 * @package FreshDewClinicSystem
 */

if (!defined('ABSPATH')) {
    exit;
}

class FDCS_Database {

    /**
     * Create all custom tables on plugin activation
     */
    public static function create_tables() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $prefix = $wpdb->prefix . FDCS_TABLE_PREFIX;

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        // ── Patients ──
        $sql_patients = "CREATE TABLE {$prefix}patients (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id BIGINT UNSIGNED NOT NULL,
            date_of_birth DATE DEFAULT NULL,
            gender VARCHAR(30) DEFAULT NULL,
            health_card_number VARCHAR(50) DEFAULT NULL,
            emergency_contact_name VARCHAR(100) DEFAULT NULL,
            emergency_contact_phone VARCHAR(30) DEFAULT NULL,
            family_history LONGTEXT DEFAULT NULL,
            drug_history LONGTEXT DEFAULT NULL,
            allergy_history LONGTEXT DEFAULT NULL,
            medical_surgical_history LONGTEXT DEFAULT NULL,
            pap_smear_status VARCHAR(20) DEFAULT NULL,
            last_mammogram VARCHAR(100) DEFAULT NULL,
            other_information LONGTEXT DEFAULT NULL,
            blood_type VARCHAR(10) DEFAULT NULL,
            assigned_doctor_id BIGINT UNSIGNED DEFAULT NULL,
            registration_status VARCHAR(20) DEFAULT 'waitlist',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY idx_user_id (user_id),
            KEY idx_assigned_doctor (assigned_doctor_id),
            KEY idx_registration_status (registration_status)
        ) $charset_collate;";

        // ── Appointments ──
        $sql_appointments = "CREATE TABLE {$prefix}appointments (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            patient_id BIGINT UNSIGNED NOT NULL,
            doctor_id BIGINT UNSIGNED NOT NULL,
            appointment_date DATE NOT NULL,
            appointment_time TIME NOT NULL,
            duration_minutes INT DEFAULT 30,
            type VARCHAR(30) DEFAULT 'scheduled',
            status VARCHAR(20) DEFAULT 'scheduled',
            reason TEXT DEFAULT NULL,
            symptoms TEXT DEFAULT NULL,
            notes TEXT DEFAULT NULL,
            created_by BIGINT UNSIGNED DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_patient (patient_id),
            KEY idx_doctor_date (doctor_id, appointment_date),
            KEY idx_status (status),
            KEY idx_date (appointment_date)
        ) $charset_collate;";

        // ── Medical Notes ──
        $sql_notes = "CREATE TABLE {$prefix}medical_notes (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            appointment_id BIGINT UNSIGNED DEFAULT NULL,
            patient_id BIGINT UNSIGNED NOT NULL,
            doctor_id BIGINT UNSIGNED NOT NULL,
            note_type VARCHAR(30) DEFAULT 'consultation',
            content LONGTEXT NOT NULL,
            is_private TINYINT(1) DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_appointment (appointment_id),
            KEY idx_patient (patient_id),
            KEY idx_doctor (doctor_id),
            KEY idx_type (note_type)
        ) $charset_collate;";

        // ── Prescriptions ──
        $sql_prescriptions = "CREATE TABLE {$prefix}prescriptions (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            patient_id BIGINT UNSIGNED NOT NULL,
            doctor_id BIGINT UNSIGNED NOT NULL,
            appointment_id BIGINT UNSIGNED DEFAULT NULL,
            medication_name VARCHAR(255) NOT NULL,
            dosage VARCHAR(100) DEFAULT NULL,
            frequency VARCHAR(100) DEFAULT NULL,
            duration VARCHAR(100) DEFAULT NULL,
            instructions TEXT DEFAULT NULL,
            status VARCHAR(20) DEFAULT 'active',
            prescribed_date DATE NOT NULL,
            expiry_date DATE DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_patient_status (patient_id, status),
            KEY idx_doctor (doctor_id)
        ) $charset_collate;";

        // ── Messages ──
        $sql_messages = "CREATE TABLE {$prefix}messages (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            sender_id BIGINT UNSIGNED NOT NULL,
            receiver_id BIGINT UNSIGNED NOT NULL,
            subject VARCHAR(255) DEFAULT NULL,
            content LONGTEXT NOT NULL,
            is_read TINYINT(1) DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_receiver_read (receiver_id, is_read),
            KEY idx_sender (sender_id)
        ) $charset_collate;";

        // ── Audit Log ──
        $sql_audit = "CREATE TABLE {$prefix}audit_log (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id BIGINT UNSIGNED NOT NULL,
            action VARCHAR(100) NOT NULL,
            entity_type VARCHAR(50) DEFAULT NULL,
            entity_id BIGINT UNSIGNED DEFAULT NULL,
            details LONGTEXT DEFAULT NULL,
            ip_address VARCHAR(45) DEFAULT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_user_action (user_id, action),
            KEY idx_entity (entity_type, entity_id),
            KEY idx_created_at (created_at)
        ) $charset_collate;";

        // ── Chat History ──
        $sql_chat = "CREATE TABLE {$prefix}chat_history (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            session_id VARCHAR(64) NOT NULL,
            user_id BIGINT UNSIGNED DEFAULT NULL,
            role VARCHAR(20) NOT NULL,
            message LONGTEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_session (session_id),
            KEY idx_user (user_id)
        ) $charset_collate;";

        // ── Doctor Availability ──
        $sql_availability = "CREATE TABLE {$prefix}doctor_availability (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            doctor_id BIGINT UNSIGNED NOT NULL,
            day_of_week TINYINT NOT NULL,
            start_time TIME NOT NULL,
            end_time TIME NOT NULL,
            slot_duration INT DEFAULT 30,
            is_active TINYINT(1) DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY idx_doctor_day (doctor_id, day_of_week)
        ) $charset_collate;";

        // Execute all
        dbDelta($sql_patients);
        dbDelta($sql_appointments);
        dbDelta($sql_notes);
        dbDelta($sql_prescriptions);
        dbDelta($sql_messages);
        dbDelta($sql_audit);
        dbDelta($sql_chat);
        dbDelta($sql_availability);

        // Migrate existing tables to add new columns if needed
        self::migrate_patients_table();

        // Store DB version
        update_option('fdcs_db_version', FDCS_VERSION);
    }

    /**
     * Migrate patients table to add new columns
     */
    public static function migrate_patients_table() {
        global $wpdb;
        $table = self::table('patients');

        // Check if columns exist and add them if they don't
        $columns_to_add = array(
            'pap_smear_status' => "ALTER TABLE $table ADD COLUMN pap_smear_status VARCHAR(20) DEFAULT NULL AFTER medical_surgical_history",
            'last_mammogram' => "ALTER TABLE $table ADD COLUMN last_mammogram VARCHAR(100) DEFAULT NULL AFTER pap_smear_status",
            'other_information' => "ALTER TABLE $table ADD COLUMN other_information LONGTEXT DEFAULT NULL AFTER last_mammogram",
        );

        foreach ($columns_to_add as $column_name => $sql) {
            $column_exists = $wpdb->get_results($wpdb->prepare(
                "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
                 WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s",
                DB_NAME,
                $table,
                $column_name
            ));

            if (empty($column_exists)) {
                $wpdb->query($sql);
            }
        }
    }

    /**
     * Get table name with prefix
     */
    public static function table($name) {
        global $wpdb;
        return $wpdb->prefix . FDCS_TABLE_PREFIX . $name;
    }

    /**
     * Drop all custom tables (only on uninstall, not deactivation)
     */
    public static function drop_tables() {
        global $wpdb;
        $prefix = $wpdb->prefix . FDCS_TABLE_PREFIX;

        $tables = array(
            'patients', 'appointments', 'medical_notes', 'prescriptions',
            'messages', 'audit_log', 'chat_history', 'doctor_availability',
        );

        foreach ($tables as $table) {
            $wpdb->query("DROP TABLE IF EXISTS {$prefix}{$table}");
        }

        delete_option('fdcs_db_version');
    }
}

