<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Notice Board</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active">Notice Board</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div id="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                <button wire:click="create()" class="btn btn-primary mb-3">
                                    <i class="fa fa-plus"></i> Add New Notice
                                </button>

                                @if (session()->has('message'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Content</th>
                                                <th class="text-center">Start Date</th>
                                                <th class="text-center">End Date</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($notices as $notice)
                                            <tr>
                                                <td>{{ $notice->title }}</td>
                                                <td>{{ Str::limit($notice->content, 50) }}</td>
                                                <td class="text-center">{{ $notice->start_date->format('d-m-Y') }}</td>
                                                <td class="text-center">{{ $notice->end_date->format('d-m-Y') }}</td>
                                                <td class="text-center">
                                                    <span wire:click="toggleStatus({{ $notice->id }})" 
                                                        class="badge badge-{{ $notice->is_active ? 'success' : 'danger' }} cursor-pointer">
                                                        {{ $notice->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <button wire:click="edit({{ $notice->id }})" 
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <button wire:click="delete({{ $notice->id }})" 
                                                        class="btn btn-sm btn-danger" title="Delete"
                                                        onclick="return confirm('Are you sure?') || event.stopImmediatePropagation()">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        @if($isOpen)
                        <div class="modal fade show" style="display: block; padding-right: 17px;" aria-modal="true" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            {{ $notice_id ? 'Edit Notice' : 'Create Notice' }}
                                        </h5>
                                        <button type="button" wire:click="closeModal()" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" wire:model="title" class="form-control" id="title">
                                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="content">Content</label>
                                                <textarea wire:model="content" rows="4" class="form-control" id="content"></textarea>
                                                @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="start_date">Start Date</label>
                                                        <input type="date" wire:model="start_date" class="form-control" id="start_date">
                                                        @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="end_date">End Date</label>
                                                        <input type="date" wire:model="end_date" class="form-control" id="end_date">
                                                        @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input type="checkbox" wire:model="is_active" class="form-check-input" id="is_active">
                                                    <label class="form-check-label" for="is_active">Active</label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" wire:click.prevent="store()" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                        <button type="button" wire:click="closeModal()" class="btn btn-secondary" data-dismiss="modal">
                                            <i class="fa fa-times"></i> Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-backdrop fade show"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>