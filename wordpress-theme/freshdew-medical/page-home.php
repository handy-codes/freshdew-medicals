<?php
/**
 * Template Name: Home Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
$page_id = get_the_ID();

$default_book_img = 'https://www.myhealthaccess.ca/build/branded_signup/book_appt_online_big.png';
$hero_book_url = trim( freshdew_get_section( $page_id, 'hero_book_online_url', 'https://www.myhealthaccess.ca/branded/freshdew-medical-centre' ) );
$hero_book_img = trim( freshdew_get_section( $page_id, 'hero_book_online_img_url', '' ) );
if ( $hero_book_img === '' ) {
	$hero_book_img = $default_book_img;
}
$hero_virtual_url = trim( freshdew_get_section( $page_id, 'hero_virtual_consult_url', '' ) );
if ( $hero_virtual_url === '' ) {
	$hero_virtual_url = home_url( '/telehealth' );
}
$hero_virtual_label = freshdew_get_section( $page_id, 'hero_virtual_consult_label', 'Virtual Consultation' );
$home_about_cta_url = trim( freshdew_get_section( $page_id, 'home_about_cta_url', '' ) );
if ( $home_about_cta_url === '' ) {
	$home_about_cta_url = home_url( '/about' );
}
$home_directions_url = trim( freshdew_get_section( $page_id, 'home_directions_url', '' ) );
if ( $home_directions_url === '' ) {
	$home_directions_url = home_url( '/contact' );
}

$home_hours_rows_raw = freshdew_get_section(
	$page_id,
	'home_hours_rows',
	"Monday|09:00 - 17:00 OPEN\nTuesday|CLOSED\nWednesday|09:00 - 17:00 OPEN\nThursday|09:00 - 17:00 OPEN\nFriday|09:00 - 15:00 OPEN\nSaturday|CLOSED\nSUNDAY|CLOSED"
);
$home_hours_parsed = freshdew_parse_pipe_table_rows( $home_hours_rows_raw );

$policy_cards = array(
	array(
		'title_key' => 'policy_1_title',
		'body_key'  => 'policy_1_body',
		'title_def' => 'Safety of Staff and Patient',
		'body_def'  => 'We aim to provide high standards of care and work under incredible pressure. We understand you may be experiencing stress coming into the clinic. We have a Zero Tolerance Practice Policy and strictly prohibit abusive, violent, threatening or any form of assault towards staff and patients. Violators will be immediately removed from the Practice and Police may be contacted.',
	),
	array(
		'title_key' => 'policy_2_title',
		'body_key'  => 'policy_2_body',
		'title_def' => 'No Show',
		'body_def'  => 'We understand circumstances change, so we provide a free 24hour cancellation notice, otherwise there will be a $50 no show fee.',
	),
	array(
		'title_key' => 'policy_3_title',
		'body_key'  => 'policy_3_body',
		'title_def' => 'Medical Visit',
		'body_def'  => 'To ensure effective treatment, only ONE medical issue will be discussed per appointment. Please feel free to book as many appointments as needed.',
	),
);
$policies_block_visible = freshdew_section_field_visible( $page_id, 'policies_heading' );
foreach ( $policy_cards as $pc ) {
	if ( freshdew_section_field_visible( $page_id, $pc['title_key'] ) || freshdew_section_field_visible( $page_id, $pc['body_key'] ) ) {
		$policies_block_visible = true;
		break;
	}
}
?>

<!-- Hero Section with Medical Team *** Image -->
<section class="hero-section hero-section--marquee">
    <?php if ( freshdew_section_checkbox_show_enabled( $page_id, 'home_marquee_show' ) ) : ?>
        <?php
        global $freshdew_marquee_args;
        $freshdew_marquee_args = array(
			'text'           => freshdew_get_section(
				$page_id,
				'marquee_text',
				'This is to notify all patients that Dr. Kinze will be away on vacation from April 15 to April 24, 2026.  The clinic will resume fully on April 29, 2026. Please find local walk-in clinics if needed and in emergency, please call 911.'
			),
			'badge_desktop'  => freshdew_get_section( $page_id, 'marquee_badge_desktop', 'Vacation Notice' ),
			'badge_mobile'   => freshdew_get_section( $page_id, 'marquee_badge_mobile', 'Vacation' ),
        );
        get_template_part( 'inc/hero-news-marquee' );
        ?>
    <?php endif; ?>
    <div class="hero-background-wrapper">
        <?php if ( freshdew_section_field_visible( $page_id, 'hero_image' ) ) : ?>
        <?php
        $hero_img_id = freshdew_get_section_image_id( $page_id, 'hero_image' );
        $hero_src = $hero_img_id ? wp_get_attachment_image_url( $hero_img_id, 'full' ) : 'https://images.unsplash.com/photo-1725870953863-4ad4db0acfc2?w=500&auto=format&fit=crop&q=60';
        ?>
        <img src="<?php echo esc_url( $hero_src ); ?>" alt="Medical Team" class="hero-background"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
        <div class="hero-background" style="display: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
        <?php else : ?>
        <div class="hero-background" style="display: block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
        <?php endif; ?>
        <!-- Professional gradient overlay matching TSX version - lighter for better clarity -->
        <div class="hero-overlay" style="position: absolute; inset: 0; background: linear-gradient(to right, rgba(30, 58, 138, 0.5), rgba(30, 58, 138, 0.25), transparent); z-index: 10;"></div>
    </div>
    
    <div class="container">
        <div class="hero-content">
            <?php if ( freshdew_section_field_visible( $page_id, 'hero_badge' ) ) : ?>
            <div class="hero-badge">
                <span class="badge-dot"></span>
                <span class="badge-text"><?php echo esc_html( freshdew_get_section( $page_id, 'hero_badge', 'Accepting New Patients' ) ); ?></span>
            </div>
            <?php endif; ?>

            <?php if ( freshdew_section_field_visible( $page_id, 'hero_title' ) || freshdew_section_field_visible( $page_id, 'hero_title_highlight' ) ) : ?>
            <h1 class="hero-title">
                <?php if ( freshdew_section_field_visible( $page_id, 'hero_title' ) ) : ?>
                <?php echo esc_html( freshdew_get_section( $page_id, 'hero_title', 'Quality Healthcare' ) ); ?>
                <?php endif; ?>
                <?php if ( freshdew_section_field_visible( $page_id, 'hero_title_highlight' ) ) : ?>
                <span class="hero-title-gradient"><?php echo esc_html( freshdew_get_section( $page_id, 'hero_title_highlight', 'You Can Trust' ) ); ?></span>
                <?php endif; ?>
            </h1>
            <?php endif; ?>

            <?php if ( freshdew_section_field_visible( $page_id, 'hero_subtitle' ) ) : ?>
            <p class="hero-subtitle">
                <?php echo esc_html( freshdew_get_section( $page_id, 'hero_subtitle', 'Experience premium medical care with cutting-edge technology, compassionate professionals, and innovative telehealth solutions—all from the comfort of your home.' ) ); ?>
            </p>
            <?php endif; ?>
            
            <div class="hero-buttons">
                <a href="<?php echo esc_url(home_url('/register')); ?>" class="btn btn-primary-hero" style="display: none !important;">
                    Register as Patient
                </a>
                <?php if ( freshdew_section_field_visible( $page_id, 'hero_book_online_url' ) || freshdew_section_field_visible( $page_id, 'hero_book_online_img_url' ) ) : ?>
                <a href="<?php echo esc_url( $hero_book_url ); ?>" target="_blank" rel="noopener noreferrer" style="display: inline-block;">
                    <img src="<?php echo esc_url( $hero_book_img ); ?>" alt="Book Appointment Online" style="max-width: 100%; height: auto; display: block;">
                </a>
                <?php endif; ?>
                <?php if ( freshdew_section_field_visible( $page_id, 'hero_virtual_consult_url' ) || freshdew_section_field_visible( $page_id, 'hero_virtual_consult_label' ) ) : ?>
                <a href="<?php echo esc_url( $hero_virtual_url ); ?>" class="btn btn-ghost-hero">
                    <?php echo esc_html( $hero_virtual_label ); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section style="padding: 4rem 0; background: #f9fafb;">
    <div class="container">
        <?php if ( freshdew_section_field_visible( $page_id, 'services_heading' ) ) : ?>
        <h2 style="text-align: center; font-size: 2.5rem; margin-bottom: 3rem;"><?php echo esc_html( freshdew_get_section( $page_id, 'services_heading', 'Our Services' ) ); ?></h2>
        <?php endif; ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2.5rem;">
            <?php
            $services = array(
                array(
                    'title_key' => 'service_1_title',
                    'desc_key' => 'service_1_description',
                    'title' => freshdew_get_section( $page_id, 'service_1_title', 'Walk-in Clinic' ),
                    'description' => freshdew_get_section( $page_id, 'service_1_description', 'No appointment needed. Walk in and receive quality medical care.' ),
                    'link' => home_url( '/walk-in-clinic' ),
                    'image_key' => 'service_1_image',
                    'theme_image' => 'walk-in-clinic.jpg',
                    'initials' => 'WC',
                ),
                array(
                    'title_key' => 'service_2_title',
                    'desc_key' => 'service_2_description',
                    'title' => freshdew_get_section( $page_id, 'service_2_title', 'Family Practice' ),
                    'description' => freshdew_get_section( $page_id, 'service_2_description', 'Comprehensive family healthcare with dedicated family doctors.' ),
                    'link' => home_url( '/family-practice' ),
                    'image_key' => 'service_2_image',
                    'theme_image' => 'family-practice.jpg',
                    'initials' => 'FP',
                ),
                array(
                    'title_key' => 'service_3_title',
                    'desc_key' => 'service_3_description',
                    'title' => freshdew_get_section( $page_id, 'service_3_title', 'Telehealth' ),
                    'description' => freshdew_get_section( $page_id, 'service_3_description', 'Virtual consultations from the comfort of your home.' ),
                    'link' => home_url( '/telehealth' ),
                    'image_key' => 'service_3_image',
                    'theme_image' => 'telehealth.jpg',
                    'initials' => 'TH',
                ),
            );
            foreach ( $services as $service ) :
                $card_visible = freshdew_section_field_visible( $page_id, $service['title_key'] )
                    || freshdew_section_field_visible( $page_id, $service['desc_key'] )
                    || freshdew_section_field_visible( $page_id, $service['image_key'] );
                if ( ! $card_visible ) {
                    continue;
                }
                $service_img_id = freshdew_get_section_image_id_for_display( $page_id, $service['image_key'] );
                $service_img_url = $service_img_id ? wp_get_attachment_image_url( $service_img_id, 'large' ) : '';
                if ( ! $service_img_url ) {
                    $service_image_path = get_template_directory() . '/assets/images/services/' . $service['theme_image'];
                    $service_img_url = file_exists( $service_image_path ) ? get_template_directory_uri() . '/assets/images/services/' . $service['theme_image'] : '';
                }
                ?>
            <div style="background: white; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 12px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';">
                <?php if ( freshdew_section_field_visible( $page_id, $service['image_key'] ) ) : ?>
                <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden;">
                    <?php
                    if ( $service_img_url ) {
                        echo '<img src="' . esc_url( $service_img_url ) . '" alt="' . esc_attr( $service['title'] ) . '" style="width: 100%; height: 100%; object-fit: cover; display: block; margin: 0; padding: 0;">';
                    } else {
                        echo '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 600;">' . esc_html( $service['initials'] ) . '</div>';
                    }
                    ?>
                </div>
                <?php endif; ?>
                <div style="padding: 2rem;">
                    <?php if ( freshdew_section_field_visible( $page_id, $service['title_key'] ) ) : ?>
                    <h3 style="font-size: 1.5rem; font-weight: 700; color: #2563eb; margin-bottom: 0.5rem;"><?php echo esc_html( $service['title'] ); ?></h3>
                    <?php endif; ?>
                    <?php if ( freshdew_section_field_visible( $page_id, $service['desc_key'] ) ) : ?>
                    <p style="color: #1f2937; line-height: 1.7; margin-bottom: 1.5rem; font-size: 0.95rem;"><?php echo esc_html( $service['description'] ); ?></p>
                    <?php endif; ?>
                    <?php if ( freshdew_section_field_visible( $page_id, $service['title_key'] ) || freshdew_section_field_visible( $page_id, $service['desc_key'] ) ) : ?>
                    <a href="<?php echo esc_url( $service['link'] ); ?>" class="btn" style="display: inline-block; width: 100%; text-align: center; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 0.5rem; font-weight: 600; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                        Learn More
                    </a>
                    <?php endif; ?>
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
                <?php if ( freshdew_section_field_visible( $page_id, 'about_heading' ) ) : ?>
                <h2 style="font-size: 2.5rem; margin-bottom: 1.5rem;"><?php echo esc_html( freshdew_get_section( $page_id, 'about_heading', 'About FreshDew Medical Clinic' ) ); ?></h2>
                <?php endif; ?>
                <?php if ( freshdew_section_field_visible( $page_id, 'about_para1' ) ) : ?>
                <p style="color: #4b5563; line-height: 1.8; margin-bottom: 1rem;">
                    <?php echo esc_html( freshdew_get_section( $page_id, 'about_para1', 'FreshDew Medical Clinic is committed to providing exceptional healthcare services to the Belleville community and surrounding areas.' ) ); ?>
                </p>
                <?php endif; ?>
                <?php if ( freshdew_section_field_visible( $page_id, 'about_para2' ) ) : ?>
                <p style="color: #4b5563; line-height: 1.8; margin-bottom: 1.5rem;">
                    <?php echo esc_html( freshdew_get_section( $page_id, 'about_para2', 'Our team of experienced healthcare professionals are dedicated to delivering compassionate, patient-centered care using the latest medical technologies.' ) ); ?>
                </p>
                <?php endif; ?>
                <?php if ( freshdew_section_field_visible( $page_id, 'home_about_cta_label' ) || freshdew_section_field_visible( $page_id, 'home_about_cta_url' ) ) : ?>
                <a href="<?php echo esc_url( $home_about_cta_url ); ?>" class="btn"><?php echo esc_html( freshdew_get_section( $page_id, 'home_about_cta_label', 'Learn More About Us' ) ); ?></a>
                <?php endif; ?>
            </div>
            <?php if ( freshdew_section_field_visible( $page_id, 'about_image' ) ) : ?>
            <div>
                <?php
                $about_img_id = freshdew_get_section_image_id( $page_id, 'about_image' );
                $about_img_url = $about_img_id ? wp_get_attachment_image_url( $about_img_id, 'large' ) : get_template_directory_uri() . '/assets/images/fresh-leaf-hero.jpg';
                ?>
                <img src="<?php echo esc_url( $about_img_url ); ?>" alt="Fresh Healthcare"
                     style="width: 100%; height: auto; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
                     onerror="this.style.display='none';">
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
if ( freshdew_section_checkbox_show_on_enabled( $page_id, 'home_meet_greet_show' ) ) :
	$meet_greet_defaults = array(
		'home_meet_greet_para1' => 'All first appointments with Dr. Kinze will be a "Meet and Greet" to enrol patients into her family practice.',
		'home_meet_greet_para2' => 'Please note that no medical complaints will be discussed during this visit.',
		'home_meet_greet_para3' => 'You are welcome to book other appointments to discuss medical concerns.',
		'home_meet_greet_para4' => 'Please take note of the clinic policies on the website.',
	);
	$meet_greet_any = false;
	foreach ( array_keys( $meet_greet_defaults ) as $mg_key ) {
		if ( ! freshdew_section_field_visible( $page_id, $mg_key ) ) {
			continue;
		}
		$t = trim( (string) freshdew_get_section( $page_id, $mg_key, $meet_greet_defaults[ $mg_key ] ) );
		if ( $t !== '' ) {
			$meet_greet_any = true;
			break;
		}
	}
	if ( $meet_greet_any ) :
		?>
<!-- Meet and Greet Notice Section -->
<section class="fd-home-meet-greet-notice" style="padding: 4rem 0; background: #f9fafb;">
    <div class="container">
        <div style="max-width: 900px; margin: 0 auto;">
            <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 1.5rem; border-radius: 0.5rem;">
                <?php if ( freshdew_section_field_visible( $page_id, 'home_meet_greet_para1' ) ) : ?>
                    <?php
					$mg_p1 = trim( (string) freshdew_get_section( $page_id, 'home_meet_greet_para1', $meet_greet_defaults['home_meet_greet_para1'] ) );
					if ( $mg_p1 !== '' ) :
						?>
                <p style="color: #92400e; margin: 0 0 1rem 0; font-weight: 600; font-size: 1rem;">
                    ⚠️ <strong><?php esc_html_e( 'Important Notice:', 'freshdew-medical' ); ?></strong> <?php echo esc_html( $mg_p1 ); ?>
                </p>
					<?php endif; ?>
                <?php endif; ?>
                <?php if ( freshdew_section_field_visible( $page_id, 'home_meet_greet_para2' ) ) : ?>
                    <?php
					$mg_p2 = trim( (string) freshdew_get_section( $page_id, 'home_meet_greet_para2', $meet_greet_defaults['home_meet_greet_para2'] ) );
					if ( $mg_p2 !== '' ) :
						?>
                <p style="color: #92400e; margin: 0 0 1rem 0; font-weight: 600; font-size: 1rem;">
                    <?php echo esc_html( $mg_p2 ); ?>
                </p>
					<?php endif; ?>
                <?php endif; ?>
                <?php if ( freshdew_section_field_visible( $page_id, 'home_meet_greet_para3' ) ) : ?>
                    <?php
					$mg_p3 = trim( (string) freshdew_get_section( $page_id, 'home_meet_greet_para3', $meet_greet_defaults['home_meet_greet_para3'] ) );
					if ( $mg_p3 !== '' ) :
						?>
                <p style="color: #92400e; margin: 0 0 1rem 0; font-weight: 600; font-size: 1rem;">
                    <?php echo esc_html( $mg_p3 ); ?>
                </p>
					<?php endif; ?>
                <?php endif; ?>
                <?php if ( freshdew_section_field_visible( $page_id, 'home_meet_greet_para4' ) ) : ?>
                    <?php
					$mg_p4 = trim( (string) freshdew_get_section( $page_id, 'home_meet_greet_para4', $meet_greet_defaults['home_meet_greet_para4'] ) );
					if ( $mg_p4 !== '' ) :
						?>
                <p style="color: #92400e; margin: 0; font-weight: 600; font-size: 1rem;">
                    <?php echo esc_html( $mg_p4 ); ?>
                </p>
					<?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
		<?php
	endif;
endif;
?>

<?php if ( $policies_block_visible ) : ?>
<!-- Clinic Policies Section -->
<section style="padding: 4rem 0; background: #f0f4f8;">
    <div class="container">
        <?php if ( freshdew_section_field_visible( $page_id, 'policies_heading' ) ) : ?>
        <h2 style="text-align: center; font-size: 2.5rem; margin-bottom: 3rem; color: #1f2937; font-weight: 700;"><?php echo esc_html( freshdew_get_section( $page_id, 'policies_heading', 'Clinic Policies' ) ); ?></h2>
        <?php endif; ?>
        <div style="max-width: 900px; margin: 0 auto; display: flex; flex-direction: column; gap: 2rem;">
            <?php foreach ( $policy_cards as $pc ) : ?>
                <?php
                $pc_vis = freshdew_section_field_visible( $page_id, $pc['title_key'] )
                    || freshdew_section_field_visible( $page_id, $pc['body_key'] );
                if ( ! $pc_vis ) {
                    continue;
                }
                $pc_title = freshdew_get_section( $page_id, $pc['title_key'], $pc['title_def'] );
                $pc_body  = freshdew_get_section( $page_id, $pc['body_key'], $pc['body_def'] );
                ?>
            <div style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); padding: 2.5rem; border-radius: 0.75rem; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                <?php if ( freshdew_section_field_visible( $page_id, $pc['title_key'] ) ) : ?>
                <h3 style="font-size: 1.75rem; margin-bottom: 1.25rem; color: #ffffff; font-weight: 700;"><?php echo esc_html( $pc_title ); ?></h3>
                <?php endif; ?>
                <?php if ( freshdew_section_field_visible( $page_id, $pc['body_key'] ) ) : ?>
                <p style="color: #ffffff; line-height: 1.8; font-size: 1.125rem;">
                    <?php echo esc_html( $pc_body ); ?>
                </p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Location & Map Section -->
<section style="padding: 4rem 0; background: #f9fafb;">
    <div class="container">
        <?php if ( freshdew_section_field_visible( $page_id, 'visit_heading' ) ) : ?>
        <h2 style="text-align: center; font-size: 2.5rem; margin-bottom: 1rem;"><?php echo esc_html( freshdew_get_section( $page_id, 'visit_heading', 'Visit Us' ) ); ?></h2>
        <?php endif; ?>
        <?php if ( freshdew_section_field_visible( $page_id, 'visit_subtitle' ) ) : ?>
        <p style="text-align: center; color: #6b7280; margin-bottom: 3rem; font-size: 1.125rem;">
            <?php echo esc_html( freshdew_get_section( $page_id, 'visit_subtitle', 'Conveniently located in Belleville, Ontario' ) ); ?>
        </p>
        <?php endif; ?>
        
        <?php
        $hours_heading_vis = freshdew_section_field_visible( $page_id, 'home_hours_heading' );
        $hours_table_vis   = freshdew_section_field_visible( $page_id, 'home_hours_rows' ) && ! empty( $home_hours_parsed );
        $hours_alert_vis   = freshdew_section_field_visible( $page_id, 'home_hours_alert' );
        $hours_block_vis   = $hours_heading_vis || $hours_table_vis || $hours_alert_vis;
        ?>
        <?php if ( $hours_block_vis ) : ?>
        <!-- Hours of Operation -->
        <div style="max-width: 600px; margin: 0 auto 3rem;">
            <?php if ( $hours_heading_vis ) : ?>
            <h3 style="text-align: center; font-size: 2rem; margin-bottom: 1.5rem; color: #1f2937;"><?php echo esc_html( freshdew_get_section( $page_id, 'home_hours_heading', 'Hours of Operation' ) ); ?></h3>
            <?php endif; ?>
            <div style="background: white; padding: 2rem; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <?php if ( $hours_table_vis ) : ?>
                <table style="width: 100%; border-collapse: collapse;">
                    <?php
                    $hr_count = count( $home_hours_parsed );
                    foreach ( $home_hours_parsed as $idx => $row ) :
                        $is_last = ( $idx === $hr_count - 1 );
                        ?>
                    <tr<?php echo $is_last ? '' : ' style="border-bottom: 1px solid #e5e7eb;"'; ?>>
                        <td style="padding: 1rem 0; font-weight: 600; color: #1f2937;"><?php echo esc_html( $row[0] ); ?></td>
                        <td style="padding: 1rem 0; text-align: right; color: #4b5563;"><?php echo esc_html( $row[1] ); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
                <?php if ( $hours_alert_vis ) : ?>
                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                    <p style="margin: 0; font-size: 1rem; font-weight: 600; color: #92400e; background: #fef3c7; padding: 1rem 1.25rem; border-radius: 0.5rem; border-left: 4px solid #f59e0b; text-align: center;">
                        <?php echo esc_html( freshdew_get_section( $page_id, 'home_hours_alert', '⚠️ Please check our website and clinic notice for any updates to working hours.' ) ); ?>
                    </p>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem; align-items: start;">
            <div>
                <?php if ( freshdew_section_field_visible( $page_id, 'home_location_heading' ) ) : ?>
                <h3 style="font-size: 1.5rem; margin-bottom: 1.5rem; color: #1f2937;"><?php echo esc_html( freshdew_get_section( $page_id, 'home_location_heading', 'Location Details' ) ); ?></h3>
                <?php endif; ?>
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
                    
                    <?php if ( freshdew_section_field_visible( $page_id, 'home_directions_label' ) || freshdew_section_field_visible( $page_id, 'home_directions_url' ) ) : ?>
                    <div style="margin-top: 2rem;">
                        <a href="<?php echo esc_url( $home_directions_url ); ?>" class="btn"><?php echo esc_html( freshdew_get_section( $page_id, 'home_directions_label', 'Get Directions' ) ); ?></a>
                    </div>
                    <?php endif; ?>
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

