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
                                <li><a wire:navigate href="{{ route('users') }}">System Users</a></li>
                                <li class="active">Create</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                Create User
                            </div>
                            <div class="card-body">
                                <form wire:submit.prevent="addUser" enctype="multipart/form-data">
                                    <div class="row">
                                        
                                        <div class="col-lg-9">
                                            <div class="mb-3 row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label text-end">Name</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" wire:model="name" type="text" value="" id="example-text-input">
                                                    @error('name') 
                                                    <span class="text-danger">{{ $message }}</span> 
                                                @enderror
            
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="example-email-input" class="col-sm-2 col-form-label text-end">Email</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" wire:model="email" type="email" value="" id="example-email-input">
                                                    @error('email') 
                                                    <span class="text-danger">{{ $message }}</span> 
                                                @enderror
                                                </div>
                                            </div> 
                                            <div class="mb-3 row">
                                                <label for="example-phone-input" class="col-sm-2 col-form-label text-end">Phone</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" wire:model="phone" type="phone" value="" id="example-phone-input">
                                                    @error('phone') 
                                                    <span class="text-danger">{{ $message }}</span> 
                                                    @enderror
                                                </div>
                                            </div> 
                                            <div class="mb-3 row">
                                                <label for="example-password-input" class="col-sm-2 col-form-label text-end">Password</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" type="password" wire:model="password" value="" id="example-password-input">
                                                    @error('password') 
                                                    <span class="text-danger">{{ $message }}</span> 
                                                @enderror

                                                </div>
                                            </div>
                                            <div class="mb-3 row" >
                                                <label for="example-email-input" class="col-sm-2 col-form-label text-end">Role</label>
                                                <div class="col-sm-10" wire:ignore>
                                                    <select wire:ignore.self class="form-select select2" id="rol"  multiple="multiple" wire:model="selectedRoles">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role }}" >{{ $role }}</option>
                                                        @endforeach
                                                    </select> 
                                                    @error('selectedRoles') 
                                                    <span class="text-danger">{{ $message }}</span> 
                                                @enderror
                                                </div>
                                            </div> 
                                        </div>

                                        <div class="col-lg-3">                                       
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Image</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-grid">
                                                        <div wire:loading wire:target="image" wire:key="image"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i> Uploading...</div>
                                                        @if ($image)
                                                        <img class="img-thumbnail rounded me-2" id="blah" alt="Image Preview" width="200" 
                                                            src="{{ $image->temporaryUrl() }}" 
                                                            style="display: {{ $image ? 'block' : 'none' }};">
                                                        @endif 
                                                        <input type="file" id="input-file" wire:model="image" accept="image/*"  hidden />
                                                        <label class="btn-upload btn btn-outline-secondary mt-4" for="input-file"><i class="fas fa-cloud-upload-alt"></i> Browse Image</label>
                                                        @error('image') 
                                                        <span class="text-danger">{{ $image }}</span> 
                                                    @enderror

                                                    </div>                        
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Publish</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <div class="custom-control custom-switch">
                                                            <input wire:model="status" type="checkbox" class="custom-control-input" id="status" checked>
                                                            <label class="custom-control-label" for="status">Active</label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 float-end">
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <span wire:loading wire:target="addUser">
                                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                                                            </span>
                                                            <span wire:loading.remove wire:target="addUser">
                                                                Save & Publish
                                                            </span>
                                                        </button>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end card -->                               
                    </div> <!-- end col -->                    
                </div>
            </div>

        </div> 
        <!-- end Footer -->                
      
    </div>
    <!-- end page content -->
</div>

@script()
<script>
$(document).ready(function() {
    $('#rol').select2();
    $('#rol').on('change', function(e) 
        {
            let data = $(this).val();
            console.log(data)
            //$wire.set('selectedRoles' ,data)
            $wire.selectedRoles = data;
        });
});


document.addEventListener('livewire:init', () => {
    // Initialize Select2
    $('#rol').select2();
    // Ensure Select2 is reinitialized after Livewire updates
    Livewire.on('select2Reset', () => {
        $('#rol').val(null).trigger('change'); // Reset the value
        $('#rol').select2(); // Reinitialize Select2
    });
});
</script>
@endscript