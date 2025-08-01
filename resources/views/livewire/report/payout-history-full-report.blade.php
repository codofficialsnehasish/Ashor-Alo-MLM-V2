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
                                        <label for="startDate">Start Date</label>
                                        <input type="date" class="form-control" id="startDate" wire:model="startDate">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="endDate">End Date</label>
                                        <input type="date" class="form-control" id="endDate" wire:model="endDate">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end">
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
                                    <div class="col-md-12 d-flex align-items-end justify-content-center mt-4">
                                        <h5>Showing transactions for: {{ $userName }} (ID: {{ $userId }})</h5>
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
                                                <th>Sl. No.</th>
                                                <th>Issue Date</th>
                                                <th>Amount</th>
                                                <th>Paid Date</th>
                                                <th>Mode</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($items as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ formated_date($item->end_date,'-') }}</td>
                                                    <td>{{ $item->total_payout }}</td>
                                                    <td>{{ !empty($item->paid_date) ? formated_date($item->paid_date,'-') : '' }}</td>
                                                    <td>{{ $item->paid_mode }}</td>
                                                    <td>{!! paid_unpaid($item->id,$item->user_id) !!}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No transactions found</td>
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