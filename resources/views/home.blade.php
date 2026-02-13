@extends('layouts.app')

@section('title', 'Manam Catering Service - Authentic South Indian Hospitality')

@section('content')

<!-- Hero Carousel Section -->
<div id="heroCarousel" class="carousel slide hero-carousel-wrapper" data-bs-ride="carousel" data-bs-interval="3000">
    <!-- Carousel Indicators -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>

    <!-- Carousel Items -->
    <div class="carousel-inner">
        @foreach($heroBanners as $key => $banner)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <div class="hero-section" style="background-image: url('{{ asset($banner->image) }}');">
                    <div class="hero-overlay"></div>
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="hero-content">
                                    <p class="hero-subtitle">{{ $banner->subtitle }}</p>
                                    <h1 class="hero-title">{!! nl2br(e($banner->title)) !!}</h1>
                                    <p class="hero-description text-white">
                                        {{ $banner->description }}
                                    </p>
                                    <div class="hero-buttons">
                                        @if($banner->button_text_1)
                                            <a href="{{ $banner->button_link_1 ?? '#' }}" class="btn btn-primary-dakshin">{{ $banner->button_text_1 }}</a>
                                        @endif
                                        @if($banner->button_text_2)
                                            <a href="{{ $banner->button_link_2 ?? '#' }}" class="btn btn-outline-dakshin">{{ $banner->button_text_2 }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Carousel Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Culinary Excellence Section -->
<style>
    .culinary-section {
        position: relative;
        background-color: #FAFAF5; /* Ensure base color is present */
        z-index: 1;
        overflow: hidden;
    }
    
    .culinary-section::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset("assets/images/bg-leaf.svg") }}'); 
        background-size: 60px 60px;
        background-repeat: repeat;
        opacity: 0.4; /* Increased opacity */
        z-index: -1; 
        pointer-events: none;
        animation: leafVerticalAnim 3s linear infinite; /* Vertical Animation */
    }
    
    /* Ensure the content is above the background */
    .culinary-section .container {
        position: relative;
        z-index: 10;
    }
    
    /* Ensure the top border gradient is visible */
    .culinary-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 10px;
        background: linear-gradient(to right, #1B4D3E, #DAA520, #1B4D3E);
        z-index: 20;
    }

    @keyframes leafVerticalAnim {
        0% { background-position: 0 0; }
        100% { background-position: 0 60px; } /* Vertical loop */
    }

    /* Forced Overrides for Royal Paper Look */
    .gallery-item.card-effect {
        background-color: #FDF5E6 !important; /* Old Lace / Parchment */
        border: 1px solid rgba(218, 165, 32, 0.2) !important; /* Subtle Gold Border */
    }
    .card-details {
        background-color: #FDF5E6 !important;
        transition: background 0.3s ease;
    }
    .curve-shape {
        background-color: #FDF5E6 !important; /* Match card background */
        transition: background-color 0.3s ease;
    }
    
    /* Hover Effects with Premium Gradient */
    .gallery-item.card-effect:hover .card-details {
        /* Premium Gradient from Bottom */
        background: linear-gradient(to top, #ffeac2 0%, #FDF5E6 80%) !important; 
    }
    
    /* Keep curve shape and item background consistent with the top of the gradient */
    .gallery-item.card-effect:hover,
    .gallery-item.card-effect:hover .curve-shape {
        background-color: #FDF5E6 !important; 
    }

    .card-text {
        font-size: 0.85rem !important;
        line-height: 1.6;
    }
</style>
<div class="culinary-section" id="heritage" style="background-color: #FAFAF5;">
    <div class="container">
        <div class="section-title-wrapper text-center mb-5">
            <p class="section-subtitle text-gold fw-bold text-uppercase tracking-widest mb-2">A Legacy of Taste</p>
            <h2 class="section-title display-4 fw-bold mb-3" style="font-family: 'Playfair Display', serif;">The Dakshin Royal Feast</h2>
            <div class="separator-line mx-auto mb-4" style="width: 100px; height: 3px; background: linear-gradient(90deg, transparent, #DAA520, transparent);"></div>
            <p class="section-description text-muted mb-4 mx-auto" style="max-width: 700px; font-size: 1.1rem; line-height: 1.8;">
                Embark on a culinary journey where the grandeur of the Chola heritage meets the finesse of modern gastronomy. Each dish is a masterpiece, crafted with time-honored recipes and distinct spice blends.
            </p>
            <a href="{{ route('menu') }}" class="btn btn-outline-dark rounded-pill px-4 py-2 text-uppercase fw-bold royal-hover-fix" style="border-color: #DAA520; color: #1B4D3E; letter-spacing: 1px;">
                Explore Royal Menu
            </a>
        </div>

        <div class="gallery-grid">
             <!-- Grid Item 1 -->
             <div class="gallery-item card-effect">
                <div class="card-img-block">
                    <img src="{{ asset('assets/images/food/filter-coffee.jpg.png') }}" alt="Filter Coffee">
                    <div class="curve-shape"></div>
                </div>
                <div class="card-details">
                    <h4 class="card-title">Brass Filter Kaapi</h4>
                    <p class="card-text">The soul of South India, slow-brewed and served frothy in traditional brass.</p>
                    <a href="{{ route('menu') }}" class="card-btn">View Details</a>
                </div>
            </div>
            <!-- Grid Item 2 -->
            <div class="gallery-item card-effect">
                <div class="card-img-block">
                    <img src="{{ asset('assets/images/food/sweets-platter.jpg.png') }}" alt="Rasamalai & Sweets">
                    <div class="curve-shape"></div>
                </div>
                <div class="card-details">
                    <h4 class="card-title">Divine Rasamalai & Halwa</h4>
                    <p class="card-text">Rich, ghee-laden sweets crafted with saffron, pistachios and traditional finesse.</p>
                    <a href="{{ route('menu') }}" class="card-btn">View Details</a>
                </div>
            </div>
             <!-- Grid Item 3 -->
             <div class="gallery-item card-effect">
                <div class="card-img-block">
                    <img src="{{ asset('assets/images/food/variety-rice.jpg.png') }}" alt="Variety Rice">
                    <div class="curve-shape"></div>
                </div>
                <div class="card-details">
                    <h4 class="card-title">Royal Variety Rice Collection</h4>
                    <p class="card-text">Lemon, coconut, tamarind and curd rice - each a masterpiece of South Indian tradition.</p>
                    <a href="{{ route('menu') }}" class="card-btn">View Details</a>
                </div>
            </div>
             <!-- Grid Item 4 -->
             <div class="gallery-item card-effect">
                <div class="card-img-block">
                    <img src="{{ asset('assets/images/food/grand-thali.jpg.png') }}" alt="Grand Thali">
                    <div class="curve-shape"></div>
                </div>
                <div class="card-details">
                    <h4 class="card-title">The Grand Banana Leaf Thali</h4>
                    <p class="card-text">A majestic platter featuring a symphony of over 20 authentic South Indian dishes.</p>
                    <a href="{{ route('menu') }}" class="card-btn">View Details</a>
                </div>
            </div>
             <!-- Grid Item 5 -->
             <div class="gallery-item card-effect">
                <div class="card-img-block">
                    <img src="{{ asset('assets/images/food/samosa.jpg.png') }}" alt="Mini Veg Samosa">
                    <div class="curve-shape"></div>
                </div>
                <div class="card-details">
                    <h4 class="card-title">Mini Veg Samosa</h4>
                    <p class="card-text">Golden triangles of flaky pastry with aromatic vegetable filling, served with chutneys.</p>
                    <a href="{{ route('menu') }}" class="card-btn">View Details</a>
                </div>
            </div>
             <!-- Grid Item 6 -->
             <div class="gallery-item card-effect">
                <div class="card-img-block">
                    <img src="{{ asset('assets/images/food/mysore-bonda.jpg.png') }}" alt="Mysore Bonda">
                    <div class="curve-shape"></div>
                </div>
                <div class="card-details">
                    <h4 class="card-title">Mysore Bonda</h4>
                    <p class="card-text">Golden fried dumplings served with coconut chutney and traditional accompaniments.</p>
                    <a href="{{ route('menu') }}" class="card-btn">View Details</a>
                </div>
            </div>
             <!-- Grid Item 7 -->
             <div class="gallery-item card-effect">
                <div class="card-img-block">
                    <img src="{{ asset('assets/images/food/masala-dosa.jpg.png') }}" alt="Butter Masala Dosa">
                    <div class="curve-shape"></div>
                </div>
                <div class="card-details">
                    <h4 class="card-title">Butter Masala Dosa</h4>
                    <p class="card-text">Crisp, golden crepe roasted in pure ghee, filled with spiced potato masala.</p>
                    <a href="{{ route('menu') }}" class="card-btn">View Details</a>
                </div>
            </div>
             <!-- Grid Item 8 -->
             <div class="gallery-item card-effect">
                <div class="card-img-block">
                    <img src="{{ asset('assets/images/food/chettinad-curry.jpg.png') }}" alt="Chettinad Curry">
                    <div class="curve-shape"></div>
                </div>
                <div class="card-details">
                    <h4 class="card-title">Chettinad Vegetable Curry</h4>
                    <p class="card-text">A fiery, flavorful curry slow-cooked with fresh vegetables and roasted spices.</p>
                    <a href="{{ route('menu') }}" class="card-btn">View Details</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<style>
    /* Complete Royal Redesign for Feature Cards */
    .feature-card {
        background: #FFFDF5 !important; /* Milder Royal Parchment */
        border: 1px solid rgba(218, 165, 32, 0.4) !important;
        border-radius: 8px !important;
        padding: 40px 30px !important;
        position: relative !important;
        overflow: hidden !important;
        /* The Royal Red Touch - Bottom Gradient Bar */
        border-bottom: 5px solid transparent !important;
        border-image: linear-gradient(to right, #800000, #DAA520, #800000) 1 !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3) !important;
        height: 100%;
        text-align: center;
    }

    /* Decorative Top Line */
    .feature-card::before {
        content: '';
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        bottom: 10px;
        border: 1px solid rgba(218, 165, 32, 0.2);
        pointer-events: none;
    }

    /* Icon Styling */
    .feature-icon {
        background: transparent !important;
        width: auto !important;
        height: auto !important;
        font-size: 3rem !important;
        color: #DAA520 !important;
        margin: 0 auto 25px auto !important;
        display: inline-block !important;
        position: relative;
        z-index: 2;
        text-shadow: 0 2px 5px rgba(218, 165, 32, 0.2);
    }
    
    /* Title Styling */
    .feature-title {
        font-family: 'Playfair Display', serif !important;
        font-size: 1.5rem !important;
        color: #800000 !important; /* Royal Maroon/Red text */
        margin-bottom: 15px !important;
        font-weight: 700 !important;
        letter-spacing: 0.5px;
    }

    /* Text Styling */
    .feature-text {
        font-family: 'Inter', sans-serif !important;
        font-size: 0.95rem !important;
        color: #555 !important;
        line-height: 1.7 !important;
    }
    
    /* Hover Effect - Subtle Lift */
    .feature-card:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 15px 40px rgba(0,0,0,0.4) !important;
        transition: all 0.4s ease !important;
    }
</style>
<div class="features-section">
    <div class="container">
        <div class="section-title-wrapper text-center mb-5">
            <p class="section-subtitle text-gold fw-bold text-uppercase tracking-widest mb-2">The Dakshin Promise</p>
            <h2 class="section-title display-5 fw-bold text-white mb-3" style="font-family: 'Playfair Display', serif;">The Pillars of Royal Dining</h2>
            <div class="separator-line mx-auto mb-4" style="width: 80px; height: 3px; background: #DAA520;"></div>
        </div>
        
        <div class="row">
            <!-- Feature 1 -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="60" height="60" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M32 6C32 6 22 14 22 26V58H28V36H36V58H42V26C42 14 32 6 32 6Z" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M14 6V30C14 30 14 36 22 36" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M50 6V30C50 30 50 36 42 36" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M18 58V36" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M46 58V36" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Bespoke Curation</h3>
                    <p class="feature-text">Menus crafted with royal precision, selecting only the finest ancestral recipes for your grand occasion.</p>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="60" height="60" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M32 58V40" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 40C16 32 20 28 20 18C20 10 32 6 32 6C32 6 44 10 44 18C44 28 48 32 48 40" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 40H48" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Masterful Preparation</h3>
                    <p class="feature-text">Artisan chefs employing age-old techniques to create textures and flavors that define heritage dining.</p>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="60" height="60" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 14H44V34C44 42.8 36.8 50 28 50C19.2 50 12 42.8 12 34V14Z" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M44 20H48C51.3 20 54 22.7 54 26C54 29.3 51.3 32 48 32H44" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 56H48" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22 6L24 10" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M34 6L32 10" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Heritage Brewing</h3>
                    <p class="feature-text">The ceremonial experience of Kumbakonam degree coffee, served in traditional brass with aromatic perfection.</p>
                </div>
            </div>

            <!-- Feature 4 -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="60" height="60" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M32 30V58" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M32 30H10V50C10 54.4 13.6 58 18 58H32V30Z" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M32 30H54V50C54 54.4 50.4 58 46 58H32V30Z" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M32 30C32 30 26 24 26 16C26 11.6 28.7 8 32 8C35.3 8 38 11.6 38 16C38 24 32 30 32 30Z" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10 30H54" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="feature-title">Divine Confections</h3>
                    <p class="feature-text">Rich, ghee-laden sweets and handcrafted desserts that offer a sweet conclusion to a majestic feast.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Testimonials Section -->
<!-- Testimonials Section -->
<style>
    .testimonials-section {
        position: relative;
        background-color: #FAFAF5 !important;
        overflow: hidden;
    }
    
    .testimonials-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset("assets/images/bg-royal-floral.svg") }}');
        background-size: 100px 100px;
        background-repeat: repeat;
        opacity: 0.25;
        z-index: 1;
        pointer-events: none;
        animation: floralHorizontalAnim 10s linear infinite; /* Horizontal Animation */
    }

    .testimonials-section .container {
        position: relative;
        z-index: 10;
    }

    @keyframes floralHorizontalAnim {
        0% { background-position: 0 0; }
        100% { background-position: 100px 0; } /* Horizontal loop */
    }

    /* Royal Invitation Card Style for Testimonial */
    .testimonial-content {
        background-color: #FFFDF5 !important; /* Cream/Ivory Background */
        border: 1px solid rgba(218, 165, 32, 0.3);
        box-shadow: 0 15px 35px rgba(0,0,0,0.05); /* Soft, hovering shadow */
        border-radius: 2px; /* Sharp corners like a card */
        position: relative;
        margin: 20px 10px; /* Spacing for the shadow */
    }

    /* The 'Inner Frame' - Essential for the Invitation Card look */
    .testimonial-content::before {
        content: '';
        position: absolute;
        top: 12px;
        left: 12px;
        right: 12px;
        bottom: 12px;
        border: 1px solid rgba(218, 165, 32, 0.15); /* Very subtle inner gold line */
        pointer-events: none;
    }
</style>
<div class="testimonials-section py-5 position-relative">
    
    <div class="container position-relative" style="z-index: 2;">
        <div class="section-title-wrapper text-center mb-5">
            <p class="section-subtitle fw-bold text-uppercase mb-2" style="color: #DAA520; letter-spacing: 3px; font-size: 0.85rem;">Client Experiences</p>
            <h2 class="section-title display-5 fw-bold mb-3" style="font-family: 'Playfair Display', serif; color: #1B4D3E;">Words from Our Guests</h2>
            <div class="separator-line mx-auto mb-4" style="width: 80px; height: 3px; background: linear-gradient(90deg, transparent, #DAA520, transparent);"></div>
        </div>

        <!-- Testimonial Carousel -->
        <div class="testimonial-carousel-wrapper position-relative" style="max-width: 900px; margin: 0 auto;">
            <div class="testimonial-carousel" id="testimonialCarousel">
                <!-- Testimonial 1 -->
                <div class="testimonial-slide active">
                    <div class="testimonial-content text-center p-5">
                        <div class="quote-icon mb-4" style="color: #DAA520; font-size: 3rem; opacity: 0.4;">
                            <i class="fa fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text mb-4" style="color: #44566c; font-size: 1.25rem; line-height: 1.9; font-style: italic; max-width: 700px; margin: 0 auto;">
                            "Manam Catering transformed our wedding into an unforgettable feast. The authentic South Indian flavors and impeccable presentation exceeded all expectations. Every guest was mesmerized!"
                        </p>
                        <div class="testimonial-author mt-4">
                            <div class="author-avatar mx-auto mb-3" style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #1B4D3E, #4CAF50); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.5rem; border: 3px solid rgba(218, 165, 32, 0.3);">
                                P
                            </div>
                            <h6 class="mb-1 fw-bold" style="color: #1B4D3E; font-size: 1.1rem;">Priya & Rajesh</h6>
                            <p class="mb-0" style="color: #DAA520; font-size: 0.85rem; letter-spacing: 1.5px;">WEDDING CELEBRATION</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-slide">
                    <div class="testimonial-content text-center p-5">
                        <div class="quote-icon mb-4" style="color: #DAA520; font-size: 3rem; opacity: 0.4;">
                            <i class="fa fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text mb-4" style="color: #44566c; font-size: 1.25rem; line-height: 1.9; font-style: italic; max-width: 700px; margin: 0 auto;">
                            "The grand thali served at our corporate event was a masterpiece. Every dish was crafted with precision and love. Truly royal hospitality that impressed all our international clients!"
                        </p>
                        <div class="testimonial-author mt-4">
                            <div class="author-avatar mx-auto mb-3" style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #1B4D3E, #4CAF50); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.5rem; border: 3px solid rgba(218, 165, 32, 0.3);">
                                A
                            </div>
                            <h6 class="mb-1 fw-bold" style="color: #1B4D3E; font-size: 1.1rem;">Arun Kumar</h6>
                            <p class="mb-0" style="color: #DAA520; font-size: 0.85rem; letter-spacing: 1.5px;">CORPORATE EVENT</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="testimonial-slide">
                    <div class="testimonial-content text-center p-5">
                        <div class="quote-icon mb-4" style="color: #DAA520; font-size: 3rem; opacity: 0.4;">
                            <i class="fa fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text mb-4" style="color: #44566c; font-size: 1.25rem; line-height: 1.9; font-style: italic; max-width: 700px; margin: 0 auto;">
                            "From the filter coffee to the variety rice, every item reminded us of home. Manam truly serves love, the South Indian way. The Mysore Bonda was absolutely divine!"
                        </p>
                        <div class="testimonial-author mt-4">
                            <div class="author-avatar mx-auto mb-3" style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #1B4D3E, #4CAF50); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.5rem; border: 3px solid rgba(218, 165, 32, 0.3);">
                                L
                            </div>
                            <h6 class="mb-1 fw-bold" style="color: #1B4D3E; font-size: 1.1rem;">Lakshmi Iyer</h6>
                            <p class="mb-0" style="color: #DAA520; font-size: 0.85rem; letter-spacing: 1.5px;">FAMILY GATHERING</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 4 -->
                <div class="testimonial-slide">
                    <div class="testimonial-content text-center p-5">
                        <div class="quote-icon mb-4" style="color: #DAA520; font-size: 3rem; opacity: 0.4;">
                            <i class="fa fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text mb-4" style="color: #44566c; font-size: 1.25rem; line-height: 1.9; font-style: italic; max-width: 700px; margin: 0 auto;">
                            "The attention to detail was remarkable. From the banana leaf presentation to the perfectly balanced spices, everything was authentic and delicious. Best catering service in the city!"
                        </p>
                        <div class="testimonial-author mt-4">
                            <div class="author-avatar mx-auto mb-3" style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #1B4D3E, #4CAF50); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.5rem; border: 3px solid rgba(218, 165, 32, 0.3);">
                                V
                            </div>
                            <h6 class="mb-1 fw-bold" style="color: #1B4D3E; font-size: 1.1rem;">Venkatesh Reddy</h6>
                            <p class="mb-0" style="color: #DAA520; font-size: 0.85rem; letter-spacing: 1.5px;">BIRTHDAY CELEBRATION</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 5 -->
                <div class="testimonial-slide">
                    <div class="testimonial-content text-center p-5">
                        <div class="quote-icon mb-4" style="color: #DAA520; font-size: 3rem; opacity: 0.4;">
                            <i class="fa fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text mb-4" style="color: #44566c; font-size: 1.25rem; line-height: 1.9; font-style: italic; max-width: 700px; margin: 0 auto;">
                            "The Vegetable Chettinad curry and Paneer Biriyani were outstanding! Manam brought the essence of traditional South Indian cuisine to our anniversary. Highly recommended for any special occasion."
                        </p>
                        <div class="testimonial-author mt-4">
                            <div class="author-avatar mx-auto mb-3" style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #1B4D3E, #4CAF50); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.5rem; border: 3px solid rgba(218, 165, 32, 0.3);">
                                M
                            </div>
                            <h6 class="mb-1 fw-bold" style="color: #1B4D3E; font-size: 1.1rem;">Meera & Suresh</h6>
                            <p class="mb-0" style="color: #DAA520; font-size: 0.85rem; letter-spacing: 1.5px;">ANNIVERSARY PARTY</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 6 -->
                <div class="testimonial-slide">
                    <div class="testimonial-content text-center p-5">
                        <div class="quote-icon mb-4" style="color: #DAA520; font-size: 3rem; opacity: 0.4;">
                            <i class="fa fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text mb-4" style="color: #44566c; font-size: 1.25rem; line-height: 1.9; font-style: italic; max-width: 700px; margin: 0 auto;">
                            "Professional, punctual, and absolutely delicious! The variety rice collection and filter coffee were the highlights. Manam made our housewarming ceremony truly memorable."
                        </p>
                        <div class="testimonial-author mt-4">
                            <div class="author-avatar mx-auto mb-3" style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, #1B4D3E, #4CAF50); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 1.5rem; border: 3px solid rgba(218, 165, 32, 0.3);">
                                K
                            </div>
                            <h6 class="mb-1 fw-bold" style="color: #1B4D3E; font-size: 1.1rem;">Kavitha Krishnan</h6>
                            <p class="mb-0" style="color: #DAA520; font-size: 0.85rem; letter-spacing: 1.5px;">HOUSEWARMING CEREMONY</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dots Indicator -->
            <div class="testimonial-dots text-center mt-4">
                <span class="dot active" onclick="currentTestimonial(1)"></span>
                <span class="dot" onclick="currentTestimonial(2)"></span>
                <span class="dot" onclick="currentTestimonial(3)"></span>
                <span class="dot" onclick="currentTestimonial(4)"></span>
                <span class="dot" onclick="currentTestimonial(5)"></span>
                <span class="dot" onclick="currentTestimonial(6)"></span>
            </div>
        </div>
    </div>
</div>

<style>
.testimonial-slide {
    display: none;
    animation: fadeIn 0.6s ease-in-out;
}

.testimonial-slide.active {
    display: block;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.testimonial-nav:hover {
    background: rgba(218, 165, 32, 0.4) !important;
    transform: translateY(-50%) scale(1.1);
}

.dot {
    height: 10px;
    width: 10px;
    margin: 0 6px;
    background-color: rgba(218, 165, 32, 0.3);
    border-radius: 50%;
    display: inline-block;
    cursor: pointer;
    transition: all 0.3s ease;
}

.dot.active,
.dot:hover {
    background-color: #DAA520;
    transform: scale(1.3);
}

@media (max-width: 768px) {
    .testimonial-nav {
        display: none;
    }
    
    .testimonial-text {
        font-size: 1.1rem !important;
    }
}
</style>

<script>
let currentSlide = 1;
const totalSlides = 6;

function changeTestimonial(direction) {
    showTestimonial(currentSlide += direction);
}

function currentTestimonial(n) {
    showTestimonial(currentSlide = n);
}

function showTestimonial(n) {
    const slides = document.getElementsByClassName("testimonial-slide");
    const dots = document.getElementsByClassName("dot");
    
    if (n > totalSlides) { currentSlide = 1; }
    if (n < 1) { currentSlide = totalSlides; }
    
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
    }
    
    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
    }
    
    slides[currentSlide - 1].classList.add("active");
    dots[currentSlide - 1].classList.add("active");
}

// Auto-scroll every 5 seconds
setInterval(() => {
    changeTestimonial(1);
}, 5000);
</script>



@endsection
