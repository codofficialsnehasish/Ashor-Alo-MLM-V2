<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Categories</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-end">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Orders & Products</a></li>
                                <li class="active">Categories</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}" class="mb-4 card p-4 shadow-sm">
                                <h4 class="mb-4">{{ $isEdit ? 'Edit Category' : 'Create New Category' }}</h4>

                                <div class="row g-3 align-items-center">
                                    <!-- Category Name -->
                                    <div class="col-md-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" wire:model="name" class="form-control" placeholder="Category Name">
                                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="col-md-3">
                                        <label class="form-label">Description</label>
                                        <input type="text" wire:model="description" class="form-control" placeholder="Category Description">
                                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- Parent Category -->
                                    <div class="col-md-3">
                                        <label class="form-label">Parent Category</label>
                                        <select wire:model="parent_id" class="form-select">
                                            <option value="">-- Root Category --</option>
                                            @foreach ($parentcategories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->path }}</option>
                                            @endforeach
                                        </select>
                                        @error('parent_id') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- Visibility Checkbox -->
                                    <div class="col-md-1 d-flex align-items-center pt-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model="is_visible" id="isVisible">
                                            <label class="form-check-label" for="isVisible">Visible</label>
                                        </div>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" wire:model="is_provide_direct" id="is_provide_direct">
                                        <label class="form-check-label" for="is_provide_direct">Provide Direct</label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" wire:model="is_provide_roi" id="is_provide_roi">
                                        <label class="form-check-label" for="is_provide_roi">Provide ROI</label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" wire:model="is_provide_level" id="is_provide_level">
                                        <label class="form-check-label" for="is_provide_level">Provide Level</label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" wire:model="is_show_on_business" id="is_show_on_business">
                                        <label class="form-check-label" for="is_show_on_business">Is Show On Business</label>
                                    </div>

                                    <!-- Submit Buttons -->
                                    <div class="col-md-1 d-flex align-items-center mt-3">
                                        <button type="submit" class="btn btn-primary me-2" wire:loading.attr="disabled">
                                            {{ $isEdit ? 'Update' : 'Create' }}
                                            <span wire:loading wire:target="{{ $isEdit ? 'update' : 'store' }}" class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                        </button>

                                        @if($isEdit)
                                            <button type="button" wire:click="resetForm" class="btn btn-outline-danger">
                                                Cancel
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </form>



                            
                            <div class="d-flex flex-wrap justify-content-between items-center mb-3 gap-2">
                                <div class="space-x-2">
                                    <button wire:click="exportExcel" class="btn btn-sm btn-outline-info px-4 py-2">
                                        Export Excel
                                    </button>
                                    <button wire:click="exportPDF" class="btn btn-sm btn-outline-warning px-4 py-2">
                                        Export PDF
                                    </button>
                                </div>
                                <input type="text" wire:model.live="search" placeholder="Search categories..." class="form-input border rounded px-3 py-2 w-full sm:w-1/3" />

                            </div>

                            <!-- Category Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="px-4 py-2">Name</th>
                                            <th scope="col" class="px-4 py-2">Parent</th>
                                            <th scope="col" class="px-4 py-2">Visible</th>
                                            <th scope="col" class="px-4 py-2">Provide Direct</th>
                                            <th scope="col" class="px-4 py-2">Provide ROI</th>
                                            <th scope="col" class="px-4 py-2">Provide Level</th>
                                            <th scope="col" class="px-4 py-2">Is Show On Business</th>
                                            <th scope="col" class="px-4 py-2">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($categories as $cat)
                                            <tr>
                                                <td class="px-4 py-2">{{ $cat->name }}</td>
                                                <td class="px-4 py-2">{{ $cat->parent->name ?? '-' }}</td>
                                                <td class="px-4 py-2">
                                                    <span class="{{ $cat->is_visible ? 'text-success' : 'text-danger' }}">
                                                        {{ $cat->is_visible ? 'Yes' : 'No' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <span class="{{ $cat->is_provide_direct ? 'text-success' : 'text-danger' }}">
                                                        {{ $cat->is_provide_direct ? 'Yes' : 'No' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <span class="{{ $cat->is_provide_roi ? 'text-success' : 'text-danger' }}">
                                                        {{ $cat->is_provide_roi ? 'Yes' : 'No' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <span class="{{ $cat->is_provide_level ? 'text-success' : 'text-danger' }}">
                                                        {{ $cat->is_provide_level ? 'Yes' : 'No' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <span class="{{ $cat->is_show_on_business ? 'text-success' : 'text-danger' }}">
                                                        {{ $cat->is_show_on_business ? 'Yes' : 'No' }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-2">
                                                    <button wire:click="edit({{ $cat->id }})" class="btn btn-outline-success btn-sm">Edit</button>
                                                    <button wire:click="delete({{ $cat->id }})" onclick="return confirm('Are you sure?')"
                                                        class="btn btn-outline-danger btn-sm ms-2">Delete</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center px-4 py-3 text-muted">No categories found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-3">
                                {{ $categories->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
