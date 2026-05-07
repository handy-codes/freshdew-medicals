<?php
/**
 * Template Name: About Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
$page_id = get_the_ID();
$default_team_book_img = 'https://www.myhealthaccess.ca/build/branded_signup/book_appt_online_big.png';
$about_team_book_url = trim( freshdew_get_section( $page_id, 'about_team_book_url', 'https://www.myhealthaccess.ca/branded/freshdew-medical-centre' ) );
$about_team_book_img = trim( freshdew_get_section( $page_id, 'about_team_book_img_url', '' ) );
if ( $about_team_book_img === '' ) {
	$about_team_book_img = $default_team_book_img;
}
$show_karen_team_card = freshdew_section_checkbox_show_enabled( $page_id, 'team_show_karen_card' );

$show_about_hero = freshdew_section_field_visible( $page_id, 'hero_title' )
	|| freshdew_section_field_visible( $page_id, 'hero_subtitle' );
?>

<?php if ( $show_about_hero ) : ?>
<section style="padding: 4rem 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <?php if ( freshdew_section_field_visible( $page_id, 'hero_title' ) ) : ?>
        <h1 style="font-size: 3rem; margin-bottom: 1rem; text-align: center; color: white; text-shadow: 0 2px 10px rgba(0,0,0,0.2);"><?php echo esc_html( freshdew_get_section( $page_id, 'hero_title', 'About FreshDew Medical Clinic' ) ); ?></h1>
        <?php endif; ?>
        <?php if ( freshdew_section_field_visible( $page_id, 'hero_subtitle' ) ) : ?>
        <p style="font-size: 1.25rem; text-align: center; opacity: 0.95; max-width: 800px; margin: 0 auto; color: white; text-shadow: 0 1px 5px rgba(0,0,0,0.2);">
            <?php echo esc_html( freshdew_get_section( $page_id, 'hero_subtitle', 'Providing exceptional healthcare services to the Belleville community and surrounding areas.' ) ); ?>
        </p>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<section style="padding: 4rem 0;">
    <div class="container">
        <div style="max-width: 1200px; margin: 0 auto;">
            <?php
            $page_content    = get_post_field( 'post_content', $page_id );
            $has_page_body   = strlen( trim( wp_strip_all_tags( $page_content ) ) ) > 0;
            if ( $has_page_body && freshdew_section_field_visible( $page_id, 'about_editor_content' ) ) {
                echo '<div class="freshdew-page-content entry-content" style="margin-bottom: 3rem;">';
                the_content();
                echo '</div>';
            } elseif ( ! $has_page_body && freshdew_section_field_visible( $page_id, 'about_fallback_mission' ) ) {
				if ( freshdew_section_field_visible( $page_id, 'about_mission_heading' ) ) {
					echo '<h2 style="font-size: 2.5rem; margin-bottom: 2rem; color: #1f2937;">' . esc_html( freshdew_get_section( $page_id, 'about_mission_heading', 'Our Mission' ) ) . '</h2>';
				}
				if ( freshdew_section_field_visible( $page_id, 'about_mission_para1' ) ) {
					echo '<p style="color: #000000; line-height: 1.8; margin-bottom: 1.5rem; font-size: 1.125rem;">' . esc_html( freshdew_get_section( $page_id, 'about_mission_para1', 'Freshdew medical clinic is committed to delivering exceptional patient care to persons of all ages in a warm, welcoming environment.' ) ) . '</p>';
				}
				if ( freshdew_section_field_visible( $page_id, 'about_mission_para2' ) ) {
					echo '<p style="color: #000000; line-height: 1.8; margin-bottom: 3rem; font-size: 1.125rem;">' . esc_html( freshdew_get_section( $page_id, 'about_mission_para2', 'Our Mission is to provide excellent comprehensive medical care in a timely, compassionate, and patient centred manner.' ) ) . '</p>';
				}
            }
            ?>

            <!-- Meet Our Team Section -->
            <?php if ( freshdew_section_field_visible( $page_id, 'meet_heading' ) ) : ?>
            <h2 style="font-size: 2.5rem; margin: 4rem 0 3rem; color: #1f2937; text-align: center;"><?php echo esc_html( freshdew_get_section( $page_id, 'meet_heading', 'Meet Our Team' ) ); ?></h2>
            <?php endif; ?>
            <div style="display: flex; flex-direction: column; gap: 2.5rem; margin-bottom: 4rem;">
                <?php
                $freshdew_team_layout = array(
                    1 => array(
                        'file'        => 'dr-joy-kinze.jpg',
                        'initials'    => 'JK',
                        'card_class'  => 'team-card',
                        'objpos'      => 'center top',
                        'name'        => 'Dr. Joy Kinze',
                        'credentials' => 'MBBS, MRCGP, CCFP',
                        'bio'         => "Dr. Joy Kinze is a UK trained family physician with over a decade of clinical experience and practice. She has worked in low and middle income climes and spent the majority of her practice in rural English town.\nHer areas of interest are lifestyle medicine and women's health. She is very passionate about healthcare administration having seen the catastrophic consequences when standards are not met in developing countries.\nShe is best described as a compassionate and excellent physician.",
                    ),
                    2 => array(
                        'file'        => 'dr-jamal-doe.jpg',
                        'initials'    => 'JD',
                        'card_class'  => 'team-card',
                        'objpos'      => 'center top',
                        'name'        => 'Dr. Kalu N. Ukoha',
                        'credentials' => 'MD, LMCC, CCFP, Family Physician',
                        'bio'         => '',
                    ),
                    3 => array(
                        'file'        => 'karen-howald.jpg',
                        'initials'    => 'KH',
                        'card_class'  => 'team-card',
                        'objpos'      => 'center 20%',
                        'name'        => 'Karen Howald',
                        'credentials' => 'Medical Office Assistant',
                        'bio'         => 'With many years of experience in patient care, Karen is committed to delivering compassionate, efficient, and detail-oriented service. She prides in supporting others and creating a positive experience for every person she works with. Outside of work, she enjoys reading, the arts, and baking—especially carrot cake—and she shares her home with two cats. Karen is also a proud parent of a successful son and brings that same dedication and care to her professional life.',
                    ),
                    4 => array(
                        'file'        => 'emeka-owo.jpg',
                        'initials'    => 'EO',
                        'card_class'  => 'team-card emeka-owo-card',
                        'objpos'      => 'center top',
                        'name'        => 'Emeka Owo',
                        'credentials' => 'Healthcare Technology Developer',
                        'bio'         => 'Emeka Owo is a Healthcare Technology Developer with years of experience designing and implementing secure, high-performance systems for clinical settings. He brings deep expertise in health information systems, telemedicine integration, clinical workflow optimization, and healthcare data protection. His core strengths include building secure cloud infrastructures, developing scalable application architectures, and ensuring compliance-driven data management for modern medical practices. Outside of work, he maintains a keen interest in global affairs and practices strategic chess to refine his analytical thinking.',
                    ),
                    5 => array(
                        'file'        => 'rejoice-obioha.jpg',
                        'initials'    => 'RO',
                        'card_class'  => 'team-card',
                        'objpos'      => 'center top',
                        'name'        => 'Rejoice Obioha',
                        'credentials' => 'Executive Assistant',
                        'bio'         => "Rejoice works as the Executive Assistant, providing  operational support with efficiency and professionalism.\nAfter completing High school, she spent a year studying pre-medical science, before enrolling in a Medical degree program, demonstrating her strong interest in healthcare systems.\nShe has previously worked as the Executive Secretary of a British medical corporation coordinating Family Physician services to the UK National Health Service.\nShe brings enthusiasm and reliability to her role contributing to the smooth daily operations of the clinic.",
                    ),
                );
                foreach ( $freshdew_team_layout as $ti => $td ) {
                    if ( $ti === 3 && ! $show_karen_team_card ) {
                        continue;
                    }
                    $ik       = 'team_' . $ti . '_image';
                    $nk       = 'team_' . $ti . '_name';
                    $ck       = 'team_' . $ti . '_credentials';
                    $bk       = 'team_' . $ti . '_bio';
                    $banner_k = 'team_' . $ti . '_book_banner';
                    $name     = freshdew_get_section( $page_id, $nk, $td['name'] );
                    $cred     = freshdew_get_section( $page_id, $ck, $td['credentials'] );
                    $bio      = freshdew_get_section( $page_id, $bk, $td['bio'] );
                    $show_book = freshdew_section_field_visible( $page_id, $banner_k ) && $about_team_book_url !== '';
                    $card_vis = freshdew_section_field_visible( $page_id, $ik )
                        || freshdew_section_field_visible( $page_id, $nk )
                        || freshdew_section_field_visible( $page_id, $ck )
                        || freshdew_section_field_visible( $page_id, $bk )
                        || $show_book;
                    if ( ! $card_vis ) {
                        continue;
                    }
                    $team_img_url = '';
                    if ( freshdew_section_field_visible( $page_id, $ik ) ) {
                        $team_img_id = freshdew_get_section_image_id_for_display( $page_id, $ik );
                        $team_img_url = $team_img_id ? wp_get_attachment_image_url( $team_img_id, 'large' ) : '';
                        if ( ! $team_img_url ) {
                            $p = get_template_directory() . '/assets/images/doctors/' . $td['file'];
                            $team_img_url = ( file_exists( $p ) && filesize( $p ) > 0 ) ? get_template_directory_uri() . '/assets/images/doctors/' . $td['file'] : '';
                        }
                    }
                    ?>
                <div class="<?php echo esc_attr( $td['card_class'] ); ?>" style="background: white; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 12px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';">
                    <?php if ( freshdew_section_field_visible( $page_id, $ik ) ) : ?>
                    <div class="team-card-image" style="width: 100%; height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden; border-radius: 0.75rem 0.75rem 0 0; display: flex; align-items: center; justify-content: center;">
                        <?php if ( $team_img_url ) : ?>
                            <img src="<?php echo esc_url( $team_img_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" style="width: 100%; height: 100%; object-fit: cover; object-position: <?php echo esc_attr( $td['objpos'] ); ?>;">
                        <?php else : ?>
                            <div style="width: 100%; height: 100%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 600;"><?php echo esc_html( $td['initials'] ); ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <div class="team-card-content" style="padding: 2rem; display: flex; flex-direction: column; width: 100%;">
                        <?php if ( freshdew_section_field_visible( $page_id, $nk ) ) : ?>
                        <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem; width: 100%;"><?php echo esc_html( $name ); ?></h3>
                        <?php endif; ?>
                        <?php if ( freshdew_section_field_visible( $page_id, $ck ) ) : ?>
                        <p style="color: #667eea; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem; width: 100%;"><?php echo esc_html( $cred ); ?></p>
                        <?php endif; ?>
                        <?php if ( freshdew_section_field_visible( $page_id, $bk ) && $bio !== '' ) : ?>
                        <p style="color: #000000; line-height: 1.7; margin-bottom: 1.5rem; font-size: 1.125rem; flex-grow: 1; width: 100%;"><?php echo nl2br( esc_html( $bio ) ); ?></p>
                        <?php endif; ?>
                        <?php if ( $show_book ) : ?>
                        <a href="<?php echo esc_url( $about_team_book_url ); ?>" target="_blank" rel="noopener noreferrer" style="display: block; width: 100%;">
                            <img src="<?php echo esc_url( $about_team_book_img ); ?>" alt="Book Appointment Online" style="max-width: 100%; height: auto; display: block; width: 100%;">
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                    <?php
                }
                ?>
            </div>
            
            <?php
            $services_heading = freshdew_get_section( $page_id, 'services_heading', 'Our Services' );
            $services_list_raw = freshdew_get_section( $page_id, 'services_list', "Walk-in Clinic: No appointment needed. Quality medical care when you need it.\nFamily Practice: Comprehensive family healthcare with dedicated family doctors.\nTelehealth: Virtual consultations from the comfort of your home." );
            $services_list_lines = array_filter( array_map( 'trim', explode( "\n", $services_list_raw ) ) );
            if ( empty( $services_list_lines ) ) {
                $services_list_lines = array( 'Walk-in Clinic: No appointment needed. Quality medical care when you need it.', 'Family Practice: Comprehensive family healthcare with dedicated family doctors.', 'Telehealth: Virtual consultations from the comfort of your home.' );
            }
            if ( freshdew_section_field_visible( $page_id, 'services_heading' ) ) :
                ?>
            <h2 style="font-size: 2.5rem; margin: 3rem 0 2rem; color: #1f2937;"><?php echo esc_html( $services_heading ); ?></h2>
            <?php endif; ?>
            <?php if ( freshdew_section_field_visible( $page_id, 'services_list' ) ) : ?>
            <ul style="color: #000000; line-height: 2; font-size: 1.125rem; list-style: none; padding: 0;">
                <?php foreach ( $services_list_lines as $line ) : ?>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    <?php echo wp_kses_post( $line ); ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
get_footer();

