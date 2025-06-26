<div>
    <footer class="footer-area border-top-2 pt-50">
        <div class="footer-top">
            <div class="custom-container">
                <div class="row">
                    <div class="footer-column footer-column-1">
                    <div class="footer-widget footer-about-2 mb-30">
                        <div class="footer-logo-2">
                            <a wire:navigate href="{{ route('home') }}"><img src="{{ asset('web-assets/images/logo/ashoralo.png') }}" alt="logo"></a>
                        </div>
                    </div>
                    </div>
                    <div class="footer-column footer-column-2">
                    <div class="footer-widget mb-30">
                        <div class="widget-title">
                            <h3>Company</h3>
                        </div>
                        <div class="footer-list">
                            <ul>
                                <li><a wire:navigate href="{{ route('about') }}">About Us</a></li>
                                <li><a wire:navigate href="{{ route('site-products') }}">Products</a></li>
                                <li><a wire:navigate href="{{ route('legal') }}">Certificate</a></li>
                                <li><a wire:navigate href="{{ route('contact') }}">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                    </div>
                    <div class="footer-column footer-column-3">
                    <div class="footer-widget mb-30">
                        <div class="widget-title">
                            <h3>Resources</h3>
                        </div>
                        <div class="footer-list">
                            <ul>
                                <li><a wire:navigate href="{{ route('legal') }}">Legal / Affiliation</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a wire:navigate href="{{ route('photo-gallery') }}">Photo Gallery</a></li>
                            </ul>
                        </div>
                    </div>
                    </div>
                    <div class="footer-column footer-column-4">
                    <div class="footer-widget mb-30">
                        <div class="widget-title">
                            <h3>Support</h3>
                        </div>
                        <div class="footer-list">
                            <ul>
                                <li><a wire:navigate href="{{ route('contact') }}">Help</a></li>
                                <li><a href="#">Login</a></li>
                                <li><a href="#">Signup</a></li>
                                <li><a wire:navigate href="{{ route('contact') }}">Contact Support</a></li>
                            </ul>
                        </div>
                    </div>
                    </div>
                    <!--    <div class="footer-column footer-column-5">
                    <div class="footer-widget mb-30">
                        <div class="widget-title">
                            <h3>PROFILE</h3>
                        </div>
                        <div class="footer-list">
                            <ul>
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">Checkout</a></li>
                                <li><a href="#">Order tracking</a></li>
                                <li><a href="#">Help & Support</a></li>
                            </ul>
                        </div>
                    </div>
                    </div> -->
                    <div class="footer-column footer-column-6">
                    <div class="footer-widget subscribe-right mb-30">
                        <div class="widget-title">
                            <h3>Get The Latest Updates:</h3>
                            <p>Signup for offers & exclusive discounts.</p>
                        </div>
                        <div id="mc_embed_signup" class="subscribe-form-2 mt-20">
                            <form id="mc-embedded-subscribe-form" class="validate subscribe-form-style"
                                novalidate="" name="mc-embedded-subscribe-form" method="post"
                                action="https://devitems.us11.list-manage.com/subscribe/post?u=6bbb9b6f5827bd842d9640c82&amp;id=05d85f18ef">
                                <div id="mc_embed_signup_scroll" class="mc-form-2">
                                <input class="email" type="email" required=""
                                    placeholder="Enter your email address..." name="EMAIL" value="">
                                <div class="mc-news-2" aria-hidden="true">
                                    <input type="text" value="" tabindex="-1"
                                        name="b_6bbb9b6f5827bd842d9640c82_05d85f18ef">
                                </div>
                                <div class="clear-2">
                                    <input id="mc-embedded-subscribe" class="button" type="submit"
                                        name="subscribe" value="Submit">
                                </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom pt-25 pb-15">
            <div class="custom-container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="footer-widget footer-social-2">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-pinterest-p"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-behance"></i></a>
                    </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="footer-widget copyright-2 text-center">
                        <p>© 2025 by Ashor Alo. Crafted with  by <a href="#">Code of Dolphins</a></p>
                    </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="footer-widget payments-img">
                        <a href="#"><img src="{{ asset('web-assets/images/icon-img/payments.png') }}" alt="payments"></a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
