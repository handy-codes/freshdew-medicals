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
                <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>" style="padding: 0.5rem 1rem; background: #ef4444; color: white; border-radius: 0.5rem; text-decoration: none; font-size: 0.875rem;">Sign Out</a>
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

