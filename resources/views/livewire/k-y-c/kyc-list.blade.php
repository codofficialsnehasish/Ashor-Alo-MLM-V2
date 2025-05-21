<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>KYC @if($statusFilter !== 'all') - {{ ucfirst($statusFilter) }} @endif</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active">KYC @if($statusFilter !== 'all') - {{ ucfirst($statusFilter) }} @endif</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <!-- Status Tabs -->
                            <ul class="nav nav-tabs mb-4">
                                <li class="nav-item">
                                    <a wire:navigate href="{{ route('kyc.all') }}" 
                                    class="nav-link {{ request()->routeIs('kyc.all') ? 'active bg-dark text-white' : '' }}">
                                        All
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a wire:navigate href="{{ route('kyc.pending') }}" 
                                    class="nav-link {{ request()->routeIs('kyc.pending') ? 'active bg-warning text-white' : '' }}">
                                        Pending
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a wire:navigate href="{{ route('kyc.completed') }}" 
                                    class="nav-link {{ request()->routeIs('kyc.completed') ? 'active bg-success text-white' : '' }}">
                                        Completed
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a wire:navigate href="{{ route('kyc.cancelled') }}" 
                                    class="nav-link {{ request()->routeIs('kyc.cancelled') ? 'active bg-danger text-white' : '' }}">
                                        Cancelled
                                    </a>
                                </li>
                            </ul>

                            <!-- Your table content here -->
                            <table class="table table-bordered">
                                <!-- Table headers -->
                                <thead>
                                    <tr>
                                        <th>Sl No</th>
                                        <th>User Name</th>
                                        <th>User ID</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kycs as $index => $kyc)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $kyc->user->name ?? 'N/A' }}</td>
                                            <td>{{ $kyc->user->id }}</td>
                                            <td>
                                                @if($kyc->status == 1)
                                                    <span class="badge bg-success">Verified</span>
                                                @elseif($kyc->status == 2)
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>{{ $kyc->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('kyc.details', $kyc) }}" class="btn btn-sm btn-info" style="font-size: 1rem;">Details</a>
                                                @if($kyc->activities->count())
                                                <button 
                                                    wire:click="showActivity({{ $kyc->id }})"
                                                    class="btn btn-warning">
                                                    View Activity
                                                </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @if(count($kycs) === 0)
                                <div class="p-4 text-center text-gray-500">
                                    No KYC requests found @if($statusFilter !== 'all') with status "{{ $statusFilter }}" @endif.
                                </div>
                            @endif

                            @if($selectedKyc)
                                <div class="bg-gray-100 p-4 border rounded">
                                    <h3 class="text-lg font-bold mb-2">KYC Details for: {{ $selectedKyc->user->name }}</h3>
                                    <button wire:click="closeDetails" class="float-right text-red-500">✖ Close</button>
                                    <ul class="list-disc pl-5">
                                        @foreach (['identity_proof', 'address_proof', 'bank_proof', 'pan_proof'] as $type)
                                            @php
                                                $media = $selectedKyc->getFirstMedia($type);
                                            @endphp
                                            <li class="mb-2">
                                                <strong>{{ ucwords(str_replace('_', ' ', $type)) }}:</strong><br>
                                                @if($media)
                                                    <strong>{{ ucwords(str_replace('_', ' ', $media->getCustomProperty('type'))) }}:</strong><br>
                                                    <img src="{{ $media->getFullUrl() }}" alt="{{ $type }}" class="w-32 h-auto border mb-1"><br>
                                                    Status: {{ $media->getCustomProperty('status') == 1 ? 'Approved' : 'Pending' }}<br>
                                                    Remarks: {{ $media->getCustomProperty('remarks') ?? 'N/A' }}
                                                @else
                                                    <em>No document uploaded</em>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Activity Modal -->
                            @if($showActivityModal)
                                <div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title">Change History of - {{ $kycs->firstWhere('id', $activityKycId)?->user?->name }} KYC</h5>
                                                <button type="button" class="btn-close" wire:click="closeActivityModal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <livewire:k-y-c.kyc-activity-log :kycId="$activityKycId" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" wire:click="closeActivityModal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>