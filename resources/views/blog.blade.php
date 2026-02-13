@extends('layouts.app')

@section('title', 'Culinary Chronicles - Manam Blog')

@section('content')
<style>
    .blog-hero {
        position: relative;
        background: linear-gradient(135deg, #1B4D3E 0%, #0d2b22 100%);
        padding: 100px 0 80px;
        overflow: hidden;
    }

    .blog-hero::after {
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

    .blog-hero .container {
        position: relative;
        z-index: 2;
    }

    .blog-section {
        background-color: #FAFAF5;
        position: relative;
    }

    .blog-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 10px;
        background: linear-gradient(to right, #1B4D3E, #DAA520, #1B4D3E);
        z-index: 5;
    }

    /* Royal Blog Card */
    .royal-blog-card {
        background: #FFFDF5;
        border: 1px solid rgba(218, 165, 32, 0.3);
        border-radius: 4px;
        overflow: hidden;
        height: 100%;
        transition: all 0.4s ease;
        position: relative;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .royal-blog-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        border-color: rgba(218, 165, 32, 0.6);
    }

    .royal-blog-card::before {
        content: '';
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        bottom: 10px;
        border: 1px solid rgba(218, 165, 32, 0.1);
        pointer-events: none;
        z-index: 2;
    }

    .blog-img-container {
        position: relative;
        height: 240px;
        overflow: hidden;
    }

    .blog-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .royal-blog-card:hover .blog-img-container img {
        transform: scale(1.1);
    }

    .blog-date-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: #DAA520;
        color: white;
        padding: 5px 15px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 3;
        border-radius: 2px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .blog-body {
        padding: 30px 25px;
        text-align: center;
    }

    .blog-category {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #DAA520;
        font-weight: 700;
        margin-bottom: 12px;
        display: block;
    }

    .blog-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: #1B4D3E;
        margin-bottom: 15px;
        line-height: 1.4;
        transition: color 0.3s ease;
    }

    .blog-title a {
        text-decoration: none;
        color: inherit;
    }

    .blog-title a:hover {
        color: #DAA520;
    }

    .blog-text {
        font-size: 0.95rem;
        color: #555;
        line-height: 1.7;
        margin-bottom: 20px;
    }

    .blog-link {
        color: #1B4D3E;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        padding-bottom: 5px;
    }

    .blog-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: #DAA520;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .blog-link:hover::after {
        width: 100%;
    }

    .blog-link i {
        margin-left: 5px;
        transition: transform 0.3s ease;
    }

    .blog-link:hover i {
        transform: translateX(5px);
    }

    .pagination-wrapper .pagination {
        justify-content: center;
    }

    .pagination-wrapper .page-link {
        color: #1B4D3E;
        border-color: rgba(218, 165, 32, 0.3);
        background-color: #FFFDF5;
        margin: 0 5px;
    }

    .pagination-wrapper .page-item.active .page-link {
        background-color: #1B4D3E;
        border-color: #1B4D3E;
    }
</style>

<section class="blog-hero">
    <div class="container text-center text-white">
        <p class="section-subtitle text-gold fw-bold text-uppercase tracking-widest mb-2" style="color: #DAA520;">Culinary Chronicles</p>
        <h1 class="display-4 fw-bold mb-3 text-white" style="font-family: 'Playfair Display', serif;">Our Blog</h1>
        <div class="separator-line mx-auto mb-4" style="width: 100px; height: 3px; background: linear-gradient(90deg, transparent, #DAA520, transparent);"></div>
        <p class="lead mx-auto" style="max-width: 700px; opacity: 0.9;">Discover the stories, traditions, and craftsmanship behind Dakshin's most celebrated flavors.</p>
    </div>
</section>

<section class="blog-section py-5">
    <div class="container py-4">
        <div class="row g-4">
            @forelse($blogs as $blog)
                <div class="col-lg-4 col-md-6">
                    <article class="royal-blog-card">
                        <div class="blog-img-container">
                            <a href="{{ route('blog.show', $blog->slug) }}">
                                @if($blog->image)
                                    <img src="{{ \Illuminate\Support\Str::contains($blog->image, 'http') ? $blog->image : asset($blog->image) }}" alt="{{ $blog->title }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 bg-dark">
                                        <i class="fa fa-utensils fa-4x text-gold opacity-50"></i>
                                    </div>
                                @endif
                            </a>
                            <div class="blog-date-badge">
                                {{ $blog->published_at->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="blog-body">
                            <span class="blog-category">{{ $blog->category ?? 'Catering & Heritage' }}</span>
                            <h3 class="blog-title">
                                <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                            </h3>
                            <p class="blog-text">
                                {{ $blog->excerpt ?? Str::limit(strip_tags($blog->content), 110) }}
                            </p>
                            <a href="{{ route('blog.show', $blog->slug) }}" class="blog-link">
                                Read More <i class="fa fa-chevron-right small"></i>
                            </a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="empty-state">
                        <i class="fa fa-feather fa-4x mb-4" style="color: #DAA520; opacity: 0.5;"></i>
                        <h3 style="font-family: 'Playfair Display', serif; color: #1B4D3E;">No Culinary Stories Yet</h3>
                        <p class="text-muted">Our experts are currently crafting new stories for you.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($blogs->hasPages())
            <div class="row mt-5">
                <div class="col-12 pagination-wrapper">
                    {{ $blogs->links() }}
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
