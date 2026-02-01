/**
 * FreshDew Medical Clinic Theme JavaScript
 */
(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Mobile menu toggle with hamburger/close icon
        $('.mobile-menu-toggle').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var $toggle = $(this);
            var $nav = $('.main-navigation');
            var $hamburger = $toggle.find('.hamburger-icon');
            var $close = $toggle.find('.close-icon');
            var isActive = $nav.hasClass('active');
            
            $nav.toggleClass('active');
            $toggle.attr('aria-expanded', !isActive);
            
            if ($nav.hasClass('active')) {
                $hamburger.hide();
                $close.show();
                $('body').addClass('menu-open');
            } else {
                $hamburger.show();
                $close.hide();
                $('body').removeClass('menu-open');
            }
        });
        
        // Close menu when clicking on menu links
        $('.main-navigation a').on('click', function() {
            if ($(window).width() <= 768) {
                $('.mobile-menu-toggle').trigger('click');
            }
        });
        
        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.header-content').length && 
                !$(e.target).closest('.main-navigation').length && 
                $('.main-navigation').hasClass('active')) {
                $('.mobile-menu-toggle').trigger('click');
            }
        });
        
        // Close menu on window resize if desktop
        $(window).on('resize', function() {
            if ($(window).width() > 768 && $('.main-navigation').hasClass('active')) {
                $('.mobile-menu-toggle').trigger('click');
            }
        });
        
        // Close menu on ESC key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $('.main-navigation').hasClass('active')) {
                $('.mobile-menu-toggle').trigger('click');
            }
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

