<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Asign Permissions</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-6 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Roles & Permission</a></li>
                                <li><a wire:navigate href="{{ route('role') }}">Roles</a></li>
                                <li class="active">Asign Permissions</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-header bg-primary">
                                    <h4 class="card-title text-white mb-0">Permissions</h4>
                                </div>
                        
                                <form wire:submit.prevent="updatePermissions" class="mt-4">
                                    @foreach ($permissions->groupBy('group_name') as $groupName => $groupedPermissions)
                                        <div class="mb-4 border rounded p-3">
                                            <h5 class="text-primary mb-3">{{ $groupName }}</h5>
                                            <div class="row">
                                                @foreach ($groupedPermissions as $permission)
                                                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                                                        <div class="form-check form-switch form-switch-success">
                                                            <input
                                                                id="remember{{ $permission->id }}"
                                                                type="checkbox"
                                                                class="form-check-input"
                                                                wire:model="selectedPermissions"
                                                                value="{{ $permission->id }}">
                                                            <label class="form-check-label" for="remember{{ $permission->id }}">
                                                                {{ $permission->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                        
                                    <div class="text-center mt-5">
                                        <button type="submit" class="btn btn-primary btn-sm px-4">
                                            <span wire:loading wire:target="updatePermissions">
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                                            </span>
                                            <span wire:loading.remove wire:target="updatePermissions">
                                                Assign Permissions
                                            </span>
                                        </button>
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

