@extends('layouts.app')

@section('title', 'Book Event - ' . ($event ? ($event->title ?? ucfirst($event->category)) : 'Custom Package'))

@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/booking-redesign.css') }}?v={{ time() }}">

<div class="booking-redesign-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-xl-10">
                @if(session('success'))
                    <!-- Royal Success Message -->
                    <div class="royal-success-container">
                        <div class="royal-success-card animate__animated animate__fadeIn">
                            <div class="royal-success-icon">
                                <i class="fa fa-university"></i>
                            </div>
                            <h2>Reservation Received</h2>
                            <p>Your request for a royal catering experience has been noted. Our heritage consultants will reach out to you within 24 hours to finalize the arrangements.</p>
                            
                            <div class="redirect-info mb-4">
                                <p>Returning to our library in <span id="countdown">5</span> seconds...</p>
                            </div>
                            
                            <a href="{{ route('home') }}" class="btn-royal-submit text-decoration-none">
                                <i class="fa fa-home me-2"></i> Return to Palace
                            </a>
                        </div>
                    </div>
                    
                    <script>
                        let countdown = 5;
                        const countdownEl = document.getElementById('countdown');
                        const timer = setInterval(() => {
                            countdown--;
                            if (countdownEl) countdownEl.textContent = countdown;
                            if (countdown <= 0) {
                                clearInterval(timer);
                                window.location.href = "{{ route('home') }}";
                            }
                        }, 1000);
                    </script>
                @else
                    <!-- Royal Booking Form -->
                    <div class="booking-royal-wrapper animate__animated animate__fadeInUp">
                        <div class="row g-0">
                            <!-- Royal Sidebar -->
                            <div class="col-lg-4">
                                <div class="booking-royal-sidebar">
                                    <div class="sidebar-brand">
                                        <h3>Manam</h3>
                                    </div>
                                    
                                    <div class="event-preview text-center py-4">
                                        @if($event)
                                            @if($event->image)
                                                <div class="mb-3">
                                                    <img src="{{ asset($event->image) }}" alt="{{ $event->title ?? ucfirst($event->category) }}" style="max-width: 100%; border-radius: 4px; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                                                </div>
                                            @endif
                                            <h4 class="text-white mt-2">{{ $event->title ?? ucfirst($event->category) }}</h4>
                                            <span class="badge" style="background: var(--royal-gold); color: #fff;">{{ ucfirst($event->category) }}</span>
                                        @else
                                            <div class="mb-3">
                                                <div class="royal-placeholder-icon" style="font-size: 3rem; color: var(--royal-gold); opacity: 0.5;">
                                                    <i class="fa fa-calendar-check-o"></i>
                                                </div>
                                            </div>
                                            <h4 class="text-white mt-2">Custom Package</h4>
                                            <span class="badge" style="background: var(--royal-gold); color: #fff;">Flexible Catering</span>
                                        @endif
                                    </div>
                                    
                                    <div class="royal-steps-nav">
                                        <div class="royal-step-item active" data-step="1">
                                            <div class="step-number-pill">1</div>
                                            <div class="step-label">
                                                <h5>Inquiry</h5>
                                                <p>Client Details</p>
                                            </div>
                                        </div>
                                        
                                        <div class="royal-step-item" data-step="2">
                                            <div class="step-number-pill">2</div>
                                            <div class="step-label">
                                                <h5>Occasion</h5>
                                                <p>Event Details</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Royal Form Area -->
                            <div class="col-lg-8">
                                <div class="booking-royal-form-area">
                                    <div class="booking-royal-header">
                                        <h2>Royal Reservation</h2>
                                        <p>Curating exceptional flavors for your most precious moments.</p>
                                    </div>
                                    
                                    <!-- Royal Progress Bar -->
                                    <div class="royal-progress-bar">
                                        <div class="royal-progress-fill" id="formProgressBar" style="width: 50%;"></div>
                                    </div>
                                    
                                    <form id="eventBookingForm" method="POST" action="{{ route('events.booking.store') }}">
                                        @csrf
                                        <input type="hidden" name="event_id" value="{{ $event->id ?? '' }}">
                                        
                                        <!-- Step 1: Client Details -->
                                        <div class="form-step active" id="step1">
                                            <div class="row">
                                                <div class="col-md-12 royal-form-group">
                                                    <label for="name" class="royal-form-label">Honored Guest Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control royal-form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                                                </div>
                                                
                                                <div class="col-md-12 royal-form-group">
                                                    <label for="email" class="royal-form-label">Correspondence Email <span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control royal-form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                                                </div>
                                                
                                                <div class="col-md-6 royal-form-group">
                                                    <label for="contact_number" class="royal-form-label">Direct Contact <span class="text-danger">*</span></label>
                                                    <input type="tel" class="form-control royal-form-control @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" placeholder="Phone Number" required>
                                                </div>
                                                
                                                <div class="col-md-6 royal-form-group">
                                                    <label for="country" class="royal-form-label">Region <span class="text-danger">*</span></label>
                                                    <select class="form-select royal-form-control royal-form-select @error('country') is-invalid @enderror" id="country" name="country" required>
                                                        <option value="">Select Region</option>
                                                        <option value="India" selected>India</option>
                                                        <option value="USA">United States</option>
                                                        <option value="UK">United Kingdom</option>
                                                        <option value="Singapore">Singapore</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-actions mt-4">
                                                <a href="{{ route('events') }}" class="btn-royal-back text-decoration-none">
                                                    <i class="fa fa-arrow-left me-2"></i> Gallery
                                                </a>
                                                <button type="button" class="btn-royal-submit" id="nextToStep2">
                                                    Continue to Details <i class="fa fa-arrow-right ms-2"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Step 2: Event Details -->
                                        <div class="form-step" id="step2" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-12 royal-form-group">
                                                    <label for="event_type" class="royal-form-label">Nature of Celebration <span class="text-danger">*</span></label>
                                                    <select class="form-select royal-form-control royal-form-select @error('event_type') is-invalid @enderror" id="event_type" name="event_type" required>
                                                        <option value="">Select Event Type</option>
                                                        <option value="Wedding">Traditional Wedding</option>
                                                        <option value="Corporate Event">Royal Corporate Gathering</option>
                                                        <option value="Celebration">Premier Celebration</option>
                                                        <option value="Social Gathering">Elite Gathering</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-6 royal-form-group">
                                                    <label for="event_date" class="royal-form-label">Date of Occasion <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control royal-form-control @error('event_date') is-invalid @enderror" id="event_date" name="event_date" value="{{ old('event_date') }}" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                                </div>
                                                
                                                <div class="col-md-6 royal-form-group">
                                                    <label for="guest_count" class="royal-form-label">Expected Attendees <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control royal-form-control @error('guest_count') is-invalid @enderror" id="guest_count" name="guest_count" value="{{ old('guest_count') }}" min="1" max="10000" placeholder="Number of guests" required>
                                                </div>
                                                
                                                <!-- <div class="col-md-12 royal-form-group">
                                                    <label class="royal-form-label">Culinary Preference <span class="text-danger">*</span></label>
                                                    <div class="royal-pref-options">
                                                        <div class="royal-pref-card selected" data-input-id="veg" style="width: 100%;">
                                                            <i class="fa fa-leaf"></i>
                                                            <div class="royal-pref-label">Vegetarian</div>
                                                            <input type="radio" name="food_preference" id="veg" value="Vegetarian" style="display:none" checked required>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                
                                                <!-- Food Selection (Integrated in Step 2) -->
                                                <div class="col-md-12 royal-form-group mt-3">
                                                    <label class="royal-form-label">Select Preferred Dishes</label>
                                                    <div class="food-selection-container p-3 border rounded bg-light" style="max-height: 400px; overflow-y: auto;">
                                                        @foreach($categories as $category)
                                                            <div class="category-block mb-3">
                                                                <h6 class="category-title" style="font-size: 0.9rem; text-transform: uppercase;">{{ $category->name }}</h6>
                                                                <div class="food-items-grid">
                                                                    @foreach($category->activeMenuItems as $item)
                                                                        <div class="food-item-pill @if(is_array(old('selected_items')) && in_array($item->name, old('selected_items'))) selected @endif" data-item-name="{{ $item->name }}">
                                                                            <span>{{ $item->name }}</span>
                                                                            <input type="checkbox" name="selected_items[]" value="{{ $item->name }}" style="display:none" @if(is_array(old('selected_items')) && in_array($item->name, old('selected_items'))) checked @endif>
                                                                            <i class="fa fa-plus ms-2"></i>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="col-md-12 royal-form-group">
                                                    <label for="special_requests" class="royal-form-label">Bespoke Requirements</label>
                                                    <textarea class="form-control royal-form-control @error('special_requests') is-invalid @enderror" id="special_requests" name="special_requests" rows="3" style="height: auto;" placeholder="Any dietary restrictions or special royal requests..."></textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="form-actions mt-4">
                                                <button type="button" class="btn-royal-back" id="backToStep1">
                                                    <i class="fa fa-arrow-left me-2"></i> Back
                                                </button>
                                                <button type="submit" class="btn-royal-submit">
                                                    <i class="fa fa-check me-2"></i> Submit Reservation
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- JS specifically for the new UI interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const prefCards = document.querySelectorAll('.royal-pref-card');
    prefCards.forEach(card => {
        card.addEventListener('click', function() {
            const radioId = this.getAttribute('data-input-id');
            const radio = document.getElementById(radioId);
            if (radio) {
                radio.checked = true;
                prefCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
            }
        });
    });
});
</script>


<script src="{{ asset('assets/js/booking-page.js') }}"></script>
@endsection
