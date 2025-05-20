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
                                <li class="active">Monthly Return</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-4 d-flex align-items-end">
                                    <button wire:click="exportPdf" class="btn btn-danger me-2">
                                        <i class="fas fa-file-pdf me-1"></i> PDF Export
                                    </button>
                                    <button wire:click="exportExcel" class="btn btn-success">
                                        <i class="fas fa-file-excel me-1"></i> Excel Export
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input wire:model.live="search" type="text" class="form-control" placeholder="Search...">
                                    </div>
                                </div>
                                <div class="col-md-2 text-right">
                                    <a href="{{ route('monthly-return.create') }}" class="btn btn-primary">
                                        <i class="ti-plus"></i> Add New
                                    </a>
                                </div>
                                
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                Sl.No.
                                            </th>
                                            <th>Category</th>
                                            {{-- <th>Product</th> --}}
                                            <th wire:click="sortBy('form_amount')" style="cursor: pointer;">
                                                From Amount
                                            </th>
                                            <th wire:click="sortBy('to_amount')" style="cursor: pointer;">
                                                To Amount
                                            </th>
                                            <th>Return %</th>
                                            <th>Visible</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($returns as $return)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $return->category?->name }}</td>
                                            {{-- <td>{{ $return->product?->title }}</td> --}}
                                            <td>{{ number_format($return->form_amount, 2) }}</td>
                                            <td>{{ number_format($return->to_amount, 2) }}</td>
                                            <td>{{ $return->return_persentage }}%</td>
                                            <td>
                                                <span class="badge badge-{{ $return->is_visible ? 'success' : 'danger' }}">
                                                    {{ $return->is_visible ? 'Yes' : 'No' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('monthly-return.edit', $return->id) }}" class="btn btn-sm btn-primary">
                                                    Edit
                                                </a>
                                                <button wire:click="delete({{ $return->id }})" class="btn btn-sm btn-danger" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No records found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    Showing {{ $returns->firstItem() }} to {{ $returns->lastItem() }} of {{ $returns->total() }} entries
                                </div>
                                <div class="col-md-6">
                                    <div class="float-right">
                                        {{ $returns->links() }}
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