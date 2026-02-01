<?php
/**
 * Template Name: Home Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
?>

<!-- Hero Section with Leaf Image -->
<section class="hero-section">
    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/fresh-leaf-hero.jpg'); ?>" 
         alt="Fresh Healthcare" 
         class="hero-background"
         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
    <div class="hero-background" style="display: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
    
    <div class="container">
        <div class="hero-content">
            <div style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 9999px; margin-bottom: 1.5rem; border: 1px solid rgba(255,255,255,0.2);">
                <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; margin-right: 0.5rem; animation: pulse 2s infinite;"></span>
                <span style="color: rgba(255,255,255,0.9); font-size: 0.875rem; font-weight: 500;">Accepting New Patients</span>
            </div>
            
            <h1 class="hero-title">
                Advanced Healthcare
                <span style="display: block; background: linear-gradient(to right, #67e8f9, #93c5fd); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    For All Canadians
                </span>
            </h1>
            
            <p class="hero-subtitle">
                Experience world-class medical care with cutting-edge technology, 
                compassionate professionals, and innovative telehealth solutions—all from the comfort of your home.
            </p>
            
            <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 3rem;">
                <a href="<?php echo esc_url(home_url('/appointments/book')); ?>" class="btn" style="background: white; color: #1e40af;">
                    Find a Doctor
                </a>
                <a href="<?php echo esc_url(home_url('/appointments/book')); ?>" class="btn btn-outline">
                    Book Appointment
                </a>
                <a href="<?php echo esc_url(home_url('/telehealth')); ?>" class="btn btn-outline">
                    Virtual Visit
                </a>
            </div>
            
            <!-- Stats -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1.5rem;">
                <?php
                $stats = array(
                    array('value' => '24/7', 'label' => 'Emergency Care'),
                    array('value' => '98%', 'label' => 'Patient Satisfaction'),
                    array('value' => '50+', 'label' => 'Specialists'),
                    array('value' => '15min', 'label' => 'Avg Wait Time'),
                );
                foreach ($stats as $stat) :
                ?>
                <div style="text-align: center; padding: 1.5rem; border-radius: 1rem; backdrop-filter: blur(10px); background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                    <div style="font-size: 2rem; font-weight: bold; color: white; margin-bottom: 0.5rem;">
                        <?php echo esc_html($stat['value']); ?>
                    </div>
                    <div style="font-size: 0.875rem; color: rgba(255,255,255,0.7);">
                        <?php echo esc_html($stat['label']); ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section style="padding: 4rem 0; background: #f9fafb;">
    <div class="container">
        <h2 style="text-align: center; font-size: 2.5rem; margin-bottom: 3rem;">Our Services</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <?php
            $services = array(
                array(
                    'title' => 'Walk-in Clinic',
                    'description' => 'No appointment needed. Walk in and receive quality medical care.',
                    'link' => home_url('/walk-in-clinic'),
                    'icon' => '🏥',
                ),
                array(
                    'title' => 'Family Practice',
                    'description' => 'Comprehensive family healthcare with dedicated family doctors.',
                    'link' => home_url('/family-practice'),
                    'icon' => '👨‍⚕️',
                ),
                array(
                    'title' => 'Telehealth',
                    'description' => 'Virtual consultations from the comfort of your home.',
                    'link' => home_url('/telehealth'),
                    'icon' => '💻',
                ),
            );
            foreach ($services as $service) :
            ?>
            <div style="background: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <div style="font-size: 3rem; margin-bottom: 1rem;"><?php echo esc_html($service['icon']); ?></div>
                <h3 style="font-size: 1.5rem; margin-bottom: 1rem;"><?php echo esc_html($service['title']); ?></h3>
                <p style="color: #6b7280; margin-bottom: 1.5rem;"><?php echo esc_html($service['description']); ?></p>
                <a href="<?php echo esc_url($service['link']); ?>" class="btn">Learn More</a>
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
                    Our team of experienced healthcare professionals is dedicated to delivering compassionate, patient-centered care using the latest medical technologies.
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

<!-- Location & Map Section -->
<section style="padding: 4rem 0; background: #f9fafb;">
    <div class="container">
        <h2 style="text-align: center; font-size: 2.5rem; margin-bottom: 1rem;">Visit Us</h2>
        <p style="text-align: center; color: #6b7280; margin-bottom: 3rem; font-size: 1.125rem;">
            Conveniently located in Belleville, Ontario
        </p>
        
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

