<?php
$contact_info = freshdew_get_contact_info();
?>

<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="footer-brand-text" style="margin-bottom: 1rem; text-decoration: none;">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/freshdew-favicon-logo.png'); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="brand-logo" loading="lazy" decoding="async">
                    <span class="brand-text">
                        <span class="brand-name">FreshDew</span>
                        <span class="brand-tagline" style="color: #16a34a;">Medical Clinic</span>
                    </span>
                </a>
                <p class="footer-description">
                    Providing quality health care in the Bay of Quinte.
                </p>
                <div class="footer-description-border"></div>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/about')); ?>">About Us</a></li>
                    <li><a href="<?php echo esc_url(home_url('/walk-in-clinic')); ?>">Walk-in Clinic</a></li>
                    <li><a href="<?php echo esc_url(home_url('/family-practice')); ?>">Family Practice</a></li>
                    <li><a href="<?php echo esc_url(home_url('/telehealth')); ?>">Telehealth</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Contact Us</h3>
                <div class="contact-info">
                    <address style="font-style: normal; line-height: 1.8;">
                        <?php echo esc_html($contact_info['address']); ?><br>
                        <?php echo esc_html($contact_info['city']); ?>, <?php echo esc_html($contact_info['province']); ?> <?php echo esc_html($contact_info['postal_code']); ?><br>
                        Canada<br><br>
                        Phone: <a href="tel:+1<?php echo esc_attr($contact_info['phone']); ?>"><?php echo esc_html($contact_info['phone_formatted']); ?></a><br>
                        Fax: <?php echo esc_html($contact_info['fax_formatted']); ?><br>
                        Email: <a href="mailto:<?php echo esc_attr($contact_info['email']); ?>"><?php echo esc_html($contact_info['email']); ?></a><br>
                        Website: <a href="https://<?php echo esc_attr($contact_info['website']); ?>" target="_blank" rel="noopener"><?php echo esc_html($contact_info['website']); ?></a>
                    </address>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Follow Us</h3>
                <div class="social-links" style="display: flex; gap: 1.5rem; margin-top: 1rem;">
                    <a href="https://x.com/FreshDewMedClin" target="_blank" rel="noopener noreferrer" class="social-icon social-x" aria-label="Follow us on X (Twitter)">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" fill="currentColor"/>
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/share/1GJJTzcRQc/?mibextid=wwXIfr" target="_blank" rel="noopener noreferrer" class="social-icon social-facebook" aria-label="Follow us on Facebook">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" fill="currentColor"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php echo esc_html($contact_info['name']); ?>. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php 
wp_footer();
?>
</body>
</html>

