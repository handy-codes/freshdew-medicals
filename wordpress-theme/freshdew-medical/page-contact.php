<?php
/**
 * Template Name: Contact Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
?>

<main id="main" class="site-main">
    <div class="container" style="padding: 4rem 20px;">
        <h1 style="text-align: center; font-size: 3rem; margin-bottom: 3rem;">Contact Us</h1>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; max-width: 1200px; margin: 0 auto;">
            <!-- Contact Form -->
            <div style="background: #f9fafb; padding: 2rem; border-radius: 0.5rem;">
                <h2 style="margin-bottom: 1.5rem;">Get in Touch</h2>
                
                <?php
                // Display success/error messages
                if (isset($_GET['contact'])) {
                    $status = sanitize_text_field($_GET['contact']);
                    if ($status === 'success') {
                        echo '<div style="background: #d1fae5; border: 1px solid #10b981; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">';
                        echo '<strong>✓ Success!</strong> Your message has been sent. We will get back to you soon.';
                        echo '</div>';
                    } elseif ($status === 'error') {
                        echo '<div style="background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">';
                        echo '<strong>Error:</strong> Security verification failed. Please try again.';
                        echo '</div>';
                    } elseif ($status === 'missing') {
                        echo '<div style="background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">';
                        echo '<strong>Error:</strong> Please fill in all required fields.';
                        echo '</div>';
                    } elseif ($status === 'invalid_email') {
                        echo '<div style="background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">';
                        echo '<strong>Error:</strong> Please enter a valid email address.';
                        echo '</div>';
                    } elseif ($status === 'error_send') {
                        echo '<div style="background: #fef3c7; border: 1px solid #f59e0b; color: #92400e; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">';
                        echo '<strong>Notice:</strong> There was an issue sending your message. Please try again or contact us directly at <a href="mailto:' . esc_attr($contact_info['email']) . '" style="color: #92400e; text-decoration: underline;">' . esc_html($contact_info['email']) . '</a>.';
                        echo '</div>';
                    }
                }
                ?>
                
                <?php
                // Use Contact Form 7 if available, otherwise show basic form
                if (function_exists('wpcf7_contact_form')) {
                    echo do_shortcode('[contact-form-7 id="1" title="Contact form 1"]');
                } else {
                    ?>
                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="display: flex; flex-direction: column; gap: 1rem;">
                        <input type="hidden" name="action" value="freshdew_contact_form">
                        <?php wp_nonce_field('freshdew_contact_form', 'freshdew_contact_nonce'); ?>
                        
                        <div>
                            <label for="contact_name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Name</label>
                            <input type="text" id="contact_name" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                        </div>
                        
                        <div>
                            <label for="contact_email" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email</label>
                            <input type="email" id="contact_email" name="email" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.25rem;">
                        </div>
                        
                        <div>
                            <label for="contact_message" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Message</label>
                            <textarea id="contact_message" name="message" rows="5" required style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.25rem;"></textarea>
                        </div>
                        
                        <button type="submit" class="btn">Send Message</button>
                    </form>
                    <?php
                }
                ?>
            </div>
            
            <!-- Contact Information -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <!-- Location -->
                <div style="background: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                    <h3 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 1.25rem;">📍</span> Location
                    </h3>
                    <address style="font-style: normal; color: #4b5563; line-height: 1.8;">
                        <?php echo esc_html($contact_info['address']); ?><br>
                        <?php echo esc_html($contact_info['city']); ?>, <?php echo esc_html($contact_info['province']); ?> <?php echo esc_html($contact_info['postal_code']); ?><br>
                        Canada
                    </address>
                </div>
                
                <!-- Phone -->
                <div style="background: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                    <h3 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 1.25rem;">📞</span> Phone
                    </h3>
                    <p style="color: #4b5563;">
                        <a href="tel:+1<?php echo esc_attr($contact_info['phone']); ?>" style="color: #2563eb; text-decoration: none;">
                            <?php echo esc_html($contact_info['phone_formatted']); ?>
                        </a>
                    </p>
                    <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.5rem;">Emergency: 911</p>
                </div>
                
                <!-- Fax -->
                <div style="background: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                    <h3 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 1.25rem;">📠</span> Fax
                    </h3>
                    <p style="color: #4b5563;">
                        <?php echo esc_html($contact_info['fax_formatted']); ?>
                    </p>
                </div>
                
                <!-- Email -->
                <div style="background: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                    <h3 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 1.25rem;">✉️</span> Email
                    </h3>
                    <p style="color: #4b5563;">
                        <a href="mailto:<?php echo esc_attr($contact_info['email']); ?>" style="color: #2563eb; text-decoration: none;">
                            <?php echo esc_html($contact_info['email']); ?>
                        </a>
                    </p>
                </div>
                
                <!-- Hours -->
                <div style="background: #f9fafb; padding: 1.5rem; border-radius: 0.5rem;">
                    <h3 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <span style="font-size: 1.25rem;">🕐</span> Hours
                    </h3>
                    <div style="color: #4b5563; line-height: 1.8;">
                        <p>Monday - Friday: 8:00 AM - 8:00 PM</p>
                        <p>Saturday - Sunday: 9:00 AM - 5:00 PM</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Map -->
        <div style="margin-top: 3rem; max-width: 1200px; margin-left: auto; margin-right: auto;">
            <h2 style="text-align: center; margin-bottom: 2rem;">Find Us</h2>
            <div class="map-container">
                <?php
                $lat = $contact_info['latitude'];
                $lng = $contact_info['longitude'];
                $map_url = "https://www.openstreetmap.org/export/embed.html?bbox=" . ($lng - 0.015) . "," . ($lat - 0.01) . "," . ($lng + 0.015) . "," . ($lat + 0.01) . "&layer=mapnik&marker=" . $lat . "," . $lng;
                $map_direct = "https://www.openstreetmap.org/?mlat=" . $lat . "&mlon=" . $lng . "&zoom=15";
                ?>
                <iframe
                    width="100%"
                    height="100%"
                    frameborder="0"
                    scrolling="no"
                    marginheight="0"
                    marginwidth="0"
                    src="<?php echo esc_url($map_url); ?>"
                    title="FreshDew Medical Clinic Location"
                ></iframe>
            </div>
            <div style="text-align: center; margin-top: 1rem;">
                <a href="<?php echo esc_url($map_direct); ?>" target="_blank" rel="noopener noreferrer" class="btn">
                    Open in Maps
                </a>
            </div>
            <p style="text-align: center; margin-top: 0.5rem; font-size: 0.875rem; color: #6b7280;">
                <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener noreferrer" style="color: #6b7280;">
                    © OpenStreetMap
                </a>
            </p>
        </div>
    </div>
</main>

<?php
get_footer();

