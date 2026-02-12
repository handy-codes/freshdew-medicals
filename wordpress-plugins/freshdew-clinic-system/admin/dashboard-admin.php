<?php
/**
 * Clinic Admin Frontend Dashboard
 * Similar to Head Admin but with reduced permissions
 *
 * @package FreshDewClinicSystem
 */

if (!defined('ABSPATH')) {
    exit;
}

// Reuse the Head Admin dashboard layout for now — permissions are enforced at the API/capability level
include FDCS_PLUGIN_DIR . 'admin/dashboard-head-admin.php';

