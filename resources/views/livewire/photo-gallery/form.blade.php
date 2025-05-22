<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Photo Gallery</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a wire:navigate href="{{ route('photo-galleries.index') }}">Photo Gallery</a></li>
                                <li class="breadcrumb-item active">{{ $gallery->exists ? 'Edit' : 'Create' }}</li>
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
                                <form wire:submit.prevent="save">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                            id="title" wire:model="title">
                                        @error('title') 
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                id="description" wire:model="description" rows="3"></textarea>
                                        @error('description') 
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" 
                                            id="is_active" wire:model="is_active">
                                        <label class="form-check-label" for="is_active">Active</label>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Images</label>
                                        
                                        <!-- Existing Images -->
                                        @if($uploadedImage)
                                            <div class="mb-3 position-relative" style="max-width: 200px;">
                                                <img src="{{ $uploadedImage->temporaryUrl() }}" 
                                                    alt="Gallery image" 
                                                    class="img-thumbnail w-100">
                                            </div>
                                        @elseif($existingImage)
                                            <div class="mb-3 position-relative" style="max-width: 200px;">
                                                <img src="{{ $existingImage }}" 
                                                    alt="Gallery image" 
                                                    class="img-thumbnail w-100">
                                            </div>
                                        @endif

                                        <!-- New Image Uploads -->
                                        <input type="file" class="form-control @error('uploadedImage') is-invalid @enderror" 
                                            wire:model="uploadedImage">
                                        @error('uploadedImage') 
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        
                                        <!-- Preview of newly uploaded images -->
                                        @if($uploadedImage)
                                            <div class="row mt-3">
                                                @foreach($uploadedImage as $image)
                                                    <div class="col-6 col-md-3 mb-3">
                                                        <img src="{{ $image->temporaryUrl() }}" 
                                                            alt="Preview" 
                                                            class="img-thumbnail w-100">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('photo-galleries.index') }}" class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Save</button>
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