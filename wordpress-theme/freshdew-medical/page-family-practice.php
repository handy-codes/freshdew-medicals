<?php
/**
 * Template Name: Family Practice Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
?>

<section style="padding: 4rem 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem; text-align: center; color: white; text-shadow: 0 2px 10px rgba(0,0,0,0.2);">Family Practice</h1>
        <p style="font-size: 1.25rem; text-align: center; opacity: 0.95; max-width: 800px; margin: 0 auto; color: white; text-shadow: 0 1px 5px rgba(0,0,0,0.2);">
            Comprehensive family healthcare with dedicated family doctors.
        </p>
    </div>
</section>

<section style="padding: 4rem 0;">
    <div class="container">
        <div style="max-width: 900px; margin: 0 auto;">
            <h2 style="font-size: 2.5rem; margin-bottom: 2rem; color: #1f2937;">Your Family's Health Partner</h2>
            <p style="color: #4b5563; line-height: 1.8; margin-bottom: 1.5rem; font-size: 1.125rem;">
                At FreshDew Medical Clinic, we provide comprehensive family healthcare services. Our dedicated family 
                doctors build long-term relationships with you and your family, ensuring continuity of care and personalized 
                treatment plans.
            </p>
            
            <h2 style="font-size: 2.5rem; margin: 3rem 0 2rem; color: #1f2937;">Services We Provide</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="width: 64px; height: 64px; margin-bottom: 1rem; color: #2563eb;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">Pediatric Care</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Comprehensive healthcare for children of all ages.</p>
                </div>
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="width: 64px; height: 64px; margin-bottom: 1rem; color: #2563eb;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">Family Health</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Preventive care and health maintenance for the whole family.</p>
                </div>
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="width: 64px; height: 64px; margin-bottom: 1rem; color: #2563eb;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">Chronic Disease Management</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Ongoing care for diabetes, hypertension, and other chronic conditions.</p>
                </div>
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="width: 64px; height: 64px; margin-bottom: 1rem; color: #2563eb;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">Vaccinations</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Immunizations for children and adults.</p>
                </div>
            </div>
            
            <div style="background: #f0f9ff; border-left: 4px solid #2563eb; padding: 1.5rem; margin: 3rem 0; border-radius: 0.5rem;">
                <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: #1e40af;">Accepting New Patients</h3>
                <p style="color: #1e40af; margin: 0;">We are currently accepting new patients for our family practice. Contact us to schedule your first appointment.</p>
            </div>
            
            <div style="text-align: center; margin-top: 3rem;">
                <a href="<?php echo esc_url(home_url('/appointments/book')); ?>" class="btn" style="font-size: 1.125rem; padding: 1rem 2.5rem;">
                    Become a Patient
                </a>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();



