<?php
$contact_info = freshdew_get_contact_info();
?>

<footer class="site-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3><?php echo esc_html($contact_info['name']); ?></h3>
                <p style="color: #9ca3af; margin-bottom: 1rem;">
                    Providing world-class healthcare services in Canada.
                </p>
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
                    <address style="font-style: normal; color: #9ca3af; line-height: 1.8;">
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
                <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                    <a href="#" style="color: #9ca3af;">Facebook</a>
                    <a href="#" style="color: #9ca3af;">Twitter</a>
                    <a href="#" style="color: #9ca3af;">LinkedIn</a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php echo esc_html($contact_info['name']); ?>. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

