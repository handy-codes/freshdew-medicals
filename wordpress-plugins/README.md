# WordPress Plugins for FreshDew Medical Clinic

This directory contains all custom WordPress plugins for the FreshDew Medical Clinic hospital management system.

## Plugins Included

### 1. Hospital Core System
**Location:** `hospital-core-system/`

Core hospital management functionality including:
- Patient management
- Doctor management
- Appointment system
- Medical records
- Custom user roles
- Database tables

**Installation:**
1. Upload folder to `/wp-content/plugins/`
2. Activate in WordPress admin

### 2. Appointment Management System
**Location:** `appointment-management/`

Appointment booking and management:
- Booking form (shortcode: `[appointment_booking_form]`)
- Calendar integration
- Availability checking
- Email notifications

**Installation:**
1. Upload folder to `/wp-content/plugins/`
2. Activate in WordPress admin
3. Use shortcode on pages: `[appointment_booking_form]`

### 3. EMR Integration - Juno
**Location:** `emr-integration-juno/`

EMR integration with Juno/OSCAR systems:
- ⚠️ **PENDING GOVERNMENT APPROVAL**
- Settings page for API configuration
- Features disabled until approval received

**Installation:**
1. Upload folder to `/wp-content/plugins/`
2. Activate in WordPress admin
3. Configure when government approval is received

**Status:**
- Plugin is installed but features are disabled
- Admin notice shows pending approval status
- Will activate when approval checkbox is enabled in settings

## Requirements

- WordPress 6.0+
- PHP 8.0+
- MySQL 5.7+ or MariaDB 10.3+

## Dependencies

- Hospital Core System should be activated first
- Other plugins depend on Hospital Core System

## Support

For plugin support, refer to the main documentation or contact FreshDew Medical Clinic.

