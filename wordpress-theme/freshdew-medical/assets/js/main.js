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
        
        // Contact form: refresh nonce before POST so LiteSpeed-cached HTML cannot expire it.
        $(document).on('submit', '#freshdew-contact-form', function(e) {
            var form = this;
            if (form.dataset.nonceReady === '1') {
                return;
            }
            e.preventDefault();

            var $btn = $(form).find('[type="submit"]');
            $btn.prop('disabled', true);

            $.ajax({
                url: (typeof freshdewAjax !== 'undefined' && freshdewAjax.ajaxurl) ? freshdewAjax.ajaxurl : '/wp-admin/admin-ajax.php',
                type: 'POST',
                dataType: 'json',
                data: { action: 'freshdew_contact_nonce' }
            }).done(function(response) {
                if (response && response.success && response.data && response.data.nonce) {
                    var nonceInput = form.querySelector('[name="freshdew_contact_nonce"]');
                    if (nonceInput) {
                        nonceInput.value = response.data.nonce;
                    }
                    form.dataset.nonceReady = '1';
                    form.submit();
                    return;
                }
                $btn.prop('disabled', false);
                alert('Security check could not be refreshed. Please reload the page and try again.');
            }).fail(function() {
                $btn.prop('disabled', false);
                alert('Could not reach the server. Please check your connection and try again.');
            });
        });
    });
})(jQuery);

