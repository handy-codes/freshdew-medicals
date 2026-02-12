/**
 * FreshDew Medical Clinic Theme JavaScript
 */
(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Mark current page in navigation
        function markCurrentPage() {
            const normalize = (p) => {
                if (!p) return '/';
                // ensure trailing slash consistency (strip unless root)
                const stripped = p.replace(/\/+$/, '');
                return stripped === '' ? '/' : stripped;
            };

            const currentPath = normalize(window.location.pathname);
            const navLinks = document.querySelectorAll('.main-navigation a');
            
            navLinks.forEach(link => {
                try {
                    const linkUrl = new URL(link.href);
                    const linkPath = normalize(linkUrl.pathname);
                    const linkParent = link.closest('li');
                    
                    // Remove existing active class
                    link.classList.remove('current', 'active');
                    if (linkParent) {
                        linkParent.classList.remove('current-menu-item', 'current_page_item');
                    }
                    
                    // Check if this link matches current page
                    const isMatch = (linkPath === currentPath) || (currentPath === '/' && linkPath === '/');
                    if (isMatch) {
                        link.classList.add('current', 'active');
                        link.setAttribute('aria-current', 'page');
                        if (linkParent) {
                            linkParent.classList.add('current-menu-item', 'current_page_item');
                        }
                    } else {
                        link.removeAttribute('aria-current');
                    }
                } catch (e) {
                    // Skip invalid URLs
                }
            });
        }
        
        // Mark current page on load
        markCurrentPage();
        
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

