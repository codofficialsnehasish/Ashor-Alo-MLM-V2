<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-body p-4">
                    <h4 class="mb-4 text-center fw-bold">Sign Up</h4>

                    <form wire:submit.prevent="submit">
                        {{-- Sponsor ID --}}
                        <div class="mb-3">
                            <label class="form-label">Sponsor ID</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                                <input type="number"
                                    wire:model.live="sponsor_id"
                                    class="form-control @error('sponsor_id') is-invalid @enderror"
                                    placeholder="Enter Sponsor ID">
                            </div>
                            @error('sponsor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Sponsor Name (readonly) --}}
                        <div class="mb-3">
                            <label class="form-label">Sponsor Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $sponsorName }}"
                                    wire:model="sponsor_name"
                                    placeholder="Sponsor Name"
                                    readonly>
                            </div>
                        </div>

                        {{-- Your Name --}}
                        <div class="mb-3">
                            <label class="form-label">Your Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                                <input type="text" wire:model="name" class="form-control" placeholder="Enter your name">
                            </div>
                        </div>

                        {{-- Position --}}
                        <div class="mb-3">
                            <label class="form-label">Position</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-diagram-3"></i></span>
                                <select wire:model="position" class="form-select">
                                    <option value="">Choose</option>
                                    <option value="left">Left</option>
                                    <option value="right">Right</option>
                                </select>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                                <input type="email" wire:model="email" class="form-control" placeholder="name@address.com">
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-phone"></i></span>
                                <input type="text" wire:model="phone" class="form-control" placeholder="Enter your phone number">
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" wire:model="terms" id="terms">
                            <label class="form-check-label small" for="terms">
                                I agree to the <a href="#" class="text-decoration-none">Terms and Conditions</a>
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-pink fw-semibold">Sign up</button>
                        </div>
                    </form>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @error('form') <div class="alert alert-danger">{{ $message }}</div> @enderror

                    {{-- Confirmation Modal --}}
                    @if($showConfirmModal)
                        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); display: flex; justify-content: center; align-items: center; z-index: 1000;">
                            <div style="background: white; border-radius: 12px; width: 90%; max-width: 500px; box-shadow: 0 10px 30px rgba(0,0,0,0.25); overflow: hidden;">
                                <div style="padding: 20px; border-bottom: 1px solid #eaeaea; display: flex; justify-content: space-between; align-items: center;">
                                    <h3 style="margin: 0; font-family: 'Segoe UI', Arial, sans-serif; color: #2c3e50; font-weight: 600;">Confirm Registration</h3>
                                    <button style="background: none; border: none; font-size: 24px; cursor: pointer; color: #7f8c8d;" wire:click="$set('showConfirmModal',false)">×</button>
                                </div>
                                
                                <div style="padding: 25px;" wire:ignore>
                                    <div style="margin-bottom: 15px;">
                                        <strong style="display: inline-block; width: 120px; color: #34495e;">Sponsor ID:</strong>
                                        <span style="color: #2c3e50;">{{ $sponsor_id }}</span>
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <strong style="display: inline-block; width: 120px; color: #34495e;">Sponsor Name:</strong>
                                        <span style="color: #2c3e50;">{{ $sponsorName }}</span>
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <strong style="display: inline-block; width: 120px; color: #34495e;">Name:</strong>
                                        <span style="color: #2c3e50;">{{ $name }}</span>
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <strong style="display: inline-block; width: 120px; color: #34495e;">Position:</strong>
                                        <span style="color: #2c3e50;">{{ $position }}</span>
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <strong style="display: inline-block; width: 120px; color: #34495e;">Email:</strong>
                                        <span style="color: #2c3e50;">{{ $email }}</span>
                                    </div>
                                    <div style="margin-bottom: 15px;">
                                        <strong style="display: inline-block; width: 120px; color: #34495e;">Phone:</strong>
                                        <span style="color: #2c3e50;">{{ $phone }}</span>
                                    </div>
                                </div>
                                
                                <div style="padding: 20px; background: #f8f9fa; display: flex; justify-content: flex-end; gap: 10px;">
                                    <button style="padding: 10px 20px; background: #95a5a6; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 500;" wire:click="$set('showConfirmModal',false)">Cancel</button>
                                    <button style="padding: 10px 20px; background: #27ae60; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 500;" wire:click="register">Confirm & Register</button>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Success Modal --}}
                    @if($showSuccessModal)
                        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); display: flex; justify-content: center; align-items: center; z-index: 1000;">
                            <div style="background: white; border-radius: 12px; width: 90%; max-width: 500px; box-shadow: 0 10px 30px rgba(0,0,0,0.25); overflow: hidden;">
                                <div style="padding: 20px; border-bottom: 1px solid #eaeaea; display: flex; justify-content: space-between; align-items: center;">
                                    <h3 style="margin: 0; font-family: 'Segoe UI', Arial, sans-serif; color: #2c3e50; font-weight: 600;">Signup Successfully</h3>
                                    <button style="background: none; border: none; font-size: 24px; cursor: pointer; color: #7f8c8d;" wire:click="$set('showSuccessModal',false)">×</button>
                                </div>
                                
                                {{-- <div style="padding: 25px;" wire:ignore>
                                    <img src="{{ asset('web-assets/images/success.gif')}}" alt="">
                                </div> --}}
                                <div style="padding: 30px 20px 10px; background: linear-gradient(to bottom, #f8f9fa, white);">
                                    <div style="width: 100%; display: flex; justify-content: center;">
                                        <img src="{{ asset('web-assets/images/success.gif') }}" alt="Success" style="max-width: 180px; height: auto;">
                                    </div>
                                </div>
                                    
                                <!-- Content -->
                                <div style="padding: 20px 30px; text-align: center;">
                                    <h2 style="margin: 10px 0; color: #2c3e50; font-weight: 600; font-size: 24px;">Signup Successful!</h2>
                                    <p style="color: #7f8c8d; line-height: 1.6; margin-bottom: 20px; font-size: 16px; text-align: center;">
                                        Hi, <strong style="color: #2c3e50;">{{ $user_name ?? 'fgh54tfrh' }}</strong> ! Your ID is <strong style="color: #2c3e50;">{{ $generated_member_number }}</strong><br>
                                        and Password is <strong style="color: #2c3e50;">{{ $generated_password }}</strong>
                                    </p>
                                </div>
                                
                                <div style="padding: 20px; background: #f8f9fa; display: flex; justify-content: flex-end; gap: 10px;">
                                    <button style="padding: 10px 20px; background: #95a5a6; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 500;" wire:click="$set('showSuccessModal',false)">Close</button>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
