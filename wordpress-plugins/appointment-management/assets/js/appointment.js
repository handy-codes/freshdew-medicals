/**
 * Appointment Management JavaScript
 */
(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Handle booking form submission
        $('#appointment-booking-form').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var formData = form.serialize();
            var messageDiv = $('#booking-message');
            
            messageDiv.html('<p>Processing...</p>');
            
            $.ajax({
                url: appointmentAjax.ajaxurl,
                type: 'POST',
                data: formData + '&action=book_appointment&nonce=' + appointmentAjax.nonce,
                success: function(response) {
                    if (response.success) {
                        messageDiv.html('<p style="color: green;">' + response.data.message + '</p>');
                        form[0].reset();
                    } else {
                        messageDiv.html('<p style="color: red;">' + response.data.message + '</p>');
                    }
                },
                error: function() {
                    messageDiv.html('<p style="color: red;">An error occurred. Please try again.</p>');
                }
            });
        });
    });
})(jQuery);

