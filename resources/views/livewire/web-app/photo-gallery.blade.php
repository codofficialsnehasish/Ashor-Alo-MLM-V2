<div class="banner-area pt-70">
    @if($photo_gallarys->isNotEmpty())
    <div class="section-title text-center mb-20 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.2s; animation-name: fadeIn;">
        <h2>Our Gallary</h2>
        <!-- <p>Our collection hover on a look you like to shop the items featured</p> -->
    </div>

    <div class="banner-bottom padding-20-row-col mt-20">
        <div class="custom-container-2">
            <div class="row">
                @foreach ($photo_gallarys as $photo_gallary)
                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="banner-wrap mb-30 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                        <div class="banner-img-2">
                            <a href="javascript:void(0);">
                                <img src="{{ $photo_gallary->getFirstMediaUrl('gallery_images', 'thumb') }}" alt="logo">
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>