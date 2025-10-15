<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Advance</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb float-end">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Advance</a></li>
                                <li class="active">List</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input wire:model.live="search" type="text" placeholder="Search by user name or email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select wire:model.live="statusFilter" class="form-select">
                                        <option value="all">All Statuses</option>
                                        <option value="active">Active</option>
                                        <option value="paid">Paid</option>
                                    </select>
                                </div>
                                <div class="col-md-5 text-end">
                                    <a wire:navigate href="{{ route('advance.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle"></i> Create New
                                    </a>
                                </div>
                            </div>

                            {{-- <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>User</th>
                                            <th>Assigned By</th>
                                            <th class="text-end">Original Amount</th>
                                            <th class="text-end">Due Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($loans as $loan)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <h6 class="mb-0">{{ $loan->user->name }}</h6>
                                                            <small class="text-muted">{{ $loan->user->member_number }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $loan->admin->name }}</td>
                                                <td class="text-end">₹{{ number_format($loan->original_amount, 2) }}</td>
                                                <td class="text-end">₹{{ number_format($loan->due_amount, 2) }}</td>
                                                <td>
                                                    <span class="badge rounded-pill {{ $loan->status === 'active' ? 'bg-warning' : 'bg-success' }}">
                                                        {{ ucfirst($loan->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $loan->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="#" class="btn btn-sm btn-outline-primary" title="View">
                                                            <i class="ti ti-eye"></i>
                                                        </a>
                                                        <a wire:navigate href="{{ route('advance.edit',$loan->id) }}" class="btn btn-sm btn-outline-success" title="Edit">
                                                            <i class="ti-pencil-alt"></i>
                                                        </a>
                                                        <a wire:click="delete({{ $loan->id }})" class="btn btn-sm btn-outline-danger" title="Delete">
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    {{ $loans->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>User</th>
                                            <th>Assigned By</th>
                                            <th class="text-end">Original Amount</th>
                                            <th class="text-end">Cutting Percentage</th>
                                            <th class="text-end">Due Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($loans as $loan)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <h6 class="mb-0">{{ $loan->user->name }}</h6>
                                                            <small class="text-muted">{{ $loan->user->member_number }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $loan->admin->name }}</td>
                                                <td class="text-end">₹{{ number_format($loan->original_amount, 2) }}</td>
                                                <td class="text-end">{{ $loan->cut_percentage }}%</td>
                                                <td class="text-end">₹{{ number_format($loan->due_amount, 2) }}</td>
                                                <td>
                                                    <span class="badge rounded-pill {{ $loan->status === 'active' ? 'bg-warning' : 'bg-success' }}">
                                                        {{ ucfirst($loan->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $loan->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <button wire:click="toggleTransactions({{ $loan->id }})" class="btn btn-sm btn-outline-primary" title="View Transactions">
                                                            <i class="ti ti-eye"></i>
                                                        </button>
                                                        <a wire:navigate href="{{ route('advance.edit',$loan->id) }}" class="btn btn-sm btn-outline-success" title="Edit">
                                                            <i class="ti-pencil-alt"></i>
                                                        </a>
                                                        <button wire:click="delete({{ $loan->id }})" class="btn btn-sm btn-outline-danger" title="Delete">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            @if($expandedLoanId === $loan->id)
                                            <tr>
                                                <td colspan="7" class="p-0">
                                                    <div class="accordion-body p-3 bg-light">
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <input wire:model.live="transactionSearch" type="text" placeholder="Search transactions..." class="form-control">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select wire:model.live="transactionTypeFilter" class="form-select">
                                                                    <option value="all">All Types</option>
                                                                    <option value="credit">Credit</option>
                                                                    <option value="debit">Debit</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input wire:model.live="transactionDateFilter" type="date" class="form-control">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="table-responsive">
                                                            <table class="table table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Date</th>
                                                                        <th>Type</th>
                                                                        <th class="text-end">Amount</th>
                                                                        <th>Note</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse($this->transactions as $transaction)
                                                                        <tr>
                                                                            <td>{{ format_datetime($transaction->created_at) }}</td>
                                                                            <td>
                                                                                <span class="badge bg-{{ $transaction->type === 'payment' ? 'success' : 'info' }}">
                                                                                    {{ ucfirst($transaction->type) }}
                                                                                </span>
                                                                            </td>
                                                                            <td class="text-end">₹{{ number_format($transaction->amount, 2) }}</td>
                                                                            <td>{{ $transaction->description }}</td>
                                                                        </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="5" class="text-center">No transactions found</td>
                                                                        </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    {{ $loans->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>