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
                                        <div class="col-md-4">
                                            <label for="search-report">Search</label>
                                            <input type="text" class="form-control" id="search-report" placeholder="Search..." wire:model.live="search">
                                        </div>
                                        <div class="col-md-4">
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
                                                <th wire:click="sortBy('id')" style="cursor: pointer;">
                                                    ID
                                                    @if($sortField === 'id')
                                                        <i class="ti-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} float-end"></i>
                                                    @endif
                                                </th>
                                                <th>Name</th>
                                                <th wire:click="sortBy('total_amount')" style="cursor: pointer;">
                                                    Amount
                                                    @if($sortField === 'amount')
                                                        <i class="ti-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} float-end"></i>
                                                    @endif
                                                </th>
                                                <th>Category</th>
                                                <th>Payment Mode</th>
                                                <th wire:click="sortBy('start_date')" style="cursor: pointer;">
                                                    Date
                                                    @if($sortField === 'start_date')
                                                        <i class="ti-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }} float-end"></i>
                                                    @endif
                                                </th>
                                                <th>Entry By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($items as $item)
                                                <tr>
                                                    <td>{{ $item->binaryNode->member_number }}</td>
                                                    <td>{{ $item->user->name ?? 'N/A' }}</td>
                                                    <td>{{ $item->total_amount }}</td>
                                                    <td>{{ $item->order?->category?->name ?? 'N/A' }}</td>
                                                    <td>{{ $item->order?->payment_method }}</td>
                                                    <td>{{ $item->start_date }}</td>
                                                    <td>{{ $item->order->placed_by }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No records found</td>
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