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
                        <?php foreach ($recent_patients as $p): ?>
                            <div style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.5rem;">
                                <div style="width: 40px; height: 40px; background: #fef3c7; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #92400e; font-size: 1rem;">
                                    <?php echo esc_html(strtoupper(substr($p->display_name ?? 'P', 0, 1))); ?>
                                </div>
                                <div style="flex: 1;">
                                    <p style="margin: 0; font-weight: 600; color: #1f2937;"><?php echo esc_html($p->display_name); ?></p>
                                    <p style="margin: 0; color: #6b7280; font-size: 0.8rem;"><?php echo esc_html($p->user_email); ?> • Registered <?php echo esc_html(wp_date('M j', strtotime($p->created_at))); ?></p>
                                </div>
                                <span style="padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; background: #fef3c7; color: #92400e;">Waitlist</span>
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
                        <button type="submit" style="padding: 0.5rem 1rem; background: #2563eb; color: white; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: 600; font-size: 0.875rem;">
                            Create Staff Member
                        </button>
                    </div>
                </form>
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

<?php get_footer(); ?>

