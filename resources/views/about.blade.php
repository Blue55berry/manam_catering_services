@extends('layouts.app')

@section('title', 'About Us - Manam Catering')

@section('content')

<!-- Royal Theme Styles (Inherited from Events/Home) -->
<style>
    :root {
        --royal-green: #1B4D3E;
        --royal-gold: #cfa957;
        --royal-parchment: #FFFDF5;
        --royal-cream: #FAFAF5;
    }

    /* 1. Global Background Pattern */
    .royal-about-wrapper {
        position: relative;
        background-color: var(--royal-parchment);
        overflow: hidden;
        padding-bottom: 60px;
    }

    .royal-about-wrapper::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset("assets/images/bg-leaf.svg") }}'); 
        background-size: 60px 60px;
        background-repeat: repeat;
        opacity: 0.4;
        z-index: 0; 
        pointer-events: none;
        animation: leafVerticalAnim 20s linear infinite;
    }

    @keyframes leafVerticalAnim {
        0% { background-position: 0 0; }
        100% { background-position: 0 60px; } 
    }

    /* 2. Hero Section */
    .royal-about-hero {
        position: relative;
        padding: 100px 0 60px;
        text-align: center;
        z-index: 1;
    }

    .about-main-title {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        color: var(--royal-green);
        font-weight: 700;
        margin-bottom: 20px;
    }

    .about-subtitle {
        font-family: 'Inter', sans-serif;
        font-size: 1.2rem;
        color: #555;
        max-width: 700px;
        margin: 0 auto;
        font-style: italic;
    }

    /* 3. Story Section - Royal Card Style */
    .royal-story-section {
        position: relative;
        z-index: 1;
        padding: 40px 0;
    }

    .story-card-royal {
        background: #fff;
        border: 1px solid rgba(218, 165, 32, 0.3);
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 40px;
    }
    
    @media (max-width: 991px) {
        .story-card-royal { flex-direction: column; }
    }

    .story-img-frame {
        flex: 1;
        position: relative;
        border: 5px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .story-img-frame img {
        width: 100%;
        border-radius: 4px;
    }

    .story-content {
        flex: 1;
    }

    .story-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: var(--royal-green);
        margin-bottom: 20px;
    }
    
    .story-text {
        color: #555;
        line-height: 1.8;
        font-size: 1.05rem;
        margin-bottom: 15px;
    }

    /* 4. Stats Section - Green Gradient (Preserved/Updated Style) */
    .royal-stats-section {
        position: relative;
        z-index: 1;
        padding: 60px 0;
        background: linear-gradient(135deg, #1B4D3E 0%, #143a2f 100%); /* Green Gradient */
        color: white;
        margin: 60px 0;
        border-top: 4px solid var(--royal-gold);
        border-bottom: 4px solid var(--royal-gold);
    }

    .stat-item-royal {
        text-align: center;
        padding: 20px;
    }

    .stat-number-royal {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        color: var(--royal-gold);
        font-weight: 700;
        margin-bottom: 10px;
    }

    .stat-label-royal {
        font-family: 'Inter', sans-serif;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: white;
    }

    /* 5. Testimonial Section (Replacing Team) */
    .testimonials-section {
        position: relative;
        z-index: 1;
        padding: 40px 0 80px;
    }  

    /* Using Home Page Styles for Testimonials */
    .testimonial-content {
        background-color: #FFFDF5;
        border: 1px solid rgba(218, 165, 32, 0.3);
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        border-radius: 2px;
        position: relative;
        margin: 20px 10px;
        padding: 40px;
        text-align: center;
    }
    
    .testimonial-content::before {
        content: '';
        position: absolute;
        top: 12px; left: 12px; right: 12px; bottom: 12px;
        border: 1px solid rgba(218, 165, 32, 0.15);
        pointer-events: none;
    }
    
    .testimonial-slide {
        display: none;
        animation: fadeIn 0.6s ease-in-out;
    }
    .testimonial-slide.active { display: block; }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .t-dots {
        text-align: center;
        margin-top: 20px;
    }
    .t-dot {
        height: 10px; width: 10px;
        margin: 0 6px;
        background-color: rgba(218, 165, 32, 0.3);
        border-radius: 50%;
        display: inline-block;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .t-dot.active, .t-dot:hover {
        background-color: var(--royal-gold);
        transform: scale(1.3);
    }
</style>

<div class="royal-about-wrapper">

    <!-- Hero -->
    <section class="royal-about-hero">
        <div class="container">
            <h1 class="about-main-title">About Manam</h1>
            <p class="about-subtitle">Tradition, Taste, and Trust since 2000.</p>
        </div>
    </section>

    <!-- Story Section -->
    <section class="royal-story-section">
        <div class="container">
            <div class="story-card-royal">
                <div class="story-img-frame">
                    <img src="{{ asset('assets/images/about-buffet.jpeg') }}" alt="Grand Buffet Setup">
                </div>
                <div class="story-content">
                    <span class="text-uppercase fw-bold" style="color: var(--royal-gold); letter-spacing: 2px; font-size: 0.9rem;">Our Heritage</span>
                    <h2 class="story-title mt-2">Crafting Royal Culinary Experiences</h2>
                    <p class="story-text">
                        At Manam Catering, we believe that food is not just a meal, but an emotion. Started with a passion for authentic South Indian cuisine, we have grown into a premier catering service known for our uncompromising quality and royal hospitality.
                    </p>
                    <p class="story-text">
                        Every dish we serve is prepared with hand-picked spices, fresh ingredients, and generations of culinary wisdom.
                    </p>
                    <div class="d-flex gap-4 mt-4">
                        <div class="d-flex align-items-center gap-2">
                             <!-- Authentic Recipes: Cutlery & Scroll -->
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 5V19M8 5C8 5 4 5 4 8C4 11 8 11 8 11M8 5C8 5 12 5 12 8C12 11 8 11 8 11" stroke="#DAA520" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16 4V19M16 4C16 4 14 6 14 9V14C14 14 18 14 18 14V9C18 6 16 4 16 4Z" stroke="#DAA520" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Authentic Recipes</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                             <!-- Passionate Service: Heart -->
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" stroke="#DAA520" stroke-width="1.5" fill="none"/>
                            </svg>
                            <span>Passionate Service</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section (Green Gradient) -->
    <section class="royal-stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-item-royal">
                        <div class="stat-number-royal">750+</div>
                        <div class="stat-label-royal">Happy Clients</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item-royal">
                        <div class="stat-number-royal">20+</div>
                        <div class="stat-label-royal">Awards Won</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item-royal">
                        <div class="stat-number-royal">23</div>
                        <div class="stat-label-royal">Years Serving</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item-royal">
                        <div class="stat-number-royal">500+</div>
                        <div class="stat-label-royal">Events Done</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section (Replacing Team) -->
    <section class="testimonials-section">
        <div class="container">
            <div class="text-center mb-5">
                <p class="fw-bold text-uppercase mb-2" style="color: var(--royal-gold); letter-spacing: 3px; font-size: 0.85rem;">Client Experiences</p>
                <h2 class="display-5 fw-bold mb-3" style="font-family: 'Playfair Display', serif; color: var(--royal-green);">Words from Our Guests</h2>
                <div class="mx-auto mb-4" style="width: 80px; height: 3px; background: linear-gradient(90deg, transparent, var(--royal-gold), transparent);"></div>
            </div>

            <!-- Carousel -->
            <div class="testimonial-carousel" id="aboutTestimonials">
                <!-- Slide 1 -->
                <div class="testimonial-slide active">
                    <div class="testimonial-content">
                        <div class="mb-4" style="color: var(--royal-gold); font-size: 2rem; opacity: 0.5;"><i class="fa fa-quote-left"></i></div>
                        <p class="mb-4 font-italic" style="font-size: 1.2rem; color: #555;">
                            "Manam Catering transformed our wedding into an unforgettable feast. The authentic South Indian flavors and impeccable presentation exceeded all expectations. Every guest was mesmerized!"
                        </p>
                        <h6 class="fw-bold" style="color: var(--royal-green);">Priya & Rajesh</h6>
                        <span style="color: var(--royal-gold); font-size: 0.8rem; letter-spacing: 1px;">WEDDING CELEBRATION</span>
                    </div>
                </div>
                 <!-- Slide 2 -->
                 <div class="testimonial-slide">
                    <div class="testimonial-content">
                        <div class="mb-4" style="color: var(--royal-gold); font-size: 2rem; opacity: 0.5;"><i class="fa fa-quote-left"></i></div>
                        <p class="mb-4 font-italic" style="font-size: 1.2rem; color: #555;">
                             "The grand thali served at our corporate event was a masterpiece. Every dish was crafted with precision and love. Truly royal hospitality!"
                        </p>
                        <h6 class="fw-bold" style="color: var(--royal-green);">Arun Kumar</h6>
                        <span style="color: var(--royal-gold); font-size: 0.8rem; letter-spacing: 1px;">CORPORATE EVENT</span>
                    </div>
                </div>
                 <!-- Slide 3 -->
                 <div class="testimonial-slide">
                    <div class="testimonial-content">
                        <div class="mb-4" style="color: var(--royal-gold); font-size: 2rem; opacity: 0.5;"><i class="fa fa-quote-left"></i></div>
                        <p class="mb-4 font-italic" style="font-size: 1.2rem; color: #555;">
                            "From the filter coffee to the variety rice, every item reminded us of home. Manam truly serves love, the South Indian way. The Mysore Bonda was absolutely divine!"
                        </p>
                        <h6 class="fw-bold" style="color: var(--royal-green);">Lakshmi Iyer</h6>
                        <span style="color: var(--royal-gold); font-size: 0.8rem; letter-spacing: 1px;">FAMILY GATHERING</span>
                    </div>
                </div>
            </div>

            <div class="t-dots">
                <span class="t-dot active" onclick="setSlide(1)"></span>
                <span class="t-dot" onclick="setSlide(2)"></span>
                <span class="t-dot" onclick="setSlide(3)"></span>
            </div>

        </div>
    </section>

</div>

<script>
    let currentT = 1;
    const totalT = 3;
    
    function setSlide(n) {
        currentT = n;
        showSlide(currentT);
    }
    
    function showSlide(n) {
        const slides = document.querySelectorAll('#aboutTestimonials .testimonial-slide');
        const dots = document.querySelectorAll('.t-dot');
        
        if (n > totalT) currentT = 1;
        if (n < 1) currentT = totalT;
        
        slides.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));
        
        slides[currentT - 1].classList.add('active');
        dots[currentT - 1].classList.add('active');
    }
    
    // Auto Scroll
    setInterval(() => {
        currentT++;
        showSlide(currentT);
    }, 5000);
</script>

@endsection
