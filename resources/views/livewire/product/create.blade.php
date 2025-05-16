<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Products</h1>
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
                                <li class="active">Add Products</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div id="main-content">
                <form wire:submit.prevent="store" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="card">
                                <div class="card-header bg-primary text-light d-flex justify-content-between align-items-center">
                                    <div>Product Details</div>
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
                                            <label>Product Type</label>
                                            <select wire:model="product_type" class="form-select">
                                                <option value="simple">Simple</option>
                                                <option value="variable">Variable</option>
                                                <option value="combo">Combo</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Simple Product Fields -->
                                    <div class="row mb-3" x-show="$wire.product_type === 'simple'">
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

                                    <div class="row mb-3" x-show="$wire.product_type === 'simple'">
                                        <div class="col-md-3">
                                            <label>Stock</label>
                                            <input type="number" wire:model="stock" class="form-control">
                                            @error('stock') <small class="text-danger">{{ $message }}</small> @enderror
                                        </div>
                                    </div>

                                    <!-- Variable Product Fields -->
                                    <div class="mb-3" x-show="$wire.product_type === 'variable'">
                                        <h5>Product Variations</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Attribute</th>
                                                        <th>Value</th>
                                                        <th>Price</th>
                                                        <th>Stock</th>
                                                        <th>SKU</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($variations as $index => $variation)
                                                    <tr>
                                                        <td>
                                                            <input type="text" wire:model="variations.{{ $index }}.attribute" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" wire:model="variations.{{ $index }}.value" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="number" wire:model="variations.{{ $index }}.price" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="number" wire:model="variations.{{ $index }}.stock" class="form-control">
                                                        </td>
                                                        <td>
                                                            <input type="text" wire:model="variations.{{ $index }}.sku" class="form-control">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm" wire:click="removeVariation({{ $index }})">
                                                                <i class="ti-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <input type="text" wire:model="attribute_name" class="form-control" placeholder="Attribute (e.g., Size)">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" wire:model="attribute_value" class="form-control" placeholder="Value (e.g., 500gm)">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" wire:model="variation_price" class="form-control" placeholder="Price">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" wire:model="variation_stock" class="form-control" placeholder="Stock">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" wire:model="variation_sku" class="form-control" placeholder="SKU">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-primary" wire:click="addVariation">
                                                    <i class="ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @error('variations') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <!-- Combo Product Fields -->
                                    <div class="mb-3" x-show="$wire.product_type === 'combo'">
                                        <h5>Combo Price</h5>
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label>Combo Price</label>
                                                <input type="number" wire:model="combo_price" step="0.01" class="form-control">
                                                @error('combo_price') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>

                                        <h5>Combo Items</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Variation</th>
                                                        <th>Quantity</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{print_r($comboItems)}}
                                                    @foreach($comboItems as $index => $item)
                                                    <tr>
                                                        <td>{{ $item['product_title'] }}</td>
                                                        <td>{{ $item['variation_value'] ?? 'Default' }}</td>
                                                        <td>{{ $item['quantity'] }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm" wire:click="removeComboItem({{ $index }})">
                                                                <i class="ti-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @error('comboItems') <small class="text-danger">{{ $message }}</small> @enderror

                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label>Search Product</label>
                                                <input type="text" wire:model.live="searchProduct" class="form-control" placeholder="Search products...">
                                                @if(!empty($searchResults))
                                                <div class="list-group mt-2" style="position: absolute; z-index: 1000; width: 100%;">
                                                    @foreach($searchResults as $result)
                                                    <a href="#" class="list-group-item list-group-item-action" wire:click.prevent="selectProduct({{ $result->id }})">
                                                        {{ $result->title }}
                                                    </a>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                            @if($selectedProduct)
                                            <div class="col-md-4">
                                                <label>Variation</label>
                                                <select wire:model="selectedVariation" class="form-select">
                                                    <option value="">Default</option>
                                                    @foreach($selectedProduct->variations as $variation)
                                                    <option value="{{ $variation->id }}">{{ $variation->attribute }}: {{ $variation->value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-1">
                                                <label>Qty</label>
                                                <input type="number" wire:model="comboItemQuantity" min="1" class="form-control">
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-primary" wire:click="addComboItem">
                                                    <i class="ti-plus"></i>
                                                </button>
                                            </div>
                                            @endif
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
                                <div class="card-header bg-primary text-light">
                                    Product Image
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
                                        <label class="btn-upload btn btn-outline-secondary mt-2" for="input-file"><i class="fas fa-cloud-upload-alt"></i> Browse Image</label>
                                        @error('image') 
                                        <span class="text-danger">{{ $image }}</span> 
                                        @enderror
                                    </div>                        
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header bg-primary text-light">
                                    Publish
                                </div>
                                <div class="card-body">
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
                                        <input class="form-check-input" type="checkbox" wire:model="is_visible" id="is_visible">
                                        <label class="form-check-label" for="is_visible">Visible</label>
                                    </div>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" wire:model="is_bestseller" id="is_bestseller">
                                        <label class="form-check-label" for="is_bestseller">Bestseller</label>
                                    </div>
                                    <div class="mb-0">
                                        <div>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                                                Save Product
                                            </button>
                                        </div>
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

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        // Initialize Alpine.js for showing/hiding sections
        Alpine.start();
    });
</script>
@endpush