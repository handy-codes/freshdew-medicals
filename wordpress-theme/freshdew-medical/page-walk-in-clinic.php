<?php
/**
 * Template Name: Walk-in Clinic Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
?>

<section style="padding: 4rem 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem; text-align: center; color: white; text-shadow: 0 2px 10px rgba(0,0,0,0.2);">Walk-in Clinic</h1>
        <p style="font-size: 1.25rem; text-align: center; opacity: 0.95; max-width: 800px; margin: 0 auto; color: white; text-shadow: 0 1px 5px rgba(0,0,0,0.2);">
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
                    <div style="width: 64px; height: 64px; margin-bottom: 1rem; color: #2563eb;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">General Medical Care</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Treatment for common illnesses and minor injuries.</p>
                </div>
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="width: 64px; height: 64px; margin-bottom: 1rem; color: #2563eb;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">Prescriptions</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Prescription renewals and new prescriptions as needed.</p>
                </div>
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="width: 64px; height: 64px; margin-bottom: 1rem; color: #2563eb;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
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



