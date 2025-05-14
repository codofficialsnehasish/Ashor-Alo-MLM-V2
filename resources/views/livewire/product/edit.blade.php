<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Edit Product</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-end">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Orders & Products</a></li>
                                <li><a wire:navigate href="{{ route('products.index') }}">Products</a></li>
                                <li class="active">Edit Product</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div id="main-content">
                <form wire:submit.prevent="update" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="card">
                                <div class="card-header bg-primary text-light d-flex justify-content-between align-items-center">
                                    <div>Edit Product Details</div>
                                    <a class="btn btn-outline-warning btn-sm px-4 mt-0 col-md-2" wire:navigate href="{{ route('products.index') }}">
                                        <i class="ti-arrow-left"></i> Back 
                                    </a>
                                </div>

                                <div class="card-body row">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label>Title</label>
                                            <input type="text" wire:model="title" class="form-control">
                                            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label>Category</label>
                                            <select wire:model="category_id" class="form-select">
                                                <option value="">-- Select Category --</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label>SKU</label>
                                            <input type="text" wire:model="sku" class="form-control">
                                            @error('sku') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <label>Stock</label>
                                            <input type="text" wire:model="stock" class="form-control">
                                            @error('stock') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label>Price</label>
                                            <input type="number" wire:model.live="price" step="0.01" class="form-control">
                                            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label>Discount Rate (%)</label>
                                            <input type="number" wire:model.live="discount_rate" class="form-control">
                                            @error('discount_rate') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label>GST Rate (%)</label>
                                            <input type="number" wire:model.live="gst_rate" class="form-control">
                                            @error('gst_rate') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label>Total Price</label>
                                            <input type="number" wire:model="total_price" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label>Short Description</label>
                                        <textarea wire:model="short_desc" class="form-control" rows="2"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label>Description</label>
                                        <textarea wire:model="description" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-header bg-primary text-light">Product Image</div>
                                <div class="card-body">
                                    <div class="d-grid">
                                        <div wire:loading wire:target="image"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i> Uploading...</div>
                                        @if ($image)
                                            <img class="img-thumbnail rounded me-2" alt="Image Preview" width="200" src="{{ $image->temporaryUrl() }}">
                                        @elseif ($existingImage)
                                            <img class="img-thumbnail rounded me-2" alt="Image Preview" width="200" src="{{ $existingImage }}">
                                        @endif
                                        <input type="file" id="input-file" wire:model="image" accept="image/*" hidden />
                                        <label class="btn-upload btn btn-outline-secondary mt-2" for="input-file">
                                            <i class="fas fa-cloud-upload-alt"></i> Browse Image
                                        </label>
                                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-primary text-light">Publish</div>
                                <div class="card-body">
                                    @foreach (['is_provide_direct' => 'Provide Direct', 'is_provide_roi' => 'Provide ROI', 'is_provide_level' => 'Provide Level', 'is_visible' => 'Visible', 'is_bestseller' => 'Bestseller'] as $field => $label)
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" wire:model="{{ $field }}" id="{{ $field }}">
                                            <label class="form-check-label" for="{{ $field }}">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                    <div class="mb-0">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                                            Update Product
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </form>
            </div>
        </div>
    </div>
</div>
