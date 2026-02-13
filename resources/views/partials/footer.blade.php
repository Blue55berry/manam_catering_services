<!-- Footer Start -->
<footer>
    <div class="cat-footer-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                    <div class="cat-widget cat-foot-menu">
                        <h4 class="footer-title">About Manam Catering</h4>
                        <p>Authentic South Indian catering services offering traditional flavors and modern hospitality for your special occasions.</p>
                        <div class="cat-social-link">
                            <ul>
                                <li><a href="javascript:void(0);"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="javascript:void(0);"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="javascript:void(0);"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                <li><a href="javascript:void(0);"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                    <div class="cat-widget cat-foot-menu">
                        <h4 class="footer-title">Our Menu</h4>
                        <div class="footer-menu">
                            <ul>
                                <li><a href="{{ route('menu') }}">Breakfast</a></li>
                                <li><a href="{{ route('menu') }}">Lunch</a></li>
                                <li><a href="{{ route('menu') }}">Dinner</a></li>
                                <li><a href="{{ route('menu') }}">Catering Packages</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                    <div class="cat-widget cat-foot-menu">
                        <h4 class="footer-title">Contact Us</h4>
                        <div class="footer-menu contact-menu">
                                <li>
                                    <a href="javascript:void(0);" class="d-flex align-items-center">
                                        <i class="fa fa-map-marker me-2 pe-2"></i>
                                        <p class="mb-0">Northern Territory 0862 Australia</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="d-flex align-items-center">
                                        <i class="fa fa-phone me-2 pe-2"></i>
                                        <p class="mb-0">(+91) 9999 8888 666</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="d-flex align-items-center">
                                        <i class="fa fa-clock-o me-2 pe-2"></i>
                                        <p class="mb-0">24/7 Hours Service</p>
                                    </a>
                                </li>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                    <div class="cat-widget cat-foot-menu">
                        <h4 class="footer-title">Social Gallery</h4>
                        <div class="insta-picture">
                            <div class="row">
                                @for($i = 1; $i <= 6; $i++)
                                <div class="col-md-4 col-sm-4 col-4">
                                    <div class="footer-img">
                                        <a href="javascript:void(0);">
                                            <img src="{{ asset('assets/images/main/event/0' . $i . '.jpg') }}" alt="">
                                        </a>
                                    </div>
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cat-footer-copyright">
        <p>Copyright © {{ date('Y') }} Manam Catering Service. All Rights Reserved.</p>
    </div>
</footer>
