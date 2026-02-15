<?php
/**
 * Template Name: Home Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
?>

<!-- Hero Section with Medical Team Image -->
<section class="hero-section">
    <div class="hero-background-wrapper">
        <!-- Previous image: https://media.istockphoto.com/id/2218491828/photo/medical-team-smiling-at-camera-in-hospital-corridor.webp -->
        <img src="https://images.unsplash.com/photo-1725870953863-4ad4db0acfc2?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8cGF0aWVudCUyMGNhcmV8ZW58MHx8MHx8fDA%3D" 
             alt="Medical Team" 
         class="hero-background"
         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
    <div class="hero-background" style="display: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
        <!-- Professional gradient overlay matching TSX version - lighter for better clarity -->
        <div class="hero-overlay" style="position: absolute; inset: 0; background: linear-gradient(to right, rgba(30, 58, 138, 0.5), rgba(30, 58, 138, 0.25), transparent); z-index: 10;"></div>
    </div>
    
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="badge-dot"></span>
                <span class="badge-text">Accepting New Patients</span>
            </div>
            
            <h1 class="hero-title">
                Quality Healthcare
                <span class="hero-title-gradient">You Can Trust</span>
            </h1>
            
            <p class="hero-subtitle">
                Experience premium medical care with cutting-edge technology, 
                compassionate professionals, and innovative telehealth solutions—all from the comfort of your home.
            </p>
            
            <div class="hero-buttons">
                <a href="<?php echo esc_url(home_url('/register')); ?>" class="btn btn-primary-hero" style="display: none !important;">
                    Register as Patient
                </a>
                <a href="https://www.myhealthaccess.ca/branded/freshdew-medical-centre" target="_blank" rel="noopener noreferrer" style="display: inline-block;">
                    <img src="https://www.myhealthaccess.ca/build/branded_signup/book_appt_online_big.png" alt="Book Appointment Online" style="max-width: 100%; height: auto; display: block;">
                </a>
                <a href="<?php echo esc_url(home_url('/telehealth')); ?>" class="btn btn-ghost-hero">
                    Virtual Consultation
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section style="padding: 4rem 0; background: #f9fafb;">
    <div class="container">
        <h2 style="text-align: center; font-size: 2.5rem; margin-bottom: 3rem;">Our Services</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2.5rem;">
            <?php
            $services = array(
                array(
                    'title' => 'Walk-in Clinic',
                    'description' => 'No appointment needed. Walk in and receive quality medical care.',
                    'link' => home_url('/walk-in-clinic'),
                    'image' => 'walk-in-clinic.jpg',
                    'initials' => 'WC',
                ),
                array(
                    'title' => 'Family Practice',
                    'description' => 'Comprehensive family healthcare with dedicated family doctors.',
                    'link' => home_url('/family-practice'),
                    'image' => 'family-practice.jpg',
                    'initials' => 'FP',
                ),
                array(
                    'title' => 'Telehealth',
                    'description' => 'Virtual consultations from the comfort of your home.',
                    'link' => home_url('/telehealth'),
                    'image' => 'telehealth.jpg',
                    'initials' => 'TH',
                ),
            );
            foreach ($services as $service) :
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
                    <a href="<?php echo esc_url($service['link']); ?>" class="btn" style="display: inline-block; width: 100%; text-align: center; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 600; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                        Learn More
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- About Section -->
<section style="padding: 4rem 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem; align-items: center;">
            <div>
                <h2 style="font-size: 2.5rem; margin-bottom: 1.5rem;">About FreshDew Medical Clinic</h2>
                <p style="color: #4b5563; line-height: 1.8; margin-bottom: 1rem;">
                    FreshDew Medical Clinic is committed to providing exceptional healthcare services to the Belleville community and surrounding areas.
                </p>
                <p style="color: #4b5563; line-height: 1.8; margin-bottom: 1.5rem;">
                    Our team of experienced healthcare professionals are dedicated to delivering compassionate, patient-centered care using the latest medical technologies.
                </p>
                <a href="<?php echo esc_url(home_url('/about')); ?>" class="btn">Learn More About Us</a>
            </div>
            <div>
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/fresh-leaf-hero.jpg'); ?>" 
                     alt="Fresh Healthcare" 
                     style="width: 100%; height: auto; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
                     onerror="this.style.display='none';">
            </div>
        </div>
    </div>
</section>

<!-- Meet and Greet Notice Section -->
<section style="padding: 4rem 0; background: #f9fafb;">
    <div class="container">
        <div style="max-width: 900px; margin: 0 auto;">
            <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 1.5rem; border-radius: 0.5rem;">
                <p style="color: #92400e; margin: 0 0 1rem 0; font-weight: 600; font-size: 1rem;">
                    ⚠️ <strong>Important Notice:</strong> All first appointments with Dr. Kinze will be a "Meet and Greet" to enrol patients into her family practice.
                </p>
                <p style="color: #92400e; margin: 0 0 1rem 0; font-weight: 600; font-size: 1rem;">
                    Please note that no medical complaints will be discussed during this visit.
                </p>
                <p style="color: #92400e; margin: 0 0 1rem 0; font-weight: 600; font-size: 1rem;">
                    You are welcome to book other appointments to discuss medical concerns.
                </p>
                <p style="color: #92400e; margin: 0; font-weight: 600; font-size: 1rem;">
                    Please take note of the clinic policies on the website.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Clinic Policies Section -->
<section style="padding: 4rem 0; background: #f0f4f8;">
    <div class="container">
        <h2 style="text-align: center; font-size: 2.5rem; margin-bottom: 3rem; color: #1f2937; font-weight: 700;">Clinic Policies</h2>
        <div style="max-width: 900px; margin: 0 auto; display: flex; flex-direction: column; gap: 2rem;">
            
            <div style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); padding: 2.5rem; border-radius: 0.75rem; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                <h3 style="font-size: 1.75rem; margin-bottom: 1.25rem; color: #ffffff; font-weight: 700;">Safety of Staff and Patient</h3>
                <p style="color: #ffffff; line-height: 1.8; font-size: 1.125rem;">
                    We aim to provide high standards of care and work under incredible pressure. We understand you may be experiencing stress coming into the clinic. We have a Zero Tolerance Practice Policy and strictly prohibit abusive, violent, threatening or any form of assault towards staff and patients. Violators will be immediately removed from the Practice and Police may be contacted.
                </p>
            </div>
            
            <div style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); padding: 2.5rem; border-radius: 0.75rem; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                <h3 style="font-size: 1.75rem; margin-bottom: 1.25rem; color: #ffffff; font-weight: 700;">No Show</h3>
                <p style="color: #ffffff; line-height: 1.8; font-size: 1.125rem;">
                    We understand circumstances change, so we provide a free 24hour cancellation notice, otherwise there will be a $50 no show fee.
                </p>
            </div>
            
            <div style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); padding: 2.5rem; border-radius: 0.75rem; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                <h3 style="font-size: 1.75rem; margin-bottom: 1.25rem; color: #ffffff; font-weight: 700;">Medical Visit</h3>
                <p style="color: #ffffff; line-height: 1.8; font-size: 1.125rem;">
                    To ensure effective treatment, only ONE medical issue will be discussed per appointment. Please feel free to book as many appointments as needed.
                </p>
            </div>
            
        </div>
    </div>
</section>

<!-- Location & Map Section -->
<section style="padding: 4rem 0; background: #f9fafb;">
    <div class="container">
        <h2 style="text-align: center; font-size: 2.5rem; margin-bottom: 1rem;">Visit Us</h2>
        <p style="text-align: center; color: #6b7280; margin-bottom: 3rem; font-size: 1.125rem;">
            Conveniently located in Belleville, Ontario
        </p>
        
        <!-- Hours of Operation -->
        <div style="max-width: 600px; margin: 0 auto 3rem;">
            <h3 style="text-align: center; font-size: 2rem; margin-bottom: 1.5rem; color: #1f2937;">Hours of Operation</h3>
            <div style="background: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 1rem 0; font-weight: 600; color: #1f2937;">Monday - Friday</td>
                        <td style="padding: 1rem 0; text-align: right; color: #4b5563;">09:00 - 17:00</td>
                    </tr>
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 1rem 0; font-weight: 600; color: #1f2937;">Saturday</td>
                        <td style="padding: 1rem 0; text-align: right; color: #4b5563;">10:00 - 14:00</td>
                    </tr>
                    <tr>
                        <td style="padding: 1rem 0; font-weight: 600; color: #1f2937;">Sunday</td>
                        <td style="padding: 1rem 0; text-align: right; color: #4b5563;">Closed</td>
                    </tr>
                </table>
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                    <p style="margin: 0; font-size: 1rem; font-weight: 600; color: #92400e; background: #fef3c7; padding: 1rem 1.25rem; border-radius: 0.5rem; border-left: 4px solid #f59e0b; text-align: center;">
                        ⚠️ Please check our website and clinic notice for any updates to working hours.
                    </p>
                </div>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem; align-items: start;">
            <div>
                <h3 style="font-size: 1.5rem; margin-bottom: 1.5rem; color: #1f2937;">Location Details</h3>
                <div class="contact-info" style="line-height: 2;">
                    <address style="font-style: normal; color: #4b5563;">
                        <strong style="color: #1f2937; display: block; margin-bottom: 0.5rem;">Address:</strong>
                        <?php echo esc_html($contact_info['address']); ?><br>
                        <?php echo esc_html($contact_info['city']); ?>, <?php echo esc_html($contact_info['province']); ?> <?php echo esc_html($contact_info['postal_code']); ?><br>
                        Canada<br><br>
                        
                        <strong style="color: #1f2937; display: block; margin: 1rem 0 0.5rem;">Phone:</strong>
                        <a href="tel:+1<?php echo esc_attr($contact_info['phone']); ?>" style="color: #2563eb; text-decoration: none;">
                            <?php echo esc_html($contact_info['phone_formatted']); ?>
                        </a><br><br>
                        
                        <strong style="color: #1f2937; display: block; margin: 1rem 0 0.5rem;">Email:</strong>
                        <a href="mailto:<?php echo esc_attr($contact_info['email']); ?>" style="color: #2563eb; text-decoration: none;">
                            <?php echo esc_html($contact_info['email']); ?>
                        </a>
                    </address>
                    
                    <div style="margin-top: 2rem;">
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn">Get Directions</a>
                    </div>
                </div>
            </div>
            
            <div class="map-container" style="height: 400px; border-radius: 0.5rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 100%;">
                <iframe 
                    src="https://www.openstreetmap.org/export/embed.html?bbox=<?php echo esc_attr($contact_info['longitude'] - 0.01); ?>%2C<?php echo esc_attr($contact_info['latitude'] - 0.01); ?>%2C<?php echo esc_attr($contact_info['longitude'] + 0.01); ?>%2C<?php echo esc_attr($contact_info['latitude'] + 0.01); ?>&layer=mapnik&marker=<?php echo esc_attr($contact_info['latitude']); ?>,<?php echo esc_attr($contact_info['longitude']); ?>"
                    width="100%" 
                    height="400" 
                    style="border: 0; display: block; pointer-events: auto;"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            
            <style>
            @media (max-width: 768px) {
                .map-container {
                    width: 100% !important;
                    max-width: 100% !important;
                    margin: 1rem 0 !important;
                    height: 300px !important;
                }
                .map-container iframe {
                    width: 100% !important;
                    height: 300px !important;
                    touch-action: pan-x pan-y;
                }
            }
            </style>
        </div>
    </div>
</section>

<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}
</style>

<?php
get_footer();

