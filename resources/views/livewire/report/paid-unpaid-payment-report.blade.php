<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>{{ $title }}</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-8 p-l-0 title-margin-left">
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
                                <form wire:submit.prevent="">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <label for="startDate">Start Date</label>
                                            <input type="date" class="form-control" id="startDate" wire:model.live="startDate">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="endDate">End Date</label>
                                            <input type="date" class="form-control" id="endDate" wire:model.live="endDate">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="search-report">Search</label>
                                            <input type="text" class="form-control" id="search-report" placeholder="Search..." wire:model.live="search">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label" for="status">Choose Status</label>
                                            <select class="form-control" name="status" wire:model.live="status">
                                                <option value="-1">All</option>
                                                <option value="1">Paid</option>
                                                <option value="0">Unpaid</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mt-4">
                                            <button wire:click="exportExcel" class="btn btn-success me-2">
                                                Export Excel
                                            </button>
                                            <button wire:click="exportPDF" class="btn btn-danger">
                                                Export PDF
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive mt-3">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-wrap">Name</th>
                                                <th class="text-wrap">ID</th>
                                                <th class="text-wrap">Total Payout Amount</th>
                                                <th class="text-wrap">Payout Date</th>
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
                                                    <td class="text-wrap">{{ $item->user?->name }}</td>
                                                    <td class="text-wrap">{{ $item->user?->member_number }}</td>
                                                    <td class="text-wrap">{{ $item->total_payout }}</td>
                                                    <td class="text-wrap">{{ formated_date($item->start_date) }} - {{ formated_date($item->end_date) }}</td>
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
                                                    <td colspan="12" class="text-center">No records found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-3">
                                    {{ $items->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>