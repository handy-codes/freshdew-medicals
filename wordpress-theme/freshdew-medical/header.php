<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container">
        <div class="header-content">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                <?php
                // Prefer WordPress Custom Logo (Appearance → Customize → Site Identity → Logo)
                $custom_logo_id = get_theme_mod('custom_logo');
                if ($custom_logo_id) {
                    $logo_src = wp_get_attachment_image_url($custom_logo_id, 'full');
                    if ($logo_src) {
                        echo '<img src="' . esc_url($logo_src) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="brand-logo" loading="eager" decoding="async">';
                    }
                } else {
                    // Optional fallback logo URL from Customizer (legacy setting)
                    $logo = get_theme_mod('freshdew_logo');
                    if ($logo) {
                        echo '<img src="' . esc_url($logo) . '" alt="' . esc_attr(get_bloginfo('name')) . '" class="brand-logo" loading="eager" decoding="async">';
                    } else {
                        // No fallback SVG: use a simple dot mark
                        echo '<span class="brand-logo" aria-hidden="true" style="display:inline-flex;align-items:center;justify-content:center;background:#e0f2fe;color:#2563eb;font-weight:900;">FD</span>';
                    }
                }
                ?>
                <span class="brand-text">
                    <span class="brand-name">FreshDew</span>
                    <span class="brand-tagline">Medical Clinic</span>
                </span>
            </a>
            
            <button class="mobile-menu-toggle" aria-label="Toggle menu" aria-expanded="false">
                <span class="hamburger-icon">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </span>
                <span class="close-icon" style="display: none;">×</span>
            </button>
            
            <nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e('Primary Menu', 'freshdew-medical'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'nav-menu',
                    'container' => false,
                    'fallback_cb' => 'freshdew_default_menu',
                ));
                ?>
            </nav>
        </div>
    </div>
</header>

<?php
/**
 * Default Menu Fallback
 */
function freshdew_default_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about')) . '">About</a></li>';
    echo '<li><a href="' . esc_url(home_url('/walk-in-clinic')) . '">Walk-in Clinic</a></li>';
    echo '<li><a href="' . esc_url(home_url('/family-practice')) . '">Family Practice</a></li>';
    echo '<li><a href="' . esc_url(home_url('/telehealth')) . '">Telehealth</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact')) . '">Contact</a></li>';
    echo '</ul>';
}
?>

