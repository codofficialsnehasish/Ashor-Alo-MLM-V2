<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>About Us</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active">About Us</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form wire:submit.prevent="save">
                                            <div class="mb-4">
                                                <label for="about_us_title" class="form-label">Title</label>
                                                <input wire:model="about_us_title" id="title" class="form-control"/>
                                                @error('about_us_title') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="mb-4">
                                                <label for="privacyEditor" class="form-label">Content</label>
                                                <textarea wire:model="about_us" id="privacyEditor" class="form-control" rows="15"></textarea>
                                                @error('about_us') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Images</label>
                                                {{-- {{ $uploadedImage }} --}}
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
                                            
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary px-4">
                                                    <i class="ti-save me-2"></i> Save Changes
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
    </div>
</div>
