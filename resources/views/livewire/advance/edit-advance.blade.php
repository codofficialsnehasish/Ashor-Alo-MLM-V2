<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Edit Advance</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb float-end">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a wire:navigate href="{{ route('advance.list') }}">Advance</a></li>
                                <li class="active">Edit</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <form wire:submit.prevent="update">
                                    <div class="mb-4">
                                        <label for="user_id" class="form-label fw-bold">Select User</label>
                                        <select wire:model="user_id" id="user_id" class="form-select form-select-lg js-example-basic-single">
                                            <option value="">Choose a user...</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ $user->id == $user_id ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id') <div class="text-danger small mt-1"><i class="ti-alert me-1"></i>{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="original_amount" class="form-label fw-bold">Loan Amount</label>
                                        <div class="input-group">
                                            <input wire:model="original_amount" type="number" step="0.01" id="original_amount" 
                                                   class="form-control form-control-lg" placeholder="0.00">
                                        </div>
                                        @error('original_amount') <div class="text-danger small mt-1"><i class="ti-alert me-1"></i>{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="notes" class="form-label fw-bold">Notes</label>
                                        <textarea wire:model="notes" id="notes" rows="3" 
                                                  class="form-control" placeholder="Additional information..."></textarea>
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                        <a wire:navigate href="{{ route('advance.list') }}" class="btn btn-outline-secondary me-md-2">
                                            <i class="ti-close me-1"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti-save me-1"></i> Update Advance
                                        </button>
                                    </div>
                                </form>

                                @if (session()->has('message'))
                                    <div class="mt-4 alert alert-success alert-dismissible fade show">
                                        <i class="ti-check me-2"></i> {{ session('message') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script()
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();

        $('.js-example-basic-single').on('change', function(e) {
            let data = $(this).val();
            // console.log(data)
            $wire.set('user_id', data)
            $wire.user_id = data;
        });
    });
</script>
@endscript