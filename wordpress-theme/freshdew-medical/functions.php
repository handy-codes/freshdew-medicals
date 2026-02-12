<?php
/**
 * FreshDew Medical Clinic Theme Functions
 *
 * @package FreshDewMedical
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Theme Setup
 */
function freshdew_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 50,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'freshdew-medical'),
        'footer' => __('Footer Menu', 'freshdew-medical'),
    ));
    
    // Set content width
    $GLOBALS['content_width'] = 1200;
}
add_action('after_setup_theme', 'freshdew_theme_setup');

/**
 * Customizer Settings
 */
function freshdew_customize_register($wp_customize) {
    // Logo Upload
    $wp_customize->add_setting('freshdew_logo', array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'freshdew_logo', array(
        'label' => __('Site Logo', 'freshdew-medical'),
        'section' => 'title_tagline',
        'settings' => 'freshdew_logo',
        'priority' => 8,
    )));
}
add_action('customize_register', 'freshdew_customize_register');

/**
 * Enqueue Scripts and Styles
 */
function freshdew_enqueue_assets() {
    // Cache-busting version (written on deploy by GitHub Actions)
    $deploy_version_file = get_template_directory() . '/assets/deploy-version.txt';
    $deploy_version = '';
    if (file_exists($deploy_version_file)) {
        $deploy_version = trim((string) @file_get_contents($deploy_version_file));
    }
    if ($deploy_version === '') {
        $deploy_version = wp_get_theme()->get('Version');
    }
    
    // Styles
    wp_enqueue_style('freshdew-style', get_stylesheet_uri(), array(), $deploy_version);
    wp_enqueue_style('freshdew-main', get_template_directory_uri() . '/assets/css/main.css', array(), $deploy_version);
    
    // Scripts
    wp_enqueue_script('freshdew-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), $deploy_version, true);
    
    // Localize script for AJAX
    wp_localize_script('freshdew-main', 'freshdewAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('freshdew_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'freshdew_enqueue_assets');

/**
 * Auto-purge LiteSpeed cache when a new deploy is detected.
 * This removes the need to manually purge after every commit/deploy.
 */
function freshdew_maybe_purge_cache_on_deploy() {
    // Avoid running during AJAX/REST/cron to reduce noise.
    if (wp_doing_ajax() || (defined('REST_REQUEST') && REST_REQUEST) || (defined('DOING_CRON') && DOING_CRON)) {
        return;
    }

    $deploy_version_file = get_template_directory() . '/assets/deploy-version.txt';
    if (!file_exists($deploy_version_file)) {
        return;
    }

    $deploy_version = trim((string) @file_get_contents($deploy_version_file));
    if ($deploy_version === '') {
        return;
    }

    $last_version = (string) get_option('freshdew_deploy_version', '');
    if (hash_equals($last_version, $deploy_version)) {
        return; // already purged for this deploy
    }

    update_option('freshdew_deploy_version', $deploy_version, false);

    // LiteSpeed Cache purge hooks (safe to call even if LSCache isn't active)
    do_action('litespeed_purge_all');
    do_action('litespeed_purge_all_cssjs');
    do_action('litespeed_purge_all_object');
}
add_action('init', 'freshdew_maybe_purge_cache_on_deploy', 20);

/**
 * Add aria-current="page" to active menu link (for reliable active styling).
 */
function freshdew_nav_menu_link_attributes($atts, $item) {
    if (!empty($item->current) || !empty($item->current_item_ancestor) || !empty($item->current_item_parent)) {
        $atts['aria-current'] = 'page';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'freshdew_nav_menu_link_attributes', 10, 2);

/**
 * Hide WordPress Admin Bar on Frontend (All Users)
 */
function freshdew_hide_admin_bar() {
    if (!is_admin()) {
        show_admin_bar(false);
    }
}
add_action('init', 'freshdew_hide_admin_bar', 9);

/**
 * Remove Admin Bar CSS
 */
function freshdew_remove_admin_bar_css() {
    if (!is_admin()) {
        remove_action('wp_head', '_admin_bar_bump_cb');
    }
}
add_action('wp_head', 'freshdew_remove_admin_bar_css', 1);

/**
 * Remove Admin Bar HTML
 */
function freshdew_remove_admin_bar_html() {
    if (!is_admin()) {
        remove_action('wp_footer', 'wp_admin_bar_render', 1000);
    }
}
add_action('wp_footer', 'freshdew_remove_admin_bar_html', 1);

/**
 * Force remove admin bar class from body
 */
function freshdew_remove_admin_bar_body_class($classes) {
    if (!is_admin()) {
        $classes = array_diff($classes, array('admin-bar'));
    }
    return $classes;
}
add_filter('body_class', 'freshdew_remove_admin_bar_body_class', 20);

/**
 * Render AI chat widget on all pages (robust).
 * Ensures widget is moved to body root to avoid parent transform issues.
 */
function freshdew_render_ai_chat_widget() {
    static $rendered = false;
    if ($rendered) {
        return;
    }
    $rendered = true;

    // Render widget template
    get_template_part('ai-chat-button');
    
    // JavaScript to ensure chat button and widget are at body root (like Next.js layout)
    ?>
    <script>
    (function() {
        function ensureChatAtBodyRoot() {
            const chatToggle = document.getElementById('ai-chat-toggle');
            const widgetRoot = document.getElementById('ai-chat-widget-root');
            
            // Move button to body if not already there (like Next.js renders it at layout level)
            if (chatToggle && chatToggle.parentNode !== document.body) {
                document.body.appendChild(chatToggle);
            }
            
            // Move widget container to body if not already there
            if (widgetRoot && widgetRoot.parentNode !== document.body) {
                document.body.appendChild(widgetRoot);
            }
        }
        
        // Run immediately if DOM is ready, otherwise wait
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', ensureChatAtBodyRoot);
        } else {
            ensureChatAtBodyRoot();
        }
        
        // Also run after a short delay to catch any late DOM manipulation
        setTimeout(ensureChatAtBodyRoot, 100);
    })();
    </script>
    <?php
}
add_action('wp_footer', 'freshdew_render_ai_chat_widget', 999); // High priority to render last

/**
 * Register Widget Areas
 */
function freshdew_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'freshdew-medical'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here.', 'freshdew-medical'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget 1', 'freshdew-medical'),
        'id' => 'footer-1',
        'description' => __('Add widgets here.', 'freshdew-medical'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget 2', 'freshdew-medical'),
        'id' => 'footer-2',
        'description' => __('Add widgets here.', 'freshdew-medical'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'freshdew_widgets_init');

/**
 * Get Contact Information
 */
function freshdew_get_contact_info() {
    return array(
        'name' => 'FreshDew Medical Clinic',
        'address' => '135 Cannifton Road, Unit 2 & 3',
        'city' => 'Belleville',
        'province' => 'Ontario',
        'postal_code' => 'K8N 4V4',
        'phone' => '6132880183',
        'phone_formatted' => '(613) 288-0183',
        'fax' => '6132880321',
        'fax_formatted' => '(613) 288-0321',
        'email' => 'info@freshdewmedicalclinic.com',
        'website' => 'www.freshdewmedicalclinic.com',
        'latitude' => 44.1628,
        'longitude' => -77.3831,
    );
}

/**
 * SEO: Custom document title for better Google indexing
 */
function freshdew_document_title_parts($title) {
    $title['site'] = 'FreshDew Medical Clinic';
    if (is_front_page()) {
        $title['title'] = 'Quality Healthcare You Can Trust';
    }
    return $title;
}
add_filter('document_title_parts', 'freshdew_document_title_parts');

function freshdew_document_title_separator($sep) {
    return '–';
}
add_filter('document_title_separator', 'freshdew_document_title_separator');

/**
 * SEO: Per-page meta descriptions for Google snippets
 */
function freshdew_page_meta_descriptions() {
    $descriptions = array(
        'home'            => 'Experience premium medical care with cutting-edge technology, compassionate professionals, and innovative telehealth solutions at FreshDew Medical Clinic in Belleville, Ontario.',
        'about'           => 'Learn about FreshDew Medical Clinic\'s experienced team of family doctors providing exceptional healthcare to the Belleville community and surrounding areas.',
        'walk-in-clinic'  => 'No appointment needed. Visit FreshDew Walk-in Clinic in Belleville, Ontario for quality medical care when you need it. Open Monday to Saturday.',
        'family-practice' => 'Comprehensive family healthcare with dedicated family doctors at FreshDew Medical Clinic. Now accepting new patients in Belleville, Ontario.',
        'telehealth'      => 'Virtual medical consultations from the comfort of your home. FreshDew Medical Clinic offers secure, convenient telehealth appointments in Ontario.',
        'contact'         => 'Contact FreshDew Medical Clinic at (613) 288-0183. Located at 135 Cannifton Road, Belleville, Ontario. Walk-ins welcome.',
        'register'        => 'Register as a new patient at FreshDew Medical Clinic in Belleville. Join our waitlist for family practice services.',
    );

    if (is_page()) {
        $slug = get_post_field('post_name', get_post());
        if (isset($descriptions[$slug])) {
            echo '<meta name="description" content="' . esc_attr($descriptions[$slug]) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'freshdew_page_meta_descriptions', 1);

/**
 * SEO: Generate a basic XML sitemap at /sitemap.xml (WordPress 5.5+ has built-in)
 */
function freshdew_add_sitemap_pages($args, $post_type) {
    // Ensure pages are included in sitemap
    if ($post_type === 'page') {
        $args['orderby'] = 'modified';
        $args['order'] = 'DESC';
    }
    return $args;
}
add_filter('wp_sitemaps_posts_query_args', 'freshdew_add_sitemap_pages', 10, 2);

/**
 * SEO: Output BreadcrumbList structured data for inner pages
 */
function freshdew_breadcrumb_schema() {
    if (is_front_page()) return;
    if (!is_page()) return;

    $contact = freshdew_get_contact_info();
    $page_title = get_the_title();
    $page_url = get_permalink();
    ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "Home",
                "item": "<?php echo esc_url(home_url('/')); ?>"
            },
            {
                "@type": "ListItem",
                "position": 2,
                "name": "<?php echo esc_js($page_title); ?>",
                "item": "<?php echo esc_url($page_url); ?>"
            }
        ]
    }
    </script>
    <?php
}
add_action('wp_head', 'freshdew_breadcrumb_schema', 5);

/**
 * Custom Excerpt Length
 */
function freshdew_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'freshdew_excerpt_length');

/**
 * Custom Excerpt More
 */
function freshdew_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'freshdew_excerpt_more');

/**
 * AI Chat API Endpoint
 */
function freshdew_ai_chat_endpoint() {
    register_rest_route('freshdew/v1', '/ai-chat', array(
        'methods' => 'POST',
        'callback' => 'freshdew_ai_chat_handler',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'freshdew_ai_chat_endpoint');

/**
 * Book Appointment API Endpoint
 * DISABLED: Appointment booking now uses government EMR system
 * To re-enable: Uncomment the add_action line below
 */
function freshdew_book_appointment_endpoint() {
    register_rest_route('freshdew/v1', '/book-appointment', array(
        'methods' => 'POST',
        'callback' => 'freshdew_book_appointment_handler',
        'permission_callback' => '__return_true',
    ));
}
// add_action('rest_api_init', 'freshdew_book_appointment_endpoint'); // Disabled - using EMR system

function freshdew_book_appointment_handler($request) {
    $fullName = sanitize_text_field($request->get_param('fullName'));
    $email = sanitize_email($request->get_param('email'));
    $phone = sanitize_text_field($request->get_param('phone'));
    $date = sanitize_text_field($request->get_param('date'));
    $time = sanitize_text_field($request->get_param('time'));
    $type = sanitize_text_field($request->get_param('type'));
    $reason = sanitize_text_field($request->get_param('reason'));
    $symptoms = sanitize_textarea_field($request->get_param('symptoms'));
    
    if (empty($fullName) || empty($email) || empty($phone) || empty($date) || empty($time) || empty($type) || empty($reason)) {
        return new WP_Error('missing_fields', 'Required fields are missing', array('status' => 400));
    }
    
    // Store appointment in database or send email
    // For now, we'll just return success
    // You can integrate with your appointment management plugin here
    
    $contact_info = freshdew_get_contact_info();
    
    // Prepare email notification with better formatting to avoid spam
    $to = $contact_info['email'];
    $subject = 'New Appointment Request - ' . $fullName;
    
    // HTML email for better deliverability
    $message_html = '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">';
    $message_html .= '<div style="max-width: 600px; margin: 0 auto; padding: 20px; background: #f9fafb; border-radius: 8px;">';
    $message_html .= '<h2 style="color: #667eea; margin-bottom: 20px;">New Appointment Request</h2>';
    $message_html .= '<div style="background: white; padding: 20px; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">';
    $message_html .= '<p><strong>Name:</strong> ' . esc_html($fullName) . '</p>';
    $message_html .= '<p><strong>Email:</strong> <a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a></p>';
    $message_html .= '<p><strong>Phone:</strong> <a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a></p>';
    $message_html .= '<p><strong>Preferred Date:</strong> ' . esc_html($date) . '</p>';
    $message_html .= '<p><strong>Preferred Time:</strong> ' . esc_html($time) . '</p>';
    $message_html .= '<p><strong>Appointment Type:</strong> ' . esc_html($type) . '</p>';
    $message_html .= '<p><strong>Reason for Visit:</strong> ' . esc_html($reason) . '</p>';
    if ($symptoms) {
        $message_html .= '<p><strong>Symptoms:</strong> ' . esc_html($symptoms) . '</p>';
    }
    $message_html .= '</div>';
    $message_html .= '<p style="margin-top: 20px; font-size: 12px; color: #666;">';
    $message_html .= 'Submitted: ' . current_time('mysql') . '<br>';
    $message_html .= 'IP Address: ' . $_SERVER['REMOTE_ADDR'];
    $message_html .= '</p>';
    $message_html .= '</div></body></html>';
    
    // Plain text version for email clients that don't support HTML
    $message_text = "New appointment request received:\n\n";
    $message_text .= "Name: $fullName\n";
    $message_text .= "Email: $email\n";
    $message_text .= "Phone: $phone\n";
    $message_text .= "Date: $date\n";
    $message_text .= "Time: $time\n";
    $message_text .= "Type: $type\n";
    $message_text .= "Reason: $reason\n";
    if ($symptoms) {
        $message_text .= "Symptoms: $symptoms\n";
    }
    $message_text .= "\n---\n";
    $message_text .= "Submitted: " . current_time('mysql') . "\n";
    $message_text .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";
    
    // Improved headers to prevent spam
    // Use the actual contact email as From address for better deliverability
    $from_email = $contact_info['email'];
    
    // Check if SMTP is enabled, otherwise use default WordPress mail
    $smtp_enabled = get_option('freshdew_smtp_enabled', 0);
    
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: FreshDew Medical Clinic <' . $from_email . '>',
        'Reply-To: ' . $email,
        'X-Mailer: WordPress',
        'MIME-Version: 1.0',
    );
    
    // If SMTP is not configured, add additional headers for better deliverability
    if (!$smtp_enabled) {
        $headers[] = 'X-Priority: 1';
        $headers[] = 'Importance: High';
    }
    
    // Send HTML email
    $email_sent = wp_mail($to, $subject, $message_html, $headers);
    
    // Log appointment for debugging (optional - can be removed in production)
    error_log('Appointment Booking: ' . $fullName . ' - ' . $date . ' ' . $time . ' - Email sent: ' . ($email_sent ? 'Yes' : 'No'));
    
    return rest_ensure_response(array(
        'success' => true,
        'message' => 'Appointment request received. We will contact you shortly to confirm.',
        'email_sent' => $email_sent,
        'notification_email' => $to
    ));
}

/**
 * Handle Contact Form Submission
 */
function freshdew_handle_contact_form() {
    // Verify nonce
    if (!isset($_POST['freshdew_contact_nonce']) || !wp_verify_nonce($_POST['freshdew_contact_nonce'], 'freshdew_contact_form')) {
        wp_redirect(add_query_arg('contact', 'error', home_url('/contact')));
        exit;
    }
    
    // Sanitize input
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        wp_redirect(add_query_arg('contact', 'missing', home_url('/contact')));
        exit;
    }
    
    // Validate email format
    if (!is_email($email)) {
        wp_redirect(add_query_arg('contact', 'invalid_email', home_url('/contact')));
        exit;
    }
    
    $contact_info = freshdew_get_contact_info();
    $to = $contact_info['email'];
    $subject = 'New Contact Form Message from ' . get_bloginfo('name');
    
    // Create HTML email
    $message_html = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background: #f4f4f4; padding: 20px;">';
    $message_html .= '<div style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">';
    $message_html .= '<h2 style="color: #667eea; margin-bottom: 20px;">New Contact Form Message</h2>';
    $message_html .= '<div style="background: #f9fafb; padding: 20px; border-radius: 6px; margin-bottom: 20px;">';
    $message_html .= '<p><strong>Name:</strong> ' . esc_html($name) . '</p>';
    $message_html .= '<p><strong>Email:</strong> <a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a></p>';
    $message_html .= '<p><strong>Message:</strong></p>';
    $message_html .= '<div style="background: white; padding: 15px; border-left: 3px solid #667eea; margin-top: 10px;">' . nl2br(esc_html($message)) . '</div>';
    $message_html .= '</div>';
    $message_html .= '<p style="margin-top: 20px; font-size: 12px; color: #666;">';
    $message_html .= 'Submitted: ' . current_time('mysql') . '<br>';
    $message_html .= 'IP Address: ' . (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'Unknown');
    $message_html .= '</p>';
    $message_html .= '</div></body></html>';
    
    // Plain text version
    $message_text = "New contact form message received:\n\n";
    $message_text .= "Name: $name\n";
    $message_text .= "Email: $email\n";
    $message_text .= "Message:\n$message\n\n";
    $message_text .= "---\n";
    $message_text .= "Submitted: " . current_time('mysql') . "\n";
    $message_text .= "IP Address: " . (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'Unknown') . "\n";
    
    // Check if SMTP is enabled
    $smtp_enabled = get_option('freshdew_smtp_enabled', 0);
    
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: FreshDew Medical Clinic <' . $contact_info['email'] . '>',
        'Reply-To: ' . $email,
        'X-Mailer: WordPress',
        'MIME-Version: 1.0',
    );
    
    if (!$smtp_enabled) {
        $headers[] = 'X-Priority: 1';
        $headers[] = 'Importance: High';
    }
    
    // Send email
    $email_sent = wp_mail($to, $subject, $message_html, $headers);
    
    // Log for debugging
    error_log('Contact Form: ' . $name . ' (' . $email . ') - Email sent: ' . ($email_sent ? 'Yes' : 'No'));
    
    // Redirect with success message
    if ($email_sent) {
        wp_redirect(add_query_arg('contact', 'success', home_url('/contact')));
    } else {
        wp_redirect(add_query_arg('contact', 'error_send', home_url('/contact')));
    }
    exit;
}
add_action('admin_post_freshdew_contact_form', 'freshdew_handle_contact_form');
add_action('admin_post_nopriv_freshdew_contact_form', 'freshdew_handle_contact_form');

/**
 * Handle Register Form Submission
 */
function freshdew_handle_register_form() {
    // Verify nonce
    if (!isset($_POST['freshdew_register_nonce']) || !wp_verify_nonce($_POST['freshdew_register_nonce'], 'freshdew_register_form')) {
        wp_redirect(add_query_arg('register', 'error', home_url('/register')));
        exit;
    }
    
    // Sanitize input
    $full_name = isset($_POST['full_name']) ? sanitize_text_field($_POST['full_name']) : '';
    $date_of_birth = isset($_POST['date_of_birth']) ? sanitize_text_field($_POST['date_of_birth']) : '';
    $phone_number = isset($_POST['phone_number']) ? sanitize_text_field($_POST['phone_number']) : '';
    $email_address = isset($_POST['email_address']) ? sanitize_email($_POST['email_address']) : '';
    $family_history = isset($_POST['family_history']) ? sanitize_textarea_field($_POST['family_history']) : '';
    $drug_history = isset($_POST['drug_history']) ? sanitize_textarea_field($_POST['drug_history']) : '';
    $allergy_history = isset($_POST['allergy_history']) ? sanitize_textarea_field($_POST['allergy_history']) : '';
    $medical_surgical_history = isset($_POST['medical_surgical_history']) ? sanitize_textarea_field($_POST['medical_surgical_history']) : '';
    $pap_smear = isset($_POST['pap_smear']) ? sanitize_text_field($_POST['pap_smear']) : '';
    $last_mammogram = isset($_POST['last_mammogram']) ? sanitize_text_field($_POST['last_mammogram']) : '';
    $gyn_other_info = isset($_POST['gyn_other_info']) ? sanitize_textarea_field($_POST['gyn_other_info']) : '';
    
    // Validate required fields
    if (empty($full_name) || empty($date_of_birth) || empty($phone_number) || empty($email_address) || empty($medical_surgical_history)) {
        wp_redirect(add_query_arg('register', 'missing', home_url('/register')));
        exit;
    }
    
    // Validate email format
    if (!is_email($email_address)) {
        wp_redirect(add_query_arg('register', 'invalid_email', home_url('/register')));
        exit;
    }
    
    $contact_info = freshdew_get_contact_info();
    $to = $contact_info['email'];
    $subject = 'New Waitlist Registration - ' . $full_name;
    
    // Create HTML email
    $message_html = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background: #f4f4f4; padding: 20px;">';
    $message_html .= '<div style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">';
    $message_html .= '<h2 style="color: #FF6B35; margin-bottom: 20px;">New Waitlist Registration</h2>';
    $message_html .= '<div style="background: #f9fafb; padding: 20px; border-radius: 6px; margin-bottom: 20px;">';
    
    // Personal Information
    $message_html .= '<h3 style="color: #1f2937; margin-top: 0; margin-bottom: 15px; border-bottom: 2px solid #FF6B35; padding-bottom: 10px;">Personal Information</h3>';
    $message_html .= '<p><strong>Full Name:</strong> ' . esc_html($full_name) . '</p>';
    $message_html .= '<p><strong>Date of Birth:</strong> ' . esc_html($date_of_birth) . '</p>';
    $message_html .= '<p><strong>Phone Number:</strong> <a href="tel:' . esc_attr($phone_number) . '">' . esc_html($phone_number) . '</a></p>';
    $message_html .= '<p><strong>Email Address:</strong> <a href="mailto:' . esc_attr($email_address) . '">' . esc_html($email_address) . '</a></p>';
    
    // Medical History
    $message_html .= '<h3 style="color: #1f2937; margin-top: 25px; margin-bottom: 15px; border-bottom: 2px solid #FF6B35; padding-bottom: 10px;">Medical History</h3>';
    
    if (!empty($family_history)) {
        $message_html .= '<p><strong>Family History:</strong></p>';
        $message_html .= '<div style="background: white; padding: 15px; border-left: 3px solid #FF6B35; margin-top: 5px; margin-bottom: 15px;">' . nl2br(esc_html($family_history)) . '</div>';
    } else {
        $message_html .= '<p><strong>Family History:</strong> Not provided</p>';
    }
    
    if (!empty($drug_history)) {
        $message_html .= '<p><strong>Drug History:</strong></p>';
        $message_html .= '<div style="background: white; padding: 15px; border-left: 3px solid #FF6B35; margin-top: 5px; margin-bottom: 15px;">' . nl2br(esc_html($drug_history)) . '</div>';
    } else {
        $message_html .= '<p><strong>Drug History:</strong> Not provided</p>';
    }
    
    if (!empty($allergy_history)) {
        $message_html .= '<p><strong>Allergy History:</strong></p>';
        $message_html .= '<div style="background: white; padding: 15px; border-left: 3px solid #FF6B35; margin-top: 5px; margin-bottom: 15px;">' . nl2br(esc_html($allergy_history)) . '</div>';
    } else {
        $message_html .= '<p><strong>Allergy History:</strong> Not provided</p>';
    }
    
    if (!empty($medical_surgical_history)) {
        $message_html .= '<p><strong>Current and Past Medical and Surgical History:</strong></p>';
        $message_html .= '<div style="background: white; padding: 15px; border-left: 3px solid #FF6B35; margin-top: 5px; margin-bottom: 15px;">' . nl2br(esc_html($medical_surgical_history)) . '</div>';
    } else {
        $message_html .= '<p><strong>Current and Past Medical and Surgical History:</strong> Not provided</p>';
    }
    
    // Gynaecology History
    $message_html .= '<h3 style="color: #1f2937; margin-top: 25px; margin-bottom: 15px; border-bottom: 2px solid #FF6B35; padding-bottom: 10px;">Gynaecology History</h3>';
    
    $pap_smear_text = '';
    if ($pap_smear === 'yes') {
        $pap_smear_text = 'Yes';
    } elseif ($pap_smear === 'no') {
        $pap_smear_text = 'No';
    } elseif ($pap_smear === 'not_applicable') {
        $pap_smear_text = 'Not Applicable';
    } else {
        $pap_smear_text = 'Not provided';
    }
    $message_html .= '<p><strong>Pap Smear (Up to date):</strong> ' . esc_html($pap_smear_text) . '</p>';
    
    if (!empty($last_mammogram)) {
        $message_html .= '<p><strong>Last Mammogram:</strong> ' . esc_html($last_mammogram) . '</p>';
    } else {
        $message_html .= '<p><strong>Last Mammogram:</strong> Not provided</p>';
    }
    
    if (!empty($gyn_other_info)) {
        $message_html .= '<p><strong>Other Information:</strong></p>';
        $message_html .= '<div style="background: white; padding: 15px; border-left: 3px solid #FF6B35; margin-top: 5px;">' . nl2br(esc_html($gyn_other_info)) . '</div>';
    }
    
    $message_html .= '</div>';
    $message_html .= '<p style="margin-top: 20px; font-size: 12px; color: #666;">';
    $message_html .= 'Submitted: ' . current_time('mysql') . '<br>';
    $message_html .= 'IP Address: ' . (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'Unknown');
    $message_html .= '</p>';
    $message_html .= '</div></body></html>';
    
    // Check if SMTP is enabled
    $smtp_enabled = get_option('freshdew_smtp_enabled', 0);
    
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: FreshDew Medical Clinic <' . $contact_info['email'] . '>',
        'Reply-To: ' . $email_address,
        'X-Mailer: WordPress',
        'MIME-Version: 1.0',
    );
    
    if (!$smtp_enabled) {
        $headers[] = 'X-Priority: 1';
        $headers[] = 'Importance: High';
    }
    
    // Send email
    $email_sent = wp_mail($to, $subject, $message_html, $headers);
    
    // Log for debugging
    error_log('Register Form: ' . $full_name . ' (' . $email_address . ') - Email sent: ' . ($email_sent ? 'Yes' : 'No'));
    
    // Redirect with success message
    if ($email_sent) {
        wp_redirect(add_query_arg('register', 'success', home_url('/register')));
    } else {
        wp_redirect(add_query_arg('register', 'email_failed', home_url('/register')));
    }
    exit;
}
add_action('admin_post_freshdew_register_form', 'freshdew_handle_register_form');
add_action('admin_post_nopriv_freshdew_register_form', 'freshdew_handle_register_form');

function freshdew_ai_chat_handler($request) {
    $message = $request->get_param('message');
    
    if (empty($message)) {
        return new WP_Error('missing_message', 'Message is required', array('status' => 400));
    }
    
    $contact_info = freshdew_get_contact_info();
    
    // Check if Groq API key is configured
    $groq_api_key = get_option('freshdew_groq_api_key', '');
    
    // Rule-based responses for common queries
    $emr_link = 'https://www.myhealthaccess.ca/branded/freshdew-medical-centre';
    $emr_link_html = '<a href="' . esc_url($emr_link) . '" target="_blank" rel="noopener noreferrer" style="color: #667eea; text-decoration: underline; font-weight: 600;">Book Appointment Online</a>';
    $responses = array(
        'book appointment' => 'To book an appointment, please visit our online booking system: ' . $emr_link_html . ' or call us at ' . $contact_info['phone_formatted'] . '.',
        'find doctor' => 'You can find our doctors by visiting the family practice page or contacting our office at ' . $contact_info['phone_formatted'] . '.',
        'symptoms' => 'If you are experiencing symptoms, please book an appointment online: ' . $emr_link_html . ' or call us. For emergencies, call 911.',
        'hours' => '🕐 Hours<br>Monday - Friday: 09:00 - 17:00<br>Saturday: 10:00 - 16:00<br>Sunday: Closed<br><br>Please check our website and clinic notice for any updates to working hours.',
        'emergency' => 'For life-threatening emergencies, please call 911 immediately.',
        'location' => 'We are located at ' . $contact_info['address'] . ', ' . $contact_info['city'] . ', ' . $contact_info['province'] . '.',
        'phone' => 'You can reach us at ' . $contact_info['phone_formatted'] . '.',
        'email' => 'You can email us at ' . $contact_info['email'] . '.',
    );
    
    $lowerMessage = strtolower(trim($message));
    
    // Check for rule-based matches first
    $response = null;
    foreach ($responses as $key => $value) {
        if (strpos($lowerMessage, $key) !== false) {
            $response = $value;
            break;
        }
    }
    
    // If rule-based match found, return it
    if ($response !== null) {
        return rest_ensure_response(array('response' => $response));
    }
    
    // If no rule-based match, try Groq API if configured
    if (!empty($groq_api_key)) {
        $groq_response = freshdew_call_groq_api($message, $groq_api_key, $contact_info);
        if ($groq_response && !empty($groq_response) && strlen($groq_response) > 10) {
            return rest_ensure_response(array('response' => $groq_response));
        }
        // If Groq fails, log it
        error_log('Groq API call failed or returned invalid response. Using default response.');
    } else {
        error_log('Groq API key not configured. Using default response.');
    }
    
    // Default response only if both rule-based and Groq fail
    $emr_link = 'https://www.myhealthaccess.ca/branded/freshdew-medical-centre';
    $emr_link_html = '<a href="' . esc_url($emr_link) . '" target="_blank" rel="noopener noreferrer" style="color: #667eea; text-decoration: underline; font-weight: 600;">Book Appointment Online</a>';
    $response = 'I can help you with booking appointments (' . $emr_link_html . '), finding doctors, and general health information. How can I assist you today?';
    return rest_ensure_response(array('response' => $response));
}

/**
 * Call Groq API
 */
function freshdew_call_groq_api($message, $api_key, $contact_info) {
    $emr_link = 'https://www.myhealthaccess.ca/branded/freshdew-medical-centre';
    $system_prompt = "You are a helpful AI assistant for FreshDew Medical Clinic in Belleville, Ontario, Canada. You help patients with:
- Booking appointments (use online booking at {$emr_link})
- Finding doctors and services
- General health information
- Hospital hours and contact information
- Emergency guidance (always direct to 911 for emergencies)

Contact Information:
- Address: {$contact_info['address']}, {$contact_info['city']}, {$contact_info['province']}
- Phone: {$contact_info['phone_formatted']}
- Email: {$contact_info['email']}
- Hours: Monday - Friday: 09:00 - 17:00, Saturday: 10:00 - 16:00, Sunday: Closed. Please check our website and clinic notice for any updates to working hours.
- Online Booking: {$emr_link}

Be concise, friendly, and professional. Always remind users that for medical emergencies, they should call 911. For appointment booking, direct users to the online booking system at {$emr_link}.";

    $url = 'https://api.groq.com/openai/v1/chat/completions';
    
    $body = array(
        'model' => 'llama-3.1-8b-instant',
        'messages' => array(
            array('role' => 'system', 'content' => $system_prompt),
            array('role' => 'user', 'content' => $message)
        ),
        'temperature' => 0.7,
        'max_tokens' => 200,
        'top_p' => 0.9,
    );
    
    $args = array(
        'method' => 'POST',
        'headers' => array(
            'Authorization' => 'Bearer ' . $api_key,
            'Content-Type' => 'application/json',
        ),
        'body' => json_encode($body),
        'timeout' => 30,
    );
    
    $response = wp_remote_post($url, $args);
    
    if (is_wp_error($response)) {
        error_log('Groq API Error: ' . $response->get_error_message());
        return false;
    }
    
    $response_code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    // Log API errors for debugging
    if ($response_code !== 200) {
        error_log('Groq API Response Code: ' . $response_code);
        error_log('Groq API Response Body: ' . $body);
        if (isset($data['error'])) {
            error_log('Groq API Error: ' . print_r($data['error'], true));
        }
        return false;
    }
    
    if (isset($data['choices'][0]['message']['content'])) {
        return trim($data['choices'][0]['message']['content']);
    }
    
    // Log if response structure is unexpected
    error_log('Groq API Unexpected Response: ' . print_r($data, true));
    return false;
}

/**
 * Add Groq API Key Settings
 */
function freshdew_add_settings_page() {
    add_options_page(
        'FreshDew AI Settings',
        'FreshDew AI',
        'manage_options',
        'freshdew-ai-settings',
        'freshdew_ai_settings_page'
    );
}
add_action('admin_menu', 'freshdew_add_settings_page');

/**
 * Enqueue admin scripts for settings page
 */
function freshdew_enqueue_admin_scripts($hook) {
    if ($hook !== 'settings_page_freshdew-ai-settings') {
        return;
    }
    wp_enqueue_script('jquery');
}
add_action('admin_enqueue_scripts', 'freshdew_enqueue_admin_scripts');

/**
 * Configure SMTP for better email deliverability
 */
function freshdew_configure_smtp($phpmailer) {
    $smtp_enabled = get_option('freshdew_smtp_enabled', 0);
    
    if (!$smtp_enabled) {
        return; // SMTP not enabled
    }
    
    $phpmailer->isSMTP();
    $phpmailer->Host = get_option('freshdew_smtp_host', 'smtp.hostinger.com');
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = get_option('freshdew_smtp_port', '587');
    $phpmailer->Username = get_option('freshdew_smtp_username', '');
    $phpmailer->Password = get_option('freshdew_smtp_password', '');
    
    $encryption = get_option('freshdew_smtp_encryption', 'tls');
    if ($encryption === 'ssl') {
        $phpmailer->SMTPSecure = 'ssl';
    } elseif ($encryption === 'tls') {
        $phpmailer->SMTPSecure = 'tls';
    }
    
    $from_email = get_option('freshdew_smtp_from_email', '');
    $from_name = get_option('freshdew_smtp_from_name', 'FreshDew Medical Clinic');
    
    if ($from_email) {
        $phpmailer->setFrom($from_email, $from_name);
    }
    
    // Enable debugging (optional - can be disabled in production)
    // $phpmailer->SMTPDebug = 2;
    // $phpmailer->Debugoutput = 'error_log';
}
add_action('phpmailer_init', 'freshdew_configure_smtp');

function freshdew_ai_settings_page() {
    if (isset($_POST['submit'])) {
        check_admin_referer('freshdew_ai_settings');
        
        // Determine which form was submitted based on which fields are present
        $is_ai_form = isset($_POST['groq_api_key']);
        $is_smtp_form = isset($_POST['smtp_host']) || isset($_POST['smtp_enabled']);
        
        // Only save AI Chat settings if AI form was submitted
        if ($is_ai_form) {
            // Update Groq API key from POST data (will be in POST if AI form was submitted)
            update_option('freshdew_groq_api_key', sanitize_text_field($_POST['groq_api_key'] ?? ''));
        }
        
        // Only save SMTP settings if SMTP form was submitted
        if ($is_smtp_form) {
            // Always update smtp_enabled (checkbox - 0 or 1)
            update_option('freshdew_smtp_enabled', isset($_POST['smtp_enabled']) ? 1 : 0);
            
            // Update all SMTP fields from POST data (they will be in POST if SMTP form was submitted)
            update_option('freshdew_smtp_host', sanitize_text_field($_POST['smtp_host'] ?? ''));
            update_option('freshdew_smtp_port', sanitize_text_field($_POST['smtp_port'] ?? '587'));
            update_option('freshdew_smtp_encryption', sanitize_text_field($_POST['smtp_encryption'] ?? 'tls'));
            update_option('freshdew_smtp_username', sanitize_text_field($_POST['smtp_username'] ?? ''));
            
            // Password: only update if a new one was provided (don't clear if field is empty)
            if (isset($_POST['smtp_password']) && !empty(trim($_POST['smtp_password']))) {
                update_option('freshdew_smtp_password', sanitize_text_field($_POST['smtp_password']));
            }
            
            update_option('freshdew_smtp_from_email', sanitize_email($_POST['smtp_from_email'] ?? ''));
            update_option('freshdew_smtp_from_name', sanitize_text_field($_POST['smtp_from_name'] ?? 'FreshDew Medical Clinic'));
        }
        
        echo '<div class="notice notice-success"><p>Settings saved!</p></div>';
    }
    
    $api_key = get_option('freshdew_groq_api_key', '');
    $smtp_enabled = get_option('freshdew_smtp_enabled', 0);
    $smtp_host = get_option('freshdew_smtp_host', 'smtp.hostinger.com');
    $smtp_port = get_option('freshdew_smtp_port', '587');
    $smtp_encryption = get_option('freshdew_smtp_encryption', 'tls');
    $smtp_username = get_option('freshdew_smtp_username', '');
    $smtp_password = get_option('freshdew_smtp_password', '');
    $smtp_from_email = get_option('freshdew_smtp_from_email', '');
    $smtp_from_name = get_option('freshdew_smtp_from_name', 'FreshDew Medical Clinic');
    ?>
    <div class="wrap">
        <h1>FreshDew Settings</h1>
        
        <h2 class="nav-tab-wrapper">
            <a href="#ai-settings" class="nav-tab nav-tab-active">AI Chat Settings</a>
            <a href="#smtp-settings" class="nav-tab">Email SMTP Settings</a>
        </h2>
        
        <div id="ai-settings" class="tab-content">
            <form method="post" action="">
                <?php wp_nonce_field('freshdew_ai_settings'); ?>
                <h2>AI Chat Settings</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="groq_api_key">Groq API Key</label>
                        </th>
                        <td>
                            <input type="password" id="groq_api_key" name="groq_api_key" value="<?php echo esc_attr($api_key); ?>" class="regular-text" />
                            <p class="description">
                                Get your API key from <a href="https://console.groq.com/keys" target="_blank">Groq Console</a>
                            </p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        
        <div id="smtp-settings" class="tab-content" style="display: none;">
            <form method="post" action="">
                <?php wp_nonce_field('freshdew_ai_settings'); ?>
                <h2>Email SMTP Settings</h2>
                <p class="description">Configure SMTP to ensure appointment booking emails are delivered properly and avoid spam folders.</p>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="smtp_enabled">Enable SMTP</label>
                        </th>
                        <td>
                            <input type="checkbox" id="smtp_enabled" name="smtp_enabled" value="1" <?php checked($smtp_enabled, 1); ?> />
                            <p class="description">Enable SMTP authentication for better email deliverability</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="smtp_host">SMTP Host</label>
                        </th>
                        <td>
                            <input type="text" id="smtp_host" name="smtp_host" value="<?php echo esc_attr($smtp_host); ?>" class="regular-text" />
                            <p class="description">Hostinger: smtp.hostinger.com | Gmail: smtp.gmail.com | Outlook: smtp-mail.outlook.com</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="smtp_port">SMTP Port</label>
                        </th>
                        <td>
                            <input type="number" id="smtp_port" name="smtp_port" value="<?php echo esc_attr($smtp_port); ?>" class="small-text" />
                            <p class="description">Common ports: 587 (TLS), 465 (SSL), 25 (unencrypted)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="smtp_encryption">Encryption</label>
                        </th>
                        <td>
                            <select id="smtp_encryption" name="smtp_encryption">
                                <option value="tls" <?php selected($smtp_encryption, 'tls'); ?>>TLS (Recommended)</option>
                                <option value="ssl" <?php selected($smtp_encryption, 'ssl'); ?>>SSL</option>
                                <option value="none" <?php selected($smtp_encryption, 'none'); ?>>None</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="smtp_username">SMTP Username</label>
                        </th>
                        <td>
                            <input type="email" id="smtp_username" name="smtp_username" value="<?php echo esc_attr($smtp_username); ?>" class="regular-text" />
                            <p class="description">Your email address (e.g., info@freshdewmedicalclinic.com)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="smtp_password">SMTP Password</label>
                        </th>
                        <td>
                            <input type="password" id="smtp_password" name="smtp_password" value="" class="regular-text" placeholder="<?php echo !empty($smtp_password) ? '••••••••' : ''; ?>" />
                            <?php if (!empty($smtp_password)): ?>
                                <p class="description" style="color: #666; font-style: italic;">Password is saved. Leave blank to keep current password, or enter a new password to change it.</p>
                            <?php endif; ?>
                            <p class="description">
                                For Hostinger: Use your email account password<br>
                                For Gmail: Use an <a href="https://support.google.com/accounts/answer/185833" target="_blank">App Password</a> (not your regular password)<br>
                                For other providers: Use your email password or app-specific password
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="smtp_from_email">From Email</label>
                        </th>
                        <td>
                            <input type="email" id="smtp_from_email" name="smtp_from_email" value="<?php echo esc_attr($smtp_from_email); ?>" class="regular-text" />
                            <p class="description">Email address to send from (usually same as SMTP username)</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="smtp_from_name">From Name</label>
                        </th>
                        <td>
                            <input type="text" id="smtp_from_name" name="smtp_from_name" value="<?php echo esc_attr($smtp_from_name); ?>" class="regular-text" />
                            <p class="description">Name shown as sender (e.g., FreshDew Medical Clinic)</p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('.nav-tab').on('click', function(e) {
            e.preventDefault();
            var target = $(this).attr('href');
            $('.nav-tab').removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');
            $('.tab-content').hide();
            $(target).show();
        });
    });
    </script>
    <?php
}

