<?php
/**
 * Template Name: Register Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
?>

<main id="main" class="site-main">
    <div class="container" style="padding: 4rem 20px;">
        <h1 style="text-align: center; font-size: 3rem; margin-bottom: 1rem; color: #1f2937;">Join our waitlist</h1>
        <p style="text-align: center; font-size: 1.125rem; color: #4b5563; margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto;">
            Please enter your details to join our waitlist and get updates on our services.
        </p>
        
        <div style="max-width: 600px; margin: 0 auto; background: white; padding: 2.5rem; border-radius: 0.75rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <?php
            // Display success/error messages
            if (isset($_GET['register'])) {
                $status = sanitize_text_field($_GET['register']);
                if ($status === 'success') {
                    echo '<div style="background: #d1fae5; border: 1px solid #10b981; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">';
                    echo '<strong>✓ Success!</strong> Thank you for registering. We will contact you soon.';
                    echo '</div>';
                } elseif ($status === 'error') {
                    echo '<div style="background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">';
                    echo '<strong>Error:</strong> Security verification failed. Please try again.';
                    echo '</div>';
                } elseif ($status === 'missing') {
                    echo '<div style="background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">';
                    echo '<strong>Error:</strong> Please fill in all required fields.';
                    echo '</div>';
                } elseif ($status === 'invalid_email') {
                    echo '<div style="background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">';
                    echo '<strong>Error:</strong> Please enter a valid email address.';
                    echo '</div>';
                } elseif ($status === 'email_failed') {
                    echo '<div style="background: #fef3c7; border: 1px solid #f59e0b; color: #92400e; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">';
                    echo '<strong>Notice:</strong> There was an issue sending your registration. Please try again or contact us directly at <a href="mailto:' . esc_attr($contact_info['email']) . '" style="color: #92400e; text-decoration: underline;">' . esc_html($contact_info['email']) . '</a>.';
                    echo '</div>';
                }
            }
            ?>
            
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="display: flex; flex-direction: column; gap: 1.5rem;">
                <input type="hidden" name="action" value="freshdew_register_form">
                <?php wp_nonce_field('freshdew_register_form', 'freshdew_register_nonce'); ?>
                
                <!-- Full Name -->
                <div>
                    <label for="full_name" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1f2937;">Full Name <span style="color: #ef4444;">*</span></label>
                    <input type="text" id="full_name" name="full_name" required style="width: 100%; padding: 0.75rem; border: 1px solid #f59e0b; border-radius: 0.5rem; font-size: 1rem; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='#FF6B35';" onblur="this.style.borderColor='#f59e0b';">
                </div>
                
                <!-- Date of Birth -->
                <div>
                    <label for="date_of_birth" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1f2937;">Date of Birth <span style="color: #ef4444;">*</span></label>
                    <input type="date" id="date_of_birth" name="date_of_birth" required style="width: 100%; padding: 0.75rem; border: 1px solid #f59e0b; border-radius: 0.5rem; font-size: 1rem; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='#FF6B35';" onblur="this.style.borderColor='#f59e0b';">
                </div>
                
                <!-- Phone Number -->
                <div>
                    <label for="phone_number" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1f2937;">Phone Number <span style="color: #ef4444;">*</span></label>
                    <input type="tel" id="phone_number" name="phone_number" required style="width: 100%; padding: 0.75rem; border: 1px solid #f59e0b; border-radius: 0.5rem; font-size: 1rem; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='#FF6B35';" onblur="this.style.borderColor='#f59e0b';">
                </div>
                
                <!-- Email Address -->
                <div>
                    <label for="email_address" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1f2937;">Email Address <span style="color: #ef4444;">*</span></label>
                    <input type="email" id="email_address" name="email_address" required style="width: 100%; padding: 0.75rem; border: 1px solid #f59e0b; border-radius: 0.5rem; font-size: 1rem; outline: none; transition: border-color 0.3s; background: #fef3c7;" onfocus="this.style.borderColor='#FF6B35'; this.style.background='white';" onblur="this.style.borderColor='#f59e0b'; this.style.background='#fef3c7';">
                </div>
                
                <!-- Family History -->
                <div>
                    <label for="family_history" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1f2937;">Family History</label>
                    <textarea id="family_history" name="family_history" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; outline: none; transition: border-color 0.3s; resize: vertical;" onfocus="this.style.borderColor='#FF6B35';" onblur="this.style.borderColor='#d1d5db';" placeholder="Please provide any relevant family medical history..."></textarea>
                </div>
                
                <!-- Drug History -->
                <div>
                    <label for="drug_history" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1f2937;">Drug History</label>
                    <textarea id="drug_history" name="drug_history" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; outline: none; transition: border-color 0.3s; resize: vertical;" onfocus="this.style.borderColor='#FF6B35';" onblur="this.style.borderColor='#d1d5db';" placeholder="Please list any current medications or drug history..."></textarea>
                </div>
                
                <!-- Allergy History -->
                <div>
                    <label for="allergy_history" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1f2937;">Allergy History</label>
                    <textarea id="allergy_history" name="allergy_history" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; outline: none; transition: border-color 0.3s; resize: vertical;" onfocus="this.style.borderColor='#FF6B35';" onblur="this.style.borderColor='#d1d5db';" placeholder="Please list any known allergies..."></textarea>
                </div>
                
                <!-- Gynaecology History Section -->
                <div style="border-top: 2px solid #f3f4f6; padding-top: 1.5rem; margin-top: 0.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem;">Gynaecology History</h3>
                    
                    <!-- Pap Smear -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.75rem; font-weight: 600; color: #1f2937;">Are you up to date on your pap smear?</label>
                        <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="radio" name="pap_smear" value="yes" style="width: 18px; height: 18px; cursor: pointer; accent-color: #FF6B35;">
                                <span style="color: #4b5563;">Yes</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="radio" name="pap_smear" value="no" style="width: 18px; height: 18px; cursor: pointer; accent-color: #FF6B35;">
                                <span style="color: #4b5563;">No</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                <input type="radio" name="pap_smear" value="not_applicable" style="width: 18px; height: 18px; cursor: pointer; accent-color: #FF6B35;">
                                <span style="color: #4b5563;">Not Applicable</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Last Mammogram -->
                    <div style="margin-bottom: 1.5rem;">
                        <label for="last_mammogram" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1f2937;">When was your last mammogram?</label>
                        <input type="text" id="last_mammogram" name="last_mammogram" placeholder="e.g., January 2024 or Not applicable" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; outline: none; transition: border-color 0.3s;" onfocus="this.style.borderColor='#FF6B35';" onblur="this.style.borderColor='#d1d5db';">
                    </div>
                    
                    <!-- Other Information -->
                    <div>
                        <label for="gyn_other_info" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1f2937;">Any other information <span style="color: #6b7280; font-weight: 400;">(optional)</span></label>
                        <textarea id="gyn_other_info" name="gyn_other_info" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; outline: none; transition: border-color 0.3s; resize: vertical;" onfocus="this.style.borderColor='#FF6B35';" onblur="this.style.borderColor='#d1d5db';" placeholder="Any additional information..."></textarea>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #FF6B35 0%, #f59e0b 100%); color: white; border: none; border-radius: 0.5rem; font-size: 1.125rem; font-weight: 700; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; margin-top: 1rem;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(255,107,53,0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    Register and Join the Waitlist
                </button>
            </form>
        </div>
    </div>
</main>

<?php
get_footer();
?>

