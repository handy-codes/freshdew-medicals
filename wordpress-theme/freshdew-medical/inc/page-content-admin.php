<?php
/**
 * Admin-editable page sections. Only these 6 nav pages are editable: Home, About, Walk-in Clinic, Family Practice, Telehealth, Contact.
 * No other pages get section editing or pre-populated content.
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
			array( 'key' => 'hero_badge', 'label' => 'Hero badge', 'default' => 'Accepting New Patients', 'type' => 'text' ),
			array( 'key' => 'hero_title', 'label' => 'Hero title', 'default' => 'Quality Healthcare', 'type' => 'text' ),
			array( 'key' => 'hero_title_highlight', 'label' => 'Hero title highlight', 'default' => 'You Can Trust', 'type' => 'text' ),
			array( 'key' => 'hero_subtitle', 'label' => 'Hero subtitle', 'default' => 'Experience premium medical care with cutting-edge technology, compassionate professionals, and innovative telehealth solutions—all from the comfort of your home.', 'type' => 'textarea' ),
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
		),
		'about' => array(
			array( 'key' => 'hero_title', 'label' => 'Hero title', 'default' => 'About FreshDew Medical Clinic', 'type' => 'text' ),
			array( 'key' => 'hero_subtitle', 'label' => 'Hero subtitle', 'default' => 'Providing exceptional healthcare services to the Belleville community and surrounding areas.', 'type' => 'textarea' ),
			array( 'key' => 'meet_heading', 'label' => 'Meet Our Team heading', 'default' => 'Meet Our Team', 'type' => 'text' ),
			array( 'key' => 'services_heading', 'label' => 'Our Services heading', 'default' => 'Our Services', 'type' => 'text' ),
			array( 'key' => 'services_list', 'label' => 'Services list (one per line)', 'default' => "Walk-in Clinic: No appointment needed. Quality medical care when you need it.\nFamily Practice: Comprehensive family healthcare with dedicated family doctors.\nTelehealth: Virtual consultations from the comfort of your home.", 'type' => 'textarea' ),
			array( 'key' => 'team_1_image', 'label' => 'Team member 1 (Dr. Joy Kinze) image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'team_2_image', 'label' => 'Team member 2 (Dr. Kalu N. Ukoha) image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'team_3_image', 'label' => 'Team member 3 (Karen Howald) image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'team_4_image', 'label' => 'Team member 4 (Emeka Owo) image', 'default' => '', 'type' => 'image' ),
			array( 'key' => 'team_5_image', 'label' => 'Team member 5 (Rejoice Obioha) image', 'default' => '', 'type' => 'image' ),
		),
		'walk-in-clinic' => array(
			array( 'key' => 'hero_title', 'label' => 'Hero title', 'default' => 'Walk-in Clinic', 'type' => 'text' ),
			array( 'key' => 'hero_subtitle', 'label' => 'Hero subtitle', 'default' => 'No appointment needed. Quality medical care when you need it.', 'type' => 'textarea' ),
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
		),
		'family-practice' => array(
			array( 'key' => 'hero_title', 'label' => 'Hero title', 'default' => 'Family Practice', 'type' => 'text' ),
			array( 'key' => 'hero_subtitle', 'label' => 'Hero subtitle', 'default' => 'Comprehensive family healthcare with dedicated family doctors.', 'type' => 'textarea' ),
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
		),
		'telehealth' => array(
			array( 'key' => 'hero_title', 'label' => 'Hero title', 'default' => 'Telehealth Services', 'type' => 'text' ),
			array( 'key' => 'hero_subtitle', 'label' => 'Hero subtitle', 'default' => 'Virtual consultations from the comfort of your home.', 'type' => 'textarea' ),
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
	echo '<p class="description">Only these pages are editable: Home, About, Walk-in Clinic, Family Practice, Telehealth, Contact. Edit text and images below, then Update the page. Use "Select/Update" to change an image, "Remove" to delete it.</p>';
	echo '<div style="display: grid; gap: 1rem;">';
	foreach ( $config[ $page_key ] as $section ) {
		$meta_key = 'freshdew_section_' . $section['key'];
		$value = get_post_meta( $post->ID, $meta_key, true );
		if ( $value === '' || $value === null ) {
			$value = $section['default'];
		}
		echo '<div class="freshdew-section-field" data-type="' . esc_attr( $section['type'] ) . '">';
		echo '<label for="' . esc_attr( $meta_key ) . '" style="display:block; font-weight: 600; margin-bottom: 0.25rem;">' . esc_html( $section['label'] ) . '</label>';
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
			echo '<button type="button" class="button freshdew-select-image">Select / Update image</button>';
			echo '<button type="button" class="button freshdew-remove-image">Remove image</button>';
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
	// Inline script for media picker (runs only when this meta box is present).
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
	if ( ! isset( $_POST['freshdew_sections_nonce'] ) || ! wp_verify_nonce( $_POST['freshdew_sections_nonce'], 'freshdew_save_page_sections' ) ) {
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
	foreach ( $config[ $page_key ] as $section ) {
		$meta_key = 'freshdew_section_' . $section['key'];
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
