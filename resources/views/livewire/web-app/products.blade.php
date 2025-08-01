<div class="product-area pro_warp wow fadeIn" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeIn;">
    <div class="custom-container-2 top_warp">
        @if($products->isNotEmpty())
        <div class="section-title text-center mb-20 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.2s; animation-name: fadeIn;">
            <h2>Our Products</h2>
            <!-- <p>Our collection hover on a look you like to shop the items featured</p> -->
        </div>
        <div class="all-product-btn text-right mb-25 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.3s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.3s; animation-name: fadeIn;">
            {{-- <a href="javascript:void(0);">View all products</a> --}}
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
        @endif
    </div>
</div>