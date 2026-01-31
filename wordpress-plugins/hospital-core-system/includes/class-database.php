<?php
/**
 * Database Management Class
 *
 * @package Hospital_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class Hospital_Database {
    
    /**
     * Create custom database tables
     */
    public static function create_tables() {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // Patients table
        $table_patients = $wpdb->prefix . 'hospital_patients';
        $sql_patients = "CREATE TABLE IF NOT EXISTS $table_patients (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id bigint(20) UNSIGNED NOT NULL,
            blood_type varchar(10),
            allergies text,
            medications text,
            conditions text,
            height decimal(5,2),
            weight decimal(5,2),
            insurance_provider varchar(255),
            insurance_number varchar(255),
            insurance_expiry datetime,
            family_doctor_id bigint(20) UNSIGNED,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY user_id (user_id),
            KEY family_doctor_id (family_doctor_id)
        ) $charset_collate;";
        
        // Doctors table
        $table_doctors = $wpdb->prefix . 'hospital_doctors';
        $sql_doctors = "CREATE TABLE IF NOT EXISTS $table_doctors (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id bigint(20) UNSIGNED NOT NULL,
            license_number varchar(255) NOT NULL,
            specialty varchar(255),
            qualifications text,
            years_of_experience int,
            biography text,
            working_hours text,
            is_accepting_patients tinyint(1) DEFAULT 1,
            max_patients_per_day int DEFAULT 20,
            office_phone varchar(50),
            office_email varchar(255),
            office_location varchar(255),
            rating decimal(3,2) DEFAULT 5.00,
            total_reviews int DEFAULT 0,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY license_number (license_number),
            KEY user_id (user_id)
        ) $charset_collate;";
        
        // Appointments table
        $table_appointments = $wpdb->prefix . 'hospital_appointments';
        $sql_appointments = "CREATE TABLE IF NOT EXISTS $table_appointments (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            patient_id bigint(20) UNSIGNED NOT NULL,
            doctor_id bigint(20) UNSIGNED NOT NULL,
            appointment_date datetime NOT NULL,
            duration int DEFAULT 30,
            status varchar(50) DEFAULT 'SCHEDULED',
            type varchar(50) DEFAULT 'IN_PERSON',
            reason text,
            symptoms text,
            location_id bigint(20) UNSIGNED,
            room_number varchar(50),
            telehealth_link varchar(255),
            meeting_password varchar(255),
            intake_form_completed tinyint(1) DEFAULT 0,
            consent_form_completed tinyint(1) DEFAULT 0,
            scheduled_at datetime DEFAULT CURRENT_TIMESTAMP,
            confirmed_at datetime,
            started_at datetime,
            ended_at datetime,
            cancelled_at datetime,
            cancellation_reason text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY patient_id (patient_id),
            KEY doctor_id (doctor_id),
            KEY appointment_date (appointment_date),
            KEY status (status)
        ) $charset_collate;";
        
        // Medical Records table
        $table_medical_records = $wpdb->prefix . 'hospital_medical_records';
        $sql_medical_records = "CREATE TABLE IF NOT EXISTS $table_medical_records (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            patient_id bigint(20) UNSIGNED NOT NULL,
            doctor_id bigint(20) UNSIGNED NOT NULL,
            appointment_id bigint(20) UNSIGNED,
            diagnosis text,
            notes text,
            procedures text,
            prescriptions text,
            follow_up_date datetime,
            blood_pressure varchar(20),
            heart_rate int,
            temperature decimal(4,2),
            oxygen_saturation decimal(5,2),
            respiratory_rate int,
            attachments text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY patient_id (patient_id),
            KEY doctor_id (doctor_id),
            KEY appointment_id (appointment_id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_patients);
        dbDelta($sql_doctors);
        dbDelta($sql_appointments);
        dbDelta($sql_medical_records);
    }
}

