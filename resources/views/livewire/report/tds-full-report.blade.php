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
                                    <div class="col-md-6 d-flex align-items-end">
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
                                                <th>Amount</th>
                                                <th>Statement</th>
                                                <th>Generated Against</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($items as $item)
                                                <tr>
                                                    <td>{{ number_format($item->amount, 2) }}</td>
                                                    <td>{{ $item->which_for }}</td>
                                                    <td>{{ $item->generatedAgainstUser?->name ?? 'N/A' }}</td>
                                                    <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">No transactions found</td>
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