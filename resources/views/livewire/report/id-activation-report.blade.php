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
                                <form wire:submit.prevent="generateReport">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="startDate">Start Date</label>
                                            <input type="date" class="form-control" id="startDate" wire:model="startDate">
                                            @error('startDate') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="endDate">End Date</label>
                                            <input type="date" class="form-control" id="endDate" wire:model="endDate">
                                            @error('endDate') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="activatedBy">Activated By</label>
                                            <select class="form-control" id="activatedBy" wire:model="activatedBy">
                                                <option value="">All Admins</option>
                                                @foreach($admins as $admin)
                                                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary">Generate Report</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-body">
                                @if(count($items) > 0)
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>ID</th>
                                                <th>Amount</th>
                                                <th>Activation Date</th>
                                                <th>Activated By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($items as $item)
                                                <tr>
                                                    <td>{{ $item->user?->name }}</td>
                                                    <td>{{ $item->member_number }}</td>
                                                    <td>{{ $item->joining_amount }}</td>
                                                    <td>{{ $item->joinedBy->name ?? 'N/A' }}</td>
                                                    <td>{{ format_datetime($item->activated_at) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-info">No records found for the selected criteria.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>