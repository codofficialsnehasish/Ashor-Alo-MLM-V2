<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>System Users</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active">System Users</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title mb-4">Enhanced Binary Tree Report</h2>
                
                                <!-- Filters Section -->
                                <div class="row mb-4">
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <label class="form-label">Start Date</label>
                                        <input type="date" wire:model="startDate" class="form-control">
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <label class="form-label">End Date</label>
                                        <input type="date" wire:model="endDate" class="form-control">
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <label class="form-label">Member Number</label>
                                        <input type="text" wire:model.debounce.500ms="memberNumber" placeholder="Member number" class="form-control">
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3 d-flex align-items-end">
                                        <button wire:click="resetFilters" class="btn btn-outline-secondary w-100">
                                            <i class="fas fa-redo"></i> Reset Filters
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <input type="text" wire:model.debounce.300ms="tableSearch" placeholder="Search in table..." class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3 d-flex justify-content-end">
                                        <button wire:click="exportExcel" class="btn btn-success me-2">
                                            <i class="fas fa-file-excel"></i> Export Excel
                                        </button>
                                        <button wire:click="exportPDF" class="btn btn-danger">
                                            <i class="fas fa-file-pdf"></i> Export PDF
                                        </button>
                                    </div>
                                </div>
                
                                <!-- Summary Cards -->
                                <div class="row mb-4">
                                    <div class="col-md-4 mb-3">
                                        <div class="card bg-primary text-white">
                                            <div class="card-body">
                                                <h5 class="card-title">Total Members</h5>
                                                <p class="card-text display-6">{{ number_format($totalMembers) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card bg-success text-white">
                                            <div class="card-body">
                                                <h5 class="card-title">Active Members</h5>
                                                <p class="card-text display-6">{{ number_format($activeMembers) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card bg-danger text-white">
                                            <div class="card-body">
                                                <h5 class="card-title">Inactive Members</h5>
                                                <p class="card-text display-6">{{ number_format($inactiveMembers) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                
                                <!-- Results Table -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="dataTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>
                                                    <input type="checkbox" wire:model="selectAll" class="form-check-input">
                                                </th>
                                                <th wire:click="sortBy('member_number')" style="cursor: pointer">
                                                    Member # 
                                                    @if($sortField === 'member_number')
                                                        @if($sortDirection === 'asc')
                                                            <i class="fas fa-sort-up"></i>
                                                        @else
                                                            <i class="fas fa-sort-down"></i>
                                                        @endif
                                                    @else
                                                        <i class="fas fa-sort"></i>
                                                    @endif
                                                </th>
                                                <th wire:click="sortBy('user.name')" style="cursor: pointer">
                                                    Member Name
                                                    @if($sortField === 'user.name')
                                                        @if($sortDirection === 'asc')
                                                            <i class="fas fa-sort-up"></i>
                                                        @else
                                                            <i class="fas fa-sort-down"></i>
                                                        @endif
                                                    @else
                                                        <i class="fas fa-sort"></i>
                                                    @endif
                                                </th>
                                                <th>Sponsor</th>
                                                <th>Parent</th>
                                                <th wire:click="sortBy('position')" style="cursor: pointer">
                                                    Position
                                                    @if($sortField === 'position')
                                                        @if($sortDirection === 'asc')
                                                            <i class="fas fa-sort-up"></i>
                                                        @else
                                                            <i class="fas fa-sort-down"></i>
                                                        @endif
                                                    @else
                                                        <i class="fas fa-sort"></i>
                                                    @endif
                                                </th>
                                                <th wire:click="sortBy('status')" style="cursor: pointer">
                                                    Status
                                                    @if($sortField === 'status')
                                                        @if($sortDirection === 'asc')
                                                            <i class="fas fa-sort-up"></i>
                                                        @else
                                                            <i class="fas fa-sort-down"></i>
                                                        @endif
                                                    @else
                                                        <i class="fas fa-sort"></i>
                                                    @endif
                                                </th>
                                                <th wire:click="sortBy('activated_at')" style="cursor: pointer">
                                                    Activated Date
                                                    @if($sortField === 'activated_at')
                                                        @if($sortDirection === 'asc')
                                                            <i class="fas fa-sort-up"></i>
                                                        @else
                                                            <i class="fas fa-sort-down"></i>
                                                        @endif
                                                    @else
                                                        <i class="fas fa-sort"></i>
                                                    @endif
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($members as $member)
                                                <tr wire:key="{{ $member->id }}">
                                                    <td>
                                                        <input type="checkbox" wire:model="selectedRows" value="{{ $member->id }}" class="form-check-input">
                                                    </td>
                                                    <td>{{ $member->member_number }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $member->user->profile_photo_url ?? 'https://via.placeholder.com/40' }}" 
                                                                 class="rounded-circle me-3" width="40" height="40" alt="Member">
                                                            <div>
                                                                <div class="fw-bold">{{ $member->user->name }}</div>
                                                                <div class="text-muted small">{{ $member->user->email }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($member->sponsor)
                                                            {{ $member->sponsor->user->name ?? 'N/A' }}
                                                            <span class="text-muted">({{ $member->sponsor->member_number }})</span>
                                                        @else
                                                            System
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($member->parent)
                                                            {{ $member->parent->user->name ?? 'N/A' }}
                                                            <span class="text-muted">({{ $member->parent->member_number }})</span>
                                                        @else
                                                            Root
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge {{ $member->position === 'left' ? 'bg-success' : 'bg-info' }}">
                                                            {{ ucfirst($member->position) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge {{ $member->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $member->status == 1 ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ $member->activated_at ? $member->activated_at : 'Not activated' }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center py-4 text-muted">
                                                        No members found matching your criteria.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                
                                <!-- Pagination -->
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="text-muted">
                                            Showing <span class="fw-bold">{{ $members->firstItem() }}</span> to 
                                            <span class="fw-bold">{{ $members->lastItem() }}</span> of 
                                            <span class="fw-bold">{{ $members->total() }}</span> entries
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="float-end">
                                            {{ $members->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @push('styles')
                <style>
                    .card-title {
                        font-size: 1.5rem;
                        font-weight: 600;
                    }
                    .table th {
                        white-space: nowrap;
                    }
                    .table td {
                        vertical-align: middle;
                    }
                    .form-check-input {
                        margin-left: 0;
                    }
                </style>
                @endpush
                
                @push('scripts')
                <script>
                    // Client-side table search functionality
                    document.addEventListener('livewire:load', function() {
                        const searchInput = document.querySelector('input[wire\\:model="tableSearch"]');
                        const dataRows = document.querySelectorAll('tbody tr');
                        
                        searchInput.addEventListener('input', function() {
                            const searchTerm = this.value.toLowerCase();
                            
                            dataRows.forEach(row => {
                                const rowText = row.textContent.toLowerCase();
                                if (rowText.includes(searchTerm)) {
                                    row.style.display = '';
                                } else {
                                    row.style.display = 'none';
                                }
                            });
                        });
                    });
                </script>
                @endpush
            </div>
        </div>
    </div>
</div>
                        