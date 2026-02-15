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
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2.5rem; margin-bottom: 3rem;">
                <?php
                $family_services = array(
                    array(
                        'title' => 'Pediatric Care',
                        'description' => 'Comprehensive healthcare for children of all ages.',
                        'image' => 'pediatric-care.jpg',
                        'initials' => 'PC',
                    ),
                    array(
                        'title' => 'Family Health',
                        'description' => 'Preventive care and health maintenance for the whole family.',
                        'image' => 'family-health.jpg',
                        'initials' => 'FH',
                    ),
                    array(
                        'title' => 'Chronic Disease Management',
                        'description' => 'Ongoing care for diabetes, hypertension, and other chronic conditions.',
                        'image' => 'chronic-disease.jpg',
                        'initials' => 'CD',
                    ),
                    array(
                        'title' => 'Vaccinations',
                        'description' => 'Immunizations for children and adults.',
                        'image' => 'vaccinations.jpg',
                        'initials' => 'VA',
                    ),
                );
                foreach ($family_services as $service) :
                ?>
                <div style="background: white; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 12px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';">
                    <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden;">
                        <?php
                        $service_image = get_template_directory_uri() . '/assets/images/services/' . $service['image'];
                        $service_image_path = get_template_directory() . '/assets/images/services/' . $service['image'];
                        if (file_exists($service_image_path)) {
                            echo '<img src="' . esc_url($service_image) . '" alt="' . esc_attr($service['title']) . '" style="width: 100%; height: 100%; object-fit: cover; display: block; margin: 0; padding: 0;">';
                        } else {
                            echo '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 600;">' . esc_html($service['initials']) . '</div>';
                        }
                        ?>
                    </div>
                    <div style="padding: 2rem;">
                        <h3 style="font-size: 1.5rem; font-weight: 700; color: #2563eb; margin-bottom: 0.5rem;"><?php echo esc_html($service['title']); ?></h3>
                        <p style="color: #1f2937; line-height: 1.7; margin-bottom: 1.5rem; font-size: 0.95rem;"><?php echo esc_html($service['description']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div style="background: #f0f9ff; border-left: 4px solid #2563eb; padding: 1.5rem; margin: 3rem 0; border-radius: 0.5rem;">
                <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: #1e40af;">Accepting New Patients</h3>
                <p style="color: #1e40af; margin: 0;">We are currently accepting new patients for our family practice. click below link to book your first appointment.</p>
            </div>
            
            <div style="text-align: center; margin-top: 3rem;">
                <a href="https://www.myhealthaccess.ca/branded/freshdew-medical-centre" target="_blank" rel="noopener noreferrer" style="display: inline-block;">
                    <img src="https://www.myhealthaccess.ca/build/branded_signup/book_appt_online_big.png" alt="Book Appointment Online" style="max-width: 100%; height: auto; display: block;">
                </a>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();



