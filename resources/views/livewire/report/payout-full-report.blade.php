<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>{{ $title }}</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Reports</a></li>
                                <li class="active">{{ $title }}</li>
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
                                <div class="row align-item-center">
                                    <div class="col-md-3">
                                        <label for="searchs">Search User</label>
                                        <input type="text" class="form-control" id="searchs" placeholder="Search" wire:model.live="search">
                                    </div>
                                    <div class="col-md-6">
                                        <button wire:click="backToSummary" class="btn btn-secondary me-2">
                                            Back to Summary
                                        </button>
                                        <button wire:click="exportFullExcel" class="btn btn-success me-2">
                                            Export Excel
                                        </button>
                                        <button wire:click="exportFullPDF" class="btn btn-danger">
                                            Export PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-wrap">Paid / Unpaid</th>
                                                <th class="text-wrap">Name</th>
                                                <th class="text-wrap">ID</th>
                                                <th class="text-wrap">Total Payout Amount</th>
                                                <th class="text-wrap">Account Name (As Per Bank)</th>
                                                <th class="text-wrap">Bank Name</th>
                                                <th class="text-wrap">Account Number</th>
                                                <th class="text-wrap">IFSC</th>
                                                <th class="text-wrap">Account Type</th>
                                                <th class="text-wrap">UPI Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($items as $item)
                                                <tr>
                                                    <td><input type="checkbox" class="status-toggle" data-bs-toggle="modal" data-bs-target="#statusModal" id="" data-item-id="{{ $item->id }}" {{ $item->paid_unpaid == 1 ? 'checked' : '' }}></td>
                                                    <td class="text-wrap">{{ $item->user->name ?? '' }}</td>
                                                    <td class="text-wrap">{{ $item->user->member_number ?? '' }}</td>
                                                    <td class="text-wrap">{{ $item->total_payout ?? '' }}</td>
                                                    <td class="text-wrap">{{ $item->user?->bankDetails?->account_name ?? '' }}</td>
                                                    <td class="text-wrap">{{ $item->user?->bankDetails?->bank_name ?? '' }}</td>
                                                    <td class="text-wrap">{{ $item->user?->bankDetails?->account_number ?? '' }}</td>
                                                    <td class="text-wrap">{{ $item->user?->bankDetails?->ifsc_code ?? '' }}</td>
                                                    <td class="text-wrap">{{ $item->user?->bankDetails?->account_type ?? '' }}</td>
                                                    <td>
                                                        <Strong>UPI Type : </Strong> {{ $item->user?->bankDetails?->upi_type ?? '' }}<br>
                                                        <Strong>UPI Number : </Strong> {{ $item->user?->bankDetails?->upi_number ?? '' }}<br>
                                                        <Strong>UPI Name : </Strong> {{ $item->user?->bankDetails?->upi_name ?? '' }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center">No transactions found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-3">
                                    {{ $items->links() }}
                                </div>

                                <div wire:ignore.self class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>