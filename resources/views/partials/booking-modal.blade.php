{{-- Event Booking Modal - 2 Step Process --}}
<div id="bookingModal" class="booking-modal" style="display: none;">
    <div class="booking-modal-backdrop"></div>
    <div class="booking-modal-container">
        <button type="button" class="booking-modal-close" id="closeBookingModal">
            <i class="fa fa-times"></i>
        </button>
        
        <div class="booking-modal-content">
            {{-- Left Sidebar - Progress Steps --}}
            <div class="booking-sidebar">
                <div class="booking-brand">
                    <h3>Epicure</h3>
                    <p class="text-success">CATERING EXCELLENCE</p>
                </div>
                
                <div class="booking-steps">
                    <div class="booking-step active" data-step="1">
                        <div class="step-circle">
                            <i class="fa fa-check"></i>
                            <span class="step-number">1</span>
                        </div>
                        <div class="step-info">
                            <h5>STEP 1</h5>
                            <p>Client Details</p>
                        </div>
                    </div>
                    
                    <div class="booking-step" data-step="2">
                        <div class="step-circle">
                            <i class="fa fa-check"></i>
                            <span class="step-number">2</span>
                        </div>
                        <div class="step-info">
                            <h5>STEP 2</h5>
                            <p>Event Details</p>
                        </div>
                    </div>
                </div>
                
                <div class="booking-help">
                    <div class="help-icon">
                        <i class="fa fa-question-circle"></i>
                    </div>
                    <p>Need assistance?</p>
                </div>
            </div>
            
            {{-- Right Content - Form --}}
            <div class="booking-form-area">
                <div class="booking-progress-bar">
                    <div class="progress-text">Finalizing</div>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 50%;" id="formProgressBar">
                            <span id="progressPercentage">50%</span>
                        </div>
                    </div>
                    <div class="progress-actions">
                        <button type="button" class="btn-back-nav">Back</button>
                        <button type="button" class="btn-review-quote">Review Quote</button>
                    </div>
                </div>
                
                <div class="booking-header">
                    <h2 id="modalEventTitle">Menu Selection</h2>
                    <p id="modalEventSubtitle">Curating your bespoke culinary experience</p>
                </div>
                
                <form id="eventBookingForm" method="POST" action="{{ route('events.booking.store') }}">
                    @csrf
                    <input type="hidden" name="event_id" id="bookingEventId" value="">
                    
                    {{-- Step 1: Client Details --}}
                    <div class="form-step active" id="step1">
                        <div class="form-section-title">
                            <h4>Personal Information</h4>
                            <p>Please provide your contact details</p>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-premium" id="name" name="name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-premium" id="email" name="email" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="contact_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control form-control-premium" id="contact_number" name="contact_number" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                <select class="form-select form-control-premium" id="country" name="country" required>
                                    <option value="">Select Country</option>
                                    <option value="India">India</option>
                                    <option value="USA">United States</option>
                                    <option value="UK">United Kingdom</option>
                                    <option value="UAE">United Arab Emirates</option>
                                    <option value="Singapore">Singapore</option>
                                    <option value="Malaysia">Malaysia</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Other">Other</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        
                        <div class="form-actions mt-4">
                            <button type="button" class="btn btn-secondary" id="closeModalBtn">Cancel</button>
                            <button type="button" class="btn btn-success btn-next" id="nextToStep2">
                                Next: Event Details <i class="fa fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                    
                    {{-- Step 2: Event Details --}}
                    <div class="form-step" id="step2" style="display: none;">
                        <div class="form-section-title">
                            <h4>Event Information</h4>
                            <p>Tell us about your event</p>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="event_type" class="form-label">Event Type <span class="text-danger">*</span></label>
                                <select class="form-select form-control-premium" id="event_type" name="event_type" required>
                                    <option value="">Select Event Type</option>
                                    <option value="Wedding">Wedding</option>
                                    <option value="Corporate Event">Corporate Event</option>
                                    <option value="Celebration">Celebration (Birthday, Anniversary)</option>
                                    <option value="Social Gathering">Social Gathering</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="event_date" class="form-label">Event Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control form-control-premium" id="event_date" name="event_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                <div class="invalid-feedback"></div>
                            </div>
                            
                            
                            <div class="col-md-6 mb-3">
                                <label for="guest_count_min" class="form-label">Minimum Guests <span class="text-danger">*</span></label>
                                <input type="number" class="form-control form-control-premium" id="guest_count_min" name="guest_count_min" min="1" max="10000" placeholder="e.g., 50" required>
                                <small class="text-muted">Minimum expected guests</small>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="guest_count_max" class="form-label">Maximum Guests <span class="text-danger">*</span></label>
                                <input type="number" class="form-control form-control-premium" id="guest_count_max" name="guest_count_max" min="1" max="10000" placeholder="e.g., 100" required>
                                <small class="text-muted">Maximum expected guests</small>
                                <div class="invalid-feedback"></div>
                            </div>
                            <input type="hidden" name="guest_count" id="guest_count" value="50">
                            
                            <div class="col-md-12 mb-3">
                                <label for="special_requests" class="form-label">Special Requests</label>
                                <textarea class="form-control form-control-premium" id="special_requests" name="special_requests" rows="4" placeholder="Any dietary restrictions, preferences, or special requirements..."></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        
                        <div class="form-actions mt-4">
                            <button type="button" class="btn btn-outline-secondary" id="backToStep1">
                                <i class="fa fa-arrow-left me-2"></i> Back
                            </button>
                            <button type="submit" class="btn btn-success" id="submitBooking">
                                <i class="fa fa-check me-2"></i> Submit Booking Request
                            </button>
                        </div>
                    </div>
                </form>
                
                {{-- Success Message --}}
                <div class="booking-success" id="bookingSuccess" style="display: none;">
                    <div class="success-icon">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <h3>Booking Request Submitted!</h3>
                    <p>Thank you for choosing Manam Catering Service. We have received your booking request and will contact you shortly to confirm the details.</p>
                    <button type="button" class="btn btn-success" id="closeSuccessBtn">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Include Booking Form CSS & JS --}}
<link rel="stylesheet" href="{{ asset('assets/css/booking-form.css') }}">
<script src="{{ asset('assets/js/booking-form.js') }}"></script>
