/**
 * Event Booking Form - JavaScript
 * Handles 2-step form navigation, validation, and AJAX submission
 */

(function () {
    'use strict';

    // DOM Elements
    const modal = document.getElementById('bookingModal');
    const closeModalBtn = document.getElementById('closeBookingModal');
    const closeModalBtnAlt = document.getElementById('closeModalBtn');
    const closeSuccessBtn = document.getElementById('closeSuccessBtn');
    const bookEventButtons = document.querySelectorAll('.btn-book-event');
    const form = document.getElementById('eventBookingForm');
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const nextBtn = document.getElementById('nextToStep2');
    const backBtn = document.getElementById('backToStep1');
    const progressBar = document.getElementById('formProgressBar');
    const progressPercentage = document.getElementById('progressPercentage');
    const successMessage = document.getElementById('bookingSuccess');
    const eventIdInput = document.getElementById('bookingEventId');
    const modalTitle = document.getElementById('modalEventTitle');
    const modalSubtitle = document.getElementById('modalEventSubtitle');

    // State
    let currentStep = 1;
    let formData = {};

    /**
     * Initialize event listeners
     */
    function init() {
        // Open modal on book event button click
        bookEventButtons.forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const eventId = this.dataset.eventId;
                const eventTitle = this.dataset.eventTitle;
                const eventCategory = this.dataset.eventCategory;
                openModal(eventId, eventTitle, eventCategory);
            });
        });

        // Close modal
        if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
        if (closeModalBtnAlt) closeModalBtnAlt.addEventListener('click', closeModal);
        if (closeSuccessBtn) closeSuccessBtn.addEventListener('click', closeModal);

        // Close on backdrop click
        modal?.addEventListener('click', function (e) {
            if (e.target === modal || e.target.classList.contains('booking-modal-backdrop')) {
                closeModal();
            }
        });

        // Navigation buttons
        if (nextBtn) nextBtn.addEventListener('click', goToStep2);
        if (backBtn) backBtn.addEventListener('click', goToStep1);

        // Form submission
        if (form) form.addEventListener('submit', handleFormSubmit);

        // Real-time validation
        setupRealTimeValidation();
    }

    /**
     * Open booking modal
     */
    function openModal(eventId, eventTitle, eventCategory) {
        if (eventIdInput) eventIdInput.value = eventId || '';
        if (modalTitle) modalTitle.textContent = `Book ${eventTitle}`;
        if (modalSubtitle) modalSubtitle.textContent = `Reserve your ${eventCategory} catering experience`;

        resetForm();
        currentStep = 1;
        updateStepDisplay();
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    /**
     * Close booking modal
     */
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = '';
        resetForm();
    }

    /**
     * Reset form to initial state
     */
    function resetForm() {
        if (form) form.reset();
        currentStep = 1;
        formData = {};
        clearValidationErrors();
        if (successMessage) successMessage.style.display = 'none';
        if (step1) step1.style.display = 'block';
        if (step2) step2.style.display = 'none';
        updateStepDisplay();
    }

    /**
     * Navigate to Step 2
     */
    function goToStep2(e) {
        e.preventDefault();

        // Validate Step 1
        if (!validateStep1()) {
            return;
        }

        // Save Step 1 data
        saveStepData(1);

        // Show Step 2
        currentStep = 2;
        updateStepDisplay();
    }

    /**
     * Navigate to Step 1
     */
    function goToStep1(e) {
        e.preventDefault();

        // Save Step 2 data
        saveStepData(2);

        // Show Step 1
        currentStep = 1;
        updateStepDisplay();
    }

    /**
     * Update step display (show/hide steps & progress)
     */
    function updateStepDisplay() {
        // Update step visibility
        if (step1 && step2) {
            step1.style.display = currentStep === 1 ? 'block' : 'none';
            step2.style.display = currentStep === 2 ? 'block' : 'none';
        }

        // Update progress bar
        const progress = currentStep === 1 ? 50 : 100;
        if (progressBar) {
            progressBar.style.width = progress + '%';
        }
        if (progressPercentage) {
            progressPercentage.textContent = progress + '%';
        }

        // Update sidebar steps
        document.querySelectorAll('.booking-step').forEach((step, index) => {
            const stepNumber = index + 1;
            step.classList.remove('active', 'completed');

            if (stepNumber < currentStep) {
                step.classList.add('completed');
            } else if (stepNumber === currentStep) {
                step.classList.add('active');
            }
        });

        // Scroll to top
        const formArea = document.querySelector('.booking-form-area');
        if (formArea) formArea.scrollTop = 0;
    }

    /**
     * Save current step data to formData object
     */
    function saveStepData(step) {
        const stepElement = document.getElementById(`step${step}`);
        if (!stepElement) return;

        const inputs = stepElement.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            if (input.name) {
                formData[input.name] = input.value;
            }
        });
    }

    /**
     * Validate Step 1 fields
     */
    function validateStep1() {
        let isValid = true;
        clearValidationErrors();

        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const contactNumber = document.getElementById('contact_number');
        const country = document.getElementById('country');

        // Name validation
        if (!name?.value.trim()) {
            showError(name, 'Please enter your full name');
            isValid = false;
        }

        // Email validation
        if (!email?.value.trim()) {
            showError(email, 'Please enter your email address');
            isValid = false;
        } else if (!isValidEmail(email.value)) {
            showError(email, 'Please enter a valid email address');
            isValid = false;
        }

        // Contact number validation
        if (!contactNumber?.value.trim()) {
            showError(contactNumber, 'Please enter your phone number');
            isValid = false;
        }

        // Country validation
        if (!country?.value) {
            showError(country, 'Please select your country');
            isValid = false;
        }

        return isValid;
    }

    /**
     * Validate Step 2 fields
     */
    function validateStep2() {
        let isValid = true;
        clearValidationErrors();

        const eventType = document.getElementById('event_type');
        const eventDate = document.getElementById('event_date');
        const guestCountMin = document.getElementById('guest_count_min');
        const guestCountMax = document.getElementById('guest_count_max');
        const guestCount = document.getElementById('guest_count');

        // Event type validation
        if (!eventType?.value) {
            showError(eventType, 'Please select an event type');
            isValid = false;
        }

        // Event date validation
        if (!eventDate?.value) {
            showError(eventDate, 'Please select an event date');
            isValid = false;
        } else {
            const selectedDate = new Date(eventDate.value);
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            tomorrow.setHours(0, 0, 0, 0);

            if (selectedDate < tomorrow) {
                showError(eventDate, 'Event date must be at least tomorrow');
                isValid = false;
            }
        }

        // Min guest validation
        if (!guestCountMin?.value) {
            showError(guestCountMin, 'Please enter minimum expected guests');
            isValid = false;
        } else if (parseInt(guestCountMin.value) < 1) {
            showError(guestCountMin, 'Minimum guests must be at least 1');
            isValid = false;
        }

        // Max guest validation
        if (!guestCountMax?.value) {
            showError(guestCountMax, 'Please enter maximum expected guests');
            isValid = false;
        } else if (parseInt(guestCountMax.value) < 1) {
            showError(guestCountMax, 'Maximum guests must be at least 1');
            isValid = false;
        } else if (parseInt(guestCountMax.value) < parseInt(guestCountMin.value || 0)) {
            showError(guestCountMax, 'Maximum guests must be greater than or equal to minimum guests');
            isValid = false;
        }

        // Calculate average for hidden field
        if (guestCountMin?.value && guestCountMax?.value && isValid) {
            const min = parseInt(guestCountMin.value);
            const max = parseInt(guestCountMax.value);
            const average = Math.round((min + max) / 2);
            if (guestCount) guestCount.value = average;
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
            feedback.style.display = 'block';
        }
    }

    /**
     * Clear all validation errors
     */
    function clearValidationErrors() {
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.style.display = 'none';
        });
    }

    /**
     * Setup real-time validation
     */
    function setupRealTimeValidation() {
        const inputs = document.querySelectorAll('.form-control-premium, .form-select');
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

    /**
     * Handle form submission
     */
    function handleFormSubmit(e) {
        e.preventDefault();

        // Validate Step 2
        if (!validateStep2()) {
            return;
        }

        // Submit via AJAX
        submitFormAjax();
    }

    /**
     * Submit form via AJAX
     */
    function submitFormAjax() {
        const formData = new FormData(form);
        const submitBtn = document.getElementById('submitBooking');

        // Disable submit button
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i> Submitting...';
        }

        fetch(form.action.replace('/booking', '/booking/ajax'), {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Hide form, show success message
                    if (step1) step1.style.display = 'none';
                    if (step2) step2.style.display = 'none';
                    if (successMessage) successMessage.style.display = 'block';
                } else {
                    // Show errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(fieldName => {
                            const field = document.getElementById(fieldName);
                            if (field) {
                                showError(field, data.errors[fieldName][0]);
                            }
                        });
                    }
                    alert('There was an error submitting your booking. Please check the form and try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while submitting your booking. Please try again.');
            })
            .finally(() => {
                // Re-enable submit button
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fa fa-check me-2"></i> Submit Booking Request';
                }
            });
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
