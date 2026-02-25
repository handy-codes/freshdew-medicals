<?php
/**
 * Template Name: Telehealth Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
$page_id = get_the_ID();
?>

<section style="padding: 4rem 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem; text-align: center; color: white; text-shadow: 0 2px 10px rgba(0,0,0,0.2);"><?php echo esc_html( freshdew_get_section( $page_id, 'hero_title', 'Telehealth Services' ) ); ?></h1>
        <p style="font-size: 1.25rem; text-align: center; opacity: 0.95; max-width: 800px; margin: 0 auto; color: white; text-shadow: 0 1px 5px rgba(0,0,0,0.2);">
            <?php echo esc_html( freshdew_get_section( $page_id, 'hero_subtitle', 'Virtual consultations from the comfort of your home.' ) ); ?>
        </p>
    </div>
</section>

<section style="padding: 4rem 0;">
    <div class="container">
        <div style="max-width: 900px; margin: 0 auto;">
            <?php
            $page_content = get_post_field('post_content', $page_id);
            if ( ! empty( trim( $page_content ) ) ) {
                echo '<div class="freshdew-page-content entry-content" style="margin-bottom: 3rem;">';
                the_content();
                echo '</div>';
            } else {
                $intro_heading = freshdew_get_section( $page_id, 'intro_heading', 'Healthcare at Your Fingertips' );
                $intro_text = freshdew_get_section( $page_id, 'intro_text', 'Our telehealth services allow you to consult with our healthcare professionals from anywhere, at any time. Perfect for follow-up appointments, prescription renewals, and non-urgent medical consultations.' );
                echo '<h2 style="font-size: 2.5rem; margin-bottom: 2rem; color: #1f2937;">' . esc_html( $intro_heading ) . '</h2>';
                echo '<p style="color: #4b5563; line-height: 1.8; margin-bottom: 3rem; font-size: 1.125rem;">' . esc_html( $intro_text ) . '</p>';
            }
            ?>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2.5rem; margin: 3rem 0;">
                <?php
                $telehealth_services = array(
                    array(
                        'title' => freshdew_get_section( $page_id, 'service_1_title', 'Video Consultations' ),
                        'description' => freshdew_get_section( $page_id, 'service_1_description', 'Secure video calls with your doctor from your computer or mobile device.' ),
                        'image' => 'video-consultations.jpg',
                        'initials' => 'VC',
                    ),
                    array(
                        'title' => freshdew_get_section( $page_id, 'service_2_title', 'Phone Consultations' ),
                        'description' => freshdew_get_section( $page_id, 'service_2_description', 'Speak with a healthcare professional over the phone.' ),
                        'image' => 'phone-consultations.jpg',
                        'initials' => 'PC',
                    ),
                    array(
                        'title' => freshdew_get_section( $page_id, 'service_3_title', 'Follow-up Care' ),
                        'description' => freshdew_get_section( $page_id, 'service_3_description', 'Convenient follow-up appointments without leaving home.' ),
                        'image' => 'follow-up-care.jpg',
                        'initials' => 'FC',
                    ),
                );
                foreach ($telehealth_services as $service) :
                ?>
                <div style="background: white; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 12px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';">
                    <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden;">
                        <?php
                        $service_image = get_template_directory_uri() . '/assets/images/services/' . $service['image'];
                        $service_image_path = get_template_directory() . '/assets/images/services/' . $service['image'];
                        if (file_exists($service_image_path)) {
                            echo '<img src="' . esc_url($service_image) . '" alt="' . esc_attr($service['title']) . '" style="width: 100%; height: 100%; object-fit: cover; display: block; margin: 0; padding: 0;">';
                        } else {
                            echo '<div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 600;">' . esc_html($service['initials']) . '</div>';
                        }
                        ?>
                    </div>
                    <div style="padding: 2rem;">
                        <h3 style="font-size: 1.5rem; font-weight: 700; color: #2563eb; margin-bottom: 0.5rem;"><?php echo esc_html($service['title']); ?></h3>
                        <p style="color: #1f2937; line-height: 1.7; margin-bottom: 1.5rem; font-size: 0.95rem;"><?php echo esc_html($service['description']); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <?php
            $when_heading = freshdew_get_section( $page_id, 'when_to_use_heading', 'When to Use Telehealth' );
            $when_list = freshdew_get_section( $page_id, 'when_to_use_list', "Follow-up appointments for ongoing conditions\nPrescription renewals\nGeneral health questions and advice\nMental health consultations\nNon-urgent medical concerns" );
            $when_items = array_filter( array_map( 'trim', explode( "\n", $when_list ) ) );
            if ( empty( $when_items ) ) {
                $when_items = array( 'Follow-up appointments for ongoing conditions', 'Prescription renewals', 'General health questions and advice', 'Mental health consultations', 'Non-urgent medical concerns' );
            }
            ?>
            <h2 style="font-size: 2.5rem; margin: 3rem 0 2rem; color: #1f2937;"><?php echo esc_html( $when_heading ); ?></h2>
            <ul style="color: #4b5563; line-height: 2; font-size: 1.125rem; list-style: none; padding: 0;">
                <?php foreach ( $when_items as $item ) : ?>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    <?php echo esc_html( $item ); ?>
                </li>
                <?php endforeach; ?>
            </ul>
            
            <div style="text-align: center; margin-top: 3rem;">
                <a href="https://www.myhealthaccess.ca/branded/freshdew-medical-centre" target="_blank" rel="noopener noreferrer" style="display: inline-block;">
                    <img src="https://www.myhealthaccess.ca/build/branded_signup/book_appt_online_big.png" alt="Book Appointment Online" style="max-width: 100%; height: auto; display: block;">
                </a>
            </div>
            <?php $disclaimer = freshdew_get_section( $page_id, 'disclaimer', 'For medical emergencies, please call 911 or visit your nearest emergency room. Telehealth is not suitable for life-threatening situations.' ); ?>
            <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 1.5rem; margin: 3rem 0; border-radius: 0.5rem;">
                <p style="color: #92400e; margin: 0; font-weight: 600;">
                    ⚠️ <strong>Note:</strong> <?php echo esc_html( $disclaimer ); ?>
                </p>
            </div>
            
        </div>
    </div>
</section>

<!-- Telehealth Video/Voice Conference Section -->
<section style="padding: 4rem 0; background: #f9fafb;">
    <div class="container">
        <div class="telehealth-consultation-section" style="max-width: 900px; margin: 0 auto;">
            <?php
            $virtual_heading = freshdew_get_section( $page_id, 'virtual_heading', 'Start Your Virtual Consultation' );
            $virtual_subtitle = freshdew_get_section( $page_id, 'virtual_subtitle', 'Connect with our healthcare professionals via secure video or voice call' );
            $video_title = freshdew_get_section( $page_id, 'video_title', 'Video Consultation' );
            $video_description = freshdew_get_section( $page_id, 'video_description', 'Face-to-face consultation with your doctor via secure video call' );
            $video_button = freshdew_get_section( $page_id, 'video_button', 'Start Video Call' );
            $voice_title = freshdew_get_section( $page_id, 'voice_title', 'Voice Call' );
            $voice_description = freshdew_get_section( $page_id, 'voice_description', 'Speak with your doctor over a secure phone call' );
            $voice_button = freshdew_get_section( $page_id, 'voice_button', 'Start Voice Call' );
            ?>
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem; text-align: center; color: #1f2937;"><?php echo esc_html( $virtual_heading ); ?></h2>
            <p style="text-align: center; color: #6b7280; margin-bottom: 3rem; font-size: 1.125rem;">
                <?php echo esc_html( $virtual_subtitle ); ?>
            </p>
            
            <div class="telehealth-buttons" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; margin-bottom: 3rem; align-items: stretch;">
                <div style="background: white; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center; display: flex; flex-direction: column; justify-content: space-between; align-items: center; height: 100%; min-height: 320px;">
                    <div>
                        <div style="width: 80px; height: 80px; margin: 0 auto 1rem; color: #2563eb;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: #1f2937;"><?php echo esc_html( $video_title ); ?></h3>
                        <p style="color: #6b7280; margin-bottom: 1.5rem; line-height: 1.6;">
                            <?php echo esc_html( $video_description ); ?>
                        </p>
                    </div>
                    <button id="start-video-call" class="btn" style="width: 100%; margin-top: auto;">
                        <?php echo esc_html( $video_button ); ?>
                    </button>
                </div>
                
                <div style="background: white; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center; display: flex; flex-direction: column; justify-content: space-between; align-items: center; height: 100%; min-height: 320px;">
                    <div>
                        <div style="width: 80px; height: 80px; margin: 0 auto 1rem; color: #2563eb;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: #1f2937;"><?php echo esc_html( $voice_title ); ?></h3>
                        <p style="color: #6b7280; margin-bottom: 1.5rem; line-height: 1.6;">
                            <?php echo esc_html( $voice_description ); ?>
                        </p>
                    </div>
                    <button id="start-voice-call" class="btn" style="width: 100%; margin-top: auto;">
                        <?php echo esc_html( $voice_button ); ?>
                    </button>
                </div>
            </div>
            
            <style>
            @media (max-width: 768px) {
                .telehealth-buttons {
                    grid-template-columns: 1fr !important;
                }
                
                .telehealth-buttons > div {
                    min-height: auto !important;
                }
            }
            </style>
            
            <!-- Video/Voice Conference Container -->
            <div id="video-conference-container" style="display: none; background: white; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-top: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 id="conference-title" style="margin: 0; color: #1f2937;">Video Conference</h3>
                    <button id="end-call" class="btn" style="background: #ef4444; padding: 0.5rem 1.5rem; font-size: 0.875rem;">
                        End Call
                    </button>
                </div>
                <div id="video-container" style="position: relative; width: 100%; padding-bottom: 56.25%; background: #000; border-radius: 0.5rem; overflow: hidden;">
                    <video id="local-video" autoplay muted style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;"></video>
                    <video id="remote-video" autoplay style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; display: none;"></video>
                    <div id="voice-only-indicator" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 1.5rem; text-align: center;">
                        <div style="width: 80px; height: 80px; margin: 0 auto 1rem; color: white;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>Voice Call Active</div>
                    </div>
                </div>
                <div style="margin-top: 1rem; display: flex; gap: 1rem; justify-content: center;">
                    <button id="toggle-mute" class="btn" style="background: #6b7280; padding: 0.75rem 1.5rem;">
                        <span id="mute-text">Mute</span>
                    </button>
                    <button id="toggle-video" class="btn" style="background: #6b7280; padding: 0.75rem 1.5rem;">
                        <span id="video-text">Turn Off Video</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function() {
    let localStream = null;
    let peerConnection = null;
    const videoContainer = document.getElementById('video-conference-container');
    const localVideo = document.getElementById('local-video');
    const remoteVideo = document.getElementById('remote-video');
    const voiceIndicator = document.getElementById('voice-only-indicator');
    
    // Start Video Call
    document.getElementById('start-video-call')?.addEventListener('click', async function() {
        try {
            localStream = await navigator.mediaDevices.getUserMedia({ 
                video: true, 
                audio: true 
            });
            localVideo.srcObject = localStream;
            videoContainer.style.display = 'block';
            remoteVideo.style.display = 'block';
            voiceIndicator.style.display = 'none';
            
            // Update title
            document.getElementById('conference-title').textContent = 'Video Conference';
            
            // Scroll to video container
            videoContainer.scrollIntoView({ behavior: 'smooth' });
            
            // Show message
            alert('Video call started. This will connect you to your doctor.');
        } catch (error) {
            console.error('Error accessing media devices:', error);
            alert('Unable to access camera/microphone. Please check permissions.');
        }
    });
    
    // Start Voice Call
    document.getElementById('start-voice-call')?.addEventListener('click', async function() {
        try {
            localStream = await navigator.mediaDevices.getUserMedia({ 
                video: false, 
                audio: true 
            });
            videoContainer.style.display = 'block';
            remoteVideo.style.display = 'none';
            voiceIndicator.style.display = 'block';
            
            // Update title
            document.getElementById('conference-title').textContent = 'Voice Conference';
            
            // Scroll to video container
            videoContainer.scrollIntoView({ behavior: 'smooth' });
            
            // Show message
            alert('Voice call started. This will connect you to your doctor.');
        } catch (error) {
            console.error('Error accessing microphone:', error);
            alert('Unable to access microphone. Please check permissions.');
        }
    });
    
    // End Call
    document.getElementById('end-call')?.addEventListener('click', function() {
        if (localStream) {
            localStream.getTracks().forEach(track => track.stop());
            localStream = null;
        }
        if (localVideo.srcObject) {
            localVideo.srcObject = null;
        }
        if (remoteVideo.srcObject) {
            remoteVideo.srcObject = null;
        }
        videoContainer.style.display = 'none';
    });
    
    // Toggle Mute
    document.getElementById('toggle-mute')?.addEventListener('click', function() {
        if (localStream) {
            const audioTracks = localStream.getAudioTracks();
            audioTracks.forEach(track => {
                track.enabled = !track.enabled;
            });
            const muteText = document.getElementById('mute-text');
            muteText.textContent = audioTracks[0]?.enabled ? 'Mute' : 'Unmute';
        }
    });
    
    // Toggle Video
    document.getElementById('toggle-video')?.addEventListener('click', function() {
        if (localStream) {
            const videoTracks = localStream.getVideoTracks();
            videoTracks.forEach(track => {
                track.enabled = !track.enabled;
            });
            const videoText = document.getElementById('video-text');
            videoText.textContent = videoTracks[0]?.enabled ? 'Turn Off Video' : 'Turn On Video';
        }
    });
})();
</script>

<?php
get_footer();

