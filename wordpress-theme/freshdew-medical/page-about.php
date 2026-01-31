<?php
/**
 * Template Name: About Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
?>

<section style="padding: 4rem 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem; text-align: center;">About FreshDew Medical Clinic</h1>
        <p style="font-size: 1.25rem; text-align: center; opacity: 0.9; max-width: 800px; margin: 0 auto;">
            Providing exceptional healthcare services to the Belleville community and surrounding areas.
        </p>
    </div>
</section>

<section style="padding: 4rem 0;">
    <div class="container">
        <div style="max-width: 900px; margin: 0 auto;">
            <h2 style="font-size: 2.5rem; margin-bottom: 2rem; color: #1f2937;">Our Mission</h2>
            <p style="color: #4b5563; line-height: 1.8; margin-bottom: 1.5rem; font-size: 1.125rem;">
                FreshDew Medical Clinic is committed to delivering world-class medical care with cutting-edge technology, 
                compassionate professionals, and innovative telehealth solutions. We believe that quality healthcare should 
                be accessible to all Canadians.
            </p>
            
            <h2 style="font-size: 2.5rem; margin: 3rem 0 2rem; color: #1f2937;">Our Values</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                <div style="padding: 2rem; background: #f9fafb; border-radius: 0.5rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">❤️</div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: #1f2937;">Compassion</h3>
                    <p style="color: #6b7280; line-height: 1.6;">We treat every patient with empathy, respect, and understanding.</p>
                </div>
                <div style="padding: 2rem; background: #f9fafb; border-radius: 0.5rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">⚡</div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: #1f2937;">Innovation</h3>
                    <p style="color: #6b7280; line-height: 1.6;">We embrace the latest medical technologies and telehealth solutions.</p>
                </div>
                <div style="padding: 2rem; background: #f9fafb; border-radius: 0.5rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🎯</div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: #1f2937;">Excellence</h3>
                    <p style="color: #6b7280; line-height: 1.6;">We strive for the highest standards in patient care and service.</p>
                </div>
            </div>
            
            <h2 style="font-size: 2.5rem; margin: 3rem 0 2rem; color: #1f2937;">Our Services</h2>
            <ul style="color: #4b5563; line-height: 2; font-size: 1.125rem; list-style: none; padding: 0;">
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    <strong>Walk-in Clinic:</strong> No appointment needed. Quality medical care when you need it.
                </li>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    <strong>Family Practice:</strong> Comprehensive family healthcare with dedicated family doctors.
                </li>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    <strong>Telehealth:</strong> Virtual consultations from the comfort of your home.
                </li>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    <strong>Emergency Care:</strong> 24/7 emergency medical services.
                </li>
            </ul>
        </div>
    </div>
</section>

<?php
get_footer();

