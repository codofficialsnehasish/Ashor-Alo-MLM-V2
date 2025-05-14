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
                                    <div class="col-md-6 d-flex align-items-end">
                                        <button wire:click="exportPdf" class="btn btn-danger me-2">
                                            <i class="fas fa-file-pdf me-1"></i> PDF Export
                                        </button>
                                        <button wire:click="exportExcel" class="btn btn-success">
                                            <i class="fas fa-file-excel me-1"></i> Excel Export
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <input wire:model.live="search" type="search" class="form-control" placeholder="Search products...">
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <a class="btn btn-outline-primary btn-sm px-4 mt-0 mb-3" wire:navigate href="{{ route('products.create')}}" >
                                            Create <i class="ti-plus"></i> 
                                        </a>
                                    </div>
                                </div>

                                <div class="table-responsive">
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
                                </div>

                                <div class="d-flex justify-content-center">
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
