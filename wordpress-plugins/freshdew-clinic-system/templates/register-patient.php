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

<main class="fdcs-auth-page" style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 2rem 1rem; background: linear-gradient(135deg, #f0f4ff 0%, #e8f5e9 100%);">
    <div style="width: 100%; max-width: 520px;">

        <!-- Logo -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <a href="<?php echo esc_url(home_url('/')); ?>" style="text-decoration: none;">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/freshdew-favicon-logo.png'); ?>" alt="FreshDew" style="width: 64px; height: 64px; border-radius: 50%; margin-bottom: 0.75rem;">
                <div>
                    <span style="font-size: 1.75rem; font-weight: 800; color: #2563eb; display: block;">FreshDew</span>
                    <span style="font-size: 1rem; font-weight: 700; color: #16a34a;">Medical Clinic</span>
                </div>
            </a>
        </div>

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

                <!-- Name -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                    <div>
                        <label for="first_name" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">First Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="first_name" name="first_name" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none;"
                               onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#d1d5db'">
                    </div>
                    <div>
                        <label for="last_name" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Last Name <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="last_name" name="last_name" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none;"
                               onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#d1d5db'">
                    </div>
                </div>

                <!-- Email -->
                <div style="margin-bottom: 1.25rem;">
                    <label for="email" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Email Address <span style="color: #ef4444;">*</span></label>
                    <input type="email" id="email" name="email" required autocomplete="email"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; background: white;"
                           onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#d1d5db'">
                </div>

                <!-- Phone -->
                <div style="margin-bottom: 1.25rem;">
                    <label for="phone" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Phone Number <span style="color: #ef4444;">*</span></label>
                    <input type="tel" id="phone" name="phone" required placeholder="(613) 000-0000"
                           style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none;"
                           onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#d1d5db'">
                </div>

                <!-- Date of Birth & Gender -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                    <div>
                        <label for="date_of_birth" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Date of Birth <span style="color: #ef4444;">*</span></label>
                        <input type="date" id="date_of_birth" name="date_of_birth" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none;"
                               onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#d1d5db'">
                    </div>
                    <div>
                        <label for="gender" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Gender</label>
                        <select id="gender" name="gender"
                                style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; background: white;"
                                onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#d1d5db'">
                            <option value="">Select...</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                            <option value="prefer_not_to_say">Prefer not to say</option>
                        </select>
                    </div>
                </div>

                <!-- Password -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <label for="password" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Password <span style="color: #ef4444;">*</span></label>
                        <div style="position: relative;">
                            <input type="password" id="password" name="password" required minlength="8" autocomplete="new-password"
                                   style="width: 100%; padding: 0.75rem 2.5rem 0.75rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none;"
                                   onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#d1d5db'">
                            <button type="button" onclick="togglePassword('password', this)" 
                                    style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 0.25rem; color: #6b7280; font-size: 1.1rem;"
                                    aria-label="Show password">
                                👁️
                            </button>
                        </div>
                        <span style="font-size: 0.75rem; color: #6b7280;">Min. 8 characters</span>
                    </div>
                    <div>
                        <label for="password_confirm" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Confirm Password <span style="color: #ef4444;">*</span></label>
                        <div style="position: relative;">
                            <input type="password" id="password_confirm" name="password_confirm" required minlength="8" autocomplete="new-password"
                                   style="width: 100%; padding: 0.75rem 2.5rem 0.75rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none;"
                                   onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#d1d5db'">
                            <button type="button" onclick="togglePassword('password_confirm', this)" 
                                    style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 0.25rem; color: #6b7280; font-size: 1.1rem;"
                                    aria-label="Show password">
                                👁️
                            </button>
                        </div>
                    </div>
                </div>
                <script>
                function togglePassword(inputId, button) {
                    const input = document.getElementById(inputId);
                    if (input.type === 'password') {
                        input.type = 'text';
                        button.textContent = '🙈';
                    } else {
                        input.type = 'password';
                        button.textContent = '👁️';
                    }
                }
                </script>

                <button type="submit" style="width: 100%; padding: 0.875rem; background: linear-gradient(135deg, #16a34a, #15803d); color: white; border: none; border-radius: 0.5rem; font-size: 1rem; font-weight: 600; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;"
                        onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(22,163,74,0.4)'"
                        onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                    Create Account
                </button>

                <p style="text-align: center; margin-top: 1.5rem; font-size: 0.875rem; color: #6b7280;">
                    Already have an account?
                    <a href="<?php echo esc_url(home_url('/clinic-login')); ?>" style="color: #2563eb; text-decoration: none; font-weight: 600;">Sign In</a>
                </p>
            </form>
        </div>
    </div>
</main>

<?php get_footer(); ?>

