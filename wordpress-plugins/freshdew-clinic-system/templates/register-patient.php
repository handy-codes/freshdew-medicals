<?php
/**
 * Patient Registration Page Template
 *
 * @package FreshDewClinicSystem
 */

if (!defined('ABSPATH')) {
    exit;
}

$error = isset($_GET['error']) ? urldecode(sanitize_text_field($_GET['error'])) : '';
$errors = $error ? explode('|', $error) : array();

get_header();
?>

<main class="fdcs-auth-page" style="min-height: 100vh; display: flex; align-items: flex-start; justify-content: center; padding: 6rem 1rem 2rem 1rem; background: linear-gradient(135deg, #f0f4ff 0%, #e8f5e9 100%);">
    <div style="width: 100%; max-width: 440px;">

        <!-- Tab Switcher -->
        <div style="display: flex; margin-bottom: 0; border-bottom: 2px solid #e5e7eb; background: white; border-radius: 0.75rem 0.75rem 0 0; overflow: hidden;">
            <a href="<?php echo esc_url(home_url('/clinic-login')); ?>" style="flex: 1; text-align: center; padding: 1rem; font-weight: 600; text-decoration: none; color: #6b7280;">Sign In</a>
            <a href="<?php echo esc_url(home_url('/clinic-register')); ?>" style="flex: 1; text-align: center; padding: 1rem; font-weight: 600; text-decoration: none; color: #2563eb; border-bottom: 2px solid #2563eb; margin-bottom: -2px;">Create Account</a>
        </div>

        <!-- Card -->
        <div style="background: white; padding: 2rem; border-radius: 0 0 0.75rem 0.75rem; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">

            <?php if (!empty($errors)): ?>
                <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    <strong>Please fix the following:</strong>
                    <ul style="margin: 0.5rem 0 0 1.25rem; padding: 0;">
                        <?php foreach ($errors as $err): ?>
                            <li><?php echo esc_html(trim($err)); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Create Patient Account</h2>
            <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1.5rem;">Register to access the patient portal, book appointments, and manage your health records.</p>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="fdcs_patient_register">
                <?php wp_nonce_field('fdcs_register_action', 'fdcs_register_nonce'); ?>

                <!-- Personal Information Section -->
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1f2937; margin: 2rem 0 1rem 0; padding-bottom: 0.5rem; border-bottom: 2px solid #e5e7eb;">Personal Information</h3>

                <!-- Name -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                    <div>
                        <label for="first_name" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">First Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="first_name" name="first_name" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid #F69710; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; background: white;"
                               onfocus="this.style.borderColor='#2563eb'; this.style.borderWidth='2px'" onblur="this.style.borderColor='#F69710'; this.style.borderWidth='1px'">
                    </div>
                    <div>
                        <label for="last_name" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Last Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="last_name" name="last_name" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid #F69710; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; background: white;"
                               onfocus="this.style.borderColor='#2563eb'; this.style.borderWidth='2px'" onblur="this.style.borderColor='#F69710'; this.style.borderWidth='1px'">
                    </div>
                </div>

                <!-- Date of Birth -->
                <div style="margin-bottom: 1.25rem;">
                    <label for="date_of_birth" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Date of Birth <span style="color: #ef4444;">*</span></label>
                    <input type="date" id="date_of_birth" name="date_of_birth" required placeholder="mm/dd/yyyy"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #F69710; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; background: white;"
                           onfocus="this.style.borderColor='#2563eb'; this.style.borderWidth='2px'" onblur="this.style.borderColor='#F69710'; this.style.borderWidth='1px'">
                </div>

                <!-- Phone -->
                <div style="margin-bottom: 1.25rem;">
                    <label for="phone" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Phone Number <span style="color: #ef4444;">*</span></label>
                    <input type="tel" id="phone" name="phone" required placeholder="(613) 000-0000"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #F69710; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; background: white;"
                           onfocus="this.style.borderColor='#2563eb'; this.style.borderWidth='2px'" onblur="this.style.borderColor='#F69710'; this.style.borderWidth='1px'">
                </div>

                <!-- Email -->
                <div style="margin-bottom: 1.25rem;">
                    <label for="email" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Email Address <span style="color: #ef4444;">*</span></label>
                    <input type="email" id="email" name="email" required autocomplete="email"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #F69710; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; background: white;"
                           onfocus="this.style.borderColor='#2563eb'; this.style.borderWidth='2px'" onblur="this.style.borderColor='#F69710'; this.style.borderWidth='1px'">
                </div>

                <!-- Gender -->
                <div style="margin-bottom: 2rem;">
                    <label for="gender" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Gender</label>
                    <select id="gender" name="gender"
                            style="width: 100%; padding: 0.75rem; border: 1px solid #F69710; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; background: white;"
                            onfocus="this.style.borderColor='#2563eb'; this.style.borderWidth='2px'" onblur="this.style.borderColor='#F69710'; this.style.borderWidth='1px'">
                        <option value="">Select...</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                        <option value="prefer_not_to_say">Prefer not to say</option>
                    </select>
                </div>

                <!-- Family History Section -->
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1f2937; margin: 2rem 0 1rem 0; padding-bottom: 0.5rem; border-bottom: 2px solid #e5e7eb;">Family History</h3>
                <div style="margin-bottom: 2rem;">
                    <label for="family_history" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Family History <span style="color: #ef4444;">*</span></label>
                    <textarea id="family_history" name="family_history" rows="4" required placeholder="Please provide any relevant family medical history..."
                              style="width: 100%; padding: 0.75rem; border: 1px solid #F69710; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; background: white; resize: vertical; font-family: inherit;"
                              onfocus="this.style.borderColor='#2563eb'; this.style.borderWidth='2px'" onblur="this.style.borderColor='#F69710'; this.style.borderWidth='1px'"></textarea>
                </div>

                <!-- Drug History Section -->
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1f2937; margin: 2rem 0 1rem 0; padding-bottom: 0.5rem; border-bottom: 2px solid #e5e7eb;">Drug History</h3>
                <div style="margin-bottom: 2rem;">
                    <label for="drug_history" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Drug History <span style="color: #ef4444;">*</span></label>
                    <textarea id="drug_history" name="drug_history" rows="4" required placeholder="Please list any current medications or drug history..."
                              style="width: 100%; padding: 0.75rem; border: 1px solid #F69710; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; background: white; resize: vertical; font-family: inherit;"
                              onfocus="this.style.borderColor='#2563eb'; this.style.borderWidth='2px'" onblur="this.style.borderColor='#F69710'; this.style.borderWidth='1px'"></textarea>
                </div>

                <!-- Allergy History Section -->
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1f2937; margin: 2rem 0 1rem 0; padding-bottom: 0.5rem; border-bottom: 2px solid #e5e7eb;">Allergy History</h3>
                <div style="margin-bottom: 2rem;">
                    <label for="allergy_history" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Allergy History <span style="color: #ef4444;">*</span></label>
                    <textarea id="allergy_history" name="allergy_history" rows="4" required placeholder="Please list any known allergies..."
                              style="width: 100%; padding: 0.75rem; border: 1px solid #F69710; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; background: white; resize: vertical; font-family: inherit;"
                              onfocus="this.style.borderColor='#2563eb'; this.style.borderWidth='2px'" onblur="this.style.borderColor='#F69710'; this.style.borderWidth='1px'"></textarea>
                </div>

                <!-- Medical and Surgical History Section -->
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1f2937; margin: 2rem 0 1rem 0; padding-bottom: 0.5rem; border-bottom: 2px solid #e5e7eb;">Current and Past Medical and Surgical History</h3>
                <div style="margin-bottom: 2rem;">
                    <label for="medical_surgical_history" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Current and Past Medical and Surgical History <span style="color: #ef4444;">*</span></label>
                    <textarea id="medical_surgical_history" name="medical_surgical_history" rows="4" required placeholder="Please provide details of any current or past medical conditions and surgical procedures..."
                              style="width: 100%; padding: 0.75rem; border: 1px solid #F69710; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; background: white; resize: vertical; font-family: inherit;"
                              onfocus="this.style.borderColor='#2563eb'; this.style.borderWidth='2px'" onblur="this.style.borderColor='#F69710'; this.style.borderWidth='1px'"></textarea>
                </div>

                <!-- Gynaecology History Section -->
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1f2937; margin: 2rem 0 1rem 0; padding-bottom: 0.5rem; border-bottom: 2px solid #e5e7eb;">Gynaecology History</h3>
                
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Are you up to date on your pap smear? <span style="color: #ef4444;">*</span></label>
                    <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: #374151;">
                            <input type="radio" name="pap_smear_status" value="yes" required style="accent-color: #2563eb;">
                            <span>Yes</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: #374151;">
                            <input type="radio" name="pap_smear_status" value="no" required style="accent-color: #2563eb;">
                            <span>No</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: #374151;">
                            <input type="radio" name="pap_smear_status" value="not_applicable" required style="accent-color: #2563eb;">
                            <span>Not Applicable</span>
                        </label>
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label for="last_mammogram" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">When was your last mammogram? <span style="color: #ef4444;">*</span></label>
                    <input type="text" id="last_mammogram" name="last_mammogram" required placeholder="e.g., January 2024 or Not applicable"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #F69710; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; background: white;"
                           onfocus="this.style.borderColor='#2563eb'; this.style.borderWidth='2px'" onblur="this.style.borderColor='#F69710'; this.style.borderWidth='1px'">
                </div>

                <!-- Any Other Information Section -->
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1f2937; margin: 2rem 0 1rem 0; padding-bottom: 0.5rem; border-bottom: 2px solid #e5e7eb;">Any other information (optional)</h3>
                <div style="margin-bottom: 2rem;">
                    <label for="other_information" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Any other information</label>
                    <textarea id="other_information" name="other_information" rows="4" placeholder="Any additional information..."
                              style="width: 100%; padding: 0.75rem; border: 1px solid #F69710; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; background: white; resize: vertical; font-family: inherit;"
                              onfocus="this.style.borderColor='#2563eb'; this.style.borderWidth='2px'" onblur="this.style.borderColor='#F69710'; this.style.borderWidth='1px'"></textarea>
                </div>

                <!-- Password Section -->
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1f2937; margin: 2rem 0 1rem 0; padding-bottom: 0.5rem; border-bottom: 2px solid #e5e7eb;">Account Security</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label for="password" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Password <span style="color: #ef4444;">*</span></label>
                        <div style="position: relative;">
                            <input type="password" id="password" name="password" required minlength="8" autocomplete="new-password"
                                   style="width: 100%; padding: 0.75rem 2.5rem 0.75rem 0.75rem; border: 1px solid #F69710; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; background: white;"
                                   onfocus="this.style.borderColor='#2563eb'; this.style.borderWidth='2px'" onblur="this.style.borderColor='#F69710'; this.style.borderWidth='1px'">
                            <button type="button" onclick="togglePassword('password', this)" 
                                    style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 0.25rem; color: #6b7280;"
                                    aria-label="Toggle password visibility">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        <span style="font-size: 0.75rem; color: #6b7280;">Min. 8 characters</span>
                        <div id="passwordError" style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: none;"></div>
                    </div>
                    <div>
                        <label for="password_confirm" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Confirm Password <span style="color: #ef4444;">*</span></label>
                        <div style="position: relative;">
                            <input type="password" id="password_confirm" name="password_confirm" required minlength="8" autocomplete="new-password"
                                   style="width: 100%; padding: 0.75rem 2.5rem 0.75rem 0.75rem; border: 1px solid #F69710; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; background: white;"
                                   onfocus="this.style.borderColor='#2563eb'; this.style.borderWidth='2px'" onblur="this.style.borderColor='#F69710'; this.style.borderWidth='1px'">
                            <button type="button" onclick="togglePassword('password_confirm', this)" 
                                    style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 0.25rem; color: #6b7280;"
                                    aria-label="Toggle password visibility">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                        <div id="confirmPasswordError" style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: none;"></div>
                    </div>
                </div>
                <div id="emailError" style="color: #dc2626; font-size: 0.875rem; margin-bottom: 0.5rem; display: none;"></div>
                <script>
                function togglePassword(inputId, button) {
                    const input = document.getElementById(inputId);
                    const svg = button.querySelector('svg');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        svg.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
                    } else {
                        input.type = 'password';
                        svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
                    }
                }
                
                // Form validation and spinner on submit
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.querySelector('form[action*="admin-post.php"]');
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            // Clear previous errors
                            document.getElementById('emailError').style.display = 'none';
                            document.getElementById('passwordError').style.display = 'none';
                            document.getElementById('confirmPasswordError').style.display = 'none';
                            
                            const email = document.getElementById('email').value.trim();
                            const password = document.getElementById('password').value;
                            const passwordConfirm = document.getElementById('password_confirm').value;
                            let hasError = false;
                            
                            // Validate email format
                            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                            if (!emailRegex.test(email)) {
                                document.getElementById('emailError').textContent = 'Please enter a valid email address';
                                document.getElementById('emailError').style.display = 'block';
                                hasError = true;
                            }
                            
                            // Validate password length
                            if (password.length < 8) {
                                document.getElementById('passwordError').textContent = 'Password must be at least 8 characters';
                                document.getElementById('passwordError').style.display = 'block';
                                hasError = true;
                            }
                            
                            // Validate passwords match
                            if (password !== passwordConfirm) {
                                document.getElementById('confirmPasswordError').textContent = 'Passwords do not match';
                                document.getElementById('confirmPasswordError').style.display = 'block';
                                hasError = true;
                            }
                            
                            if (hasError) {
                                e.preventDefault();
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                                return false;
                            }
                            
                            // Show loading state
                            const btn = document.getElementById('registerBtn');
                            const btnText = document.getElementById('registerBtnText');
                            const spinner = document.getElementById('registerSpinner');
                            if (btn && btnText && spinner) {
                                btn.disabled = true;
                                btn.style.opacity = '0.7';
                                btn.style.cursor = 'not-allowed';
                                btnText.textContent = 'Registering...';
                                spinner.style.display = 'inline-block';
                            }
                        });
                    }
                });
                </script>

                <button type="submit" id="registerBtn" style="width: 100%; padding: 0.875rem; background: linear-gradient(135deg, #16a34a, #15803d); color: white; border: none; border-radius: 0.5rem; font-size: 1rem; font-weight: 600; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; margin-top: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;"
                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(22,163,74,0.4)'"
                        onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                    <span id="registerBtnText">Register as Patient</span>
                    <span id="registerSpinner" style="display: none; width: 20px; height: 20px; border: 2px solid rgba(255,255,255,0.3); border-top: 2px solid white; border-radius: 50%; animation: fdcs-spin 0.8s linear infinite;"></span>
                </button>
                <style>@keyframes fdcs-spin { to { transform: rotate(360deg); } }</style>

                <p style="text-align: center; margin-top: 1.5rem; font-size: 0.875rem; color: #6b7280;">
                    Already have an account?
                    <a href="<?php echo esc_url(home_url('/clinic-login')); ?>" style="color: #2563eb; text-decoration: none; font-weight: 600;">Sign In</a>
                </p>
            </form>
        </div>
    </div>
</main>

<!-- No footer on auth pages -->
<?php wp_footer(); ?>
</body>
</html>
