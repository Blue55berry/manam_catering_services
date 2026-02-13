<!-- Custom Header for All Pages -->
<header class="dakshin-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xl-3 col-lg-3 col-md-3 col-4">
                <a href="{{ route('home') }}" class="dakshin-logo-wrapper">
                     <img src="{{ asset('assets/images/main/logo.png') }}" alt="Catering Services" style="max-height: 50px;">
                </a>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-9 col-8">
                <nav class="dakshin-nav d-none d-lg-flex">
                    <a href="{{ route('home') }}" class="dakshin-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('menu') }}" class="dakshin-nav-link {{ request()->routeIs('menu') ? 'active' : '' }}">Menu</a>
                    <a href="{{ route('events') }}" class="dakshin-nav-link {{ request()->routeIs('events') ? 'active' : '' }}">Events</a>
                    <a href="{{ route('blog') }}" class="dakshin-nav-link {{ request()->routeIs('blog') || request()->routeIs('blog.show') ? 'active' : '' }}">Blog</a>
                    <a href="{{ route('about') }}" class="dakshin-nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
                    <a href="{{ route('contact') }}" class="dakshin-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact Us</a>
                    <a href="{{ route('events.book') }}" class="btn btn-primary-dakshin text-white">Get Free Quote</a>
                </nav>
                <!-- Mobile Toggle -->
                <button class="d-lg-none btn btn-link text-dakshin-green float-end mobile-menu-toggle" id="mobileMenuToggle">
                    <i class="fa fa-bars fa-2x"></i>  
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay">
    <div class="mobile-menu-container">
        <div class="mobile-menu-header">
            <img src="{{ asset('assets/images/main/logo.png') }}" alt="Catering Services" class="mobile-menu-logo">
            <button class="mobile-menu-close" id="mobileMenuClose">
                <i class="fa fa-times fa-2x"></i>
            </button>
        </div>
        <nav class="mobile-menu-nav">
            <a href="{{ route('home') }}" class="mobile-menu-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fa fa-home"></i> Home
            </a>
            <a href="{{ route('menu') }}" class="mobile-menu-link {{ request()->routeIs('menu') ? 'active' : '' }}">
                <i class="fa fa-cutlery"></i> Menu
            </a>
            <a href="{{ route('events') }}" class="mobile-menu-link {{ request()->routeIs('events') ? 'active' : '' }}">
                <i class="fa fa-calendar"></i> Events
            </a>
            <a href="{{ route('blog') }}" class="mobile-menu-link {{ request()->routeIs('blog') || request()->routeIs('blog.show') ? 'active' : '' }}">
                <i class="fa fa-book"></i> Blog
            </a>
            <a href="{{ route('about') }}" class="mobile-menu-link {{ request()->routeIs('about') ? 'active' : '' }}">
                <i class="fa fa-info-circle"></i> About Us
            </a>
            <a href="{{ route('contact') }}" class="mobile-menu-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                <i class="fa fa-envelope"></i> Contact Us
            </a>
            <a href="{{ route('events.book') }}" class="btn btn-primary-dakshin text-white mobile-menu-cta">
                Get Free Quote
            </a>
        </nav>
    </div>
</div>

