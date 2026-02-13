<?php
/**
 * Head Admin / CMO Frontend Dashboard
 *
 * @package FreshDewClinicSystem
 */

if (!defined('ABSPATH')) {
    exit;
}

$current_user = wp_get_current_user();
$today = current_time('Y-m-d');
$total_patients = FDCS_Patient::count();
$waitlist = FDCS_Patient::count(array('status' => 'waitlist'));
$active_patients = FDCS_Patient::count(array('status' => 'active'));
$today_appts = FDCS_Appointment::count(array('date' => $today));
$total_appts = FDCS_Appointment::count();
$recent_logs = FDCS_Audit_Log::get_recent(8);
$recent_patients = FDCS_Patient::get_all(array('limit' => 5, 'status' => 'waitlist'));
$today_appointments = FDCS_Appointment::get_by_date($today);

// Get all staff members (admins and doctors)
$staff_query = new WP_User_Query(array(
    'role__in' => array('head_admin', 'clinic_admin', 'clinic_doctor', 'administrator'),
    'number' => 50,
    'orderby' => 'registered',
    'order' => 'DESC',
));
$all_staff = $staff_query->get_results();

// Get all patients for patient management
// First get patients from custom table
$all_patients = FDCS_Patient::get_all(array('limit' => 100, 'orderby' => 'created_at', 'order' => 'DESC'));

// Also get ALL WordPress users with clinic_patient role (includes Hostinger-created users)
$all_patient_users_query = new WP_User_Query(array(
    'role' => 'clinic_patient',
    'number' => 100,
    'orderby' => 'registered',
    'order' => 'DESC',
));
$all_wp_patient_users = $all_patient_users_query->get_results();

// Build a set of user_ids already in fd_patients table
$existing_patient_user_ids = array();
foreach ($all_patients as $p) {
    $existing_patient_user_ids[] = $p->user_id;
}

// Auto-create fd_patients entries for WP users with clinic_patient role who are missing
foreach ($all_wp_patient_users as $wp_user) {
    if (!in_array($wp_user->ID, $existing_patient_user_ids)) {
        // Create a minimal patient record so they show up in Patient Management
        global $wpdb;
        $table = FDCS_Database::table('patients');
        $wpdb->insert($table, array(
            'user_id'             => $wp_user->ID,
            'registration_status' => 'waitlist',
            'created_at'          => $wp_user->user_registered ?: current_time('mysql'),
        ), array('%d', '%s', '%s'));
    }
}

// Re-fetch all patients after syncing
$all_patients = FDCS_Patient::get_all(array('limit' => 100, 'orderby' => 'created_at', 'order' => 'DESC'));

// Get all doctors for assignment dropdown
$doctors_query = new WP_User_Query(array(
    'role__in' => array('clinic_doctor'),
    'number' => 50,
    'orderby' => 'display_name',
    'order' => 'ASC',
));
$all_doctors = $doctors_query->get_results();

// Get success/error messages
$success_msg = isset($_GET['success']) ? sanitize_text_field($_GET['success']) : '';
$error_msg = isset($_GET['error']) ? sanitize_text_field($_GET['error']) : '';

get_header();
?>

<main style="background: #f3f4f6; min-height: calc(100vh - 80px);">
    <div style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">

        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 style="font-size: 1.75rem; font-weight: 700; color: #1f2937; margin: 0;">
                    Welcome, <?php echo esc_html($current_user->display_name); ?>
                </h1>
                <p style="color: #6b7280; margin: 0.25rem 0 0;">
                    Clinic Management Dashboard • <?php echo esc_html(wp_date('l, F j, Y')); ?>
                </p>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <a href="<?php echo esc_url(home_url('/')); ?>" style="padding: 0.5rem 1rem; background: white; color: #374151; border-radius: 0.5rem; text-decoration: none; font-size: 0.875rem; border: 1px solid #d1d5db;">← Website</a>
                <a href="<?php echo esc_url(wp_logout_url(home_url('/clinic-login'))); ?>" style="padding: 0.5rem 1rem; background: #ef4444; color: white; border-radius: 0.5rem; text-decoration: none; font-size: 0.875rem;">Sign Out</a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-top: 4px solid #2563eb;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Total Patients</p>
                        <p style="font-size: 2rem; font-weight: 700; color: #1f2937; margin: 0.25rem 0 0;"><?php echo esc_html($total_patients); ?></p>
                    </div>
                    <div style="width: 48px; height: 48px; background: #dbeafe; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">👥</div>
                </div>
            </div>
            <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-top: 4px solid #f59e0b;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Waitlist</p>
                        <p style="font-size: 2rem; font-weight: 700; color: #1f2937; margin: 0.25rem 0 0;"><?php echo esc_html($waitlist); ?></p>
                    </div>
                    <div style="width: 48px; height: 48px; background: #fef3c7; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">⏳</div>
                </div>
            </div>
            <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-top: 4px solid #10b981;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Active Patients</p>
                        <p style="font-size: 2rem; font-weight: 700; color: #1f2937; margin: 0.25rem 0 0;"><?php echo esc_html($active_patients); ?></p>
                    </div>
                    <div style="width: 48px; height: 48px; background: #d1fae5; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">✅</div>
                </div>
            </div>
            <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-top: 4px solid #8b5cf6;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Today's Appointments</p>
                        <p style="font-size: 2rem; font-weight: 700; color: #1f2937; margin: 0.25rem 0 0;"><?php echo esc_html($today_appts); ?></p>
                    </div>
                    <div style="width: 48px; height: 48px; background: #ede9fe; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">📅</div>
                </div>
            </div>
        </div>

        <!-- Two-Column Layout -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">

            <!-- Today's Appointments -->
            <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0 0 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    📅 Today's Schedule
                </h2>
                <?php if (empty($today_appointments)): ?>
                    <p style="color: #6b7280; text-align: center; padding: 2rem 0;">No appointments scheduled for today.</p>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <?php foreach ($today_appointments as $appt): ?>
                            <div style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.5rem;">
                                <div style="background: #dbeafe; color: #1e40af; padding: 0.5rem 0.75rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; white-space: nowrap;">
                                    <?php echo esc_html(wp_date('g:i A', strtotime($appt->appointment_time))); ?>
                                </div>
                                <div style="flex: 1;">
                                    <p style="margin: 0; font-weight: 600; color: #1f2937;"><?php echo esc_html($appt->patient_name ?? 'Unknown'); ?></p>
                                    <p style="margin: 0; color: #6b7280; font-size: 0.8rem;">Dr. <?php echo esc_html($appt->doctor_name ?? '—'); ?> • <?php echo esc_html(ucfirst($appt->type)); ?></p>
                                </div>
                                <span style="padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; background: #dbeafe; color: #1e40af;">
                                    <?php echo esc_html(ucfirst($appt->status)); ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Waitlist Patients -->
            <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0 0 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    ⏳ Patients Awaiting Approval
                </h2>
                <?php if (empty($recent_patients)): ?>
                    <p style="color: #6b7280; text-align: center; padding: 2rem 0;">No patients on the waitlist.</p>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <?php foreach ($recent_patients as $p): 
                            $patient = FDCS_Patient::get_by_user_id($p->user_id ?? 0);
                            $patient_id = $patient ? $patient->id : 0;
                        ?>
                            <div style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.5rem;">
                                <div style="width: 40px; height: 40px; background: #fef3c7; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #92400e; font-size: 1rem;">
                                    <?php echo esc_html(strtoupper(substr($p->display_name ?? 'P', 0, 1))); ?>
                                </div>
                                <div style="flex: 1; cursor: pointer;" onclick="showPatientDetails(<?php echo esc_js($patient_id); ?>)">
                                    <p style="margin: 0; font-weight: 600; color: #1f2937;"><?php echo esc_html($p->display_name); ?></p>
                                    <p style="margin: 0; color: #6b7280; font-size: 0.8rem;"><?php echo esc_html($p->user_email); ?> • Registered <?php echo esc_html(wp_date('M j', strtotime($p->created_at))); ?></p>
                                </div>
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <span style="padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; background: #fef3c7; color: #92400e;">Waitlist</span>
                                    <?php if ($patient_id): ?>
                                        <button onclick="event.stopPropagation(); approvePatient(<?php echo esc_js($patient_id); ?>)" 
                                                style="padding: 0.25rem 0.75rem; background: #10b981; color: white; border: none; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; cursor: pointer;">
                                            Approve
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <?php if ($success_msg === 'staff_created'): ?>
            <div style="background: #d1fae5; border: 1px solid #10b981; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                ✅ Staff member created successfully! They will receive a welcome email with login credentials.
            </div>
        <?php endif; ?>
        <?php if ($error_msg): ?>
            <div style="background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                ❌ Error: <?php echo esc_html(urldecode($error_msg)); ?>
            </div>
        <?php endif; ?>

        <!-- User Management Section -->
        <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0;">👥 User Management</h2>
                <button onclick="document.getElementById('createStaffModal').style.display='block'" style="padding: 0.5rem 1rem; background: #2563eb; color: white; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 600; font-size: 0.875rem;">
                    + Add Staff Member
                </button>
            </div>

            <!-- Staff List -->
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e5e7eb;">
                            <th style="text-align: left; padding: 0.75rem; font-size: 0.8rem; color: #6b7280; text-transform: uppercase;">Name</th>
                            <th style="text-align: left; padding: 0.75rem; font-size: 0.8rem; color: #6b7280; text-transform: uppercase;">Email</th>
                            <th style="text-align: left; padding: 0.75rem; font-size: 0.8rem; color: #6b7280; text-transform: uppercase;">Role</th>
                            <th style="text-align: left; padding: 0.75rem; font-size: 0.8rem; color: #6b7280; text-transform: uppercase;">Phone</th>
                            <th style="text-align: left; padding: 0.75rem; font-size: 0.8rem; color: #6b7280; text-transform: uppercase;">Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($all_staff)): ?>
                            <tr>
                                <td colspan="5" style="padding: 2rem; text-align: center; color: #6b7280;">No staff members found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($all_staff as $staff): 
                                $role_display = '';
                                if (in_array('head_admin', $staff->roles) || in_array('administrator', $staff->roles)) {
                                    $role_display = 'Head Admin';
                                } elseif (in_array('clinic_admin', $staff->roles)) {
                                    $role_display = 'Clinic Admin';
                                } elseif (in_array('clinic_doctor', $staff->roles)) {
                                    $role_display = 'Doctor';
                                }
                                $phone = get_user_meta($staff->ID, 'phone', true);
                            ?>
                                <tr style="border-bottom: 1px solid #f3f4f6;">
                                    <td style="padding: 0.75rem; font-size: 0.875rem; color: #1f2937; font-weight: 500;">
                                        <?php echo esc_html($staff->display_name); ?>
                                    </td>
                                    <td style="padding: 0.75rem; font-size: 0.875rem; color: #6b7280;">
                                        <?php echo esc_html($staff->user_email); ?>
                                    </td>
                                    <td style="padding: 0.75rem;">
                                        <span style="padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; background: #dbeafe; color: #1e40af;">
                                            <?php echo esc_html($role_display); ?>
                                        </span>
                                    </td>
                                    <td style="padding: 0.75rem; font-size: 0.875rem; color: #6b7280;">
                                        <?php echo esc_html($phone ?: '—'); ?>
                                    </td>
                                    <td style="padding: 0.75rem; font-size: 0.875rem; color: #6b7280;">
                                        <?php echo esc_html(wp_date('M j, Y', strtotime($staff->user_registered))); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Staff Modal -->
        <div id="createStaffModal" style="display: none; position: fixed; z-index: 10002; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); overflow: auto;">
            <div style="background: white; margin: 5% auto; padding: 2rem; border-radius: 0.75rem; max-width: 500px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin: 0;">Add Staff Member</h3>
                    <button onclick="document.getElementById('createStaffModal').style.display='none'" style="background: none; border: none; font-size: 1.5rem; color: #6b7280; cursor: pointer; padding: 0; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">&times;</button>
                </div>
                
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="fdcs_create_staff">
                    <?php wp_nonce_field('fdcs_create_staff', 'fdcs_staff_nonce'); ?>
                    
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Role *</label>
                        <select name="role" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                            <option value="">Select a role...</option>
                            <?php if (current_user_can('fdcs_create_admins')): ?>
                                <option value="clinic_admin">Clinic Admin</option>
                            <?php endif; ?>
                            <?php if (current_user_can('fdcs_create_doctors')): ?>
                                <option value="clinic_doctor">Doctor</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">First Name *</label>
                            <input type="text" name="first_name" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Last Name *</label>
                            <input type="text" name="last_name" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Email *</label>
                        <input type="email" name="email" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Phone *</label>
                        <input type="tel" name="phone" required style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.875rem;">Temporary Password *</label>
                        <input type="password" name="password" required minlength="8" style="width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem;">
                        <p style="margin: 0.25rem 0 0; font-size: 0.75rem; color: #6b7280;">Minimum 8 characters. They'll receive login credentials via email.</p>
                    </div>

                    <div style="display: flex; gap: 0.75rem; justify-content: flex-end;">
                        <button type="button" onclick="document.getElementById('createStaffModal').style.display='none'" style="padding: 0.5rem 1rem; background: #f3f4f6; color: #374151; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 600; font-size: 0.875rem;">
                            Cancel
                        </button>
                        <button type="submit" id="createStaffBtn" style="padding: 0.5rem 1rem; background: #2563eb; color: white; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 600; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;">
                            <span id="createStaffBtnText">Create Staff Member</span>
                            <span id="createStaffSpinner" style="display: none; width: 16px; height: 16px; border: 2px solid rgba(255,255,255,0.3); border-top: 2px solid white; border-radius: 50%; animation: fdcs-spin 0.8s linear infinite;"></span>
                        </button>
                    </div>
                    <style>@keyframes fdcs-spin { to { transform: rotate(360deg); } }</style>
                </form>
            </div>
        </div>

        <!-- Patient Management Section -->
        <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0;">👥 Patient Management</h2>
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <input type="text" id="patientSearch" placeholder="Search patients..." 
                           style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; min-width: 200px;"
                           onkeyup="filterPatients()">
                    <select id="patientStatusFilter" onchange="filterPatients()"
                            style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem;">
                        <option value="">All Status</option>
                        <option value="waitlist">Waitlist</option>
                        <option value="active">Active</option>
                    </select>
                    <select id="patientDoctorFilter" onchange="filterPatients()"
                            style="padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem;">
                        <option value="">All Doctors</option>
                        <option value="0">Unassigned</option>
                        <?php foreach ($all_doctors as $doc): ?>
                            <option value="<?php echo esc_attr($doc->ID); ?>"><?php echo esc_html($doc->display_name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Patient List -->
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;" id="patientTable">
                    <thead>
                        <tr style="border-bottom: 2px solid #e5e7eb;">
                            <th style="text-align: left; padding: 0.75rem; font-size: 0.8rem; color: #6b7280; text-transform: uppercase;">Name</th>
                            <th style="text-align: left; padding: 0.75rem; font-size: 0.8rem; color: #6b7280; text-transform: uppercase;">Email</th>
                            <th style="text-align: left; padding: 0.75rem; font-size: 0.8rem; color: #6b7280; text-transform: uppercase;">Phone</th>
                            <th style="text-align: left; padding: 0.75rem; font-size: 0.8rem; color: #6b7280; text-transform: uppercase;">Status</th>
                            <th style="text-align: left; padding: 0.75rem; font-size: 0.8rem; color: #6b7280; text-transform: uppercase;">Assigned Doctor</th>
                            <th style="text-align: left; padding: 0.75rem; font-size: 0.8rem; color: #6b7280; text-transform: uppercase;">Registered</th>
                            <th style="text-align: left; padding: 0.75rem; font-size: 0.8rem; color: #6b7280; text-transform: uppercase;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($all_patients)): ?>
                            <tr>
                                <td colspan="7" style="padding: 2rem; text-align: center; color: #6b7280;">No patients found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($all_patients as $patient_data): 
                                $user = get_user_by('ID', $patient_data->user_id);
                                if (!$user) continue;
                                
                                $patient = FDCS_Patient::get_by_user_id($user->ID);
                                $patient_id = $patient ? $patient->id : 0;
                                $phone = get_user_meta($user->ID, 'phone', true);
                                $assigned_doctor = $patient && $patient->assigned_doctor_id ? get_user_by('ID', $patient->assigned_doctor_id) : null;
                            ?>
                                <tr class="patient-row" 
                                    data-name="<?php echo esc_attr(strtolower($user->display_name)); ?>"
                                    data-email="<?php echo esc_attr(strtolower($user->user_email)); ?>"
                                    data-status="<?php echo esc_attr($patient ? $patient->registration_status : ''); ?>"
                                    data-doctor="<?php echo esc_attr($patient && $patient->assigned_doctor_id ? $patient->assigned_doctor_id : '0'); ?>"
                                    style="border-bottom: 1px solid #f3f4f6;">
                                    <td style="padding: 0.75rem; font-size: 0.875rem; color: #1f2937; font-weight: 500; cursor: pointer;" onclick="showPatientDetails(<?php echo esc_js($patient_id); ?>)">
                                        <?php echo esc_html($user->display_name); ?>
                                    </td>
                                    <td style="padding: 0.75rem; font-size: 0.875rem; color: #6b7280;">
                                        <?php echo esc_html($user->user_email); ?>
                                    </td>
                                    <td style="padding: 0.75rem; font-size: 0.875rem; color: #6b7280;">
                                        <?php echo esc_html($phone ?: '—'); ?>
                                    </td>
                                    <td style="padding: 0.75rem;">
                                        <span style="padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 600;
                                            <?php echo ($patient && $patient->registration_status === 'active') ? 'background: #d1fae5; color: #065f46;' : 'background: #fef3c7; color: #92400e;'; ?>">
                                            <?php echo esc_html(ucfirst($patient ? $patient->registration_status : 'waitlist')); ?>
                                        </span>
                                    </td>
                                    <td style="padding: 0.75rem; font-size: 0.875rem; color: #6b7280;">
                                        <?php echo $assigned_doctor ? esc_html($assigned_doctor->display_name) : '<span style="color: #9ca3af;">Unassigned</span>'; ?>
                                    </td>
                                    <td style="padding: 0.75rem; font-size: 0.875rem; color: #6b7280;">
                                        <?php echo esc_html(wp_date('M j, Y', strtotime($patient ? $patient->created_at : $user->user_registered))); ?>
                                    </td>
                                    <td style="padding: 0.75rem;">
                                        <button onclick="showPatientDetails(<?php echo esc_js($patient_id); ?>)" 
                                                style="padding: 0.25rem 0.75rem; background: #2563eb; color: white; border: none; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; cursor: pointer; margin-right: 0.25rem;">
                                            View
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Patient Detail Modal -->
        <div id="patientDetailModal" style="display: none; position: fixed; z-index: 10003; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); overflow: auto;">
            <div style="background: white; margin: 2% auto; padding: 2rem; border-radius: 0.75rem; max-width: 900px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); max-height: 90vh; overflow-y: auto;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin: 0;">Patient Details</h3>
                    <button onclick="closePatientDetails()" style="background: none; border: none; font-size: 1.5rem; color: #6b7280; cursor: pointer; padding: 0; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">&times;</button>
                </div>
                <div id="patientDetailContent">
                    <!-- Content will be loaded via AJAX or populated inline -->
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 1.5rem;">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0 0 1rem;">📋 Recent Activity</h2>
            <?php if (empty($recent_logs)): ?>
                <p style="color: #6b7280; text-align: center; padding: 2rem 0;">No activity logged yet. The system is ready!</p>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #e5e7eb;">
                                <th style="text-align: left; padding: 0.75rem; font-size: 0.8rem; color: #6b7280; text-transform: uppercase;">Time</th>
                                <th style="text-align: left; padding: 0.75rem; font-size: 0.8rem; color: #6b7280; text-transform: uppercase;">User</th>
                                <th style="text-align: left; padding: 0.75rem; font-size: 0.8rem; color: #6b7280; text-transform: uppercase;">Action</th>
                                <th style="text-align: left; padding: 0.75rem; font-size: 0.8rem; color: #6b7280; text-transform: uppercase;">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_logs as $log): ?>
                                <tr style="border-bottom: 1px solid #f3f4f6;">
                                    <td style="padding: 0.75rem; font-size: 0.875rem; color: #6b7280;"><?php echo esc_html(wp_date('M j, g:i A', strtotime($log->created_at))); ?></td>
                                    <td style="padding: 0.75rem; font-size: 0.875rem; color: #1f2937; font-weight: 500;"><?php echo esc_html($log->user_name ?? 'System'); ?></td>
                                    <td style="padding: 0.75rem;"><code style="background: #f3f4f6; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem;"><?php echo esc_html($log->action); ?></code></td>
                                    <td style="padding: 0.75rem; font-size: 0.875rem; color: #6b7280;"><?php echo esc_html($log->details); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>

<script>
// Patient data for modal
const patientData = <?php 
    $patients_json = array();
    foreach ($all_patients as $p_data) {
        $user = get_user_by('ID', $p_data->user_id);
        if (!$user) continue;
        $patient = FDCS_Patient::get_by_user_id($user->ID);
        if (!$patient) continue;
        $phone = get_user_meta($user->ID, 'phone', true);
        $assigned_doctor = $patient->assigned_doctor_id ? get_user_by('ID', $patient->assigned_doctor_id) : null;
        
        $patients_json[$patient->id] = array(
            'id' => $patient->id,
            'user_id' => $user->ID,
            'name' => $user->display_name,
            'email' => $user->user_email,
            'phone' => $phone ?: '',
            'date_of_birth' => $patient->date_of_birth ? wp_date('F j, Y', strtotime($patient->date_of_birth)) : '',
            'gender' => $patient->gender ? ucfirst($patient->gender) : '',
            'status' => $patient->registration_status,
            'assigned_doctor_id' => $patient->assigned_doctor_id ?: 0,
            'assigned_doctor_name' => $assigned_doctor ? $assigned_doctor->display_name : '',
            'family_history' => $patient->family_history ?: '',
            'drug_history' => $patient->drug_history ?: '',
            'allergy_history' => $patient->allergy_history ?: '',
            'medical_surgical_history' => $patient->medical_surgical_history ?: '',
            'pap_smear_status' => $patient->pap_smear_status ? ucfirst(str_replace('_', ' ', $patient->pap_smear_status)) : '',
            'last_mammogram' => $patient->last_mammogram ?: '',
            'other_information' => $patient->other_information ?: '',
            'created_at' => wp_date('F j, Y', strtotime($patient->created_at)),
        );
    }
    echo json_encode($patients_json);
?>;

const doctorsList = <?php 
    $doctors_json = array();
    foreach ($all_doctors as $doc) {
        $doctors_json[$doc->ID] = $doc->display_name;
    }
    echo json_encode($doctors_json);
?>;

function showPatientDetails(patientId) {
    const patient = patientData[patientId];
    if (!patient) {
        alert('Patient not found');
        return;
    }
    
    const modal = document.getElementById('patientDetailModal');
    const content = document.getElementById('patientDetailContent');
    
    content.innerHTML = `
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
            <div>
                <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem; text-transform: uppercase;">Personal Information</h4>
                <div style="background: #f9fafb; padding: 1rem; border-radius: 0.5rem;">
                    <p style="margin: 0.5rem 0;"><strong>Name:</strong> ${escapeHtml(patient.name)}</p>
                    <p style="margin: 0.5rem 0;"><strong>Email:</strong> ${escapeHtml(patient.email)}</p>
                    <p style="margin: 0.5rem 0;"><strong>Phone:</strong> ${escapeHtml(patient.phone || '—')}</p>
                    <p style="margin: 0.5rem 0;"><strong>Date of Birth:</strong> ${escapeHtml(patient.date_of_birth || '—')}</p>
                    <p style="margin: 0.5rem 0;"><strong>Gender:</strong> ${escapeHtml(patient.gender || '—')}</p>
                </div>
            </div>
            <div>
                <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem; text-transform: uppercase;">Registration Details</h4>
                <div style="background: #f9fafb; padding: 1rem; border-radius: 0.5rem;">
                    <p style="margin: 0.5rem 0;"><strong>Status:</strong> 
                        <span style="padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; ${patient.status === 'active' ? 'background: #d1fae5; color: #065f46;' : 'background: #fef3c7; color: #92400e;'}">
                            ${escapeHtml(patient.status.charAt(0).toUpperCase() + patient.status.slice(1))}
                        </span>
                    </p>
                    <p style="margin: 0.5rem 0;"><strong>Assigned Doctor:</strong> ${escapeHtml(patient.assigned_doctor_name || 'Unassigned')}</p>
                    <p style="margin: 0.5rem 0;"><strong>Registered:</strong> ${escapeHtml(patient.created_at)}</p>
                </div>
            </div>
        </div>
        
        <div style="margin-bottom: 2rem;">
            <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem; text-transform: uppercase;">Family History</h4>
            <div style="background: #f9fafb; padding: 1rem; border-radius: 0.5rem; min-height: 80px;">
                <p style="margin: 0; color: #374151; white-space: pre-wrap;">${escapeHtml(patient.family_history || 'Not provided')}</p>
            </div>
        </div>
        
        <div style="margin-bottom: 2rem;">
            <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem; text-transform: uppercase;">Drug History</h4>
            <div style="background: #f9fafb; padding: 1rem; border-radius: 0.5rem; min-height: 80px;">
                <p style="margin: 0; color: #374151; white-space: pre-wrap;">${escapeHtml(patient.drug_history || 'Not provided')}</p>
            </div>
        </div>
        
        <div style="margin-bottom: 2rem;">
            <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem; text-transform: uppercase;">Allergy History</h4>
            <div style="background: #f9fafb; padding: 1rem; border-radius: 0.5rem; min-height: 80px;">
                <p style="margin: 0; color: #374151; white-space: pre-wrap;">${escapeHtml(patient.allergy_history || 'Not provided')}</p>
            </div>
        </div>
        
        <div style="margin-bottom: 2rem;">
            <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem; text-transform: uppercase;">Medical and Surgical History</h4>
            <div style="background: #f9fafb; padding: 1rem; border-radius: 0.5rem; min-height: 80px;">
                <p style="margin: 0; color: #374151; white-space: pre-wrap;">${escapeHtml(patient.medical_surgical_history || 'Not provided')}</p>
            </div>
        </div>
        
        <div style="margin-bottom: 2rem;">
            <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem; text-transform: uppercase;">Gynaecology History</h4>
            <div style="background: #f9fafb; padding: 1rem; border-radius: 0.5rem;">
                <p style="margin: 0.5rem 0;"><strong>Pap Smear Status:</strong> ${escapeHtml(patient.pap_smear_status || '—')}</p>
                <p style="margin: 0.5rem 0;"><strong>Last Mammogram:</strong> ${escapeHtml(patient.last_mammogram || '—')}</p>
            </div>
        </div>
        
        ${patient.other_information ? `
        <div style="margin-bottom: 2rem;">
            <h4 style="font-size: 0.875rem; font-weight: 600; color: #6b7280; margin-bottom: 0.5rem; text-transform: uppercase;">Other Information</h4>
            <div style="background: #f9fafb; padding: 1rem; border-radius: 0.5rem; min-height: 80px;">
                <p style="margin: 0; color: #374151; white-space: pre-wrap;">${escapeHtml(patient.other_information)}</p>
            </div>
        </div>
        ` : ''}
        
        <div style="display: flex; gap: 0.75rem; margin-top: 2rem; padding-top: 2rem; border-top: 2px solid #e5e7eb;">
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="flex: 1;">
                <input type="hidden" name="action" value="fdcs_update_patient_status">
                <input type="hidden" name="patient_id" value="${patient.id}">
                <input type="hidden" name="status" value="${patient.status === 'waitlist' ? 'active' : 'waitlist'}">
                <?php wp_nonce_field('fdcs_update_patient_status', 'fdcs_patient_status_nonce'); ?>
                <button type="submit" style="width: 100%; padding: 0.75rem; background: ${patient.status === 'waitlist' ? '#10b981' : '#f59e0b'}; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">
                    ${patient.status === 'waitlist' ? 'Approve Patient' : 'Move to Waitlist'}
                </button>
            </form>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="flex: 1;">
                <input type="hidden" name="action" value="fdcs_assign_doctor">
                <input type="hidden" name="patient_id" value="${patient.id}">
                <?php wp_nonce_field('fdcs_assign_doctor', 'fdcs_assign_doctor_nonce'); ?>
                <select name="doctor_id" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; margin-bottom: 0.5rem;">
                    <option value="0">Unassign</option>
                    ${Object.entries(doctorsList).map(([id, name]) => 
                        `<option value="${id}" ${patient.assigned_doctor_id == id ? 'selected' : ''}>${escapeHtml(name)}</option>`
                    ).join('')}
                </select>
                <button type="submit" style="width: 100%; padding: 0.75rem; background: #2563eb; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">
                    Assign Doctor
                </button>
            </form>
        </div>
    `;
    
    modal.style.display = 'block';
}

function closePatientDetails() {
    document.getElementById('patientDetailModal').style.display = 'none';
}

function approvePatient(patientId) {
    if (confirm('Are you sure you want to approve this patient?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo esc_url(admin_url('admin-post.php')); ?>';
        
        const action = document.createElement('input');
        action.type = 'hidden';
        action.name = 'action';
        action.value = 'fdcs_update_patient_status';
        form.appendChild(action);
        
        const patientIdInput = document.createElement('input');
        patientIdInput.type = 'hidden';
        patientIdInput.name = 'patient_id';
        patientIdInput.value = patientId;
        form.appendChild(patientIdInput);
        
        const status = document.createElement('input');
        status.type = 'hidden';
        status.name = 'status';
        status.value = 'active';
        form.appendChild(status);
        
        const nonce = document.createElement('input');
        nonce.type = 'hidden';
        nonce.name = 'fdcs_patient_status_nonce';
        nonce.value = '<?php echo wp_create_nonce('fdcs_update_patient_status'); ?>';
        form.appendChild(nonce);
        
        document.body.appendChild(form);
        form.submit();
    }
}

function filterPatients() {
    const search = document.getElementById('patientSearch').value.toLowerCase();
    const statusFilter = document.getElementById('patientStatusFilter').value;
    const doctorFilter = document.getElementById('patientDoctorFilter').value;
    const rows = document.querySelectorAll('#patientTable tbody tr.patient-row');
    
    rows.forEach(row => {
        const name = row.getAttribute('data-name') || '';
        const email = row.getAttribute('data-email') || '';
        const status = row.getAttribute('data-status') || '';
        const doctor = row.getAttribute('data-doctor') || '0';
        
        const matchesSearch = !search || name.includes(search) || email.includes(search);
        const matchesStatus = !statusFilter || status === statusFilter;
        const matchesDoctor = !doctorFilter || doctor === doctorFilter;
        
        if (matchesSearch && matchesStatus && matchesDoctor) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('patientDetailModal');
    const staffModal = document.getElementById('createStaffModal');
    if (event.target === modal) {
        closePatientDetails();
    }
    if (event.target === staffModal) {
        staffModal.style.display = 'none';
    }
}

// Staff form spinner
document.addEventListener('DOMContentLoaded', function() {
    const staffForm = document.querySelector('#createStaffModal form');
    if (staffForm) {
        staffForm.addEventListener('submit', function() {
            const btn = document.getElementById('createStaffBtn');
            const btnText = document.getElementById('createStaffBtnText');
            const spinner = document.getElementById('createStaffSpinner');
            if (btn && btnText && spinner) {
                btn.disabled = true;
                btn.style.opacity = '0.7';
                btnText.textContent = 'Creating...';
                spinner.style.display = 'inline-block';
            }
        });
    }
});
</script>

<?php get_footer(); ?>

