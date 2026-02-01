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
    // Styles
    wp_enqueue_style('freshdew-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_style('freshdew-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    
    // Scripts
    wp_enqueue_script('freshdew-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('freshdew-main', 'freshdewAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('freshdew_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'freshdew_enqueue_assets');

/**
 * Hide WordPress Admin Bar on Frontend
 */
function freshdew_hide_admin_bar() {
    if (!current_user_can('administrator')) {
        show_admin_bar(false);
    }
}
add_action('init', 'freshdew_hide_admin_bar');

/**
 * Remove Admin Bar CSS for non-admins
 */
function freshdew_remove_admin_bar_css() {
    if (!current_user_can('administrator')) {
        remove_action('wp_head', '_admin_bar_bump_cb');
    }
}
add_action('wp_head', 'freshdew_remove_admin_bar_css', 1);

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

function freshdew_ai_chat_handler($request) {
    $message = $request->get_param('message');
    
    if (empty($message)) {
        return new WP_Error('missing_message', 'Message is required', array('status' => 400));
    }
    
    $contact_info = freshdew_get_contact_info();
    
    // Check if Groq API key is configured
    $groq_api_key = get_option('freshdew_groq_api_key', '');
    
    if (!empty($groq_api_key)) {
        // Use Groq API
        $response = freshdew_call_groq_api($message, $groq_api_key, $contact_info);
        if ($response) {
            return rest_ensure_response(array('response' => $response));
        }
    }
    
    // Fallback to rule-based responses
    $responses = array(
        'book appointment' => 'To book an appointment, please visit our appointments page or call us at ' . $contact_info['phone_formatted'] . '.',
        'find doctor' => 'You can find our doctors by visiting the family practice page or contacting our office at ' . $contact_info['phone_formatted'] . '.',
        'symptoms' => 'If you are experiencing symptoms, please book an appointment with one of our doctors. For emergencies, call 911.',
        'hours' => 'Our hours are: Monday-Friday 8AM-8PM, Saturday 9AM-5PM, Sunday 10AM-4PM.',
        'emergency' => 'For life-threatening emergencies, please call 911 immediately.',
        'location' => 'We are located at ' . $contact_info['address'] . ', ' . $contact_info['city'] . ', ' . $contact_info['province'] . '.',
        'phone' => 'You can reach us at ' . $contact_info['phone_formatted'] . '.',
        'email' => 'You can email us at ' . $contact_info['email'] . '.',
    );
    
    $lowerMessage = strtolower($message);
    $response = 'I can help you with booking appointments, finding doctors, and general health information. How can I assist you today?';
    
    foreach ($responses as $key => $value) {
        if (strpos($lowerMessage, $key) !== false) {
            $response = $value;
            break;
        }
    }
    
    return rest_ensure_response(array('response' => $response));
}

/**
 * Call Groq API
 */
function freshdew_call_groq_api($message, $api_key, $contact_info) {
    $system_prompt = "You are a helpful AI assistant for FreshDew Medical Clinic in Belleville, Ontario, Canada. You help patients with:
- Booking appointments
- Finding doctors and services
- General health information
- Hospital hours and contact information
- Emergency guidance (always direct to 911 for emergencies)

Contact Information:
- Address: {$contact_info['address']}, {$contact_info['city']}, {$contact_info['province']}
- Phone: {$contact_info['phone_formatted']}
- Email: {$contact_info['email']}
- Hours: Monday-Friday 8AM-8PM, Saturday 9AM-5PM, Sunday 10AM-4PM

Be concise, friendly, and professional. Always remind users that for medical emergencies, they should call 911.";

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
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (isset($data['choices'][0]['message']['content'])) {
        return trim($data['choices'][0]['message']['content']);
    }
    
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

function freshdew_ai_settings_page() {
    if (isset($_POST['submit'])) {
        check_admin_referer('freshdew_ai_settings');
        update_option('freshdew_groq_api_key', sanitize_text_field($_POST['groq_api_key']));
        echo '<div class="notice notice-success"><p>Settings saved!</p></div>';
    }
    
    $api_key = get_option('freshdew_groq_api_key', '');
    ?>
    <div class="wrap">
        <h1>FreshDew AI Chat Settings</h1>
        <form method="post" action="">
            <?php wp_nonce_field('freshdew_ai_settings'); ?>
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
    <?php
}

