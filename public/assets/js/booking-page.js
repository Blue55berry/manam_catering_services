/**
 * Event Booking Page - JavaScript
 * Handles 2-step form navigation on separate page
 */

(function () {
    'use strict';

    // DOM Elements
    const form = document.getElementById('eventBookingForm');
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const nextBtnStep2 = document.getElementById('nextToStep2');
    const backBtnStep1 = document.getElementById('backToStep1');
    const progressBar = document.getElementById('formProgressBar');

    // State
    let currentStep = 1;

    /**
     * Initialize event listeners
     */
    function init() {
        if (!form) return;

        // Navigation buttons
        if (nextBtnStep2) nextBtnStep2.addEventListener('click', goToStep2);
        if (backBtnStep1) backBtnStep1.addEventListener('click', goToStep1);

        // Preference Card Selection
        setupPreferenceCards();

        // Food Item Pill Selection
        setupFoodItemPills();

        // Real-time validation
        setupRealTimeValidation();
    }

    /**
     * Navigate to Step 2
     */
    function goToStep2(e) {
        if (e) e.preventDefault();
        if (!validateStep1()) return;
        currentStep = 2;
        updateStepDisplay();
    }

    /**
     * Navigate to Step 1
     */
    function goToStep1(e) {
        if (e) e.preventDefault();
        currentStep = 1;
        updateStepDisplay();
    }

    /**
     * Update step display
     */
    function updateStepDisplay() {
        if (step1) step1.style.display = currentStep === 1 ? 'block' : 'none';
        if (step2) step2.style.display = currentStep === 2 ? 'block' : 'none';

        // Update progress bar
        const progress = currentStep === 1 ? 50 : 100;

        if (progressBar) {
            progressBar.style.width = progress + '%';
        }

        // Update sidebar steps
        document.querySelectorAll('.royal-step-item').forEach((step, index) => {
            const stepNumber = index + 1;
            step.classList.remove('active', 'completed');
            if (stepNumber < currentStep) {
                step.classList.add('completed');
            } else if (stepNumber === currentStep) {
                step.classList.add('active');
            }
        });

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    /**
     * Setup Royal Preference Card Selection
     */
    function setupPreferenceCards() {
        const cards = document.querySelectorAll('.royal-pref-card');
        cards.forEach(card => {
            card.addEventListener('click', function () {
                const inputId = this.dataset.inputId;
                const input = document.getElementById(inputId);
                if (input) {
                    input.checked = true;
                    cards.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                }
            });
        });
    }

    /**
     * Setup Food Item Pill Selection
     */
    function setupFoodItemPills() {
        const pills = document.querySelectorAll('.food-item-pill');
        pills.forEach(pill => {
            pill.addEventListener('click', function () {
                const checkbox = this.querySelector('input[type="checkbox"]');
                const icon = this.querySelector('i');

                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    if (checkbox.checked) {
                        this.classList.add('selected');
                        if (icon) icon.className = 'fa fa-check ms-2';
                    } else {
                        this.classList.remove('selected');
                        if (icon) icon.className = 'fa fa-plus ms-2';
                    }
                }
            });
        });
    }

    /**
     * Validate Step 1
     */
    function validateStep1() {
        let isValid = true;
        clearValidationErrors();
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const contact = document.getElementById('contact_number');
        const country = document.getElementById('country');

        if (!name?.value.trim()) { showError(name, 'Name is required'); isValid = false; }
        if (!email?.value.trim() || !isValidEmail(email.value)) { showError(email, 'Valid email is required'); isValid = false; }
        if (!contact?.value.trim()) { showError(contact, 'Contact is required'); isValid = false; }
        if (!country?.value) { showError(country, 'Please select region'); isValid = false; }

        return isValid;
    }

    /**
     * Validate Step 2
     */
    function validateStep2() {
        let isValid = true;
        clearValidationErrors();
        const eventType = document.getElementById('event_type');
        const eventDate = document.getElementById('event_date');
        const guestCount = document.getElementById('guest_count');
        const pref = document.querySelector('input[name="food_preference"]:checked');

        if (!eventType?.value) { showError(eventType, 'Event type is required'); isValid = false; }
        if (!eventDate?.value) { showError(eventDate, 'Event date is required'); isValid = false; }
        if (!guestCount?.value || guestCount.value < 1) { showError(guestCount, 'Valid guest count required'); isValid = false; }

        if (!pref) {
            const prefContainer = document.querySelector('.royal-pref-options');
            if (prefContainer) {
                const errorMsg = document.createElement('div');
                errorMsg.className = 'text-danger mt-2 small';
                errorMsg.textContent = 'Please select a culinary preference';
                prefContainer.parentNode.appendChild(errorMsg);
                isValid = false;
            }
        }

        return isValid;
    }

    /**
     * Show validation error
     */
    function showError(element, message) {
        if (!element) return;

        element.classList.add('is-invalid');
        const feedback = element.nextElementSibling;
        if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.textContent = message;
        } else {
            // Create feedback element if it doesn't exist
            const newFeedback = document.createElement('div');
            newFeedback.className = 'invalid-feedback';
            newFeedback.textContent = message;
            element.parentNode.insertBefore(newFeedback, element.nextSibling);
        }
    }

    /**
     * Clear all validation errors
     */
    function clearValidationErrors() {
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
    }

    /**
     * Setup real-time validation
     */
    function setupRealTimeValidation() {
        const inputs = document.querySelectorAll('.form-control, .form-select');
        inputs.forEach(input => {
            input.addEventListener('blur', function () {
                if (this.classList.contains('is-invalid')) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    }

    /**
     * Email validation helper
     */
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
