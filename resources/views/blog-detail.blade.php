@extends('layouts.app')

@section('title', $blog->title . ' - Manam Blog')

@section('content')
<style>
    .blog-detail-hero {
        position: relative;
        background: linear-gradient(135deg, #1B4D3E 0%, #0d2b22 100%);
        padding: 120px 0 100px;
        color: white;
        overflow: hidden;
    }

    .blog-detail-hero::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset("assets/images/bg-leaf.svg") }}');
        background-size: 80px 80px;
        background-repeat: repeat;
        opacity: 0.15;
        z-index: 1;
        pointer-events: none;
    }

    .blog-detail-hero .container {
        position: relative;
        z-index: 2;
    }

    .blog-detail-hero .separator-line {
        width: 100px;
        height: 3px;
        background: linear-gradient(90deg, transparent, #DAA520, transparent);
        margin: 20px auto;
    }

    .blog-meta-top {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #DAA520;
        font-weight: 700;
        margin-bottom: 20px;
        display: block;
    }

    .blog-detail-title {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        line-height: 1.2;
        color: #ffffff; /* Explicitly white as requested */
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    .blog-content-section {
        background-color: #FAFAF5;
        padding: 80px 0;
        position: relative;
    }

    .blog-content-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 10px;
        background: linear-gradient(to right, #1B4D3E, #DAA520, #1B4D3E);
        z-index: 5;
    }

    .royal-article-container {
        background: #FFFDF5;
        border: 1px solid rgba(218, 165, 32, 0.2);
        padding: 60px;
        position: relative;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
    }

    .royal-article-container::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 20px;
        right: 20px;
        bottom: 20px;
        border: 1px solid rgba(218, 165, 32, 0.1);
        pointer-events: none;
    }

    .featured-article-img {
        width: 100%;
        height: auto;
        border-radius: 4px;
        margin-bottom: 40px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        border: 10px solid #ffffff;
    }

    .blog-article-content {
        font-size: 1.15rem;
        line-height: 1.9;
        color: #333;
        font-family: 'Inter', sans-serif;
    }

    .blog-article-content p {
        margin-bottom: 25px;
    }

    .blog-article-content h2, .blog-article-content h3 {
        font-family: 'Playfair Display', serif;
        color: #1B4D3E;
        margin-top: 40px;
        margin-bottom: 20px;
    }

    .blog-footer-nav {
        margin-top: 60px;
        padding-top: 40px;
        border-top: 1px solid rgba(218, 165, 32, 0.2);
        display: flex;
        justify-content: center;
    }

    .btn-royal-back {
        background: transparent;
        border: 2px solid #1B4D3E;
        color: #1B4D3E;
        padding: 12px 30px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-royal-back:hover {
        background: #1B4D3E;
        color: white;
        transform: translateX(-5px);
    }

    @media (max-width: 768px) {
        .blog-detail-title {
            font-size: 2.2rem;
        }
        .royal-article-container {
            padding: 30px 20px;
        }
    }
</style>

<section class="blog-detail-hero text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <span class="blog-meta-top">
                    <i class="fa fa-calendar-alt me-2 text-gold"></i> {{ $blog->published_at->format('F d, Y') }}
                    <span class="mx-3 opacity-50">|</span>
                    <i class="fa fa-folder-open me-2 text-gold"></i> {{ $blog->category ?? 'Culinary Chronicle' }}
                </span>
                <h1 class="blog-detail-title">{{ $blog->title }}</h1>
                <div class="separator-line"></div>
                @if($blog->published_at)
                    <p class="mb-0 opacity-75" style="letter-spacing: 2px;">
                        ESTIMATED READ: {{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} MIN
                    </p>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="blog-content-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <article class="royal-article-container">
                    <div class="row g-5 align-items-start">
                        @if($blog->image)
                        <div class="col-lg-5">
                            <div class="sticky-top" style="top: 100px; z-index: 1;">
                                <img src="{{ \Illuminate\Support\Str::contains($blog->image, 'http') ? $blog->image : asset($blog->image) }}" alt="{{ $blog->title }}" class="featured-article-img mb-0">
                                <div class="mt-4 p-4 text-center" style="background: rgba(27, 77, 62, 0.03); border: 1px dashed rgba(218, 165, 32, 0.3);">
                                    <p class="mb-0 text-muted italic small">"A glimpse into our heritage and culinary traditions."</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="{{ $blog->image ? 'col-lg-7' : 'col-lg-12' }}">
                            <div class="blog-article-content">
                                {!! nl2br(e($blog->content)) !!}
                            </div>
                        </div>
                    </div>

                    <div class="blog-footer-nav">
                        <a href="{{ route('blog') }}" class="btn-royal-back">
                            <i class="fa fa-arrow-left me-3"></i> Return to Culinary Chronicles
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
@endsection
