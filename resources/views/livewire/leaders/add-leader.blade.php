<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>System Users</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active">System Users</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif

                            <form wire:submit.prevent="submitForm">
                                <div class="mb-3">
                                    <label class="form-label" for="agentid">Sponsor Id</label>
                                    <input type="text" class="form-control" 
                                        wire:model="sponsorId" 
                                        wire:keyup.debounce.500ms="getSponsorName" 
                                        placeholder="Agent Id">
                                    @error('agentId') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label" for="name">Sponsor Name</label>
                                    <input type="text" class="form-control" wire:model="sponsorName" readonly>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" wire:model="name" placeholder="Enter name" required>
                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="font-weight-bold" for="position">Position</label>
                                    <div class="input-group input-group-merge">
                                        <select wire:model="preferredPosition" id="position" class="form-select">
                                            <option value="left">Left</option>
                                            <option value="right">Right</option>
                                        </select>
                                    </div>
                                    @error('position') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-0">
                                    <label class="form-label" for="input-email">Email address:</label>
                                    <input wire:model="email" id="input-email" class="form-control">
                                    <span class="text-muted">_@_._</span>
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-3 mt-3">
                                    <label class="form-label" for="phone">Phone No.</label>
                                    <div>
                                        <input type="text" wire:model="phone" id="phone" class="form-control" required placeholder="Enter phone number">
                                        @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </form>

                            <!-- Confirmation Modal -->
                            @if($showConfirmation)
                                <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5)">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirm Registration</h5>
                                                <button type="button" class="btn-close" wire:click="$set('showConfirmation', false)"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h6>Please verify your information:</h6>
                                                <ul class="list-group list-group-flush">
                                                    @foreach($formData as $key => $value)
                                                        <li class="list-group-item d-flex justify-content-between">
                                                            <span>{{ $key }}:</span>
                                                            <strong>{{ $value }}</strong>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" wire:click="$set('showConfirmation', false)">
                                                    Cancel
                                                </button>
                                                <button type="button" class="btn btn-primary" wire:click="confirmSubmission">
                                                    Confirm & Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>