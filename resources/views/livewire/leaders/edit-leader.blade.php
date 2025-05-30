<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Leader</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a wire:navigate href="{{ route('leaders.all') }}">Leaders</a></li>
                                <li class="active">Edit Leader</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="account-pages">
                                <div class="container">
                                    <form class="custom-validation" wire:submit.prevent="submitForm">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="card">
                                                    <div class="card-header bg-primary text-light d-flex align-items-center justify-content-between">
                                                        Edit {{ $name }} ({{ $leaderId }})
                                                        <div class="float-end d-none d-md-block">
                                                            <button 
                                                                wire:click="resetProfile"
                                                                wire:confirm.prompt="Are you sure you want to reset this profile?\n\nThis will clear ALL personal data!\n\nType 'RESET' to confirm|RESET"
                                                                class="btn btn-danger"
                                                            >
                                                                <i class="fas fa-redo me-2"></i>Reset Profile
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label" for="sponsorId">Sponsor ID</label>
                                                                <input type="text" class="form-control" wire:model="sponsorId" wire:change="getSponsorName" id="sponsorId" placeholder="Enter Sponsor ID" >
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label" for="sponsorName">Sponsor Name</label>
                                                                <input type="text" class="form-control" wire:model="sponsorName" id="sponsorName" readonly>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label" for="name">Name</label>
                                                                <input type="text" class="form-control" wire:model="name" id="name" placeholder="Enter name" required>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="father_or_husband_name">Father / Husband Name</label>
                                                                <input type="text" class="form-control" wire:model="father_or_husband_name">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="date_of_birth">Date Of Birth (Ex DD/MM/YYYY)</label>
                                                                <input type="date" class="form-control" wire:model="date_of_birth">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="gender">Gender</label>
                                                                <select class="form-control" wire:model="gender">
                                                                    <option value selected disabled>Choose...</option>
                                                                    <option value="Male">Male</option>
                                                                    <option value="Female">Female</option>
                                                                    <option value="Others">Others</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="marital_status">Marital Status</label>
                                                                <select class="form-control" wire:model="marital_status">
                                                                    <option value selected disabled>Choose...</option>
                                                                    <option value="Married">Married</option>
                                                                    <option value="Unmarried">Unmarried</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="phone">Mobile</label>
                                                                <input type="number" class="form-control" wire:model="phone" required>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="email">Email</label>
                                                                <input type="email" class="form-control" wire:model="email">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="qualification">Qualification</label>
                                                                <input type="text" class="form-control" wire:model="qualification">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="occupation">Occupation/Job</label>
                                                                <input type="text" class="form-control" wire:model="occupation">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="pin_code">Pincode</label>
                                                                <input type="number" class="form-control" wire:model="pin_code">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="shipping_address">Shipping Address</label>
                                                                <textarea class="form-control" wire:model="shipping_address" rows="2"></textarea>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="address">Address</label>
                                                                <textarea class="form-control" rows="2" wire:model="address"></textarea>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="country">Country</label>
                                                                <select class="form-control" wire:model="country" wire:change="updatedCountry">
                                                                    <option value selected disabled>Choose...</option>
                                                                    @foreach($countries as $country)
                                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="state">State</label>
                                                                <select class="form-control" wire:model="state" wire:change="updatedState">
                                                                    <option value selected disabled>Choose...</option>
                                                                    @foreach($states as $state)
                                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="city">City</label>
                                                                <select class="form-control" wire:model="city">
                                                                    <option value selected disabled>Choose...</option>
                                                                    @foreach($cities as $city)
                                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header bg-primary text-light">Edit Nominee</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label for="nominee_name">Nominee Name</label>
                                                                <input type="text" class="form-control" wire:model="nominee_name">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="nominee_relation">Relation</label>
                                                                <select class="form-control" wire:model="nominee_relation">
                                                                    <option value selected disabled>Choose...</option>
                                                                    <option value="Brother">Brother</option>
                                                                    <option value="Brother In Law">Brother In Law</option>
                                                                    <option value="Cousin">Cousin</option>
                                                                    <option value="Daughter">Daughter</option>
                                                                    <option value="Father">Father</option>
                                                                    <option value="Granddaughter">Granddaughter</option>
                                                                    <option value="Grandson">Grandson</option>
                                                                    <option value="Husband">Husband</option>
                                                                    <option value="Mother">Mother</option>
                                                                    <option value="Nephew">Nephew</option>
                                                                    <option value="Niece">Niece</option>
                                                                    <option value="Other">Other</option>
                                                                    <option value="Parent In Law">Parent In Law</option>
                                                                    <option value="Properitor">Properitor</option>
                                                                    <option value="Sister">Sister</option>
                                                                    <option value="Sister In Law">Sister In Law</option>
                                                                    <option value="Son">Son</option>
                                                                    <option value="Wife">Wife</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="nominee_dob">Date Of Birth (Ex DD/MM/YYYY)</label>
                                                                <input type="date" class="form-control" wire:model="nominee_dob">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="nominee_address">Address</label>
                                                                <textarea class="form-control" rows="2" wire:model="nominee_address"></textarea>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="nominee_state_id">State</label>
                                                                <select class="form-control" wire:model="nominee_state_id" wire:change="updatedNomineeStateId">
                                                                    <option value selected disabled>Choose...</option>
                                                                    @foreach($nominee_states as $state)
                                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="nominee_city_id">City</label>
                                                                <select class="form-control" wire:model="nominee_city_id">
                                                                    <option value selected disabled>Choose...</option>
                                                                    @foreach($nominee_cities as $city)
                                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header bg-primary text-light">Bank Details</div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label for="account_name">Account Name (As Per Bank)</label>
                                                                <input type="text" class="form-control" wire:model="account_name">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="bank_name">Bank Name</label>
                                                                <input type="text" class="form-control" wire:model="bank_name">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="account_number">Account Number</label>
                                                                <input type="number" class="form-control" wire:model="account_number">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="account_type">Account Type</label>
                                                                <select class="form-control" wire:model="account_type">
                                                                    <option value="" selected>Choose...</option>
                                                                    <option value="Current">Current</option>
                                                                    <option value="Saving">Saving</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="ifsc_code">IFSC</label>
                                                                <input type="text" class="form-control" wire:model="ifsc_code">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="pan_number">PAN</label>
                                                                <input type="text" class="form-control" wire:model="pan_number">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="upi_name">UPI Name</label>
                                                                <input type="text" class="form-control" wire:model="upi_name">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="upi_type">UPI Type</label>
                                                                <select class="form-control" wire:model="upi_type">
                                                                    <option value="">Choose...</option>
                                                                    <option value="Phone Pay">Phone Pay</option>
                                                                    <option value="Google Pay">Google Pay</option>
                                                                    <option value="Paytm">Paytm</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label for="upi_number">UPI Phone Number</label>
                                                                <input type="number" class="form-control" wire:model="upi_number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <div class="card-header bg-primary text-light">Publish</div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label for="password" class="form-label">Login Password</label>
                                                            <input type="text" class="form-control" wire:model="password">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label mb-3 d-flex">Status</label>
                                                            <div class="form-check form-check-inline">
                                                                <input type="radio" id="customRadioInline1" wire:model="status" class="form-check-input" value="1">
                                                                <label class="form-check-label" for="customRadioInline1">Active</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input type="radio" id="customRadioInline2" wire:model="status" class="form-check-input" value="0">
                                                                <label class="form-check-label" for="customRadioInline2">Inactive</label>
                                                            </div>
                                                        </div>
                                                        <div class="mb-0">
                                                            <div>
                                                                <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                                                                    Update Leader
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>