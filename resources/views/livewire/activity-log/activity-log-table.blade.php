<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Activity Log</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-end">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active">Activity Log</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label>From</label>
                                    <input type="date" wire:model.live="from_date" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>To</label>
                                    <input type="date" wire:model.live="to_date" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>User</label>
                                    <select wire:model.live="user_id" class="form-select select2">
                                        <option value="">All Users</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }} @if($user->roles->count()) ({{ $user->roles->pluck('name')->join(', ') }}) @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    {{-- <tr>
                                        <th>Date</th>
                                        <th>User</th>
                                        <th>Role</th>
                                        <th>Description</th>
                                        <th>IP</th>
                                    </tr> --}}
                                    <tr>
                                        <th>#</th>
                                        <th>Log Name</th>
                                        <th>Description</th>
                                        <th>User</th>
                                        <th>Properties</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($logs as $log)
                                        {{-- <tr>
                                            <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td>{{ $log->causer?->name }}</td>
                                            <td>{{ $log->causer?->roles->pluck('name')->join(', ') }}</td>
                                            <td>{{ $log->description }}</td>
                                            <td>{{ $log->properties['ip'] ?? '-' }}</td>
                                        </tr> --}}
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ ucwords(str_replace('-', ' ', $log->log_name)) }}</td>
                                            <td>{{ $log->description }}</td>
                                            <td>{{ $log->causer ? $log->causer->name : 'System' }}</td>
                                            <td><pre>{{ json_encode($log->properties, JSON_PRETTY_PRINT) }}</pre></td>
                                            <td>{{ format_datetime($log->created_at) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $logs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>