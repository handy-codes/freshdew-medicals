<?php
/**
 * Template Name: Telehealth Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
?>

<section style="padding: 4rem 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem; text-align: center; color: white; text-shadow: 0 2px 10px rgba(0,0,0,0.2);">Telehealth Services</h1>
        <p style="font-size: 1.25rem; text-align: center; opacity: 0.95; max-width: 800px; margin: 0 auto; color: white; text-shadow: 0 1px 5px rgba(0,0,0,0.2);">
            Virtual consultations from the comfort of your home.
        </p>
    </div>
</section>

<section style="padding: 4rem 0;">
    <div class="container">
        <div style="max-width: 900px; margin: 0 auto;">
            <h2 style="font-size: 2.5rem; margin-bottom: 2rem; color: #1f2937;">Healthcare at Your Fingertips</h2>
            <p style="color: #4b5563; line-height: 1.8; margin-bottom: 1.5rem; font-size: 1.125rem;">
                Our telehealth services allow you to consult with our healthcare professionals from anywhere, at any time. 
                Perfect for follow-up appointments, prescription renewals, and non-urgent medical consultations.
            </p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin: 3rem 0;">
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">💻</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">Video Consultations</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Secure video calls with your doctor from your computer or mobile device.</p>
                </div>
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">📱</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">Phone Consultations</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Speak with a healthcare professional over the phone.</p>
                </div>
                <div style="padding: 2rem; background: white; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">📋</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 1rem; color: #1f2937;">Follow-up Care</h3>
                    <p style="color: #6b7280; line-height: 1.6;">Convenient follow-up appointments without leaving home.</p>
                </div>
            </div>
            
            <h2 style="font-size: 2.5rem; margin: 3rem 0 2rem; color: #1f2937;">When to Use Telehealth</h2>
            <ul style="color: #4b5563; line-height: 2; font-size: 1.125rem; list-style: none; padding: 0;">
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    Follow-up appointments for ongoing conditions
                </li>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    Prescription renewals
                </li>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    General health questions and advice
                </li>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    Mental health consultations
                </li>
                <li style="margin-bottom: 1rem; padding-left: 2rem; position: relative;">
                    <span style="position: absolute; left: 0; color: #2563eb;">✓</span>
                    Non-urgent medical concerns
                </li>
            </ul>
            
            <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 1.5rem; margin: 3rem 0; border-radius: 0.5rem;">
                <p style="color: #92400e; margin: 0; font-weight: 600;">
                    ⚠️ <strong>Note:</strong> For medical emergencies, please call 911 or visit your nearest emergency room. 
                    Telehealth is not suitable for life-threatening situations.
                </p>
            </div>
            
            <div style="text-align: center; margin-top: 3rem;">
                <a href="<?php echo esc_url(home_url('/appointments/book')); ?>" class="btn" style="font-size: 1.125rem; padding: 1rem 2.5rem;">
                    Schedule a Virtual Visit
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Telehealth Video/Voice Conference Section -->
<section style="padding: 4rem 0; background: #f9fafb;">
    <div class="container">
        <div style="max-width: 900px; margin: 0 auto;">
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem; text-align: center; color: #1f2937;">Start Your Virtual Visit</h2>
            <p style="text-align: center; color: #6b7280; margin-bottom: 3rem; font-size: 1.125rem;">
                Connect with our healthcare professionals via secure video or voice call
            </p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                <div style="background: white; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📹</div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: #1f2937;">Video Consultation</h3>
                    <p style="color: #6b7280; margin-bottom: 1.5rem; line-height: 1.6;">
                        Face-to-face consultation with your doctor via secure video call
                    </p>
                    <button id="start-video-call" class="btn" style="width: 100%;">
                        Start Video Call
                    </button>
                </div>
                
                <div style="background: white; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📞</div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: #1f2937;">Voice Call</h3>
                    <p style="color: #6b7280; margin-bottom: 1.5rem; line-height: 1.6;">
                        Speak with your doctor over a secure phone call
                    </p>
                    <button id="start-voice-call" class="btn" style="width: 100%;">
                        Start Voice Call
                    </button>
                </div>
            </div>
            
            <!-- Video Conference Container -->
            <div id="video-conference-container" style="display: none; background: white; padding: 2rem; border-radius: 0.75rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-top: 2rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="margin: 0; color: #1f2937;">Video Conference</h3>
                    <button id="end-call" class="btn" style="background: #ef4444; padding: 0.5rem 1.5rem; font-size: 0.875rem;">
                        End Call
                    </button>
                </div>
                <div id="video-container" style="position: relative; width: 100%; padding-bottom: 56.25%; background: #000; border-radius: 0.5rem; overflow: hidden;">
                    <video id="local-video" autoplay muted style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;"></video>
                    <video id="remote-video" autoplay style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; display: none;"></video>
                    <div id="voice-only-indicator" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 1.5rem; text-align: center;">
                        <div style="font-size: 4rem; margin-bottom: 1rem;">📞</div>
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
            
            // Scroll to video container
            videoContainer.scrollIntoView({ behavior: 'smooth' });
            
            // In production, you would initialize WebRTC connection here
            // For now, this is a demo showing local video
            alert('Video call started! In production, this would connect to your doctor via WebRTC.');
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
            
            // Scroll to video container
            videoContainer.scrollIntoView({ behavior: 'smooth' });
            
            alert('Voice call started! In production, this would connect to your doctor.');
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

