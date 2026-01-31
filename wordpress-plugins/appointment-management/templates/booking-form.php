<?php
/**
 * Appointment Booking Form Template
 *
 * @package Appointment_Management
 */

if (!defined('ABSPATH')) {
    exit;
}

$doctors = Hospital_Doctor::get_all(array('accepting_patients' => true));
?>

<div class="appointment-booking-form">
    <h2>Book an Appointment</h2>
    <form id="appointment-booking-form">
        <div class="form-group">
            <label for="doctor_id">Select Doctor</label>
            <select name="doctor_id" id="doctor_id" required>
                <option value="">-- Select Doctor --</option>
                <?php foreach ($doctors as $doctor) : 
                    $user = get_userdata($doctor->user_id);
                ?>
                <option value="<?php echo esc_attr($doctor->id); ?>">
                    <?php echo esc_html($user->display_name . ' - ' . $doctor->specialty); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="appointment_date">Date</label>
            <input type="date" name="appointment_date" id="appointment_date" required min="<?php echo date('Y-m-d'); ?>">
        </div>
        
        <div class="form-group">
            <label for="appointment_time">Time</label>
            <input type="time" name="appointment_time" id="appointment_time" required>
        </div>
        
        <div class="form-group">
            <label for="type">Visit Type</label>
            <select name="type" id="type" required>
                <option value="IN_PERSON">In Person</option>
                <option value="TELEHEALTH">Telehealth</option>
                <option value="URGENT_CARE">Urgent Care</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="reason">Reason for Visit</label>
            <textarea name="reason" id="reason" rows="4" required></textarea>
        </div>
        
        <button type="submit" class="btn">Book Appointment</button>
    </form>
    <div id="booking-message"></div>
</div>

