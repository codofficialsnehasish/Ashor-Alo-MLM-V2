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
                                <li class="active">Edit</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                Edit User
                            </div>
                            <div class="card-body">
                                <form wire:submit.prevent="updateUser">
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <div class="mb-3 row">
                                                <label for="example-text-input" class="col-sm-2 col-form-label text-end">Name</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" wire:model="data.name" type="text" id="example-text-input">
                                                    @error('data.name') 
                                                    <span class="text-danger">{{ $message }}</span> 
                                                @enderror
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="example-email-input" class="col-sm-2 col-form-label text-end">Email</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control"  wire:model="data.email" type="email"  id="example-email-input">
                                                    @error('data.email') 
                                                    <span class="text-danger">{{ $message }}</span> 
                                                @enderror
                                                </div>
                                            </div> 
                                            <div class="mb-3 row">
                                                <label for="example-phone-input" class="col-sm-2 col-form-label text-end">Phone</label>
                                                <div class="col-sm-10">
                                                    <input class="form-control" wire:model="data.phone" type="phone" id="example-phone-input">
                                                    @error('data.phone') 
                                                    <span class="text-danger">{{ $message }}</span> 
                                                    @enderror
                                                </div>
                                            </div> 
                            
                                            <div class="mb-3 row">
                                                <label for="example-password-input" class="col-sm-2 col-form-label text-end">Password</label>
                                                <div class="col-sm-10 position-relative" x-data="{ showPassword: false }">
                                                    <input class="form-control" :type="showPassword ? 'text' : 'password'" wire:model="password" id="example-password-input">
                                                    <span class="position-absolute end-0 top-50 translate-middle-y me-2 cursor-pointer" @click="showPassword = !showPassword">
                                                        <i :class="showPassword ? 'ti-eye-slash' : 'ti-eye'" style="margin-right: 9px;color: #0b51b7;"></i>
                                                    </span>
                                                    @error('password') 
                                                        <span class="text-danger">{{ $message }}</span> 
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-3 row" wire:ignore>
                                                <label for="example-email-input" class="col-sm-2 col-form-label text-end">Role</label>
                                                <div class="col-sm-10" x-data x-init="$nextTick(() => { $('.js-example-basic-multiple').select2(); })">
                                                <div wire:ignore>
                                                    <select id="rol" class="form-select select2" multiple="multiple" wire:model="selectedRoles">
                                                        @foreach ($roles as $role)
                                                        <option value="{{ $role }}" >{{ $role }}</option>
                                                        @endforeach
                                                    </select> 
                                                </div>
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
                                                        @elseif ($existingImage)
                                                            <img class="img-thumbnail rounded me-2" alt="Image Preview" width="200" src="{{ $existingImage }}">
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
                                                            <input wire:model="data.status" type="checkbox" class="custom-control-input" id="status" >
                                                            <label class="custom-control-label" for="status">Active</label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 float-end">
                                                        <button type="submit" class="btn btn-outline-primary btn-sm">
                                                            <span wire:loading wire:target="updateUser">
                                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                                                            </span>
                                                            <span wire:loading.remove wire:target="updateUser">
                                                                Save changes
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
                </div> <!-- end row -->
            </div> 
            <!-- end Footer -->                
        </div> 
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
                $wire.set('selectedRoles' ,data)
                $wire.selectedRoles = data;
            });
    });
</script>
@endscript