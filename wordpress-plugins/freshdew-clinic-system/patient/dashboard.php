<?php
/**
 * Patient Portal Dashboard
 *
 * @package FreshDewClinicSystem
 */

if (!defined('ABSPATH')) {
    exit;
}

$current_user = wp_get_current_user();
$patient = FDCS_Patient::get_by_user_id($current_user->ID);
$phone = get_user_meta($current_user->ID, 'phone', true);
$is_new = isset($_GET['registered']) && $_GET['registered'] === '1';

// Get upcoming appointments if patient exists
$upcoming_appointments = array();
if ($patient) {
    $upcoming_appointments = FDCS_Appointment::get_patient_upcoming($patient->id);
}

get_header();
?>

<main style="background: #f3f4f6; min-height: calc(100vh - 80px);">
    <div style="max-width: 960px; margin: 0 auto; padding: 2rem 1rem;">

        <!-- Welcome Banner -->
        <?php if ($is_new): ?>
            <div style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); padding: 1.5rem; border-radius: 0.75rem; margin-bottom: 1.5rem; border: 1px solid #6ee7b7;">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #065f46; margin: 0 0 0.5rem;">🎉 Welcome to FreshDew Medical Clinic!</h2>
                <p style="color: #047857; margin: 0;">Your registration has been received. Our team will review your profile and you'll be notified once your account is activated.</p>
            </div>
        <?php endif; ?>

        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 style="font-size: 1.75rem; font-weight: 700; color: #1f2937; margin: 0;">
                    Hello, <?php echo esc_html($current_user->first_name ?: $current_user->display_name); ?>
                </h1>
                <p style="color: #6b7280; margin: 0.25rem 0 0;">Patient Portal • <?php echo esc_html(wp_date('l, F j, Y')); ?></p>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <a href="<?php echo esc_url(home_url('/')); ?>" style="padding: 0.5rem 1rem; background: white; color: #374151; border-radius: 0.5rem; text-decoration: none; font-size: 0.875rem; border: 1px solid #d1d5db;">← Website</a>
                <a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>" style="padding: 0.5rem 1rem; background: #ef4444; color: white; border-radius: 0.5rem; text-decoration: none; font-size: 0.875rem;">Sign Out</a>
            </div>
        </div>

        <!-- Registration Status -->
        <?php if ($patient && $patient->registration_status === 'waitlist'): ?>
            <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 1.5rem; border-left: 4px solid #f59e0b;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <span style="font-size: 1.5rem;">⏳</span>
                    <div>
                        <p style="font-weight: 600; color: #92400e; margin: 0;">Your Registration is Under Review</p>
                        <p style="color: #6b7280; margin: 0.25rem 0 0; font-size: 0.875rem;">Our team will review your information and activate your account shortly. You'll receive an email notification once approved.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Quick Actions -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
            <a href="<?php echo esc_url(home_url('/appointments-book')); ?>" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white; padding: 1.25rem; border-radius: 0.75rem; text-decoration: none; text-align: center; font-weight: 600; box-shadow: 0 2px 8px rgba(37,99,235,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                📅 Book Appointment
            </a>
            <a href="<?php echo esc_url(home_url('/telehealth')); ?>" style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 1.25rem; border-radius: 0.75rem; text-decoration: none; text-align: center; font-weight: 600; box-shadow: 0 2px 8px rgba(16,185,129,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                💻 Virtual Consultation
            </a>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white; padding: 1.25rem; border-radius: 0.75rem; text-decoration: none; text-align: center; font-weight: 600; box-shadow: 0 2px 8px rgba(139,92,246,0.3); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
                📞 Contact Clinic
            </a>
        </div>

        <!-- Two Column Layout -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">

            <!-- Upcoming Appointments -->
            <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0 0 1rem;">📅 Upcoming Appointments</h2>
                <?php if (empty($upcoming_appointments)): ?>
                    <div style="text-align: center; padding: 2rem 0;">
                        <p style="color: #6b7280; margin: 0 0 1rem;">No upcoming appointments.</p>
                        <a href="<?php echo esc_url(home_url('/appointments-book')); ?>" style="color: #2563eb; text-decoration: none; font-weight: 600;">Book an appointment →</a>
                    </div>
                <?php else: ?>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <?php foreach ($upcoming_appointments as $appt): ?>
                            <div style="padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.5rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <p style="margin: 0; font-weight: 600; color: #1f2937;"><?php echo esc_html(wp_date('l, M j', strtotime($appt->appointment_date))); ?></p>
                                        <p style="margin: 0; color: #6b7280; font-size: 0.8rem;"><?php echo esc_html(wp_date('g:i A', strtotime($appt->appointment_time))); ?> • Dr. <?php echo esc_html($appt->doctor_name ?? '—'); ?></p>
                                    </div>
                                    <span style="padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; background: #dbeafe; color: #1e40af;">
                                        <?php echo esc_html(ucfirst($appt->status)); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- My Profile -->
            <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0 0 1rem;">👤 My Profile</h2>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #f3f4f6;">
                        <span style="color: #6b7280; font-size: 0.875rem;">Name</span>
                        <span style="font-weight: 600; color: #1f2937;"><?php echo esc_html($current_user->display_name); ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #f3f4f6;">
                        <span style="color: #6b7280; font-size: 0.875rem;">Email</span>
                        <span style="font-weight: 600; color: #1f2937;"><?php echo esc_html($current_user->user_email); ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #f3f4f6;">
                        <span style="color: #6b7280; font-size: 0.875rem;">Phone</span>
                        <span style="font-weight: 600; color: #1f2937;"><?php echo esc_html($phone ?: '—'); ?></span>
                    </div>
                    <?php if ($patient): ?>
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #f3f4f6;">
                            <span style="color: #6b7280; font-size: 0.875rem;">Date of Birth</span>
                            <span style="font-weight: 600; color: #1f2937;"><?php echo esc_html($patient->date_of_birth ? wp_date('M j, Y', strtotime($patient->date_of_birth)) : '—'); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #f3f4f6;">
                            <span style="color: #6b7280; font-size: 0.875rem;">Status</span>
                            <span style="padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 600;
                                <?php echo $patient->registration_status === 'active' ? 'background: #d1fae5; color: #065f46;' : 'background: #fef3c7; color: #92400e;'; ?>">
                                <?php echo esc_html(ucfirst($patient->registration_status)); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Clinic Info -->
        <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 1.5rem;">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin: 0 0 1rem;">🏥 Clinic Information</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div>
                    <p style="font-weight: 600; color: #1f2937; margin: 0;">Hours of Operation</p>
                    <p style="color: #6b7280; font-size: 0.875rem; margin: 0.25rem 0;">Mon–Fri: 09:00 – 17:00</p>
                    <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Sat: 10:00 – 16:00</p>
                    <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Sun: Closed</p>
                </div>
                <div>
                    <p style="font-weight: 600; color: #1f2937; margin: 0;">Contact</p>
                    <?php
                    $contact = function_exists('freshdew_get_contact_info') ? freshdew_get_contact_info() : array();
                    ?>
                    <p style="color: #6b7280; font-size: 0.875rem; margin: 0.25rem 0;">📞 <?php echo esc_html($contact['phone'] ?? '(613) 000-0000'); ?></p>
                    <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">📧 <?php echo esc_html($contact['email'] ?? 'info@freshdewmedicalclinic.com'); ?></p>
                </div>
                <div>
                    <p style="font-weight: 600; color: #1f2937; margin: 0;">Address</p>
                    <p style="color: #6b7280; font-size: 0.875rem; margin: 0.25rem 0;"><?php echo esc_html($contact['address'] ?? ''); ?></p>
                    <p style="color: #6b7280; font-size: 0.875rem; margin: 0;"><?php echo esc_html(($contact['city'] ?? 'Belleville') . ', ' . ($contact['province'] ?? 'ON')); ?></p>
                </div>
            </div>
        </div>

    </div>
</main>

<?php get_footer(); ?>

