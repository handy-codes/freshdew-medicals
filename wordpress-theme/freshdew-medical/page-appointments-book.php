<?php
/**
 * Template Name: Book Appointment Page
 *
 * @package FreshDewMedical
 */

get_header();
$contact_info = freshdew_get_contact_info();
?>

<section style="padding: 4rem 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem; text-align: center; color: white; text-shadow: 0 2px 10px rgba(0,0,0,0.2);">Book an Appointment</h1>
        <p style="font-size: 1.25rem; text-align: center; opacity: 0.95; max-width: 800px; margin: 0 auto; color: white; text-shadow: 0 1px 5px rgba(0,0,0,0.2);">
            Schedule your visit with our experienced healthcare professionals
        </p>
    </div>
</section>

<section style="padding: 4rem 0;">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto;">
            <div style="background: white; border-radius: 0.75rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding: 2.5rem;">
                <h2 style="font-size: 2rem; margin-bottom: 2rem; color: #1f2937;">Appointment Details</h2>
                
                <form id="appointment-form" style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                        <div>
                            <label for="fullName" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Full Name *</label>
                            <input type="text" id="fullName" name="fullName" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;" placeholder="Your full name">
                        </div>
                        <div>
                            <label for="phone" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;" placeholder="(613) 288-0183">
                        </div>
                    </div>
                    
                    <div>
                        <label for="email" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Email Address *</label>
                        <input type="email" id="email" name="email" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;" placeholder="you@example.com">
                    </div>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                        <div>
                            <label for="date" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Preferred Date *</label>
                            <input type="date" id="date" name="date" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;" min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div>
                            <label for="time" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Preferred Time *</label>
                            <input type="time" id="time" name="time" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;">
                        </div>
                    </div>
                    
                    <div>
                        <label for="type" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Appointment Type *</label>
                        <select id="type" name="type" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; background: white;">
                            <option value="IN_PERSON">In-Person Visit</option>
                            <option value="TELEHEALTH">Telehealth (Virtual)</option>
                            <option value="URGENT_CARE">Urgent Care</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="reason" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                            Reason for Visit <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="text" id="reason" name="reason" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem;" placeholder="Brief reason for your appointment (required)">
                    </div>
                    
                    <div>
                        <label for="symptoms" style="display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">Symptoms (Optional)</label>
                        <textarea id="symptoms" name="symptoms" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; resize: vertical;" placeholder="Describe any symptoms you're experiencing"></textarea>
                    </div>
                    
                    <div id="form-message" style="display: none; padding: 1rem; border-radius: 0.5rem; margin-top: 1rem;"></div>
                    
                    <button type="submit" id="submit-btn" style="width: 100%; padding: 1rem 2rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 0.5rem; font-size: 1.125rem; font-weight: 600; cursor: pointer; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.9';" onmouseout="this.style.opacity='1';">
                        Book Appointment
                    </button>
                </form>
            </div>
            
            <div style="margin-top: 3rem; padding: 2rem; background: #f9fafb; border-radius: 0.75rem;">
                <h3 style="font-size: 1.5rem; margin-bottom: 1rem; color: #1f2937;">Need Help?</h3>
                <p style="color: #6b7280; margin-bottom: 1rem;">If you have any questions or need assistance booking your appointment, please contact us:</p>
                <p style="color: #374151; margin-bottom: 0.5rem;"><strong>Phone:</strong> <a href="tel:<?php echo esc_attr($contact_info['phone']); ?>" style="color: #667eea; text-decoration: none;"><?php echo esc_html($contact_info['phone_formatted']); ?></a></p>
                <p style="color: #374151;"><strong>Email:</strong> <a href="mailto:<?php echo esc_attr($contact_info['email']); ?>" style="color: #667eea; text-decoration: none;"><?php echo esc_html($contact_info['email']); ?></a></p>
            </div>
        </div>
    </div>
</section>

<script>
(function() {
    const form = document.getElementById('appointment-form');
    const submitBtn = document.getElementById('submit-btn');
    const messageDiv = document.getElementById('form-message');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.textContent = 'Booking...';
        messageDiv.style.display = 'none';
        
        // Get form data
        const reason = document.getElementById('reason').value.trim();
        if (!reason) {
            showMessage('error', 'Please provide a reason for your visit.');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Book Appointment';
            return;
        }
        
        const formData = {
            fullName: document.getElementById('fullName').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value,
            date: document.getElementById('date').value,
            time: document.getElementById('time').value,
            type: document.getElementById('type').value,
            reason: reason,
            symptoms: document.getElementById('symptoms').value
        };
        
        try {
            // Try to submit via REST API (if available)
            const response = await fetch('<?php echo esc_url(rest_url('freshdew/v1/book-appointment')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            });
            
            if (response.ok) {
                const data = await response.json();
                showMessage('success', 'Appointment booked successfully! We will contact you shortly to confirm.');
                form.reset();
            } else {
                throw new Error('Booking failed');
            }
        } catch (error) {
            // Fallback: Show contact information
            showMessage('info', 'Thank you for your request! Please call us at <?php echo esc_js($contact_info['phone_formatted']); ?> or email <?php echo esc_js($contact_info['email']); ?> to complete your appointment booking.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Book Appointment';
        }
    });
    
    function showMessage(type, text) {
        messageDiv.style.display = 'block';
        messageDiv.textContent = text;
        if (type === 'success') {
            messageDiv.style.background = '#d1fae5';
            messageDiv.style.color = '#065f46';
            messageDiv.style.border = '1px solid #6ee7b7';
        } else if (type === 'error') {
            messageDiv.style.background = '#fee2e2';
            messageDiv.style.color = '#991b1b';
            messageDiv.style.border = '1px solid #fca5a5';
        } else {
            messageDiv.style.background = '#dbeafe';
            messageDiv.style.color = '#1e40af';
            messageDiv.style.border = '1px solid #93c5fd';
        }
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
})();
</script>

<?php
get_footer();
?>

