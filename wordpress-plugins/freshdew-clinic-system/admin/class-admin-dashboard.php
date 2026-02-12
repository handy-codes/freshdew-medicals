<?php
/**
 * Admin Dashboard Menu Registration
 *
 * @package FreshDewClinicSystem
 */

if (!defined('ABSPATH')) {
    exit;
}

class FDCS_Admin_Dashboard {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menus'));
        add_action('admin_notices', array($this, 'admin_notices'));
        add_action('admin_post_fdcs_flush_rewrite_rules', array($this, 'flush_rewrite_rules_handler'));
    }
    
    public function admin_notices() {
        // Only show on our plugin pages
        $screen = get_current_screen();
        if (!$screen || strpos($screen->id, 'fdcs') === false) {
            return;
        }
        
        // Check for conflicting WordPress pages
        $conflicting_pages = array();
        $routes = array('clinic-login', 'clinic-register', 'clinic-dashboard', 'patient-portal');
        foreach ($routes as $route) {
            $page = get_page_by_path($route);
            if ($page) {
                $conflicting_pages[] = $route;
            }
        }
        
        if (!empty($conflicting_pages)) {
            ?>
            <div class="notice notice-error is-dismissible">
                <p><strong>⚠️ Conflict Detected:</strong> WordPress pages exist with these slugs: <code><?php echo esc_html(implode(', ', $conflicting_pages)); ?></code></p>
                <p>These pages will interfere with the clinic system. Please delete or rename them, or the plugin routes won't work.</p>
                <p><a href="<?php echo esc_url(admin_url('edit.php?post_type=page')); ?>" class="button">Go to Pages →</a></p>
            </div>
            <?php
        }
        
        // Check if rewrite rules need flushing
        if (!get_option('fdcs_rewrite_rules_flushed')) {
            ?>
            <div class="notice notice-warning is-dismissible">
                <p><strong>FreshDew Clinic System:</strong> Rewrite rules need to be flushed. 
                <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=fdcs_flush_rewrite_rules'), 'fdcs_flush_rewrite')); ?>" class="button button-primary">Flush Rewrite Rules Now</a></p>
            </div>
            <?php
        }
        
        // Show access instructions
        ?>
        <div class="notice notice-info is-dismissible">
            <p><strong>📋 How to Access Dashboards:</strong></p>
            <ul style="list-style: disc; margin-left: 20px; margin-top: 0.5rem;">
                <li><strong>Login Page:</strong> <a href="<?php echo esc_url(home_url('/clinic-login')); ?>" target="_blank"><?php echo esc_url(home_url('/clinic-login')); ?></a> — Shows login form with email/password fields and "Forgot Password" tab</li>
                <li><strong>Patient Registration:</strong> <a href="<?php echo esc_url(home_url('/clinic-register')); ?>" target="_blank"><?php echo esc_url(home_url('/clinic-register')); ?></a> — Form for new patients to create accounts</li>
                <li><strong>Staff Dashboard:</strong> <a href="<?php echo esc_url(home_url('/clinic-dashboard')); ?>" target="_blank"><?php echo esc_url(home_url('/clinic-dashboard')); ?></a> — Requires login (Head Admin, Clinic Admin, or Doctor role)</li>
                <li><strong>Patient Portal:</strong> <a href="<?php echo esc_url(home_url('/patient-portal')); ?>" target="_blank"><?php echo esc_url(home_url('/patient-portal')); ?></a> — Requires login as Patient role</li>
            </ul>
            <p style="margin-top: 1rem;"><strong>🔧 Troubleshooting:</strong></p>
            <ul style="list-style: disc; margin-left: 20px;">
                <li>If pages show the homepage: Go to <strong>Settings → Permalinks</strong> and click <strong>"Save Changes"</strong> (this flushes rewrite rules)</li>
                <li>If you see a 404: Check if WordPress pages with those slugs exist and delete them</li>
                <li>To create your first admin: Go to <strong>Users → Add New</strong>, create a user, and set role to <strong>"Head Admin (CMO)"</strong> or <strong>"Clinic Admin"</strong></li>
            </ul>
        </div>
        <?php
    }
    
    public function flush_rewrite_rules_handler() {
        check_admin_referer('fdcs_flush_rewrite');
        flush_rewrite_rules();
        delete_option('fdcs_rewrite_rules_flushed');
        wp_redirect(add_query_arg('fdcs_flushed', '1', admin_url('admin.php?page=fdcs-dashboard')));
        exit;
    }

    public function add_admin_menus() {
        // Main Clinic Dashboard menu
        add_menu_page(
            __('Clinic Dashboard', 'freshdew-clinic'),
            __('Clinic System', 'freshdew-clinic'),
            'fdcs_access_dashboard',
            'fdcs-dashboard',
            array($this, 'render_wp_admin_dashboard'),
            'dashicons-heart',
            3
        );

        // Sub-menus
        add_submenu_page('fdcs-dashboard', __('Overview', 'freshdew-clinic'), __('Overview', 'freshdew-clinic'), 'fdcs_access_dashboard', 'fdcs-dashboard', array($this, 'render_wp_admin_dashboard'));
        add_submenu_page('fdcs-dashboard', __('Patients', 'freshdew-clinic'), __('Patients', 'freshdew-clinic'), 'fdcs_view_all_patients', 'fdcs-patients', array($this, 'render_patients_page'));
        add_submenu_page('fdcs-dashboard', __('Appointments', 'freshdew-clinic'), __('Appointments', 'freshdew-clinic'), 'fdcs_manage_appointments', 'fdcs-appointments', array($this, 'render_appointments_page'));
        add_submenu_page('fdcs-dashboard', __('User Management', 'freshdew-clinic'), __('User Management', 'freshdew-clinic'), 'fdcs_manage_users', 'fdcs-users', array($this, 'render_users_page'));
        add_submenu_page('fdcs-dashboard', __('Audit Log', 'freshdew-clinic'), __('Audit Log', 'freshdew-clinic'), 'fdcs_view_audit_log', 'fdcs-audit-log', array($this, 'render_audit_log_page'));
    }

    /**
     * Render the WP Admin overview page (for when users access wp-admin)
     */
    public function render_wp_admin_dashboard() {
        $today = current_time('Y-m-d');
        $total_patients = FDCS_Patient::count();
        $waitlist = FDCS_Patient::count(array('status' => 'waitlist'));
        $active = FDCS_Patient::count(array('status' => 'active'));
        $today_appts = FDCS_Appointment::count(array('date' => $today));
        ?>
        <div class="wrap">
            <h1 style="display: flex; align-items: center; gap: 0.5rem;">
                <span class="dashicons dashicons-heart" style="color: #2563eb;"></span>
                FreshDew Clinic Dashboard
            </h1>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
                <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #2563eb;">
                    <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Total Patients</p>
                    <p style="font-size: 2rem; font-weight: 700; color: #1f2937; margin: 0.25rem 0 0;"><?php echo esc_html($total_patients); ?></p>
                </div>
                <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #f59e0b;">
                    <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Waitlist</p>
                    <p style="font-size: 2rem; font-weight: 700; color: #1f2937; margin: 0.25rem 0 0;"><?php echo esc_html($waitlist); ?></p>
                </div>
                <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #10b981;">
                    <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Active Patients</p>
                    <p style="font-size: 2rem; font-weight: 700; color: #1f2937; margin: 0.25rem 0 0;"><?php echo esc_html($active); ?></p>
                </div>
                <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #8b5cf6;">
                    <p style="color: #6b7280; font-size: 0.875rem; margin: 0;">Today's Appointments</p>
                    <p style="font-size: 2rem; font-weight: 700; color: #1f2937; margin: 0.25rem 0 0;"><?php echo esc_html($today_appts); ?></p>
                </div>
            </div>

            <!-- Recent Activity -->
            <div style="background: white; padding: 1.5rem; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-top: 2rem;">
                <h2 style="margin-top: 0;">Recent Activity</h2>
                <table class="widefat striped">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $logs = FDCS_Audit_Log::get_recent(10);
                        if (empty($logs)):
                        ?>
                            <tr><td colspan="4" style="text-align: center; color: #6b7280;">No activity yet. The system is ready!</td></tr>
                        <?php else: foreach ($logs as $log): ?>
                            <tr>
                                <td><?php echo esc_html(wp_date('M j, g:i A', strtotime($log->created_at))); ?></td>
                                <td><?php echo esc_html($log->user_name ?? 'System'); ?></td>
                                <td><code><?php echo esc_html($log->action); ?></code></td>
                                <td><?php echo esc_html($log->details); ?></td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 2rem;">
                <p style="color: #6b7280;">
                    <strong>Frontend Dashboards:</strong>
                    <a href="<?php echo esc_url(home_url('/clinic-dashboard')); ?>" target="_blank">Staff Dashboard</a> |
                    <a href="<?php echo esc_url(home_url('/patient-portal')); ?>" target="_blank">Patient Portal</a> |
                    <a href="<?php echo esc_url(home_url('/clinic-login')); ?>" target="_blank">Login Page</a> |
                    <a href="<?php echo esc_url(home_url('/clinic-register')); ?>" target="_blank">Patient Registration</a>
                </p>
            </div>
        </div>
        <?php
    }

    public function render_patients_page() {
        $patients = FDCS_Patient::get_all(array('limit' => 50));
        ?>
        <div class="wrap">
            <h1>Patient Records</h1>
            <table class="widefat striped" style="margin-top: 1rem;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>DOB</th>
                        <th>Status</th>
                        <th>Registered</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($patients)): ?>
                        <tr><td colspan="5" style="text-align: center; color: #6b7280;">No patients registered yet.</td></tr>
                    <?php else: foreach ($patients as $p): ?>
                        <tr>
                            <td><strong><?php echo esc_html($p->display_name); ?></strong></td>
                            <td><?php echo esc_html($p->user_email); ?></td>
                            <td><?php echo esc_html($p->date_of_birth ?? '—'); ?></td>
                            <td>
                                <span style="display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 0.8rem; font-weight: 600; 
                                    <?php echo $p->registration_status === 'active' ? 'background: #d1fae5; color: #065f46;' : ($p->registration_status === 'waitlist' ? 'background: #fef3c7; color: #92400e;' : 'background: #fee2e2; color: #991b1b;'); ?>">
                                    <?php echo esc_html(ucfirst($p->registration_status)); ?>
                                </span>
                            </td>
                            <td><?php echo esc_html(wp_date('M j, Y', strtotime($p->created_at))); ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function render_appointments_page() {
        $today = current_time('Y-m-d');
        $appointments = FDCS_Appointment::get_by_date($today);
        ?>
        <div class="wrap">
            <h1>Appointments – <?php echo esc_html(wp_date('l, F j, Y')); ?></h1>
            <table class="widefat striped" style="margin-top: 1rem;">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($appointments)): ?>
                        <tr><td colspan="6" style="text-align: center; color: #6b7280;">No appointments today.</td></tr>
                    <?php else: foreach ($appointments as $a): ?>
                        <tr>
                            <td><?php echo esc_html(wp_date('g:i A', strtotime($a->appointment_time))); ?></td>
                            <td><?php echo esc_html($a->patient_name ?? '—'); ?></td>
                            <td><?php echo esc_html($a->doctor_name ?? '—'); ?></td>
                            <td><?php echo esc_html(ucfirst(str_replace('_', ' ', $a->type))); ?></td>
                            <td><span style="display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 0.8rem; font-weight: 600; background: #dbeafe; color: #1e40af;"><?php echo esc_html(ucfirst($a->status)); ?></span></td>
                            <td><?php echo esc_html($a->reason ?? '—'); ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function render_users_page() {
        $clinic_roles = array('head_admin', 'clinic_admin', 'clinic_doctor', 'clinic_patient');
        $users = get_users(array('role__in' => $clinic_roles, 'orderby' => 'registered', 'order' => 'DESC'));
        ?>
        <div class="wrap">
            <h1>User Management</h1>
            <table class="widefat striped" style="margin-top: 1rem;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Registered</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="4" style="text-align: center; color: #6b7280;">No clinic users yet.</td></tr>
                    <?php else: foreach ($users as $u): ?>
                        <tr>
                            <td><strong><?php echo esc_html($u->display_name); ?></strong></td>
                            <td><?php echo esc_html($u->user_email); ?></td>
                            <td><?php echo esc_html(implode(', ', array_map('ucwords', str_replace('_', ' ', $u->roles)))); ?></td>
                            <td><?php echo esc_html(wp_date('M j, Y', strtotime($u->user_registered))); ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function render_audit_log_page() {
        $logs = FDCS_Audit_Log::get_recent(100);
        ?>
        <div class="wrap">
            <h1>Audit Log</h1>
            <table class="widefat striped" style="margin-top: 1rem;">
                <thead>
                    <tr>
                        <th>Date/Time</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Entity</th>
                        <th>Details</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs)): ?>
                        <tr><td colspan="6" style="text-align: center; color: #6b7280;">No activity logged yet.</td></tr>
                    <?php else: foreach ($logs as $log): ?>
                        <tr>
                            <td><?php echo esc_html(wp_date('M j, Y g:i A', strtotime($log->created_at))); ?></td>
                            <td><?php echo esc_html($log->user_name ?? 'System'); ?></td>
                            <td><code><?php echo esc_html($log->action); ?></code></td>
                            <td><?php echo esc_html(($log->entity_type ?? '') . ($log->entity_id ? ' #' . $log->entity_id : '')); ?></td>
                            <td><?php echo esc_html($log->details); ?></td>
                            <td><code><?php echo esc_html($log->ip_address ?? '—'); ?></code></td>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }
}

new FDCS_Admin_Dashboard();

