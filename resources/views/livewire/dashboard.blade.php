<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-end">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active">Home</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <a href="">
                                <div class="media p-3">
                                    <div class="media-left me-3">
                                        <img src="{{ asset('assets/images/services-icon/14.1.png') }}" width="40" alt="">
                                    </div>
                                    <div class="media-body text-end">
                                        <h4>{{ $customer_count ?? 0 }}</h4>
                                        <h6>Total Member</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card">
                            <a href="">
                                <div class="media p-3">
                                    <div class="media-left me-3">
                                        <img src="{{ asset('assets/images/services-icon/25.png') }}" width="40" alt="">
                                    </div>
                                    <div class="media-body text-end">
                                        <h4>{{ $active_count ?? 0 }}</h4>
                                        <h6>Active Member</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card">
                            <div class="media p-3">
                                <div class="media-left me-3">
                                    <img src="{{ asset('assets/images/services-icon/24.png') }}" width="40" alt="">
                                </div>
                                <div class="media-body text-end">
                                    <h4>{{ $todays_business ?? 0 }}</h4>
                                    <h6>Today Business</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="media p-3">
                                <div class="media-left me-3">
                                    <img src="{{ asset('assets/images/services-icon/26.png') }}" width="40" alt="">
                                </div>
                                <div class="media-body text-end">
                                    <h4>{{ $total_business ?? 0 }}</h4>
                                    <h6>Total Business</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="media p-3">
                                <div class="media-left me-3">
                                    <img src="{{ asset('assets/images/services-icon/27.png') }}" width="40" alt="">
                                </div>
                                <div class="media-body text-end">
                                    <h4>{{ $total_payment ?? 0 }}</h4>
                                    <h6>Total Payment</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card">
                            <div class="media p-3">
                                <div class="media-left me-3">
                                    <img src="{{ asset('assets/images/services-icon/28.png') }}" width="40" alt="">
                                </div>
                                <div class="media-body text-end">
                                    <h4>{{ $last_week_payment ?? 0 }}</h4>
                                    <h6>Last Week Payment</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="media p-3">
                                <div class="media-left me-3">
                                    <img src="{{ asset('assets/images/services-icon/29.png') }}" width="40" alt="">
                                </div>
                                <div class="media-body text-end">
                                    <h4>{{ $hold_amount ?? 0 }}</h4>
                                    <h6>Hold Amount</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="media p-3">
                                <div class="media-left me-3">
                                    <img src="{{ asset('assets/images/services-icon/31.png') }}" width="40" alt="">
                                </div>
                                <div class="media-body text-end">
                                    <h4>{{ $tds ?? 0 }}</h4>
                                    <h6>TDS</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="media p-3">
                                <div class="media-left me-3">
                                    <img src="{{ asset('assets/images/services-icon/31.png') }}" width="40" alt="">
                                </div>
                                <div class="media-body text-end">
                                    <h4>{{ $repurchase_wallet ?? 0 }}</h4>
                                    <h6>Repurchase Wallet</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="media p-3">
                                <div class="media-left me-3">
                                    <img src="{{ asset('assets/images/services-icon/32.png') }}" width="40" alt="">
                                </div>
                                <div class="media-body text-end">
                                    <h4>{{ $service_charge ?? 0 }}</h4>
                                    <h6>Service Charge</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <a href="{{ route('kyc.pending') }}">
                                <div class="media p-3">
                                    <div class="media-left me-3">
                                        <img src="{{ asset('assets/images/services-icon/23.png') }}" width="40" alt="">
                                    </div>
                                    <div class="media-body text-end">
                                        <h4>{{ $pending_kyc ?? 0 }}</h4>
                                        <h6>Pending KYC</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <a href="">
                                <div class="media p-3">
                                    <div class="media-left me-3">
                                        <img src="{{ asset('assets/images/services-icon/23.png') }}" width="40" alt="">
                                    </div>
                                    <div class="media-body text-end">
                                        <h4>{{ $contac_us ?? 0 }}</h4>
                                        <h6>Customer Contacts</h6>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="media p-3">
                                <div class="media-left me-3">
                                    <img src="{{ asset('assets/images/services-icon/31.png') }}" width="40" alt="">
                                </div>
                                <div class="media-body text-end">
                                    <h4>{{ $current_week_business ?? 0 }}</h4>
                                    <h6>Current Fortnight Business</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer">
                            <p>This dashboard was generated on <span id="date-time"></span> <a href="#" class="page-refresh">Refresh Dashboard</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>