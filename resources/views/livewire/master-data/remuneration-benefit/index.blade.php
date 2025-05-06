<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Remuneration Benefit</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Master Data</a></li>
                                <li><a wire:navigate href="{{ route('remuneration-benefit.index') }}">Remuneration Benefit</a></li>
                                <li class="active">Remuneration Benefit</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <input type="text" class="form-control w-25" placeholder="Search rank name..." wire:model.debounce.500ms="search">
                                <a href="{{ route('remuneration-benefit.create') }}" class="btn btn-primary">Add New</a>
                            </div>

                            @if (session()->has('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Rank Name</th>
                                        <th>Matching Target</th>
                                        <th>Bonus</th>
                                        <th>Month Validity</th>
                                        <th>Visible</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->rank_name }}</td>
                                            <td>{{ $item->matching_target }}</td>
                                            <td>{{ $item->bonus }}</td>
                                            <td>{{ $item->month_validity }}</td>
                                            <td>{{ $item->is_visible ? 'Yes' : 'No' }}</td>
                                            <td>
                                                <a href="{{ route('remuneration-benefit.edit', $item->id) }}" class="btn btn-sm btn-info">Edit</a>
                                                <button wire:click="delete({{ $item->id }})" class="btn btn-sm btn-danger" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">No data found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{ $items->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
