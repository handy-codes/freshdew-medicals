<?php
/**
 * Hospital Dashboard
 *
 * @package Hospital_Core
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php esc_html_e('Hospital Dashboard', 'hospital-core'); ?></h1>
    
    <div class="hospital-dashboard">
        <div class="dashboard-stats">
            <div class="stat-card">
                <h3><?php esc_html_e('Total Patients', 'hospital-core'); ?></h3>
                <p class="stat-number"><?php echo esc_html(Hospital_Patient::get_count()); ?></p>
            </div>
            <div class="stat-card">
                <h3><?php esc_html_e('Total Doctors', 'hospital-core'); ?></h3>
                <p class="stat-number"><?php echo esc_html(count(Hospital_Doctor::get_all())); ?></p>
            </div>
            <div class="stat-card">
                <h3><?php esc_html_e('Today\'s Appointments', 'hospital-core'); ?></h3>
                <p class="stat-number"><?php echo esc_html(Hospital_Appointment::get_today_count()); ?></p>
            </div>
        </div>
    </div>
</div>

<style>
.hospital-dashboard {
    margin-top: 20px;
}
.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}
.stat-card {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.stat-card h3 {
    margin: 0 0 10px 0;
    font-size: 14px;
    color: #666;
}
.stat-number {
    font-size: 32px;
    font-weight: bold;
    color: #2563eb;
    margin: 0;
}
</style>

