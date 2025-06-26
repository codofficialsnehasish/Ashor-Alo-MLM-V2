<div class="contact-us-area pt-100 pb-100">
            <div class="custom-container">
                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <div class="get-in-touch-wrap">
                            <div class="contact-title">
                                <h3>Get in touch</h3>
                            </div>
                            <div class="contact-from">
                                @if($successMessage)
                                    <div class="alert alert-success">
                                        {{ $successMessage }}
                                    </div>
                                @endif
                                
                                @if(count($errorMessages) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errorMessages as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form wire:submit.prevent="submit">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input wire:model="name" type="text" placeholder="Your name*">
                                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-lg-12">
                                            <input wire:model="email_or_phone" type="text" placeholder="Email or Phone*">
                                            @error('email_or_phone') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-lg-12">
                                            <textarea wire:model="message" placeholder="Message"></textarea>
                                            @error('message') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-lg-12">
                                            <button class="submit" type="submit">SEND</button>
                                        </div>
                                    </div>
                                </form>
                                <p class="form-messege"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="contact-info-wrap">
                            <div class="contact-title">
                                <h3>Contact info</h3>
                            </div>
                            <div class="contact-info-bottom">
                                <div class="single-contact-info">
                                    <h5>Postal Address</h5>
                                    <p>Thacker House, 35, Chittaranjan Avenue, 4th Floor, Kolkata 700012, Near 5 No Gate Chandni Metro, West Bengal</p>
                                </div>
                               
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="single-contact-info">
                                            <h5>Business Phone</h5>
                                            <p><a href="#">+91 123456789</a></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="single-contact-info">
                                            <h5>Say Hello</h5>
                                            <p><a href="#">ashoralo.in@gmail.com</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>