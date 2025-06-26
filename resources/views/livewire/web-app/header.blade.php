
<div>
    <header class="header-area">
        <div class="main-header-wrap">
            <div class="site-header-outer">
                <div class="intelligent-header">
                    <div class="header-middle">
                    <div class="custom-container">
                        <div class="row align-items-center">
                            <div class="col-xl-2 col-lg-3">
                                <div class="logo">
                                <a wire:navigate href="{{ route('home') }}"><img src="{{ asset('web-assets/images/logo/ashoralo.png') }}" alt="logo"></a>
                                </div>
                            </div>
                            <div class="col-xl-10 col-lg-9 position-static">
                                <div class="main-menu menu-lh-3 main-menu-blod main-menu-center">
                                <nav>
                                    <ul>
                                        <li><a class="active" wire:navigate href="{{ route('home') }}">Home</a></li>
                                        <li><a wire:navigate href="{{ route('about') }}" >About</a></li>
                                        <li class="position-static"><a wire:navigate href="{{ route('site-products') }}">Products</a></li>
                                        <li><a wire:navigate href="{{ route('photo-gallery') }}">Photo Gallery</a></li>
                                        <li><a wire:navigate href="{{ route('legal') }}">Legal / Affiliation</a></li>
                                        <li><a wire:navigate href="{{ route('contact') }}">Contact</a></li>
                                        <li class="lis_t"><a href="#">Login</a></li>
                                        <li class="lis_t"><a href="#">Signup</a></li>
                                        <!-- <li><a href="#">Soft Toys</a></li>
                                            <li><a href="#">Sweets</a></li>
                                            -->
                                    </ul>
                                </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-small-mobile">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-6">
                    <div class="mobile-logo logo-width">
                        <a href="{{ route('home') }}">
                        <img src="{{ asset('web-assets/images/logo/ashoralo.png') }}" alt="logo">
                        </a>
                    </div>
                    </div>
                    <div class="col-6">
                    <div class="mobile-header-right-wrap">
                        <div class="mobile-off-canvas">
                            <a class="mobile-aside-button" href="#"><i class="dl-icon-menu2"></i></a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="mobile-off-canvas-active">
        <a class="mobile-aside-close"><i class="dl-icon-close"></i></a>
        <div class="header-mobile-aside-wrap">
            <div class="mobile-menu-wrap">
                <!-- mobile menu start -->
                <div class="mobile-navigation">
                    <!-- mobile menu navigation start -->
                    <nav>
                        <ul class="mobile-menu">
                            <li class="menu-item-has-children"><a href="{{ route('home') }}">Home</a>  </li>
                            <li><a href="{{ route('about') }}">About</a></li>
                            <li><a href="{{ route('site-products') }}">Products</a></li>
                            <li><a href="{{ route('photo-gallery') }}">Photo Gallery</a></li>
                            <li><a href="{{ route('legal') }}">Legal / Affiliation</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                            <li><a href="#">Login</a></li>
                            <li><a href="#">Signup</a></li>
                        </ul>
                    </nav>
                    <!-- mobile menu navigation end -->
                </div>
                <!-- mobile menu end -->
            </div>
            <div class="mobile-social-wrap">
                <a class="facebook" href="#"><i class="fa fa-facebook"></i></a>
                <a class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                <a class="pinterest" href="#"><i class="fa fa-pinterest-p"></i></a>
                <a class="instagram" href="#"><i class="fa fa-instagram"></i></a>
                <a class="google" href="#"><i class="fa fa-behance"></i></a>
            </div>
        </div>
    </div>

    <a class="btn btn-primary notic_warp blink" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
        <span>Latest Notices click Here</span>
    </a>


    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <div class="notic_warp2">
                @foreach($notices as $notice)
                    <div class="bg-white p-3 rounded shadow-sm">
                        <h4 class="font-semibold text-gray-800">{{ $notice->title }}</h4>
                        <p class="text-gray-600 mt-1 text-wrap">{{ $notice->content }}</p>
                        <div class="text-sm text-gray-500 mt-2">
                            Valid until: {{ $notice->end_date->format('d M Y') }}
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
</div>