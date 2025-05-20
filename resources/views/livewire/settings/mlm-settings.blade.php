<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>MLM Settings</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active">MLM Settings</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form wire:submit.prevent="save" class="needs-validation" novalidate>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="minimum_purchase_amount" class="form-label">Minimum Purchase Amount</label>
                                            <div class="input-group">
                                                <span class="input-group-text">₹</span>
                                                <input type="number" step="0.01" class="form-control" id="minimum_purchase_amount" 
                                                    wire:model.defer="minimum_purchase_amount" placeholder="Enter minimum amount">
                                            </div>
                                            @error('minimum_purchase_amount') 
                                                <div class="invalid-feedback d-block">{{ $message }}</div> 
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="agent_direct_bonus" class="form-label">Agent Direct Bonus (%)</label>
                                            <input type="number" step="0.01" class="form-control" id="agent_direct_bonus" 
                                                wire:model.defer="agent_direct_bonus" placeholder="Enter bonus percentage">
                                            @error('agent_direct_bonus') 
                                                <div class="invalid-feedback d-block">{{ $message }}</div> 
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tds" class="form-label">TDS (%)</label>
                                            <input type="number" step="0.01" class="form-control" id="tds" 
                                                wire:model.defer="tds" placeholder="Enter TDS percentage">
                                            @error('tds') 
                                                <div class="invalid-feedback d-block">{{ $message }}</div> 
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="repurchase" class="form-label">Repurchase (%)</label>
                                            <input type="number" step="0.01" class="form-control" id="repurchase" 
                                                wire:model.defer="repurchase" placeholder="Enter repurchase percentage">
                                            @error('repurchase') 
                                                <div class="invalid-feedback d-block">{{ $message }}</div> 
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="service_charge" class="form-label">Service Charge (%)</label>
                                            <input type="number" step="0.01" class="form-control" id="service_charge" 
                                                wire:model.defer="service_charge" placeholder="Enter service charge percentage">
                                            @error('service_charge') 
                                                <div class="invalid-feedback d-block">{{ $message }}</div> 
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="add_on_percentage" class="form-label">Add On Percentage (%)</label>
                                            <input type="number" step="0.01" class="form-control" id="add_on_percentage" 
                                                wire:model.defer="add_on_percentage" placeholder="Enter add on percentage">
                                            @error('add_on_percentage') 
                                                <div class="invalid-feedback d-block">{{ $message }}</div> 
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            
                                <button type="submit" class="btn btn-primary px-4">
                                    <span wire:loading wire:target="save" class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Save Settings
                                </button>
                                    
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
