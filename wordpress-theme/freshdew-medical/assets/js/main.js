/**
 * FreshDew Medical Clinic Theme JavaScript
 */
(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Mobile menu toggle
        $('.mobile-menu-toggle').on('click', function() {
            $('.main-navigation').toggleClass('active');
        });
        
        // Smooth scroll for anchor links
        $('a[href^="#"]').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 80
                }, 1000);
            }
        });
        
        // Contact form submission
        $('form[action*="freshdew_contact_form"]').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            
            $.ajax({
                url: freshdewAjax.ajaxurl,
                type: 'POST',
                data: formData + '&action=freshdew_contact_form',
                success: function(response) {
                    if (response.success) {
                        form.html('<div style="padding: 1rem; background: #10b981; color: white; border-radius: 0.25rem;">Thank you! Your message has been sent.</div>');
                    } else {
                        alert('Error sending message. Please try again.');
                    }
                },
                error: function() {
                    alert('Error sending message. Please try again.');
                }
            });
        });
    });
})(jQuery);

