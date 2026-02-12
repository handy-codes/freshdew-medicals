<?php
/**
 * Doctor Frontend Dashboard
 *
 * @package FreshDewClinicSystem
 */

if (!defined('ABSPATH')) {
    exit;
}

$current_user = wp_get_current_user();
$doctor_id = $current_user->ID;
$today = current_time('Y-m-d');
$my_patients = FDCS_Patient::get_by_doctor($doctor_id);
$today_appointments = FDCS_Appointment::get_doctor_today($doctor_id);
$total_my_patients = count($my_patients);
$total_today_appts = count($today_appointments);

get_header();
?>

<main style="background: #f3f4f6; min-height: calc(100vh - 80px);">
    <div style="max-width: 1200px; margin: 0 auto; padding: 2rem 1rem;">

        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 style="font-size: 1.75rem; font-weight: 700; color: #1f2937; margin: 0;">
                    Dr. <?php echo esc_html($current_user->display_name); ?>
                </h1>
                <p style="color: #6b7280; margin: 0.25rem 0 0;">
                    Doctor Dashboard • <?php echo esc_html(wp_date('l, F j, Y')); ?>
                </p>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <a href="<?php echo esc_url(home_url('/')); ?>" style="padding: 0.5rem 1rem; background: white; color: #374151; border-radius: 0.5rem; text-decoration: none; font-size: 0.875rem; border: 1px solid #d1d5db;">← Website</a>
                <a href="<?php echo esc_url(wp_logout_url(home_url('/clinic-login'))); ?>" style="padding: 0.5rem 1rem; background: #ef4444; color: white; border-radius: 0.5rem; text-decoration: none; font-size: 0.875rem;">Sign Out</a>
            </div>
        </div>

        <!-- Stats -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-top: 4px solid #2563eb;">
                <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">My Patients</p>
                <p style="font-size: 2rem; font-weight: 700; color: #1f2937; margin: 0.25rem 0 0;"><?php echo esc_html($total_my_patients); ?></p>
            </div>
            <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-top: 4px solid #10b981;">
                <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Today's Appointments</p>
                <p style="font-size: 2rem; font-weight: 700; color: #1f2937; margin: 0.25rem 0 0;"><?php echo esc_html($total_today_appts); ?></p>
            </div>
        </div>

        <!-- Two columns -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">

            <!-- Today's Appointments -->
            <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0 0 1rem;">📅 Today's Schedule</h2>
                <?php if (empty($today_appointments)): ?>
                    <p style="color: #6b7280; text-align: center; padding: 2rem 0;">No appointments today.</p>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <?php foreach ($today_appointments as $appt): ?>
                            <div style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.5rem;">
                                <div style="background: #dbeafe; color: #1e40af; padding: 0.5rem 0.75rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; white-space: nowrap;">
                                    <?php echo esc_html(wp_date('g:i A', strtotime($appt->appointment_time))); ?>
                                </div>
                                <div style="flex: 1;">
                                    <p style="margin: 0; font-weight: 600; color: #1f2937;"><?php echo esc_html($appt->patient_name ?? 'Unknown'); ?></p>
                                    <p style="margin: 0; color: #6b7280; font-size: 0.8rem;"><?php echo esc_html(ucfirst($appt->type)); ?> • <?php echo esc_html($appt->reason ?? 'General'); ?></p>
                                </div>
                                <span style="padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; background: #dbeafe; color: #1e40af;">
                                    <?php echo esc_html(ucfirst($appt->status)); ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- My Patients -->
            <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0 0 1rem;">👥 My Patients</h2>
                <?php if (empty($my_patients)): ?>
                    <p style="color: #6b7280; text-align: center; padding: 2rem 0;">No patients assigned to you yet.</p>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem; max-height: 400px; overflow-y: auto;">
                        <?php foreach ($my_patients as $p): ?>
                            <div style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.5rem;">
                                <div style="width: 40px; height: 40px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #1e40af; font-size: 1rem;">
                                    <?php echo esc_html(strtoupper(substr($p->display_name ?? 'P', 0, 1))); ?>
                                </div>
                                <div style="flex: 1;">
                                    <p style="margin: 0; font-weight: 600; color: #1f2937;"><?php echo esc_html($p->display_name); ?></p>
                                    <p style="margin: 0; color: #6b7280; font-size: 0.8rem;"><?php echo esc_html($p->user_email); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</main>

<?php get_footer(); ?>

