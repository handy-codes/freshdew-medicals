<?php
/**
 * Admin-editable page sections. Only these 6 nav pages are editable: Home, About, Walk-in Clinic, Family Practice, Telehealth, Contact.
 * No other pages get section editing or pre-populated content.
 *
 * Each section field has optional Hide (frontend) and Clear (reset saved value to theme default on save).
 *
 * @package FreshDewMedical
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Only these page keys (nav pages) are editable. No other pages. */
function freshdew_editable_page_keys() {
	return array( 'home', 'about', 'walk-in-clinic', 'family-practice', 'telehealth', 'contact' );
}

/** Slug to page key. Home is identified by front page. */
function freshdew_get_editable_page_key( $post ) {
	if ( ! $post || $post->post_type !== 'page' ) {
		return null;
	}
	$front_id = (int) get_option( 'page_on_front' );
	if ( $post->ID === $front_id ) {
		return 'home';
	}
	$template = get_post_meta( $post->ID, '_wp_page_template', true );
	$map = array(
		'page-home.php'         => 'home',
		'page-about.php'        => 'about',
		'page-walk-in-clinic.php' => 'walk-in-clinic',
		'page-family-practice.php' => 'family-practice',
		'page-telehealth.php'   => 'telehealth',
		'page-contact.php'      => 'contact',
	);
	if ( isset( $map[ $template ] ) ) {
		return $map[ $template ];
	}
	$slug = $post->post_name;
	if ( in_array( $slug, array( 'about', 'walk-in-clinic', 'family-practice', 'telehealth', 'contact' ), true ) ) {
		return $slug;
	}
	return null;
}

/** Default sections per page. Only these pages have section definitions. */
function freshdew_get_page_sections_config() {
	return array(
		'home' => array(
			array( 'key' => 'home_marquee_show', 'label' => 'Show hero marquee (scrolling ticker below header)', 'type' => 'checkbox_show', 'default' => '' ),
			array( 'key' => 'marquee_text', 'label' => 'Marquee scrolling text', 'default' => 'This is to notify all patients that Dr. Kinze will be away on vacation from April 15 to April 24, 2026.  The clinic will resume fully on April 29, 2026. Please find local walk-in clinics if needed and in emergency, please call 911.', 'type' => 'textarea' ),
			array( 'key' => 'marquee_badge_desktop', 'label' => 'Marquee badge (desktop)', 'default' => 'Vacation Notice', 'type' => 'text' ),
			array( 'key' => 'marquee_badge_mobile', 'label' => 'Marquee badge (mobile)', 'default' => 'Vacation', 'type' => 'text' ),
			array( 'key' => 'hero_badge', 'label' => 'Hero badge', 'default' => 'Accepting New Patients', 'type' => 'text' ),
			array( 'key' => 'hero_title', 'label' => 'Hero title', 'default' => 'Quality Healthcare', 'type' => 'text' ),
			array( 'key' => 'hero_title_highlight', 'label' => 'Hero title highlight', 'default' => 'You Can Trust', 'type' => 'text' ),
			array( 'key' => 'hero_subtitle', 'label' => 'Hero subtitle', 'default' => 'Experience premium medical care with cutting-edge technology, compassionate professionals, and innovative telehealth solutions—all from the comfort of your home.', 'type' => 'textarea' ),
			array( 'key' => 'hero_book_online_url', 'label' => 'Hero: Book online button URL', 'default' => 'https://www.myhealthaccess.ca/branded/freshdew-medical-centre', 'type' => 'text' ),
			array( 'key' => 'hero_book_online_img_url', 'label' => 'Hero: Book online image URL (optional, leave empty for default)', 'default' => '', 'type' => 'text' ),
			array( 'key' => 'hero_virtual_consult_url', 'label' => 'Hero: Virtual Consultation button URL', 'default' => '', 'type' => 'text' ),
			array( 'key' => 'hero_virtual_consult_label', 'label' => 'Hero: Virtual Consultation button label', 'default' => 'Virtual Consultation', 'type' => 'text' ),
			array( 'key' => 'home_vacation_para1', 'label' => 'Home vacation notice — paragraph 1', 'default' => '⚠️ Vacation Notice: This is to notify all patients that Dr. Kinze will be away on vacation from April 15 to April 24, 2026. The clinic will resume fully on April 29, 2026.', 'type' => 'textarea' ),
			array( 'key' => 'home_vacation_para2', 'label' => 'Home vacation notice — paragraph 2', 'default' => 'Please find local walk-in clinics if needed and in emergency, please call 911.', 'type' => 'textarea' ),
			array( 'key' => 'services_heading', 'label' => 'Our Services heading', 'default' => 'Our Services', 'type' => 'text' ),
			array( 'key' => 'service_1_title', 'label' => 'Service 1 title', 'default' => 'Walk-in Clinic', 'type' => 'text' ),
			array( 'key' => 'service_1_description', 'label' => 'Service 1 description', 'default' => 'No appointment needed. Walk in and receive quality medical care.', 'type' => 'textarea' ),
			array( 'key' => 'service_2_title', 'label' => 'Service 2 title', 'default' => 'Family Practice', 'type' => 'text' ),
			array( 'key' => 'service_2_description', 'label' => 'Service 2 description', 'default' => 'Comprehensive family healthcare with dedicated family doctors.', 'type' => 'textarea' ),
			array( 'key' => 'service_3_title', 'label' => 'Service 3 title', 'default' => 'Telehealth', 'type' => 'text' ),
			array( 'key' => 'service_3_description', 'label' => 'Service 3 description', 'default' => 'Virtual consultations from the comfort of your home.', 'type' => 'textarea' ),
			array( 'key' => 'about_heading', 'label' => 'About section heading', 'default' => 'About FreshDew Medical Clinic', 'type' => 'text' ),
			array( 'key' => 'about_para1', 'label' => 'About paragraph 1', 'default' => 'FreshDew Medical Clinic is committed to providing exceptional healthcare services to the Belleville community and surrounding areas.', 'type' => 'textarea' ),
			array( 'key' => 'about_para2', 'label' => 'About paragraph 2', 'default' => "Our team of experienced healthcare professionals are dedicated to delivering compassionate, patient-centered care using the latest medical technologies.", 'type' => 'textarea' ),
			array( 'key' => 'visit_heading', 'label' => 'Visit Us heading', 'default' => 'Visit Us', 'type' => 'text' ),
			array( 'key' => 'visit_subtitle', 'label' => 'Visit Us subtitle', 'default' => 'Conveniently located in Belleville, Ontario', 'type' => 'text' ),
			array( 'key' => 'hero_image', 'label' => 'Hero background image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'service_1_image', 'label' => 'Service 1 (Walk-in) image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'service_2_image', 'label' => 'Service 2 (Family Practice) image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'service_3_image', 'label' => 'Service 3 (Telehealth) image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'about_image', 'label' => 'About section image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'home_about_cta_label', 'label' => 'About block: button label (Learn More About Us)', 'default' => 'Learn More About Us', 'type' => 'text' ),
			array( 'key' => 'home_about_cta_url', 'label' => 'About block: button URL', 'default' => '', 'type' => 'text' ),
			array( 'key' => 'policies_heading', 'label' => 'Clinic Policies section heading', 'default' => 'Clinic Policies', 'type' => 'text' ),
			array( 'key' => 'policy_1_title', 'label' => 'Policy 1 title', 'default' => 'Safety of Staff and Patient', 'type' => 'text' ),
			array( 'key' => 'policy_1_body', 'label' => 'Policy 1 text', 'default' => 'We aim to provide high standards of care and work under incredible pressure. We understand you may be experiencing stress coming into the clinic. We have a Zero Tolerance Practice Policy and strictly prohibit abusive, violent, threatening or any form of assault towards staff and patients. Violators will be immediately removed from the Practice and Police may be contacted.', 'type' => 'textarea' ),
			array( 'key' => 'policy_2_title', 'label' => 'Policy 2 title', 'default' => 'No Show', 'type' => 'text' ),
			array( 'key' => 'policy_2_body', 'label' => 'Policy 2 text', 'default' => 'We understand circumstances change, so we provide a free 24hour cancellation notice, otherwise there will be a $50 no show fee.', 'type' => 'textarea' ),
			array( 'key' => 'policy_3_title', 'label' => 'Policy 3 title', 'default' => 'Medical Visit', 'type' => 'text' ),
			array( 'key' => 'policy_3_body', 'label' => 'Policy 3 text', 'default' => 'To ensure effective treatment, only ONE medical issue will be discussed per appointment. Please feel free to book as many appointments as needed.', 'type' => 'textarea' ),
			array( 'key' => 'home_hours_heading', 'label' => 'Visit section: Hours of Operation heading', 'default' => 'Hours of Operation', 'type' => 'text' ),
			array( 'key' => 'home_hours_rows', 'label' => 'Visit section: hours table (one row per line: Day|hours text)', 'default' => "Monday|09:00 - 17:00 OPEN\nTuesday|CLOSED\nWednesday|09:00 - 17:00 OPEN\nThursday|09:00 - 17:00 OPEN\nFriday|09:00 - 15:00 OPEN\nSaturday|CLOSED\nSUNDAY|CLOSED", 'type' => 'textarea' ),
			array( 'key' => 'home_hours_alert', 'label' => 'Visit section: yellow alert under hours table', 'default' => '⚠️ Please check our website and clinic notice for any updates to working hours.', 'type' => 'textarea' ),
			array( 'key' => 'home_location_heading', 'label' => 'Visit section: Location Details heading', 'default' => 'Location Details', 'type' => 'text' ),
			array( 'key' => 'home_directions_label', 'label' => 'Visit section: Get Directions button label', 'default' => 'Get Directions', 'type' => 'text' ),
			array( 'key' => 'home_directions_url', 'label' => 'Visit section: Get Directions button URL', 'default' => '', 'type' => 'text' ),
		),
		'about' => array(
			array( 'key' => 'hero_title', 'label' => 'Hero title', 'default' => 'About FreshDew Medical Clinic', 'type' => 'text' ),
			array( 'key' => 'hero_subtitle', 'label' => 'Hero subtitle', 'default' => 'Providing exceptional healthcare services to the Belleville community and surrounding areas.', 'type' => 'textarea' ),
			array( 'key' => 'about_editor_content', 'label' => 'WordPress page body (block editor — shown above Meet Our Team when not empty)', 'type' => 'visibility_only' ),
			array( 'key' => 'about_fallback_mission', 'label' => 'Default mission block (shown when page body is empty)', 'type' => 'visibility_only' ),
			array( 'key' => 'about_mission_heading', 'label' => 'Mission heading (when default mission block shows)', 'default' => 'Our Mission', 'type' => 'text' ),
			array( 'key' => 'about_mission_para1', 'label' => 'Mission paragraph 1', 'default' => 'Freshdew medical clinic is committed to delivering exceptional patient care to persons of all ages in a warm, welcoming environment.', 'type' => 'textarea' ),
			array( 'key' => 'about_mission_para2', 'label' => 'Mission paragraph 2', 'default' => 'Our Mission is to provide excellent comprehensive medical care in a timely, compassionate, and patient centred manner.', 'type' => 'textarea' ),
			array( 'key' => 'meet_heading', 'label' => 'Meet Our Team heading', 'default' => 'Meet Our Team', 'type' => 'text' ),
			array( 'key' => 'team_show_karen_card', 'label' => 'Show Karen Howald team card', 'type' => 'checkbox_show', 'default' => '' ),
			array( 'key' => 'services_heading', 'label' => 'Our Services heading', 'default' => 'Our Services', 'type' => 'text' ),
			array( 'key' => 'services_list', 'label' => 'Services list (one per line)', 'default' => "Walk-in Clinic: No appointment needed. Quality medical care when you need it.\nFamily Practice: Comprehensive family healthcare with dedicated family doctors.\nTelehealth: Virtual consultations from the comfort of your home.", 'type' => 'textarea' ),
			array( 'key' => 'team_1_image', 'label' => 'Team member 1 (Dr. Joy Kinze) image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'team_2_image', 'label' => 'Team member 2 (Dr. Kalu N. Ukoha) image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'team_3_image', 'label' => 'Team member 3 (Karen Howald) image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'team_4_image', 'label' => 'Team member 4 (Emeka Owo) image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'team_5_image', 'label' => 'Team member 5 (Rejoice Obioha) image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'team_1_name', 'label' => 'Team 1 — name', 'default' => 'Dr. Joy Kinze', 'type' => 'text' ),
			array( 'key' => 'team_1_credentials', 'label' => 'Team 1 — credentials line', 'default' => 'MBBS, MRCGP, CCFP', 'type' => 'text' ),
			array( 'key' => 'team_1_bio', 'label' => 'Team 1 — bio', 'default' => "Dr. Joy Kinze is a UK trained family physician with over a decade of clinical experience and practice. She has worked in low and middle income climes and spent the majority of her practice in rural English town.\nHer areas of interest are lifestyle medicine and women's health. She is very passionate about healthcare administration having seen the catastrophic consequences when standards are not met in developing countries.\nShe is best described as a compassionate and excellent physician.", 'type' => 'textarea' ),
			array( 'key' => 'team_1_book_banner', 'label' => 'Team 1 — Book Appointment image link', 'type' => 'visibility_only' ),
			array( 'key' => 'team_2_name', 'label' => 'Team 2 — name', 'default' => 'Dr. Kalu N. Ukoha', 'type' => 'text' ),
			array( 'key' => 'team_2_credentials', 'label' => 'Team 2 — credentials line', 'default' => 'MD, LMCC, CCFP, Family Physician', 'type' => 'text' ),
			array( 'key' => 'team_2_bio', 'label' => 'Team 2 — bio', 'default' => '', 'type' => 'textarea' ),
			array( 'key' => 'team_2_book_banner', 'label' => 'Team 2 — Book Appointment image link', 'type' => 'visibility_only' ),
			array( 'key' => 'team_3_name', 'label' => 'Team 3 — name (Karen)', 'default' => 'Karen Howald', 'type' => 'text' ),
			array( 'key' => 'team_3_credentials', 'label' => 'Team 3 — credentials line', 'default' => 'Medical Office Assistant', 'type' => 'text' ),
			array( 'key' => 'team_3_bio', 'label' => 'Team 3 — bio', 'default' => 'With many years of experience in patient care, Karen is committed to delivering compassionate, efficient, and detail-oriented service. She prides in supporting others and creating a positive experience for every person she works with. Outside of work, she enjoys reading, the arts, and baking—especially carrot cake—and she shares her home with two cats. Karen is also a proud parent of a successful son and brings that same dedication and care to her professional life.', 'type' => 'textarea' ),
			array( 'key' => 'team_3_book_banner', 'label' => 'Team 3 — Book Appointment image link', 'type' => 'visibility_only' ),
			array( 'key' => 'team_4_name', 'label' => 'Team 4 — name', 'default' => 'Emeka Owo', 'type' => 'text' ),
			array( 'key' => 'team_4_credentials', 'label' => 'Team 4 — credentials line', 'default' => 'Healthcare Technology Developer', 'type' => 'text' ),
			array( 'key' => 'team_4_bio', 'label' => 'Team 4 — bio', 'default' => 'Emeka Owo is a Healthcare Technology Developer with years of experience designing and implementing secure, high-performance systems for clinical settings. He brings deep expertise in health information systems, telemedicine integration, clinical workflow optimization, and healthcare data protection. His core strengths include building secure cloud infrastructures, developing scalable application architectures, and ensuring compliance-driven data management for modern medical practices. Outside of work, he maintains a keen interest in global affairs and practices strategic chess to refine his analytical thinking.', 'type' => 'textarea' ),
			array( 'key' => 'team_4_book_banner', 'label' => 'Team 4 — Book Appointment image link', 'type' => 'visibility_only' ),
			array( 'key' => 'team_5_name', 'label' => 'Team 5 — name', 'default' => 'Rejoice Obioha', 'type' => 'text' ),
			array( 'key' => 'team_5_credentials', 'label' => 'Team 5 — credentials line', 'default' => 'Executive Assistant', 'type' => 'text' ),
			array( 'key' => 'team_5_bio', 'label' => 'Team 5 — bio', 'default' => "Rejoice works as the Executive Assistant, providing  operational support with efficiency and professionalism.\nAfter completing High school, she spent a year studying pre-medical science, before enrolling in a Medical degree program, demonstrating her strong interest in healthcare systems.\nShe has previously worked as the Executive Secretary of a British medical corporation coordinating Family Physician services to the UK National Health Service.\nShe brings enthusiasm and reliability to her role contributing to the smooth daily operations of the clinic.", 'type' => 'textarea' ),
			array( 'key' => 'team_5_book_banner', 'label' => 'Team 5 — Book Appointment image link', 'type' => 'visibility_only' ),
			array( 'key' => 'about_team_book_url', 'label' => 'Team cards: Book Appointment link URL (all cards)', 'default' => 'https://www.myhealthaccess.ca/branded/freshdew-medical-centre', 'type' => 'text' ),
			array( 'key' => 'about_team_book_img_url', 'label' => 'Team cards: Book Appointment image URL (optional)', 'default' => '', 'type' => 'text' ),
		),
		'walk-in-clinic' => array(
			array( 'key' => 'hero_title', 'label' => 'Hero title', 'default' => 'Walk-in Clinic', 'type' => 'text' ),
			array( 'key' => 'hero_subtitle', 'label' => 'Hero subtitle', 'default' => 'No appointment needed. Quality medical care when you need it.', 'type' => 'textarea' ),
			array( 'key' => 'walkin_editor_content', 'label' => 'WordPress page body (block editor — when not empty it replaces the intro / accepting box)', 'type' => 'visibility_only' ),
			array( 'key' => 'accepting_heading', 'label' => 'Intro / accepting heading (below hero when page body is empty)', 'default' => 'Accepting New Patients', 'type' => 'text' ),
			array( 'key' => 'accepting_text', 'label' => 'Intro / accepting text', 'default' => 'We welcome walk-in patients. No appointment necessary!', 'type' => 'textarea' ),
			array( 'key' => 'what_we_offer_heading', 'label' => 'What We Offer heading', 'default' => 'What We Offer', 'type' => 'text' ),
			array( 'key' => 'service_1_title', 'label' => 'Service 1 title', 'default' => 'General Medical Care', 'type' => 'text' ),
			array( 'key' => 'service_1_description', 'label' => 'Service 1 description', 'default' => 'Treatment for common illnesses and minor injuries.', 'type' => 'textarea' ),
			array( 'key' => 'service_2_title', 'label' => 'Service 2 title', 'default' => 'Prescriptions', 'type' => 'text' ),
			array( 'key' => 'service_2_description', 'label' => 'Service 2 description', 'default' => 'Prescription renewals and new prescriptions as needed.', 'type' => 'textarea' ),
			array( 'key' => 'service_3_title', 'label' => 'Service 3 title', 'default' => 'Health Assessments', 'type' => 'text' ),
			array( 'key' => 'service_3_description', 'label' => 'Service 3 description', 'default' => 'Basic health check-ups and assessments.', 'type' => 'textarea' ),
			array( 'key' => 'service_1_image', 'label' => 'Service 1 image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'service_2_image', 'label' => 'Service 2 image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'service_3_image', 'label' => 'Service 3 image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'walkin_book_banner', 'label' => 'Book Appointment banner (image link at bottom)', 'type' => 'visibility_only' ),
		),
		'family-practice' => array(
			array( 'key' => 'hero_title', 'label' => 'Hero title', 'default' => 'Family Practice', 'type' => 'text' ),
			array( 'key' => 'hero_subtitle', 'label' => 'Hero subtitle', 'default' => 'Comprehensive family healthcare with dedicated family doctors.', 'type' => 'textarea' ),
			array( 'key' => 'family_editor_content', 'label' => 'WordPress page body (block editor — when not empty it replaces the default intro)', 'type' => 'visibility_only' ),
			array( 'key' => 'family_fallback_intro', 'label' => 'Default intro block (heading + paragraph when page body is empty)', 'type' => 'visibility_only' ),
			array( 'key' => 'services_heading', 'label' => 'Services We Provide heading', 'default' => 'Services We Provide', 'type' => 'text' ),
			array( 'key' => 'service_1_title', 'label' => 'Service 1 title', 'default' => 'Pediatric Care', 'type' => 'text' ),
			array( 'key' => 'service_1_description', 'label' => 'Service 1 description', 'default' => 'Comprehensive healthcare for children of all ages.', 'type' => 'textarea' ),
			array( 'key' => 'service_2_title', 'label' => 'Service 2 title', 'default' => 'Family Health', 'type' => 'text' ),
			array( 'key' => 'service_2_description', 'label' => 'Service 2 description', 'default' => 'Preventive care and health maintenance for the whole family.', 'type' => 'textarea' ),
			array( 'key' => 'service_3_title', 'label' => 'Service 3 title', 'default' => 'Chronic Disease Management', 'type' => 'text' ),
			array( 'key' => 'service_3_description', 'label' => 'Service 3 description', 'default' => 'Ongoing care for diabetes, hypertension, and other chronic conditions.', 'type' => 'textarea' ),
			array( 'key' => 'service_4_title', 'label' => 'Service 4 title', 'default' => 'Vaccinations', 'type' => 'text' ),
			array( 'key' => 'service_4_description', 'label' => 'Service 4 description', 'default' => 'Immunizations for children and adults.', 'type' => 'textarea' ),
			array( 'key' => 'accepting_heading', 'label' => 'Accepting New Patients heading', 'default' => 'Accepting New Patients', 'type' => 'text' ),
			array( 'key' => 'accepting_text', 'label' => 'Accepting New Patients text', 'default' => 'We are currently accepting new patients for our family practice. Please click below link to book your first appointment.', 'type' => 'textarea' ),
			array( 'key' => 'service_1_image', 'label' => 'Service 1 image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'service_2_image', 'label' => 'Service 2 image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'service_3_image', 'label' => 'Service 3 image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'service_4_image', 'label' => 'Service 4 image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'family_book_banner', 'label' => 'Book Appointment banner (bottom image link)', 'type' => 'visibility_only' ),
		),
		'telehealth' => array(
			array( 'key' => 'hero_title', 'label' => 'Hero title', 'default' => 'Telehealth Services', 'type' => 'text' ),
			array( 'key' => 'hero_subtitle', 'label' => 'Hero subtitle', 'default' => 'Virtual consultations from the comfort of your home.', 'type' => 'textarea' ),
			array( 'key' => 'telehealth_editor_content', 'label' => 'WordPress page body (block editor — when not empty it replaces intro heading/text)', 'type' => 'visibility_only' ),
			array( 'key' => 'intro_heading', 'label' => 'Intro heading (e.g. Healthcare at Your Fingertips)', 'default' => 'Healthcare at Your Fingertips', 'type' => 'text' ),
			array( 'key' => 'intro_text', 'label' => 'Intro paragraph', 'default' => 'Our telehealth services allow you to consult with our healthcare professionals from anywhere, at any time. Perfect for follow-up appointments, prescription renewals, and non-urgent medical consultations.', 'type' => 'textarea' ),
			array( 'key' => 'service_1_title', 'label' => 'Service 1 title', 'default' => 'Video Consultations', 'type' => 'text' ),
			array( 'key' => 'service_1_description', 'label' => 'Service 1 description', 'default' => 'Secure video calls with your doctor from your computer or mobile device.', 'type' => 'textarea' ),
			array( 'key' => 'service_2_title', 'label' => 'Service 2 title', 'default' => 'Phone Consultations', 'type' => 'text' ),
			array( 'key' => 'service_2_description', 'label' => 'Service 2 description', 'default' => 'Speak with a healthcare professional over the phone.', 'type' => 'textarea' ),
			array( 'key' => 'service_3_title', 'label' => 'Service 3 title', 'default' => 'Follow-up Care', 'type' => 'text' ),
			array( 'key' => 'service_3_description', 'label' => 'Service 3 description', 'default' => 'Convenient follow-up appointments without leaving home.', 'type' => 'textarea' ),
			array( 'key' => 'when_to_use_heading', 'label' => 'When to Use Telehealth heading', 'default' => 'When to Use Telehealth', 'type' => 'text' ),
			array( 'key' => 'when_to_use_list', 'label' => 'When to use list (one per line)', 'default' => "Follow-up appointments for ongoing conditions\nPrescription renewals\nGeneral health questions and advice\nMental health consultations\nNon-urgent medical concerns", 'type' => 'textarea' ),
			array( 'key' => 'telehealth_book_banner', 'label' => 'Book Appointment banner (image link in main column)', 'type' => 'visibility_only' ),
			array( 'key' => 'disclaimer', 'label' => 'Emergency disclaimer', 'default' => 'For medical emergencies, please call 911 or visit your nearest emergency room. Telehealth is not suitable for life-threatening situations.', 'type' => 'textarea' ),
			array( 'key' => 'virtual_heading', 'label' => 'Start Your Virtual Consultation heading', 'default' => 'Start Your Virtual Consultation', 'type' => 'text' ),
			array( 'key' => 'virtual_subtitle', 'label' => 'Virtual consultation subtitle', 'default' => 'Connect with our healthcare professionals via secure video or voice call', 'type' => 'textarea' ),
			array( 'key' => 'video_title', 'label' => 'Video Consultation card title', 'default' => 'Video Consultation', 'type' => 'text' ),
			array( 'key' => 'video_description', 'label' => 'Video Consultation card description', 'default' => 'Face-to-face consultation with your doctor via secure video call', 'type' => 'textarea' ),
			array( 'key' => 'video_button', 'label' => 'Video button text', 'default' => 'Start Video Call', 'type' => 'text' ),
			array( 'key' => 'voice_title', 'label' => 'Voice Call card title', 'default' => 'Voice Call', 'type' => 'text' ),
			array( 'key' => 'voice_description', 'label' => 'Voice Call card description', 'default' => 'Speak with your doctor over a secure phone call', 'type' => 'textarea' ),
			array( 'key' => 'voice_button', 'label' => 'Voice button text', 'default' => 'Start Voice Call', 'type' => 'text' ),
			array( 'key' => 'service_1_image', 'label' => 'Service 1 (Video Consultations) image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'service_2_image', 'label' => 'Service 2 (Phone Consultations) image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'service_3_image', 'label' => 'Service 3 (Follow-up Care) image', 'default' => '', 'type' => 'image' ),
		),
		'contact' => array(
			array( 'key' => 'title', 'label' => 'Page title', 'default' => 'Contact Us', 'type' => 'text' ),
			array( 'key' => 'contact_editor_content', 'label' => 'WordPress page body (intro above columns)', 'type' => 'visibility_only' ),
			array( 'key' => 'get_in_touch_heading', 'label' => 'Get in Touch heading', 'default' => 'Get in Touch', 'type' => 'text' ),
			array( 'key' => 'find_us_heading', 'label' => 'Find Us heading', 'default' => 'Find Us', 'type' => 'text' ),
		),
	);
}

/**
 * Get section content for the front end. Returns saved value or default.
 *
 * @param int    $post_id Page post ID.
 * @param string $section_key Section key (e.g. hero_title).
 * @param string $default Default if not set.
 * @return string
 */
function freshdew_get_section( $post_id, $section_key, $default = '' ) {
	$val = get_post_meta( $post_id, 'freshdew_section_' . $section_key, true );
	return $val !== '' && $val !== null ? (string) $val : (string) $default;
}

/**
 * Get section image attachment ID for the front end. Use with wp_get_attachment_image_url() or wp_get_attachment_image().
 *
 * @param int    $post_id Page post ID.
 * @param string $section_key Section key (e.g. hero_image).
 * @return int 0 if not set or invalid.
 */
function freshdew_get_section_image_id( $post_id, $section_key ) {
	$val = get_post_meta( $post_id, 'freshdew_section_' . $section_key, true );
	$id = absint( $val );
	if ( $id && wp_attachment_is_image( $id ) ) {
		return $id;
	}
	return 0;
}

/**
 * Attachment ID for display: respects per-field Hide from admin.
 *
 * @param int    $post_id Page post ID.
 * @param string $section_key Section key (e.g. hero_image).
 * @return int
 */
function freshdew_get_section_image_id_for_display( $post_id, $section_key ) {
	if ( ! freshdew_section_field_visible( $post_id, $section_key ) ) {
		return 0;
	}
	return freshdew_get_section_image_id( $post_id, $section_key );
}

/**
 * Whether this section field is shown on the frontend (Hide unchecked in admin).
 *
 * @param int    $post_id Page post ID.
 * @param string $section_key Config key (e.g. hero_title).
 */
function freshdew_section_field_visible( $post_id, $section_key ) {
	return get_post_meta( $post_id, 'freshdew_hide_' . $section_key, true ) !== '1';
}

/**
 * "Show …" toggles stored as freshdew_section_{$key} === '1' (checkbox_show fields only).
 */
function freshdew_section_checkbox_show_enabled( $post_id, $section_key ) {
	return get_post_meta( $post_id, 'freshdew_section_' . $section_key, true ) === '1';
}

/**
 * Parse textarea lines "Left|Right" into pairs for hours tables.
 *
 * @param string $raw Multiline string.
 * @return array<int, array{0: string, 1: string}>
 */
function freshdew_parse_pipe_table_rows( $raw ) {
	$lines = array_filter( array_map( 'trim', explode( "\n", (string) $raw ) ) );
	$rows    = array();
	foreach ( $lines as $line ) {
		$parts = explode( '|', $line, 2 );
		if ( count( $parts ) < 2 ) {
			continue;
		}
		$rows[] = array( trim( $parts[0] ), trim( $parts[1] ) );
	}
	return $rows;
}

/** Meta box: Page Sections (only for the 6 editable pages) */
function freshdew_add_page_sections_meta_box() {
	$screen = get_current_screen();
	if ( ! $screen || $screen->post_type !== 'page' || $screen->base !== 'post' ) {
		return;
	}
	global $post;
	if ( ! $post || freshdew_get_editable_page_key( $post ) === null ) {
		return;
	}
	wp_enqueue_media();
	add_meta_box(
		'freshdew_page_sections',
		__( 'Page sections (editable content)', 'freshdew-medical' ),
		'freshdew_render_page_sections_meta_box',
		'page',
		'normal',
		'high'
	);
}

/**
 * Output Hide checkbox + Clear button row for one section key.
 *
 * @param int    $post_id Post ID.
 * @param string $section_key Section key.
 * @param string $type Section type (visibility_only skips Clear).
 */
function freshdew_render_section_controls_row( $post_id, $section_key, $type ) {
	$hide_name = 'freshdew_hide_' . $section_key;
	$checked = get_post_meta( $post_id, $hide_name, true ) === '1';
	echo '<div class="freshdew-section-controls" style="display: flex; flex-wrap: wrap; align-items: center; gap: 12px; margin: 0.35rem 0 0.6rem;">';
	echo '<label style="display: inline-flex; align-items: center; gap: 6px; font-weight: 600; cursor: pointer;"><input type="checkbox" name="' . esc_attr( $hide_name ) . '" value="1" ' . checked( $checked, true, false ) . '> ';
	echo esc_html__( 'Hide on site', 'freshdew-medical' );
	echo '</label>';
	if ( $type !== 'visibility_only' ) {
		echo '<button type="button" class="button button-small freshdew-clear-section" data-section-key="' . esc_attr( $section_key ) . '">';
		echo esc_html__( 'Clear saved value', 'freshdew-medical' );
		echo '</button>';
		echo '<span class="description" style="margin: 0;">';
		echo esc_html__( 'Clears this field on Save so the theme default is used again.', 'freshdew-medical' );
		echo '</span>';
	}
	echo '</div>';
}

function freshdew_render_page_sections_meta_box( $post ) {
	$page_key = freshdew_get_editable_page_key( $post );
	if ( $page_key === null ) {
		return;
	}
	$config = freshdew_get_page_sections_config();
	if ( ! isset( $config[ $page_key ] ) ) {
		return;
	}
	wp_nonce_field( 'freshdew_save_page_sections', 'freshdew_sections_nonce' );
	echo '<p class="description">';
	echo esc_html__( 'Only these pages are editable: Home, About, Walk-in Clinic, Family Practice, Telehealth, Contact. Update the page to save. Most fields support Hide on site and Clear (restore theme default). Some blocks use Show on site instead of Hide. Images also have Remove image.', 'freshdew-medical' );
	echo '</p>';
	echo '<div style="display: grid; gap: 1.25rem;">';
	foreach ( $config[ $page_key ] as $section ) {
		$key = $section['key'];
		$meta_key = 'freshdew_section_' . $key;
		$value = get_post_meta( $post->ID, $meta_key, true );
		if ( $section['type'] !== 'visibility_only' && $section['type'] !== 'checkbox_show' && ( $value === '' || $value === null ) ) {
			$value = $section['default'];
		}
		echo '<div class="freshdew-section-field" data-section-key="' . esc_attr( $key ) . '" data-type="' . esc_attr( $section['type'] ) . '" style="padding-bottom: 1rem; border-bottom: 1px solid #e5e7eb;">';
		echo '<strong style="display: block; margin-bottom: 0.25rem;">' . esc_html( $section['label'] ) . '</strong>';

		if ( $section['type'] === 'checkbox_show' ) {
			$show_checked = get_post_meta( $post->ID, $meta_key, true ) === '1';
			echo '<div class="freshdew-section-controls" style="display: flex; flex-wrap: wrap; align-items: center; gap: 12px; margin: 0.35rem 0 0.6rem;">';
			echo '<label style="display: inline-flex; align-items: center; gap: 6px; font-weight: 600; cursor: pointer;"><input type="checkbox" name="' . esc_attr( $meta_key ) . '" value="1" ' . checked( $show_checked, true, false ) . '> ';
			echo esc_html__( 'Show on site', 'freshdew-medical' );
			echo '</label>';
			echo '<button type="button" class="button button-small freshdew-clear-section" data-section-key="' . esc_attr( $key ) . '">';
			echo esc_html__( 'Clear saved value', 'freshdew-medical' );
			echo '</button>';
			echo '<span class="description" style="margin: 0;">';
			echo esc_html__( 'Clears on Save so this block stays off until you check Show again.', 'freshdew-medical' );
			echo '</span>';
			echo '</div>';
			echo '<p class="description" style="margin: 0 0 0.25rem;">';
			echo esc_html__( 'Unchecked means hidden on the live site (no separate Hide row).', 'freshdew-medical' );
			echo '</p>';
			echo '</div>';
			continue;
		}

		freshdew_render_section_controls_row( $post->ID, $key, $section['type'] );

		if ( $section['type'] === 'visibility_only' ) {
			echo '<p class="description" style="margin: 0;">';
			echo esc_html__( 'No text field — use Hide on site only.', 'freshdew-medical' );
			echo '</p>';
			echo '</div>';
			continue;
		}

		if ( $section['type'] === 'image' ) {
			$img_id = absint( $value );
			$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'thumbnail' ) : '';
			echo '<div class="freshdew-image-field" style="display: flex; align-items: flex-start; gap: 10px; flex-wrap: wrap;">';
			echo '<input type="hidden" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '" value="' . esc_attr( $img_id ) . '">';
			echo '<div class="freshdew-image-preview" style="min-width: 100px; min-height: 80px; border: 1px solid #ddd; border-radius: 4px; overflow: hidden; background: #f5f5f5;">';
			if ( $img_url ) {
				echo '<img src="' . esc_url( $img_url ) . '" alt="" style="display: block; max-width: 120px; height: auto;">';
			} else {
				echo '<span style="display: flex; align-items: center; justify-content: center; height: 80px; color: #999; font-size: 12px;">No image</span>';
			}
			echo '</div>';
			echo '<div style="display: flex; flex-direction: column; gap: 4px;">';
			echo '<button type="button" class="button freshdew-select-image">' . esc_html__( 'Select / Update image', 'freshdew-medical' ) . '</button>';
			echo '<button type="button" class="button freshdew-remove-image">' . esc_html__( 'Remove image', 'freshdew-medical' ) . '</button>';
			echo '</div>';
			echo '</div>';
		} elseif ( $section['type'] === 'textarea' ) {
			echo '<textarea id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '" rows="3" class="large-text" style="width:100%;">' . esc_textarea( $value ) . '</textarea>';
		} else {
			echo '<input type="text" id="' . esc_attr( $meta_key ) . '" name="' . esc_attr( $meta_key ) . '" value="' . esc_attr( $value ) . '" class="large-text" style="width:100%;">';
		}
		echo '</div>';
	}
	echo '</div>';
	?>
	<script>
	(function() {
		function initFreshdewImageFields() {
			document.querySelectorAll('.freshdew-image-field').forEach(function(wrap) {
				if (wrap.dataset.initialized) return;
				wrap.dataset.initialized = '1';
				var input = wrap.querySelector('input[type="hidden"]');
				var preview = wrap.querySelector('.freshdew-image-preview');
				var selectBtn = wrap.querySelector('.freshdew-select-image');
				var removeBtn = wrap.querySelector('.freshdew-remove-image');
				if (!input || !selectBtn || !removeBtn) return;
				selectBtn.addEventListener('click', function() {
					var frame = wp.media({ library: { type: 'image' }, multiple: false });
					frame.on('select', function() {
						var att = frame.state().get('selection').first().toJSON();
						input.value = att.id;
						preview.innerHTML = '<img src="' + (att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url) + '" alt="" style="display: block; max-width: 120px; height: auto;">';
					});
					frame.open();
				});
				removeBtn.addEventListener('click', function() {
					input.value = '';
					preview.innerHTML = '<span style="display: flex; align-items: center; justify-content: center; height: 80px; color: #999; font-size: 12px;">No image</span>';
				});
			});
		}
		function ensureClearInput(form, key) {
			var sel = 'input[name="freshdew_clear_section[]"][value="' + key.replace(/"/g, '\\"') + '"]';
			if (form.querySelector(sel)) return;
			var inp = document.createElement('input');
			inp.type = 'hidden';
			inp.name = 'freshdew_clear_section[]';
			inp.value = key;
			form.appendChild(inp);
		}
		document.querySelectorAll('.freshdew-clear-section').forEach(function(btn) {
			btn.addEventListener('click', function() {
				var key = btn.getAttribute('data-section-key');
				if (!key) return;
				var field = btn.closest('.freshdew-section-field');
				var form = btn.closest('form');
				if (!field || !form) return;
				var metaId = 'freshdew_section_' + key;
				var hid = field.querySelector('input[type="hidden"][name="' + metaId + '"]');
				if (!hid) {
					hid = document.getElementById(metaId);
				}
				var txt = field.querySelector('textarea[name="' + metaId + '"], input[type="text"][name="' + metaId + '"]');
				if (hid) hid.value = '';
				if (txt) txt.value = '';
				var imgPrev = field.querySelector('.freshdew-image-preview');
				var imgRemove = field.querySelector('.freshdew-remove-image');
				if (hid && imgPrev && imgRemove) {
					imgRemove.click();
				}
				var hideCb = field.querySelector('input[name="freshdew_hide_' + key + '"]');
				if (hideCb) hideCb.checked = false;
				var showCb = field.querySelector('input[type="checkbox"][name="freshdew_section_' + key + '"]');
				if (showCb) showCb.checked = false;
				ensureClearInput(form, key);
			});
		});
		if (typeof wp !== 'undefined' && wp.media) {
			initFreshdewImageFields();
		} else {
			document.addEventListener('DOMContentLoaded', function() { setTimeout(initFreshdewImageFields, 100); });
		}
	})();
	</script>
	<?php
}

function freshdew_save_page_sections( $post_id ) {
	if ( ! isset( $_POST['freshdew_sections_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['freshdew_sections_nonce'] ), 'freshdew_save_page_sections' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	$post = get_post( $post_id );
	$page_key = freshdew_get_editable_page_key( $post );
	if ( $page_key === null ) {
		return;
	}
	$config = freshdew_get_page_sections_config();
	if ( ! isset( $config[ $page_key ] ) ) {
		return;
	}
	$sections = $config[ $page_key ];
	$allowed_keys = array();
	foreach ( $sections as $sec ) {
		$allowed_keys[ $sec['key'] ] = $sec['type'];
	}

	$clear_raw = isset( $_POST['freshdew_clear_section'] ) ? wp_unslash( $_POST['freshdew_clear_section'] ) : array();
	$clear_keys = array_map( 'sanitize_text_field', (array) $clear_raw );
	foreach ( $clear_keys as $ck ) {
		if ( ! isset( $allowed_keys[ $ck ] ) || $allowed_keys[ $ck ] === 'visibility_only' ) {
			continue;
		}
		delete_post_meta( $post_id, 'freshdew_section_' . $ck );
		delete_post_meta( $post_id, 'freshdew_hide_' . $ck );
	}

	foreach ( $sections as $section ) {
		$key = $section['key'];
		$meta_key = 'freshdew_section_' . $key;

		if ( $section['type'] === 'checkbox_show' ) {
			delete_post_meta( $post_id, 'freshdew_hide_' . $key );
			if ( isset( $_POST[ $meta_key ] ) && (string) wp_unslash( $_POST[ $meta_key ] ) === '1' ) {
				update_post_meta( $post_id, $meta_key, '1' );
			} else {
				delete_post_meta( $post_id, $meta_key );
			}
			continue;
		}

		$hide_name = 'freshdew_hide_' . $key;
		$hide_val = isset( $_POST[ $hide_name ] ) && $_POST[ $hide_name ] === '1' ? '1' : '';
		update_post_meta( $post_id, $hide_name, $hide_val );

		if ( $section['type'] === 'visibility_only' ) {
			continue;
		}
		if ( ! isset( $_POST[ $meta_key ] ) ) {
			continue;
		}
		if ( $section['type'] === 'image' ) {
			$value = absint( $_POST[ $meta_key ] );
			update_post_meta( $post_id, $meta_key, $value );
		} elseif ( $section['type'] === 'textarea' ) {
			$value = sanitize_textarea_field( wp_unslash( $_POST[ $meta_key ] ) );
			update_post_meta( $post_id, $meta_key, $value );
		} else {
			$value = sanitize_text_field( wp_unslash( $_POST[ $meta_key ] ) );
			update_post_meta( $post_id, $meta_key, $value );
		}
	}
}

/**
 * Return post IDs of the 6 editable pages (for restricting the admin Pages list).
 *
 * @return int[]
 */
function freshdew_editable_page_ids() {
	$ids = array();
	$front_id = (int) get_option( 'page_on_front' );
	if ( $front_id ) {
		$ids[] = $front_id;
	}
	$slugs = array( 'about', 'walk-in-clinic', 'family-practice', 'telehealth', 'contact' );
	foreach ( $slugs as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page && ! in_array( $page->ID, $ids, true ) ) {
			$ids[] = $page->ID;
		}
	}
	return $ids;
}

/**
 * In wp-admin → Pages, show only the 6 editable pages. Hide Register, Appointments, etc.
 */
function freshdew_restrict_admin_pages_list( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}
	global $pagenow;
	if ( $pagenow !== 'edit.php' || ( isset( $_GET['post_type'] ) && $_GET['post_type'] !== 'page' ) ) {
		return;
	}
	$post_type = $query->get( 'post_type' );
	if ( $post_type !== 'page' ) {
		return;
	}
	$ids = freshdew_editable_page_ids();
	if ( empty( $ids ) ) {
		return;
	}
	$query->set( 'post__in', $ids );
}

add_action( 'add_meta_boxes', 'freshdew_add_page_sections_meta_box' );
add_action( 'save_post_page', 'freshdew_save_page_sections' );
add_action( 'pre_get_posts', 'freshdew_restrict_admin_pages_list' );
