<?php
/**
 * Template Name: Telehealth Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
?>

<section style="padding: 4rem 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem; text-align: center;">Telehealth Services</h1>
        <p style="font-size: 1.25rem; text-align: center; opacity: 0.9; max-width: 800px; margin: 0 auto;">
            Virtual consultations from the comfort of your home.
        </p>
    </div>
</section>

<section style="padding: 4rem 0;">
    <div class="container">
        <div style="max-width: 900px; margin: 0 auto;">
            <h2 style="font-size: 2.5rem; margin-bottom: 2rem; color: #1f2937;">Healthcare at Your Fingertips</h2>
            <p style="color: #4b5563; line-height: 1.8; margin-bottom: 1.5rem; font-size: 1.125rem;">
                Our telehealth services allow you to consult with our healthcare professionals from anywhere, at any time. 
                Perfect for follow-up appointments, prescription renewals, and non-urgent medical consultations.
            </p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin: 3rem 0;">
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">💻</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">Video Consultations</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Secure video calls with your doctor from your computer or mobile device.</p>
                </div>
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">📱</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">Phone Consultations</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Speak with a healthcare professional over the phone.</p>
                </div>
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">📋</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">Follow-up Care</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Convenient follow-up appointments without leaving home.</p>
                </div>
            </div>
            
            <h2 style="font-size: 2.5rem; margin: 3rem 0 2rem; color: #1f2937;">When to Use Telehealth</h2>
            <ul style="color: #4b5563; line-height: 2; font-size: 1.125rem; list-style: none; padding: 0;">
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    Follow-up appointments for ongoing conditions
                </li>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    Prescription renewals
                </li>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    General health questions and advice
                </li>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    Mental health consultations
                </li>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    Non-urgent medical concerns
                </li>
            </ul>
            
            <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 1.5rem; margin: 3rem 0; border-radius: 0.5rem;">
                <p style="color: #92400e; margin: 0; font-weight: 600;">
                    ⚠️ <strong>Note:</strong> For medical emergencies, please call 911 or visit your nearest emergency room. 
                    Telehealth is not suitable for life-threatening situations.
                </p>
            </div>
            
            <div style="text-align: center; margin-top: 3rem;">
                <a href="<?php echo esc_url(home_url('/appointments/book')); ?>" class="btn" style="font-size: 1.125rem; padding: 1rem 2.5rem;">
                    Schedule a Virtual Visit
                </a>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();

