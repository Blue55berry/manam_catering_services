@extends('layouts.app')

@section('title', 'Events - Catering Services')

@section('content')

<!-- Custom Styles for Royal Events Theme -->
<style>
    :root {
        --royal-green: #1B4D3E;
        --royal-gold: #cfa957; /* Muted Gold */
        --royal-parchment: #FFFDF5; /* Cream/Paper bg */
        --royal-red-gradient: linear-gradient(180deg, transparent 0%, rgba(139, 0, 0, 0.03) 100%);
    }

    /* Global Background Pattern */
    .royal-events-wrapper {
        position: relative;
        background-color: var(--royal-parchment);
        overflow: hidden;
    }

    .royal-events-wrapper::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset("assets/images/bg-leaf.svg") }}'); 
        background-size: 60px 60px;
        background-repeat: repeat;
        opacity: 0.4; /* Increased visibility */
        z-index: 0; 
        pointer-events: none;
        animation: leafVerticalAnim 60s linear infinite;
    }

    @keyframes leafVerticalAnim {
        0% { background-position: 0 0; }
        100% { background-position: 0 60px; } 
    }

    /* Header Section */
    .gallery-header-section {
        position: relative;
        padding: 80px 0 40px;
        background: transparent;
        z-index: 1;
        text-align: center;
    }

    /* Royal CTA Button */
    .btn-royal-cta {
        display: inline-block;
        margin-top: 30px;
        padding: 14px 45px;
        background-color: var(--royal-green);
        color: #ffffff !important;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        border: 1px solid var(--royal-gold);
        border-radius: 2px;
        text-decoration: none;
        transition: all 0.4s ease;
        box-shadow: 0 5px 15px rgba(27, 77, 62, 0.2);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .btn-royal-cta::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0%;
        height: 100%;
        background-color: var(--royal-gold);
        transition: all 0.4s ease;
        z-index: -1;
    }

    .btn-royal-cta:hover {
        color: var(--royal-green);
        box-shadow: 0 8px 25px rgba(218, 165, 32, 0.4);
        transform: translateY(-3px);
    }

    .btn-royal-cta:hover::before {
        width: 100%;
    }

    .gallery-main-title {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        color: var(--royal-green);
        font-weight: 700;
        margin-bottom: 20px;
    }

    .gallery-subtitle {
        font-family: 'Inter', sans-serif;
        font-size: 1.2rem;
        color: #555;
        max-width: 700px;
        margin: 0 auto;
        font-style: italic;
    }

    /* Gallery Grid */
    .gallery-grid-section {
        position: relative;
        padding: 40px 0 80px;
        z-index: 1;
    }
    
    .gallery-masonry {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .gallery-card {
        background: #fff;
        border: 1px solid rgba(218, 165, 32, 0.3); /* Gold Border */
        padding: 5px; /* Frame effect */
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        border-color: var(--royal-gold);
    }

    .gallery-image-wrapper {
        width: 100%;
        height: 300px;
        overflow: hidden;
        position: relative;
    }

    .gallery-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .gallery-card:hover .gallery-img {
        transform: scale(1.05);
    }

    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        padding: 20px;
        color: white;
        opacity: 0; /* Hidden by default */
        transition: opacity 0.3s ease;
    }

    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }

    .btn-book-now-royal {
        display: inline-block;
        margin-top: 10px;
        padding: 5px 15px;
        background: var(--royal-gold);
        color: white;
        text-decoration: none;
        font-size: 0.8rem;
        border-radius: 2px;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* Testimonial - Invitation Card Style */
    .events-testimonial-section {
        position: relative;
        z-index: 1;
        padding: 60px 0;
    }

    .testimonial-card-royal {
        background: #FFFDF5;
        border: 1px solid rgba(218, 165, 32, 0.3);
        padding: 40px;
        text-align: center;
        position: relative;
        max-width: 900px;
        margin: 0 auto;
        box-shadow: 0 15px 40px rgba(0,0,0,0.05);
    }

    /* Inner Border for Invitation Look */
    .testimonial-card-royal::before {
        content: "";
        position: absolute;
        top: 10px; left: 10px; right: 10px; bottom: 10px;
        border: 1px solid rgba(218, 165, 32, 0.15);
        pointer-events: none;
    }

    .testimonial-text {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: var(--royal-green);
        font-style: italic;
    }

    /* Services Section - Royal Cards */
    .event-services-section {
        position: relative;
        z-index: 1;
        padding: 60px 0 80px;
    }

    .service-card-royal {
        background: #FFFDF5;
        border: 1px solid rgba(218, 165, 32, 0.2);
        padding: 30px 20px;
        text-align: center;
        height: 100%;
        transition: all 0.3s ease;
        position: relative;
    }

    .service-card-royal:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-bottom: 3px solid var(--royal-gold); /* Gold Bottom Bar */
        background: linear-gradient(180deg, #FFFDF5 70%, #FFF5EF 100%); /* Subtle Red/Gold tint at bottom */
    }

    .service-icon-royal {
        font-size: 2.5rem;
        color: var(--royal-gold);
        margin-bottom: 20px;
    }

    .service-card-royal h4 {
        font-family: 'Playfair Display', serif;
        color: var(--royal-green);
        margin-bottom: 10px;
    }
    
    /* Stats Section */
    .stat-number-royal {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        color: var(--royal-gold);
        font-weight: 700;
    }
    .stat-label-royal {
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 0.9rem;
        color: #555;
    }

    .event-stats-section {
        background-color: #FFFDF5; /* Old Paper Mild Color */
        position: relative;
        z-index: 2; /* Sit on top of the pattern */
        box-shadow: 0 0 20px rgba(0,0,0,0.03); /* Subtle separation */
        border-top: 1px solid rgba(218, 165, 32, 0.2);
    }

    /* Marquee Animation Styles */
    .marquee-wrapper {
        overflow: hidden;
        width: 100%;
        position: relative;
        padding: 20px 0;
        background: transparent;
    }
    
    .marquee-track {
        display: flex;
        width: max-content;
        /* Ensure hardware acceleration for smoother animation */
        will-change: transform;
    }
    
    .marquee-item {
        flex: 0 0 auto;
        width: 350px;
        height: 250px;
        margin: 0 15px;
        border-radius: 8px;
        border: 2px solid rgba(218, 165, 32, 0.5); /* Gold Border */
        overflow: hidden;
        position: relative;
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }
    
    .marquee-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .marquee-item:hover img {
        transform: scale(1.1);
    }

    .scroll-left-to-right {
        animation: scrollLeftToRight 150s linear infinite;
    }

    .scroll-right-to-left {
        animation: scrollRightToLeft 150s linear infinite;
    }
    
    /* Pause on hover for interaction */
    .marquee-wrapper:hover .marquee-track {
        animation-play-state: paused;
    }

    @keyframes scrollLeftToRight {
        0% { transform: translateX(-50%); }
        100% { transform: translateX(0); }
    }

    @keyframes scrollRightToLeft {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

</style>

<div class="royal-events-wrapper">

    <!-- Gallery Header Section -->
    <section class="gallery-header-section">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-10">
                    <h1 class="gallery-main-title mt-4">Gallery of Celebrations</h1>
                    <p class="gallery-subtitle">A visual journey through our most prestigious weddings and events.</p>
                    
                    <a href="{{ route('events.book') }}" class="btn-royal-cta">
                        Book Event Now
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Grid Section -->                          
    <!-- Animated Marquee Gallery Section -->                          
    <section class="gallery-grid-section" id="gallery" style="overflow: hidden; padding-bottom: 60px;">
        <div class="container-fluid p-0">
             @php
                // Use actual events from the database
                $eventImages = $events->map(function($event) {
                    if ($event->image) {
                        return asset($event->image) . '?t=' . time();
                    }
                    return asset('assets/images/main/static-menu-images/01.png');
                })->toArray();
                
                // Fallback if no events exist
                if (empty($eventImages)) {
                    $eventImages = [
                        'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&w=800&q=80',
                        'https://images.unsplash.com/photo-1587241321921-91a834d6d191?auto=format&fit=crop&w=800&q=80',
                    ];
                }
                
                $imgCount = count($eventImages);
            @endphp

            <!-- Row 1: Left to Right -->
            <div class="marquee-wrapper mb-4">
                <div class="marquee-track scroll-left-to-right">
                    @for($i=0; $i<6; $i++)
                        @foreach($eventImages as $img)
                        <div class="marquee-item">
                            <img src="{{ $img }}" alt="Manam Event">
                        </div>
                        @endforeach
                    @endfor
                </div>
            </div>

            <!-- Row 2: Right to Left -->
            <div class="marquee-wrapper mb-4">
                <div class="marquee-track scroll-right-to-left">
                    @for($i=0; $i<6; $i++)
                        @foreach(array_reverse($eventImages) as $img)
                        <div class="marquee-item">
                            <img src="{{ $img }}" alt="Manam Event">
                        </div>
                        @endforeach
                    @endfor
                </div>
            </div>

            <!-- Row 3: Left to Right -->
            <div class="marquee-wrapper">
                <div class="marquee-track scroll-left-to-right">
                    @for($i=0; $i<6; $i++)
                        @foreach($eventImages as $key => $img)
                        <div class="marquee-item">
                            <img src="{{ $eventImages[($key+1) % $imgCount] }}" alt="Manam Event">
                        </div>
                        @endforeach
                    @endfor
                </div>
            </div>
        </div>
    </section>


    {{-- 
    <!-- Testimonial Section (Invitation Style from Home) -->
    <section class="events-testimonial-section" style="padding: 60px 0;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="text-center mb-5">
                <p class="fw-bold text-uppercase mb-2" style="color: #DAA520; letter-spacing: 3px; font-size: 0.85rem;">Client Experiences</p>
                <h2 class="display-5 fw-bold mb-3" style="font-family: 'Playfair Display', serif; color: #1B4D3E;">Words from Our Guests</h2>
                <div class="mx-auto mb-4" style="width: 80px; height: 3px; background: linear-gradient(90deg, transparent, #DAA520, transparent);"></div>
            </div>

            <!-- Single Testimonial Card (Static for Events Page to keep it clean, or we can use the carousel if JS is included) -->
            <!-- Using the Home Page style structure -->
            <div class="testimonial-card-royal">
                <div class="quote-icon mb-4" style="color: #DAA520; font-size: 3rem; opacity: 0.4;">
                    <i class="fa fa-quote-left"></i>
                </div>
                <p class="testimonial-text mb-4" style="color: #1B4D3E; font-size: 1.25rem; line-height: 1.9; font-style: italic; max-width: 700px; margin: 0 auto;">
                    "Manam Catering transformed our wedding into an unforgettable feast. The authentic South Indian flavors and impeccable presentation exceeded all expectations. Every guest was mesmerized!"
                </p>
                <div class="testimonial-author mt-4">
                    <h6 class="mb-1 fw-bold" style="color: #1B4D3E; font-size: 1.1rem;">Priya & Rajesh</h6>
                    <p class="mb-0" style="color: #DAA520; font-size: 0.85rem; letter-spacing: 1.5px;">WEDDING CELEBRATION</p>
                </div>
            </div>
        </div>
    </section>
    --}}

    <!-- Event Services Section -->
    <section class="event-services-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="gallery-main-title" style="font-size: 2.5rem;">Our Event Services</h2>
                    <p class="gallery-subtitle">Creating memorable experiences for every occasion</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="service-card-royal">
                        <div class="service-icon-royal">
                            <!-- Weddings: Two Rings -->
                            <svg width="60" height="60" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="22" cy="32" r="14" stroke="#DAA520" stroke-width="2"/>
                                <circle cx="42" cy="32" r="14" stroke="#DAA520" stroke-width="2"/>
                                <path d="M42 12 L46 18 L42 24 L38 18 Z" stroke="#DAA520" stroke-width="2"/>
                                <path d="M22 18 L26 24 M22 18 L18 24" stroke="#DAA520" stroke-width="2"/> 
                            </svg>
                        </div>
                        <h4>Weddings</h4>
                        <p class="text-muted">Traditional South Indian weddings with authentic Sadhya and custom menus.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-card-royal">
                        <div class="service-icon-royal">
                             <!-- Corporate: Briefcase -->
                            <svg width="60" height="60" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="10" y="20" width="44" height="32" rx="3" stroke="#DAA520" stroke-width="2"/>
                                <path d="M24 20 V14 C24 10 26 8 32 8 C38 8 40 10 40 14 V20" stroke="#DAA520" stroke-width="2"/>
                                <path d="M10 32 H54" stroke="#DAA520" stroke-width="2"/>
                                <circle cx="32" cy="40" r="2" fill="#DAA520"/>
                            </svg>
                        </div>
                        <h4>Corporate</h4>
                        <p class="text-muted">Professional catering for conferences, seminars, and business gatherings.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-card-royal">
                        <div class="service-icon-royal">
                             <!-- Celebrations: Cake -->
                            <svg width="60" height="60" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="12" y="38" width="40" height="18" stroke="#DAA520" stroke-width="2"/>
                                <rect x="18" y="22" width="28" height="16" stroke="#DAA520" stroke-width="2"/>
                                <path d="M32 22 V12" stroke="#DAA520" stroke-width="2"/>
                                <path d="M32 12 L30 8 L32 4 L34 8 Z" fill="#DAA520"/>
                                <path d="M12 38 H52" stroke="#DAA520" stroke-width="2"/>
                            </svg>
                        </div>
                        <h4>Celebrations</h4>
                        <p class="text-muted">Birthday parties, anniversaries, and family celebrations made special.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-card-royal">
                        <div class="service-icon-royal">
                             <!-- Social: People -->
                            <svg width="60" height="60" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="32" cy="20" r="6" stroke="#DAA520" stroke-width="2"/>
                                <path d="M20 44 C20 38 24 34 32 34 C40 34 44 38 44 44 V52" stroke="#DAA520" stroke-width="2" stroke-linecap="round"/>
                                <path d="M12 28 C12 28 8 36 8 44 V52" stroke="#DAA520" stroke-width="2" stroke-linecap="round"/>
                                <circle cx="16" cy="24" r="5" stroke="#DAA520" stroke-width="2"/>
                                <path d="M52 28 C52 28 56 36 56 44 V52" stroke="#DAA520" stroke-width="2" stroke-linecap="round"/>
                                <circle cx="48" cy="24" r="5" stroke="#DAA520" stroke-width="2"/>
                            </svg>
                        </div>
                        <h4>Social</h4>
                        <p class="text-muted">Buffets, cocktail parties, and community events with style.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Royal Cinematic Highlights Section -->
    <section class="royal-video-highlights py-5" style="background: linear-gradient(180deg, transparent 0%, rgba(27, 77, 62, 0.02) 100%); overflow: hidden;">
        <div class="container-fluid p-0">
            <div class="section-title-wrapper text-center mb-5">
                <p class="section-subtitle fw-bold text-uppercase mb-2" style="color: #DAA520; letter-spacing: 3px; font-size: 0.85rem;">Digital Highlights</p>
                <h2 class="section-title display-5 fw-bold mb-3" style="font-family: 'Playfair Display', serif; color: #1B4D3E;">Experience the Magic</h2>
                <div class="mx-auto mb-4" style="width: 80px; height: 3px; background: linear-gradient(90deg, transparent, #DAA520, transparent);"></div>
                <p class="text-muted italic mx-auto px-3" style="max-width: 600px;">Catch a glimpse of our grand tradition through these cinematic snippets.</p>
            </div>

            <!-- Video Marquee Wrapper -->
            <div class="marquee-wrapper video-marquee">
                <div class="marquee-track scroll-left-to-right" style="animation-duration: 200s;">
                    @for($i=0; $i<8; $i++)
                    <div class="marquee-item" style="width: 320px; height: auto; margin: 0 20px;">
                        <!-- Royal Video card -->
                        <div class="royal-video-card p-3" style="background: #FFFDF5; border: 1px solid rgba(218, 165, 32, 0.3); box-shadow: 0 10px 25px rgba(0,0,0,0.06); position: relative;">
                            <div style="position: absolute; top: 8px; left: 8px; right: 8px; bottom: 8px; border: 1px solid rgba(218, 165, 32, 0.1); pointer-events: none;"></div>
                            
                            <div class="video-container" style="position: relative; padding-bottom: 177.77%; height: 0; overflow: hidden; border-radius: 4px; background: #000;">
                                <video autoplay muted loop playsinline 
                                       style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                    <source src="https://assets.mixkit.co/videos/preview/mixkit-serving-food-on-a-table-3011-large.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            
                            <div class="video-info-overlay mt-3 text-center">
                                <h5 style="font-family: 'Playfair Display', serif; color: #1B4D3E; font-size: 1rem; margin-bottom: 0;">Dakshin Heritage #{{ $i+1 }}</h5>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="event-stats-section py-5" style="border-top: 1px solid rgba(218,165,32,0.2);">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-number-royal">500+</div>
                        <div class="stat-label-royal">Events Catered</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-number-royal">5K+</div>
                        <div class="stat-label-royal">Happy Guests</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-number-royal">15+</div>
                        <div class="stat-label-royal">Years Experience</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card">
                        <div class="stat-number-royal">100%</div>
                        <div class="stat-label-royal">Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
