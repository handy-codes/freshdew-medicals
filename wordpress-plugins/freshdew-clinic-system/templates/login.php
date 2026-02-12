<?php
/**
 * Custom Login Page Template
 *
 * @package FreshDewClinicSystem
 */

if (!defined('ABSPATH')) {
    exit;
}

$error = isset($_GET['error']) ? sanitize_text_field($_GET['error']) : '';
$tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'login';
$success = isset($_GET['success']) ? sanitize_text_field($_GET['success']) : '';

get_header();
?>

<main class="fdcs-auth-page" style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 2rem 1rem; background: linear-gradient(135deg, #f0f4ff 0%, #e8f5e9 100%);">
    <div style="width: 100%; max-width: 440px;">

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
            <a href="<?php echo esc_url(home_url('/clinic-login')); ?>" style="flex: 1; text-align: center; padding: 1rem; font-weight: 600; text-decoration: none; <?php echo $tab !== 'forgot' ? 'color: #2563eb; border-bottom: 2px solid #2563eb; margin-bottom: -2px;' : 'color: #6b7280;'; ?>">Sign In</a>
            <a href="<?php echo esc_url(home_url('/clinic-register')); ?>" style="flex: 1; text-align: center; padding: 1rem; font-weight: 600; text-decoration: none; color: #6b7280;">Create Account</a>
        </div>

        <!-- Card -->
        <div style="background: white; padding: 2rem; border-radius: 0 0 0.75rem 0.75rem; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">

            <?php if ($error === 'invalid'): ?>
                <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    Invalid username or password. Please try again.
                </div>
            <?php elseif ($error === 'empty'): ?>
                <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    Please enter both username/email and password.
                </div>
            <?php elseif ($error === 'security'): ?>
                <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    Security verification failed. Please try again.
                </div>
            <?php endif; ?>

            <?php if ($success === 'sent'): ?>
                <div style="background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    If an account exists with that email, a password reset link has been sent.
                </div>
            <?php endif; ?>

            <?php if ($tab === 'forgot'): ?>
                <!-- Forgot Password Form -->
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Reset Password</h2>
                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1.5rem;">Enter your email and we'll send you a reset link.</p>

                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="fdcs_forgot_password">
                    <?php wp_nonce_field('fdcs_forgot_action', 'fdcs_forgot_nonce'); ?>

                    <div style="margin-bottom: 1.25rem;">
                        <label for="email" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Email Address</label>
                        <input type="email" id="email" name="email" required
                               style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#d1d5db'">
                    </div>

                    <button type="submit" style="width: 100%; padding: 0.875rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white; border: none; border-radius: 0.5rem; font-size: 1rem; font-weight: 600; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;"
                            onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(37,99,235,0.4)'"
                            onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                        Send Reset Link
                    </button>

                    <p style="text-align: center; margin-top: 1.25rem; font-size: 0.875rem;">
                        <a href="<?php echo esc_url(home_url('/clinic-login')); ?>" style="color: #2563eb; text-decoration: none; font-weight: 600;">← Back to Sign In</a>
                    </p>
                </form>
            <?php else: ?>
                <!-- Login Form -->
                <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">Welcome Back</h2>
                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1.5rem;">Sign in to your clinic account.</p>

                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="fdcs_login">
                    <?php wp_nonce_field('fdcs_login_action', 'fdcs_login_nonce'); ?>

                    <div style="margin-bottom: 1.25rem;">
                        <label for="username" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Email or Username</label>
                        <input type="text" id="username" name="username" required autocomplete="username"
                               style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#d1d5db'">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label for="password" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem;">Password</label>
                        <div style="position: relative;">
                            <input type="password" id="password" name="password" required autocomplete="current-password"
                                   style="width: 100%; padding: 0.75rem 2.5rem 0.75rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; box-sizing: border-box; outline: none; transition: border-color 0.2s;"
                                   onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#d1d5db'">
                            <button type="button" onclick="togglePassword('password', this)" 
                                    style="position: absolute; right: 0.5rem; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 0.25rem; color: #6b7280; font-size: 1.1rem;"
                                    aria-label="Show password">
                                👁️
                            </button>
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

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.875rem;">
                        <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: #374151;">
                            <input type="checkbox" name="remember" value="1" style="accent-color: #2563eb;"> Remember me
                        </label>
                        <a href="<?php echo esc_url(add_query_arg('tab', 'forgot', home_url('/clinic-login'))); ?>" style="color: #2563eb; text-decoration: none; font-weight: 600;">Forgot password?</a>
                    </div>

                    <button type="submit" style="width: 100%; padding: 0.875rem; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white; border: none; border-radius: 0.5rem; font-size: 1rem; font-weight: 600; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;"
                            onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(37,99,235,0.4)'"
                            onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                        Sign In
                    </button>

                    <p style="text-align: center; margin-top: 1.5rem; font-size: 0.875rem; color: #6b7280;">
                        Don't have an account?
                        <a href="<?php echo esc_url(home_url('/clinic-register')); ?>" style="color: #2563eb; text-decoration: none; font-weight: 600;">Register as Patient</a>
                    </p>
                </form>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>

