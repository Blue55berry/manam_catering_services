@extends('layouts.app')

@section('title', 'FAQs - Catering Services')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/faqs-redesign.css') }}?v={{ time() }}">

<div class="faq-redesign-wrapper">
    <!-- Hero Section -->
    <section class="faq-hero-section">
        <div class="container">
            <h1 class="faq-hero-title">Common Inquiries</h1>
            <p class="faq-hero-subtitle">Everything you need to know about our royal catering services and heritage hospitality.</p>
        </div>
    </section>

    <!-- FAQ Accordion -->
    <section class="faq-content-section">
        <div class="container">
            <div class="faq-accordion-wrapper">
                <div class="accordion" id="faqAccordion">
                    @forelse($faqs as $index => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $index }}">
                            <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="alert alert-info text-center">
                        <h4 class="mb-0">Our FAQ list is currently being curated.</h4>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Help Section (With Royal Gradient) -->
    <section class="faq-help-section">
        <div class="container">
            <h2>Still have questions?</h2>
            <p class="lead">Our royal consultants are ready to assist you with any bespoke requirements.</p>
            <a href="{{ route('contact') }}" class="btn-royal-outline">Talk to an Expert</a>
        </div>
    </section>
</div>
@endsection
