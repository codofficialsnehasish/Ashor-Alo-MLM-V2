<div class="about-us-area homeabot_rap pt-100 pb-100">
    <div class="custom-container-2">
        @if($setting)
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
        @endif
    </div>
</div>