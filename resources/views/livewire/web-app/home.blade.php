<div>
    @if($sliders->isNotEmpty())
    <div class="custom-container-2 slider_warp">
        <div class="slider-area">
            <div class="slider-active-1 owl-carousel nav-style-2">
                @foreach($sliders as $slider)
                <div class="single-slider bg-img slider-height-2 align-items-center custom-d-flex" style="background-image:url({{ $slider->getFirstMediaUrl('gallery_images') }});">
                    <div class="container">
                        <div class="row height-100-percent align-items-center">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                <div class="slider-content-8 slider-animated-1">
                                    <h1 class="animated">Ashoralo</h1>
                                    <p>{{ $slider->description }}</p>
                                    <div class="slider-btn-1">
                                        <a class="animated" href="#">Join Us</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <div class="product-area pt-70 pb-60">
    <div class="custom-container-2">
        <div class="section-title text-center mb-20 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
            <h2>All Categories</h2>
            <!-- <p>Our collection hover on a look you like to shop the items featured</p> -->
        </div>
        <div class="product-slider-active owl-carousel dot-style-1 wow fadeIn" data-wow-duration="1s"
            data-wow-delay="0.4s">
            <div class="product-wrap">
                <div class="product-img mb-25">
                <a href="#">
                <img class="default-img"src="{{ asset('web-assets/images/product/cat-1.jpg') }}" alt="">
                </a>
                </div>
                <div class="product-content text-center">
                <h3><a href="#">Hotel</a></h3>
                </div>
            </div>
            <div class="product-wrap">
                <div class="product-img mb-25">
                <a href="#">
                <img class="default-img"src="{{ asset('web-assets/images/product/cat-2.jpg') }}" alt="">
                </a>
                </div>
                <div class="product-content text-center">
                <h3><a href="#">Restaurant</a></h3>
                </div>
            </div>
            <div class="product-wrap">
                <div class="product-img mb-25">
                <a href="#">
                <img class="default-img"src="{{ asset('web-assets/images/product/cat-3.jpg') }}" alt="">
                </a>
                </div>
                <div class="product-content text-center">
                <h3><a href="#">Sali Land</a></h3>
                </div>
            </div>
            <div class="product-wrap">
                <div class="product-img mb-25">
                <a href="#">
                <img class="default-img"src="{{ asset('web-assets/images/product/cat-4.jpg') }}" alt="">
                </a>
                </div>
                <div class="product-content text-center">
                <h3><a href="#">Grocery</a></h3>
                </div>
            </div>
            <div class="product-wrap">
                <div class="product-img mb-25">
                <a href="#">
                <img class="default-img"src="{{ asset('web-assets/images/product/cat-1.jpg') }}" alt="">
                </a>
                </div>
                <div class="product-content text-center">
                <h3><a href="#">Hotel</a></h3>
                </div>
            </div>
            <div class="product-wrap">
                <div class="product-img mb-25">
                <a href="#">
                <img class="default-img"src="{{ asset('web-assets/images/product/cat-2.jpg') }}" alt="">
                </a>
                </div>
                <div class="product-content text-center">
                <h3><a href="#">Restaurant</a></h3>
                </div>
            </div>
            <div class="product-wrap">
                <div class="product-img mb-25">
                <a href="#">
                <img class="default-img"src="{{ asset('web-assets/images/product/cat-3.jpg') }}" alt="">
                </a>
                </div>
                <div class="product-content text-center">
                <h3><a href="#">Sali Land</a></h3>
                </div>
            </div>
            <div class="product-wrap">
                <div class="product-img mb-25">
                <a href="#">
                <img class="default-img"src="{{ asset('web-assets/images/product/cat-4.jpg') }}" alt="">
                </a>
                </div>
                <div class="product-content text-center">
                <h3><a href="#">Grocery</a></h3>
                </div>
            </div>
        </div>
    </div>
    </div>
    
    <div class="position-fixed end-0 top-50 translate-middle-y mt-5 me-3" style="z-index: 1030;">
        <!-- Collapsed State (Initial) -->
        <div id="expandableContainer" class="border p-3 d-flex flex-row-reverse align-items-center overflow-hidden" 
            style="height: 200px; width: 70px; transition: all 0.5s ease; cursor: pointer; background-color: transparent;">
            <!-- Horizontal Image (Clickable) -->
            <div class="d-flex align-items-center" onclick="toggleContainer()">
            <img id="indicator" style="height: 35px; transition: transform 0.3s ease;" 
                src="{{ asset('web-assets/images/notice/left-indicator.png') }}" alt="Indicator">
            </div>
            
            <!-- Hidden Content (Will be revealed) -->
            <div id="hiddenContent" class="h-100" style="display: none; overflow-x: auto;">
                <div  style="width: 100%; max-width: 500px;">
                    <h3 class="font-bold text-lg text-blue-800 mb-2 text-center pt-3">Latest Notices</h3>
                    <div class="space-y-3">
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
        </div>
    </div>

    @if($products->isNotEmpty())
    <div class="product-area wow fadeIn" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeIn;">
        <div class="custom-container-2 top_warp">
            <div class="section-title text-center mb-20 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
                <h2>Our Products</h2>
                <!-- <p>Our collection hover on a look you like to shop the items featured</p> -->
            </div>
            <div class="all-product-btn text-right mb-25 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.3s">
                <a wire:navigate href="{{ route('site-products') }}">View all products</a>
            </div>
            <div class="row">
                @foreach ($products as $product)
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6">
                    <div class="product-wrap mb-40">
                    <div class="product-img mb-25">
                        <a href="javascript:void(0);">
                        @if ($product->getFirstMediaUrl('products'))
                        <img class="default-img" src="{{ $product->getFirstMediaUrl('products') }}" alt="">
                        @else
                        <img class="default-img" src="{{ asset('no-image.jpg') }}" alt="">
                        @endif
                        </a>
                    </div>
                    <div class="product-content text-center">
                        <h3><a href="javascript:void(0);">{{ $product->title }}</a></h3>
                        {{-- <p>3W Bajaj RE-175 & 205</p> --}}
                        <div class="product-price price-color-2">
                            <span>Rs.{{ $product->total_price }}</span>
                        </div>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @if($offer_sliders->isNotEmpty())
    <div class="banner-area pt-70">
        <div class="section-title text-center mb-20 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.2s; animation-name: fadeIn;">
            <h2>Our Offer</h2>
            <!-- <p>Our collection hover on a look you like to shop the items featured</p> -->
        </div>
        <div class="banner-bottom padding-20-row-col mt-20">
            <div class="custom-container-2">
                <div class="row">
                    @foreach ($offer_sliders as $offer_slider)
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="banner-wrap mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                            <div class="banner-img-2">
                                <a href="javascript:void(0);"><img src="{{ $offer_slider->getFirstMediaUrl('gallery_images', 'thumb') }}"alt="banner"></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($setting)
    <div class="about-us-area homeabot_rap pt-100 pb-100">
        <div class="custom-container-2">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="about-us-img">
                        @if($setting->hasMedia('about-image'))
                        <img src="{{ $setting->getFirstMediaUrl('about-image') }}" alt="logo">
                        @endif
                    </div>
                </div>
                <div class="col-lg-8 col-md-6">
                    <div class="about-us-content">
                        <h2>{{ $setting->about_us_title ??  '' }}</h2>
                        <p>{{ $setting->about_us ??  '' }}</p>
                        <a target="_blank" href="#" class="btn btn-primary  mt-3">Join Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
