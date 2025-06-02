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
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label for="startDate">Start Date</label>
                                            <input type="date" class="form-control" id="startDate" wire:model="startDate">
                                        </div>
                                        <div class="col-md-2">
                                            <label for="endDate">End Date</label>
                                            <input type="date" class="form-control" id="endDate" wire:model="endDate">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="searchs">Search User</label>
                                            <input type="text" class="form-control" id="searchs" placeholder="Search by username or name" wire:model.live="search">
                                        </div>
                                        <div class="col-md-5">
                                            <button wire:click="exportExcel" class="btn btn-success me-2">
                                                 Export Excel
                                            </button>
                                            <button wire:click="exportPDF" class="btn btn-danger">
                                                 Export PDF
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>ID</th>
                                                <th>Amount</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($items as $item)
                                                <tr>
                                                    <td>{{ $item->user->name ?? 'N/A' }}</td>
                                                    <td>{{ $item->user->member_number ?? 'N/A' }}</td>
                                                    <td>{{ $item->total_amount }}</td>
                                                    <td>
                                                        <button wire:click="showFullDetails({{ $item->user_id }})" class="btn btn-sm btn-primary">
                                                            View Details
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">No records found</td>
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