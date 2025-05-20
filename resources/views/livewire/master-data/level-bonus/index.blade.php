<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Level Bonus</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Master Data</a></li>
                                <li class="active">Level Bonus</li>
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
                                <h4>Level Bonus List</h4>
                                <a href="{{ route('level-bonus.create') }}" class="btn btn-primary">+ Add New</a>
                            </div>

                            <input type="text" class="form-control mb-3" placeholder="Search level name..." wire:model.live="search">

                            @if (session()->has('message'))
                                <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                            @endif

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Level #</th>
                                        <th>Name</th>
                                        <th>Percentage (%)</th>
                                        <th>Visible</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($levelBonuses as $bonus)
                                        <tr>
                                            <td>{{ $bonus->level_number }}</td>
                                            <td>{{ $bonus->level_name }}</td>
                                            <td>{{ $bonus->level_percentage }}</td>
                                            <td>{{ $bonus->is_visible ? 'Yes' : 'No' }}</td>
                                            <td>{{ format_datetime($bonus->created_at) }}</td>
                                            <td>
                                                <a href="{{ route('level-bonus.edit', $bonus->id) }}" class="btn btn-sm btn-info">Edit</a>
                                                <button class="btn btn-sm btn-danger" wire:click="delete({{ $bonus->id }})"
                                                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No records found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{ $levelBonuses->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
