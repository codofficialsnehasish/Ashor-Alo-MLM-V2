<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Members of Leader</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a wire:navigate href="{{ route('leaders.all') }}">Leaders</a></li>
                                <li class="active">Members of Leader</li>
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
                                        <input type="text" wire:model="memberNumber" placeholder="Member number" class="form-control">
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3 d-flex align-items-end">
                                        <button wire:click="applyFilters" class="btn btn-primary me-2">
                                             Apply Filters
                                        </button>
                                        <button wire:click="resetFilters" class="btn btn-outline-secondary">
                                             Reset
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3 d-flex ">
                                        <button wire:click="exportExcel" class="btn btn-success me-2">
                                            <i class="fas fa-file-excel"></i> Export Excel
                                        </button>
                                        <button wire:click="exportPDF" class="btn btn-danger">
                                            <i class="fas fa-file-pdf"></i> Export PDF
                                        </button>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <input type="text" wire:model.live="tableSearch" placeholder="Search in table..." class="form-control">
                                    </div>
                                </div>
                
                                <!-- Summary Cards -->
                                <div class="row mb-3">
                                    <div class="col-md-4 mb-2">
                                        <h6 class="mb-1 text-muted">Total Members : {{ number_format($totalMembers) }}</h6>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <h6 class="mb-1 text-muted">Active Members : {{ number_format($activeMembers) }}</h6>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <h6 class="mb-1 text-muted">Inactive Members : {{ number_format($inactiveMembers) }}</h6>
                                    </div>
                                </div>

                
                                <!-- Results Table -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="dataTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Reg Date</th>
                                                <th>Name</th>
                                                <th>ID</th>
                                                <th>Phone Number</th>
                                                <th>Position</th>
                                                <th>Sponsor Name</th>
                                                <th>Sponsor ID</th>
                                                <th>Status</th>
                                                <th>Activated Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($members as $member)
                                                <tr>
                                                    <td>{{ format_datetime($member->created_at) }}</td>
                                                    <td>{{ $member->user->name }}</td>
                                                    <td>{{ $member->member_number }}</td>
                                                    <td>{{ $member->user->phone }}</td>
                                                    <td>
                                                        <span class="badge {{ $member->position === 'left' ? 'bg-success' : 'bg-info' }}">
                                                            {{ ucfirst($member->position) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($member->sponsor)
                                                            {{ $member->sponsor->user->name ?? 'N/A' }}
                                                        @else
                                                            Root
                                                        @endif
                                                    </td>
                                                    <td>{{ $member->sponsor->member_number }}</td>
                                                    
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
                                                    <td colspan="9" class="text-center py-4 text-muted">
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
                        