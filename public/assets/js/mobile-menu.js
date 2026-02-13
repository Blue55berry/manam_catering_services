/**
 * Mobile Menu Toggle Functionality
 * Handles opening, closing, and navigation for mobile menu
 */

(function($) {
    'use strict';

    // Wait for DOM to be ready
    $(document).ready(function() {
        
        const mobileMenuToggle = $('#mobileMenuToggle');
        const mobileMenuOverlay = $('#mobileMenuOverlay');
        const mobileMenuClose = $('#mobileMenuClose');
        const mobileMenuLinks = $('.mobile-menu-link');
        
        // Open mobile menu
        mobileMenuToggle.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openMobileMenu();
        });
        
        // Close mobile menu when clicking close button
        mobileMenuClose.on('click', function(e) {
            e.preventDefault();
            closeMobileMenu();
        });
        
        // Close mobile menu when clicking overlay background
        mobileMenuOverlay.on('click', function(e) {
            if (e.target === this) {
                closeMobileMenu();
            }
        });
        
        // Close mobile menu when clicking on any navigation link
        mobileMenuLinks.on('click', function() {
            closeMobileMenu();
        });
        
        // Close mobile menu on escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && mobileMenuOverlay.hasClass('active')) {
                closeMobileMenu();
            }
        });
        
        // Functions
        function openMobileMenu() {
            mobileMenuOverlay.addClass('active');
            $('body').addClass('mobile-menu-open');
        }
        
        function closeMobileMenu() {
            mobileMenuOverlay.removeClass('active');
            $('body').removeClass('mobile-menu-open');
        }
        
        // Handle window resize - close menu if resized to desktop
        let resizeTimer;
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if ($(window).width() >= 992 && mobileMenuOverlay.hasClass('active')) {
                    closeMobileMenu();
                }
            }, 250);
        });
        
    });
    
})(jQuery);
