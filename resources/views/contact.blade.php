@extends('layouts.app')

@section('title', 'Contact Us - Manam Catering')

@section('content')

<!-- Royal Theme Styles -->
<style>
    :root {
        --royal-green: #1B4D3E;
        --royal-gold: #cfa957;
        --royal-gold-dark: #DAA520;
        --royal-parchment: #FFFDF5;
        --royal-cream: #FAFAF5;
    }
   
    /* 1. Global Background Pattern */
    .royal-contact-wrapper {
        position: relative;
        background-color: var(--royal-parchment);
        overflow: hidden;
        padding-bottom: 80px;
        min-height: 100vh;
    }

    .royal-contact-wrapper::before {
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
    .contact-hero {
        position: relative;
        padding: 100px 0 60px;
        text-align: center;
        z-index: 1;
    }

    .contact-main-title {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        color: var(--royal-green);
        font-weight: 700;
        margin-bottom: 20px;
    }

    .contact-subtitle {
        font-family: 'Inter', sans-serif;
        font-size: 1.2rem;
        color: #555;
        max-width: 700px;
        margin: 0 auto;
        font-style: italic;
    }

    /* 3. Info Cards */
    .info-card-royal {
        background: #fff;
        border: 1px solid rgba(218, 165, 32, 0.3);
        padding: 30px;
        border-radius: 8px;
        text-align: center;
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .info-card-royal:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border-color: var(--royal-gold);
    }
    
    .info-icon-wrapper {
        margin-bottom: 20px;
        display: flex;
        justify-content: center;
    }

    .info-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem;
        color: var(--royal-green);
        margin-bottom: 10px;
        font-weight: 700;
    }

    .info-text, .info-text a {
        font-family: 'Inter', sans-serif;
        color: #555;
        text-decoration: none;
        display: block;
        margin-bottom: 5px;
        font-size: 0.95rem;
        transition: color 0.3s;
    }
    
    .info-text a:hover {
        color: var(--royal-green);
    }

    /* 4. Form Section */
    .form-card-royal {
        background: #FFFDF5;
        border: 1px solid rgba(218, 165, 32, 0.4);
        padding: 50px 40px;
        border-radius: 4px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.05);
        position: relative;
        margin-top: 40px;
    }
    
    /* Inner Border */
    .form-card-royal::before {
        content: "";
        position: absolute;
        top: 10px; left: 10px; right: 10px; bottom: 10px;
        border: 1px solid rgba(218, 165, 32, 0.15);
        pointer-events: none;
    }
    
    .royal-form-header {
        text-align: center;
        margin-bottom: 40px;
        position: relative;
        z-index: 2;
    }
    
    .royal-form-title {
        font-family: 'Playfair Display', serif;
        color: var(--royal-green);
        font-size: 2rem;
        margin-bottom: 10px;
    }

    /* Form Inputs */
    .form-group-royal {
        margin-bottom: 25px;
        position: relative;
        z-index: 2; /* To sit above inner border */
    }

    .form-control-royal {
        width: 100%;
        background: transparent;
        border: none;
        border-bottom: 2px solid rgba(27, 77, 62, 0.2);
        padding: 10px 5px;
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        color: #333;
        transition: border-color 0.3s ease;
        border-radius: 0;
    }

    .form-control-royal:focus {
        outline: none;
        border-bottom-color: var(--royal-gold-dark);
        background: rgba(218, 165, 32, 0.05);
    }
    
    .form-control-royal::placeholder {
        color: #999;
        font-size: 0.9rem;
    }

    .form-label-royal {
        position: absolute;
        top: 10px;
        left: 5px;
        pointer-events: none;
        color: #777;
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        opacity: 0; /* Hidden placeholder style, relying on actual placeholder for now or we can animate */
    }
    
    /* Submit Button (From Events Page) */
    .btn-royal-submit {
        display: inline-block;
        width: 100%;
        padding: 15px;
        background-color: var(--royal-green);
        color: #ffffff !important;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        border: 1px solid var(--royal-gold-dark);
        border-radius: 2px;
        cursor: pointer;
        transition: all 0.4s ease;
        box-shadow: 0 5px 15px rgba(27, 77, 62, 0.2);
        position: relative;
        overflow: hidden;
    }
    
    .btn-royal-submit:hover {
        background-color: #143a2f;
        box-shadow: 0 8px 25px rgba(218, 165, 32, 0.4);
        transform: translateY(-2px);
    }

</style>

<div class="royal-contact-wrapper">
    
    <!-- Hero -->
    <section class="contact-hero">
        <div class="container">
            <h1 class="contact-main-title">Contact Us</h1>
            <p class="contact-subtitle">Experience the royal taste. We are here to serve you.</p>
        </div>
    </section>

    <div class="container pb-5" style="position: relative; z-index: 1;">
        
        <!-- Info Cards Row -->
        <div class="row mb-5 justify-content-center">
            <!-- Phone -->
            <div class="col-md-4 mb-4">
                <div class="info-card-royal">
                    <div class="info-icon-wrapper">
                        <!-- Phone Icon SVG -->
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="info-title">Talk to Us</h3>
                    <p class="info-text"><a href="tel:+918889999666">+91 8889 999 666</a></p>
                    <p class="info-text"><a href="tel:+911800124512">1800-1245-1245</a></p>
                </div>
            </div>

            <!-- Email -->
            <div class="col-md-4 mb-4">
                <div class="info-card-royal">
                    <div class="info-icon-wrapper">
                        <!-- Email Icon SVG -->
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22 6l-10 7L2 6" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="info-title">Email Us</h3>
                    <p class="info-text"><a href="mailto:info@manamcatering.com">info@manamcatering.com</a></p>
                    <p class="info-text"><a href="mailto:bookings@manamcatering.com">bookings@manamcatering.com</a></p>
                </div>
            </div>

            <!-- Location -->
            <div class="col-md-4 mb-4">
                <div class="info-card-royal">
                    <div class="info-icon-wrapper">
                        <!-- Location Icon SVG -->
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="12" cy="10" r="3" stroke="#DAA520" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3 class="info-title">Visit Us</h3>
                    <p class="info-text">123 Culinary Street,<br>Food District, City 560001</p>
                </div>
            </div>
        </div>

        <!-- Contact Form Section -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-card-royal">
                    <div class="royal-form-header">
                        <h2 class="royal-form-title">Send a Message</h2>
                        <p class="text-muted" style="font-family: 'Inter', sans-serif;">Planning an event? Fill the form below and we will get in touch instantly.</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success mb-4 text-center">
                            <i class="fa fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger mb-4 text-center">
                            <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-royal">
                                    <input type="text" name="name" id="name" class="form-control-royal" placeholder="Your Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-royal">
                                    <input type="email" name="email" id="email" class="form-control-royal" placeholder="Email Address" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-royal">
                                    <input type="tel" name="phone" id="phone" class="form-control-royal" placeholder="Phone Number" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-royal">
                                    <input type="text" name="subject" class="form-control-royal" placeholder="Subject (Optional)">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group-royal">
                                    <textarea name="message" id="message" rows="4" class="form-control-royal" placeholder="Your Message or Requirements" required></textarea>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <button type="submit" class="btn-royal-submit">
                                    Send Enquiry
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
