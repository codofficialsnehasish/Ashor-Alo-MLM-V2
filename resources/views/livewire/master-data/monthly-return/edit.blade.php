<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Monthly Return</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Master Data</a></li>
                                <li><a wire:navigate href="{{ route('monthly-return.index') }}">Monthly Return</a></li>
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
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-8">
                                        <h2>Edit Monthly Return Master</h2>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <a href="{{ route('monthly-return.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Back to List
                                        </a>
                                    </div>
                                </div>
                                <form wire:submit.prevent="update">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="category">Category <span class="text-danger">*</span></label>
                                            <select wire:model.live="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $cat)
                                                {{-- <option value="{{ $cat->id }}">{{ $cat->name }}</option> --}}
                                                <option value="{{ $cat->id }}" {{ $cat->id == $category ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="product">Product <span class="text-danger">*</span></label>
                                            <select wire:model="product" id="product" class="form-control @error('product') is-invalid @enderror" {{ empty($products) ? 'disabled' : '' }}>
                                                <option value="">Select Product</option>
                                                @foreach($products as $prod)
                                                {{-- <option value="{{ $prod->id }}">{{ $prod->title }}</option> --}}
                                                <option value="{{ $prod->id }}" {{ $prod->id == $product ? 'selected' : '' }}>{{ $prod->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('product') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="form_amount">From Amount <span class="text-danger">*</span></label>
                                            <input wire:model="form_amount" type="number" step="0.01" class="form-control @error('form_amount') is-invalid @enderror" id="form_amount">
                                            @error('form_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="to_amount">To Amount <span class="text-danger">*</span></label>
                                            <input wire:model="to_amount" type="number" step="0.01" class="form-control @error('to_amount') is-invalid @enderror" id="to_amount">
                                            @error('to_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="percentage">Percentage</label>
                                            <input wire:model="percentage" type="number" class="form-control @error('percentage') is-invalid @enderror" id="percentage">
                                            @error('percentage') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="return_persentage">Return Percentage <span class="text-danger">*</span></label>
                                            <input wire:model="return_persentage" type="number" class="form-control @error('return_persentage') is-invalid @enderror" id="return_persentage">
                                            @error('return_persentage') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input wire:model="is_visible" type="checkbox" class="custom-control-input" id="is_visible" checked>
                                            <label class="custom-control-label" for="is_visible">Visible</label>
                                        </div>
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Save
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