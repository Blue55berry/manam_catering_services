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
                                    @if($errors->any())
                                        <div class="alert alert-danger mx-4 mt-4 mb-0">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    
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
                                                    <label for="event_type" class="royal-form-label">CUISINE / CULTURAL PREFERENCE <span class="text-danger">*</span></label>
                                                    <select class="form-select royal-form-control royal-form-select @error('event_type') is-invalid @enderror" id="event_type" name="event_type" required>
                                                        <option value="">Select service style...</option>
                                                        <option value="Wedding">Traditional Wedding</option>
                                                        <option value="Corporate Event">Royal Corporate Gathering</option>
                                                        <option value="Celebration">Premier Celebration</option>
                                                        <option value="Social Gathering">Elite Gathering</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-6 royal-form-group">
                                                    <label for="event_date" class="royal-form-label">DATE OF OCCASION <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control royal-form-control @error('event_date') is-invalid @enderror" id="event_date" name="event_date" value="{{ old('event_date') }}" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                                </div>
                                                
                                                <div class="col-md-6 royal-form-group">
                                                    <label for="guest_count" class="royal-form-label">EXPECTED ATTENDEES <span class="text-danger">*</span></label>
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
                                                    <label class="royal-form-label">Select Catering Package <span class="text-danger">*</span></label>
                                                    <input type="hidden" name="package_id" id="selectedPackageId" required>
                                                    <input type="hidden" name="food_preference" id="selectedFoodPreference" required>
                                                    
                                                    <div class="package-grid-container">
                                                        <div class="row g-3">
                                                            @foreach($packages as $package)
                                                                <div class="col-md-6 col-lg-6">
                                                                    <div class="package-card h-100" data-package-id="{{ $package->id }}" data-package-index="{{ $loop->index }}">
                                                                        <div class="package-header">
                                                                            <div class="d-flex justify-content-between align-items-start">
                                                                                <div>
                                                                                    <h5 class="package-title mb-1">{{ $package->name }}</h5>
                                                                                    @if($package->type === 'Veg')
                                                                                        <span class="badge bg-success">Vegetarian</span>
                                                                                    @elseif($package->type === 'Non-Veg')
                                                                                        <span class="badge bg-danger">Non-Veg</span>
                                                                                    @else
                                                                                        <span class="badge bg-warning text-dark">Mixed</span>
                                                                                    @endif
                                                                                </div>
                                                                                <div class="package-price text-end">
                                                                                    <span class="amount">₹{{ number_format($package->price, 0) }}</span>
                                                                                    <small class="d-block text-muted">per guest</small>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="package-body">
                                                                            <p class="small text-muted mb-3">{{ $package->description }}</p>
                                                                            @if(!empty($package->features))
                                                                                <ul class="package-features list-unstyled small mb-3">
                                                                                    @foreach(array_slice($package->features, 0, 4) as $feature)
                                                                                        <li class="mb-1"><i class="fa fa-check-circle text-success me-2"></i>{{ $feature }}</li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            @endif
                                                                        </div>
                                                                        <div class="package-footer mt-auto pt-3 border-top d-flex justify-content-between">
                                                                            <button type="button" class="btn btn-sm btn-outline-primary view-package-details" data-package-index="{{ $loop->index }}">
                                                                                <i class="fa fa-eye"></i> View Menu
                                                                            </button>
                                                                            <button type="button" class="btn btn-sm btn-primary select-package-btn">
                                                                                Select
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div id="packageError" class="text-danger small mt-2" style="display:none;">Please select a package</div>
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

<!-- Premium Package Modal -->
<div class="modal fade modal-premium" id="packageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex flex-column align-items-center text-center">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <span class="modal-premium-label mb-2">SELECTED PACKAGE</span>
                <div class="modal-premium-icon mb-3">
                    <i class="fa fa-trophy"></i>
                </div>
                <h2 class="modal-premium-title" id="modalPackageName">Package Name</h2>
            </div>
            
            <div class="modal-premium-body">
                <div class="modal-premium-quote">
                    "An elevated dining experience featuring a curated selection of gourmet delicacies."
                </div>
                
                <div class="modal-menu-grid" id="modalPackageMenu">
                    <!-- Dynamic Menu Content -->
                </div>
            </div>
            
            <div class="modal-premium-footer">
                <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-pill" data-bs-dismiss="modal">CLOSE</button>
                <button type="button" class="btn btn-success px-4 py-2 rounded-pill" id="modalSelectBtn" style="background-color: var(--royal-green); border: none;">
                    <i class="fa fa-check-circle me-2"></i> SELECT THIS PACKAGE
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Pass packages data to JS
    const packagesData = @json($packages);
</script>

<!-- JS specifically for the new UI interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const packageCards = document.querySelectorAll('.package-card');
    const packageInput = document.getElementById('selectedPackageId');
    const foodPreferenceInput = document.getElementById('selectedFoodPreference');
    const packageModal = new bootstrap.Modal(document.getElementById('packageModal'));
    
    // Select Package Logic
    function selectPackage(id) {
        // Update Inputs
        packageInput.value = id;
        
        // Find package data to set food preference
        const pkg = packagesData.find(p => p.id == id);
        if(pkg) {
            foodPreferenceInput.value = pkg.type;
        }
        
        // Update UI
        packageCards.forEach(card => {
            if(card.dataset.packageId == id) {
                card.classList.add('selected', 'border-primary', 'bg-light');
                const btn = card.querySelector('.select-package-btn');
                btn.textContent = 'Selected';
                btn.classList.replace('btn-primary', 'btn-success');
            } else {
                card.classList.remove('selected', 'border-primary', 'bg-light');
                const btn = card.querySelector('.select-package-btn');
                btn.textContent = 'Select';
                btn.classList.replace('btn-success', 'btn-primary');
            }
        });
        
        // Hide error if visible
        const packageError = document.getElementById('packageError');
        if(packageError) packageError.style.display = 'none';
        
        // Close modal if open
        // packageModal.hide(); // Allow user to verify selection in modal
    }

    // Card Click Event (Delegated)
    packageCards.forEach(card => {
        const selectBtn = card.querySelector('.select-package-btn');
        const viewBtn = card.querySelector('.view-package-details');
        
        if(selectBtn) {
            selectBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                selectPackage(card.dataset.packageId);
            });
        }
        
        if(viewBtn) {
            viewBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                openPackageModal(card.dataset.packageIndex);
            });
        }

        // Make whole card clickable
        card.addEventListener('click', function(e) {
             if(!e.target.closest('button')) {
                 selectPackage(this.dataset.packageId);
             }
        });
    });

    // Modal Logic
    function openPackageModal(index) {
        const pkg = packagesData[index];
        if(!pkg) return;

        document.getElementById('modalPackageName').textContent = pkg.name;
        
        // Helper to get icons based on category name
        const getCategoryIcon = (categoryName) => {
            const lowerCat = categoryName.toLowerCase();
            if (lowerCat.includes('starter') || lowerCat.includes('appetizer')) return 'fa-cutlery';
            if (lowerCat.includes('main') || lowerCat.includes('rice') || lowerCat.includes('bread')) return 'fa-fire';
            if (lowerCat.includes('dessert') || lowerCat.includes('sweet')) return 'fa-birthday-cake';
            if (lowerCat.includes('beverage') || lowerCat.includes('drink')) return 'fa-glass';
            if (lowerCat.includes('salad')) return 'fa-leaf';
            if (lowerCat.includes('soup')) return 'fa-spoon';
            return 'fa-circle-o';
        };

        // Menu Content
        const menuContainer = document.getElementById('modalPackageMenu');
        menuContainer.innerHTML = '';
        
        if(pkg.menu_content && pkg.menu_content.length > 0) {
            pkg.menu_content.forEach(cat => {
                const iconClass = getCategoryIcon(cat.category);
                
                let itemsHtml = '<ul class="modal-menu-list">';
                if(cat.items) {
                    cat.items.forEach(item => {
                        itemsHtml += `<li class="modal-menu-item">${item}</li>`;
                    });
                }
                itemsHtml += '</ul>';
                
                menuContainer.innerHTML += `
                    <div class="modal-menu-category">
                        <div class="modal-menu-cat-header">
                            <i class="fa ${iconClass} modal-menu-cat-icon"></i>
                            <h5 class="modal-menu-cat-title">${cat.category}</h5>
                        </div>
                        ${itemsHtml}
                    </div>
                `;
            });
        } else {
             menuContainer.innerHTML = '<p class="text-muted text-center w-100 fst-italic">Menu composition details available upon request.</p>';
        }

        // Select Button in Modal
        const modalBtn = document.getElementById('modalSelectBtn');
        // Remove old listeners to prevent multiple firings if re-opened
        const newBtn = modalBtn.cloneNode(true);
        modalBtn.parentNode.replaceChild(newBtn, modalBtn);
        
        newBtn.onclick = function() {
            selectPackage(pkg.id);
            packageModal.hide();
        };

        packageModal.show();
    }
});
</script>

<style>
/* Package Card Styles specifically for this page */
.package-card {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #fff;
}
.package-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    border-color: var(--royal-gold);
}
.package-card.selected {
    border: 2px solid var(--royal-gold);
    background-color: #fdfbf7;
}
.package-title {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
}
.amount {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--royal-gold);
}
</style>

<script src="{{ asset('assets/js/booking-page.js') }}"></script>
@endsection
