<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.min.css') }}">
    <!-- Font Awesome from CDN for reliable icon loading -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-menu-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-contact-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home-redesign.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/global-fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/success-alert.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home-responsive.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/menu-custom.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('assets/css/menu-redesign.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom-footer-styles.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/mobile-nav.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/blog-styles.css') }}?v={{ time() }}">
    <link rel="stylesheet" id="color-change" type="text/css" href="#">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/main/favicon.png') }}" />
   <title>@yield('title', 'Catering Services')</title>
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <style>
       /* Force immediate visibility */
       .cat-main-wrapper { opacity: 1 !important; visibility: visible !important; display: block !important; }
       .slim-loading-bar { height: 4px; }
   </style>
</head>

<body class="{{ request()->routeIs('home') ? 'is-home' : '' }}">
    <!-- Slim Top Loading Bar -->
    <div class="slim-loading-bar"></div>

    @include('partials.search-box')
    
    @unless(isset($useCustomHeader))
        @include('partials.header')
    @endunless

    <div class="cat-main-wrapper">
        @yield('content')
    </div>

    @include('partials.footer')

    <!-- GO To Top -->
    <a href="javascript:void(0);" class="scroll-to-topp"><span class="fa fa-angle-up"></span></a>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.mixitup.min.js') }}"></script>
    <script src="{{ asset('assets/js/main-custom.js') }}"></script>
    <script src="{{ asset('assets/js/navigation-fix.js') }}"></script>
    <script src="{{ asset('assets/js/sticky-nav.js') }}"></script>
    <script src="{{ asset('assets/js/food-slider.js') }}"></script>
    <script src="{{ asset('assets/js/chef-carousel.js') }}"></script>
    <script src="{{ asset('assets/js/testimonial-carousel.js') }}"></script>
    <script src="{{ asset('assets/js/count-up-animation.js') }}"></script>
    <script src="{{ asset('assets/js/hero-carousel.js') }}"></script>
    <script src="{{ asset('assets/js/cart-app.js') }}"></script>
    <script src="{{ asset('assets/js/mobile-menu.js') }}"></script>
</body>
</html>
