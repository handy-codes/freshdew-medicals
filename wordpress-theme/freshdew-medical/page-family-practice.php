<?php
/**
 * Template Name: Family Practice Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
?>

<section style="padding: 4rem 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem; text-align: center;">Family Practice</h1>
        <p style="font-size: 1.25rem; text-align: center; opacity: 0.9; max-width: 800px; margin: 0 auto;">
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
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">👶</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">Pediatric Care</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Comprehensive healthcare for children of all ages.</p>
                </div>
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">👨‍👩‍👧‍👦</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">Family Health</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Preventive care and health maintenance for the whole family.</p>
                </div>
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">🩺</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">Chronic Disease Management</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Ongoing care for diabetes, hypertension, and other chronic conditions.</p>
                </div>
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">💉</div>
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

