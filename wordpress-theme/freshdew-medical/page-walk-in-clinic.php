<?php
/**
 * Template Name: Walk-in Clinic Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
?>

<section style="padding: 4rem 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem; text-align: center;">Walk-in Clinic</h1>
        <p style="font-size: 1.25rem; text-align: center; opacity: 0.9; max-width: 800px; margin: 0 auto;">
            No appointment needed. Quality medical care when you need it.
        </p>
    </div>
</section>

<section style="padding: 4rem 0;">
    <div class="container">
        <div style="max-width: 900px; margin: 0 auto;">
            <div style="background: #f0f9ff; border-left: 4px solid #2563eb; padding: 1.5rem; margin-bottom: 3rem; border-radius: 0.5rem;">
                <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: #1e40af;">Accepting New Patients</h2>
                <p style="color: #1e40af; margin: 0;">We welcome walk-in patients. No appointment necessary!</p>
            </div>
            
            <h2 style="font-size: 2.5rem; margin-bottom: 2rem; color: #1f2937;">What We Offer</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">🏥</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">General Medical Care</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Treatment for common illnesses and minor injuries.</p>
                </div>
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">💊</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">Prescriptions</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Prescription renewals and new prescriptions as needed.</p>
                </div>
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">🩺</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">Health Assessments</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Basic health check-ups and assessments.</p>
                </div>
            </div>
            
            <h2 style="font-size: 2.5rem; margin: 3rem 0 2rem; color: #1f2937;">Hours of Operation</h2>
            <div style="background: #f9fafb; padding: 2rem; border-radius: 0.5rem; margin-bottom: 3rem;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 1rem 0; font-weight: 600; color: #1f2937;">Monday - Friday</td>
                        <td style="padding: 1rem 0; text-align: right; color: #4b5563;">8:00 AM - 8:00 PM</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 1rem 0; font-weight: 600; color: #1f2937;">Saturday</td>
                        <td style="padding: 1rem 0; text-align: right; color: #4b5563;">9:00 AM - 5:00 PM</td>
                    </tr>
                    <tr>
                        <td style="padding: 1rem 0; font-weight: 600; color: #1f2937;">Sunday</td>
                        <td style="padding: 1rem 0; text-align: right; color: #4b5563;">10:00 AM - 4:00 PM</td>
                    </tr>
                </table>
            </div>
            
            <div style="text-align: center; margin-top: 3rem;">
                <a href="<?php echo esc_url(home_url('/appointments/book')); ?>" class="btn" style="font-size: 1.125rem; padding: 1rem 2.5rem;">
                    Book an Appointment
                </a>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();

