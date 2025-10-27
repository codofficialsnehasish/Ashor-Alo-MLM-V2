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
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-end">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Orders & Products</a></li>
                                <li class="active">Products</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body mb-n3">

                                <div class="row mb-3">
                                    {{-- <div class="col-md-6 d-flex align-items-end">
                                        <button wire:click="exportPdf" class="btn btn-danger me-2">
                                            <i class="fas fa-file-pdf me-1"></i> PDF Export
                                        </button>
                                        <button wire:click="exportExcel" class="btn btn-success">
                                            <i class="fas fa-file-excel me-1"></i> Excel Export
                                        </button>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <input wire:model.live="search" type="search" class="form-control" placeholder="Search products...">
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <a class="btn btn-outline-primary btn-sm px-4 mt-0 mb-3" wire:navigate href="{{ route('products.create')}}" >
                                            Create <i class="ti-plus"></i> 
                                        </a>
                                    </div>
                                </div>

                                {{-- <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SL. No</th>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                                <th>Image</th>
                                                <th>Visibility</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($all_products as $product)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $product->title }}</td>
                                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                                    <td>{{ number_format($product->price, 2) }}</td>
                                                    <td>
                                                        @if($product->stock <= 5)
                                                            <span style="color: red; font-weight: bold;">{{ $product->stock }} (Low Stock!)</span>
                                                        @else
                                                            <span style="color: green; font-weight: bold;">{{ $product->stock }} (In Stock!)</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($product->getFirstMediaUrl('products'))
                                                            <img src="{{ $product->getFirstMediaUrl('products') }}" width="50" height="50">
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>{{ $product->is_visible ? 'Yes' : 'No' }}</td>
                                                    <td>
                                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                        <button wire:click="delete({{ $product->id }})"
                                                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                                            class="btn btn-danger btn-sm">Delete</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> --}}

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SL. No</th>
                                                <th>Title</th>
                                                <th>Type</th>
                                                <th>Category</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                                <th>Image</th>
                                                <th>Visibility</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($all_products as $product)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $product->title }}</td>
                                                    <td>
                                                        @if($product->product_type == 'simple')
                                                            <span class="badge bg-primary">Simple</span>
                                                        @elseif($product->product_type == 'variable')
                                                            <span class="badge bg-info">Variable</span>
                                                        @elseif($product->product_type == 'combo')
                                                            <span class="badge bg-warning text-dark">Combo</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                                                    <td>
                                                        @if($product->product_type == 'simple')
                                                            {{ number_format($product->price, 2) }}
                                                        @elseif($product->product_type == 'variable')
                                                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="collapse" 
                                                                    data-bs-target="#variations-{{ $product->id }}">
                                                                View Variations ({{ $product->variations->count() }})
                                                            </button>
                                                        @elseif($product->product_type == 'combo')
                                                            <span class="fw-bold">{{ number_format($product->combo_price, 2) }}</span>
                                                            <small class="d-block">(Combo Price)</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($product->product_type == 'simple')
                                                            @if($product->stock <= 5)
                                                                <span class="text-danger fw-bold">{{ $product->stock }} (Low Stock!)</span>
                                                            @else
                                                                <span class="text-success fw-bold">{{ $product->stock }} (In Stock)</span>
                                                            @endif
                                                        @elseif($product->product_type == 'variable')
                                                            {{-- <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" 
                                                                    data-bs-target="#variations-stock-{{ $product->id }}">
                                                                View Stock
                                                            </button> --}}
                                                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="collapse" 
                                                                    data-bs-target="#variations-{{ $product->id }}">
                                                                View Variations ({{ $product->variations->count() }})
                                                            </button>
                                                        @elseif($product->product_type == 'combo')
                                                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="collapse" 
                                                                    data-bs-target="#combo-items-{{ $product->id }}">
                                                                View Components
                                                            </button>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($product->getFirstMediaUrl('products'))
                                                            <img src="{{ $product->getFirstMediaUrl('products') }}" width="50" height="50" class="img-thumbnail">
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($product->is_visible)
                                                            <span class="badge bg-success">Visible</span>
                                                        @else
                                                            <span class="badge bg-secondary">Hidden</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                        <button wire:click="delete({{ $product->id }})"
                                                            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                                            class="btn btn-danger btn-sm">Delete</button>
                                                    </td>
                                                </tr>

                                                {{-- Variable Product Variations --}}
                                                @if($product->product_type == 'variable')
                                                <tr class="collapse" id="variations-{{ $product->id }}">
                                                    <td colspan="9">
                                                        <div class="p-3 bg-light">
                                                            <h6>Variations for {{ $product->title }}</h6>
                                                            <table class="table table-sm table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Option</th>
                                                                        <th>Price</th>
                                                                        <th>Stock</th>
                                                                        <th>SKU</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($product->variations as $variation)
                                                                    <tr>
                                                                        <td>{{ $variation->value }}</td>
                                                                        <td>{{ number_format($variation->price_override ?? $product->price, 2) }}</td>
                                                                        <td>
                                                                            @if($variation->stock <= 5)
                                                                                <span class="text-danger fw-bold">{{ $variation->stock }} (Low!)</span>
                                                                            @else
                                                                                <span class="text-success">{{ $variation->stock }}</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $variation->sku ?? 'N/A' }}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif

                                                {{-- Combo Product Components --}}
                                                @if($product->product_type == 'combo')
                                                <tr class="collapse" id="combo-items-{{ $product->id }}">
                                                    <td colspan="9">
                                                        <div class="p-3 bg-light">
                                                            <h6>Combo Components for {{ $product->title }}</h6>
                                                            <table class="table table-sm table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Product</th>
                                                                        <th>Type</th>
                                                                        <th>Quantity</th>
                                                                        <th>Price</th>
                                                                        <th>Stock</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($product->comboItems as $comboItem)
                                                                    @php
                                                                        $isVariation = $comboItem->variation_id != null;
                                                                        $itemProduct = $isVariation ? $comboItem->variation : $comboItem->product;
                                                                        $stock = $isVariation ? $comboItem->variation->stock : $comboItem->product->stock;
                                                                    @endphp
                                                                    <tr>
                                                                        <td>
                                                                            {{ $isVariation ? $comboItem->product->title : $itemProduct->title }}
                                                                            @if($isVariation)
                                                                                <br><small>{{ $comboItem->variation->value }}</small>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $isVariation ? 'Variation' : 'Product' }}</td>
                                                                        <td>{{ $comboItem->quantity }}</td>
                                                                        <td>{{ number_format($comboItem->price_override ?? $itemProduct->price, 2) }}</td>
                                                                        <td>
                                                                            @if($stock <= 5)
                                                                                <span class="text-danger fw-bold">{{ $stock }} (Low!)</span>
                                                                            @else
                                                                                <span class="text-success">{{ $stock }}</span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            <div class="mt-2">
                                                                <strong>Combo Price: </strong> {{ number_format($product->combo_price, 2) }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>



                                <div class="mt-3">
                                    {{ $all_products->links() }} <!-- Pagination links -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Initialize Bootstrap tooltips
    document.addEventListener('livewire:load', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>