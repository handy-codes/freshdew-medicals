/**
 * FreshDew Clinic System – Dashboard Scripts
 */

(function ($) {
    'use strict';

    $(document).ready(function () {
        // Auto-refresh dashboard stats every 60 seconds (if on dashboard)
        if (typeof fdcsAdmin !== 'undefined' && window.location.pathname.includes('clinic-dashboard')) {
            setInterval(function () {
                $.ajax({
                    url: fdcsAdmin.restUrl + 'stats',
                    method: 'GET',
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('X-WP-Nonce', fdcsAdmin.nonce);
                    },
                    success: function (data) {
                        // Stats will be used for dynamic updates in future phases
                        console.log('Dashboard stats refreshed:', data);
                    },
                    error: function (err) {
                        console.log('Stats refresh error:', err.statusText);
                    }
                });
            }, 60000);
        }

        // Password strength indicator
        $('input[name="password"]').on('input', function () {
            var password = $(this).val();
            var strength = 0;

            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            var $indicator = $(this).siblings('.password-strength');
            if ($indicator.length === 0) {
                $indicator = $('<div class="password-strength" style="height: 4px; border-radius: 2px; margin-top: 4px; transition: all 0.3s;"></div>');
                $(this).after($indicator);
            }

            var colors = ['#ef4444', '#f59e0b', '#eab308', '#22c55e', '#16a34a'];
            var widths = ['20%', '40%', '60%', '80%', '100%'];

            $indicator.css({
                width: widths[Math.min(strength, 4)],
                backgroundColor: colors[Math.min(strength, 4)]
            });
        });

        // Password confirmation matching
        $('input[name="password_confirm"]').on('input', function () {
            var password = $('input[name="password"]').val();
            var confirm = $(this).val();

            if (confirm.length > 0) {
                if (password === confirm) {
                    $(this).css('borderColor', '#22c55e');
                } else {
                    $(this).css('borderColor', '#ef4444');
                }
            }
        });
    });

})(jQuery);

