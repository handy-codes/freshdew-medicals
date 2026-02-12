<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <?php
    // --- SEO & Open Graph Meta Tags ---
    $fd_contact = freshdew_get_contact_info();
    $fd_site_title = 'FreshDew Medical Clinic';
    $fd_default_title = 'Quality Healthcare You Can Trust';
    $fd_description = 'Experience premium medical care with cutting-edge technology, compassionate professionals, and innovative telehealth solutions—all from the comfort of your home.';
    $fd_url = home_url('/');
    $fd_logo_url = get_template_directory_uri() . '/assets/images/freshdew-favicon-logo.png';

    // Determine current page title
    $fd_page_title = $fd_site_title . ' – ' . $fd_default_title;
    if (is_page()) {
        $fd_page_title = get_the_title() . ' – ' . $fd_site_title;
    }
    ?>

    <!-- Primary Meta Tags -->
    <meta name="title" content="<?php echo esc_attr($fd_page_title); ?>">
    <meta name="description" content="<?php echo esc_attr($fd_description); ?>">
    <meta name="keywords" content="medical clinic Belleville, family doctor Belleville Ontario, walk-in clinic Belleville, telehealth Ontario, FreshDew Medical, healthcare Belleville, doctor near me, family practice Belleville, medical centre Quinte, patient registration Belleville">
    <meta name="author" content="FreshDew Medical Clinic">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?php echo esc_url(is_front_page() ? $fd_url : get_permalink()); ?>">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo esc_url(is_front_page() ? $fd_url : get_permalink()); ?>">
    <meta property="og:title" content="<?php echo esc_attr($fd_site_title . ' – ' . $fd_default_title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($fd_description); ?>">
    <meta property="og:image" content="<?php echo esc_url($fd_logo_url); ?>">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">
    <meta property="og:image:type" content="image/png">
    <meta property="og:site_name" content="<?php echo esc_attr($fd_site_title); ?>">
    <meta property="og:locale" content="en_CA">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="<?php echo esc_url(is_front_page() ? $fd_url : get_permalink()); ?>">
    <meta name="twitter:title" content="<?php echo esc_attr($fd_site_title . ' – ' . $fd_default_title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($fd_description); ?>">
    <meta name="twitter:image" content="<?php echo esc_url($fd_logo_url); ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo esc_url($fd_logo_url); ?>">
    <link rel="apple-touch-icon" href="<?php echo esc_url($fd_logo_url); ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo esc_url($fd_logo_url); ?>">

    <!-- Geo Tags for Local SEO -->
    <meta name="geo.region" content="CA-ON">
    <meta name="geo.placename" content="Belleville">
    <meta name="geo.position" content="<?php echo esc_attr($fd_contact['latitude']); ?>;<?php echo esc_attr($fd_contact['longitude']); ?>">
    <meta name="ICBM" content="<?php echo esc_attr($fd_contact['latitude']); ?>, <?php echo esc_attr($fd_contact['longitude']); ?>">

    <!-- JSON-LD Structured Data for Google Rich Results & Sitelinks -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "MedicalClinic",
        "name": "<?php echo esc_js($fd_site_title); ?>",
        "alternateName": "FreshDew Medical Centre",
        "url": "<?php echo esc_url($fd_url); ?>",
        "logo": "<?php echo esc_url($fd_logo_url); ?>",
        "image": "<?php echo esc_url($fd_logo_url); ?>",
        "description": "<?php echo esc_js($fd_description); ?>",
        "telephone": "+1<?php echo esc_js($fd_contact['phone']); ?>",
        "faxNumber": "+1<?php echo esc_js($fd_contact['fax']); ?>",
        "email": "<?php echo esc_js($fd_contact['email']); ?>",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "<?php echo esc_js($fd_contact['address']); ?>",
            "addressLocality": "<?php echo esc_js($fd_contact['city']); ?>",
            "addressRegion": "<?php echo esc_js($fd_contact['province']); ?>",
            "postalCode": "<?php echo esc_js($fd_contact['postal_code']); ?>",
            "addressCountry": "CA"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": <?php echo esc_js($fd_contact['latitude']); ?>,
            "longitude": <?php echo esc_js($fd_contact['longitude']); ?>
        },
        "openingHoursSpecification": [
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "opens": "09:00",
                "closes": "17:00"
            },
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": "Saturday",
                "opens": "10:00",
                "closes": "16:00"
            }
        ],
        "medicalSpecialty": ["Family Practice","General Practice","Walk-in Clinic","Telehealth"],
        "availableService": [
            {"@type": "MedicalProcedure", "name": "Walk-in Clinic"},
            {"@type": "MedicalProcedure", "name": "Family Practice"},
            {"@type": "MedicalProcedure", "name": "Telehealth"},
            {"@type": "MedicalProcedure", "name": "Patient Registration"}
        ],
        "sameAs": [
            "https://x.com/FreshDewMedClin",
            "https://www.facebook.com/share/1GJJTzcRQc/?mibextid=wwXIfr"
        ],
        "priceRange": "$$",
        "areaServed": {
            "@type": "GeoCircle",
            "geoMidpoint": {
                "@type": "GeoCoordinates",
                "latitude": <?php echo esc_js($fd_contact['latitude']); ?>,
                "longitude": <?php echo esc_js($fd_contact['longitude']); ?>
            },
            "geoRadius": "50000"
        }
    }
    </script>

    <!-- Sitelinks Search Box (Google) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "<?php echo esc_js($fd_site_title); ?>",
        "url": "<?php echo esc_url($fd_url); ?>",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "<?php echo esc_url($fd_url); ?>?s={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container">
        <div class="header-content">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/freshdew-favicon-logo.png'); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="brand-logo" loading="eager" decoding="async">
                <span class="brand-text">
                    <span class="brand-name">FreshDew</span>
                    <span class="brand-tagline" style="color: #16a34a;">Medical Clinic</span>
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
    echo '<li><a href="' . esc_url(home_url('/register')) . '">Register</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact')) . '">Contact</a></li>';
    echo '</ul>';
}
?>

