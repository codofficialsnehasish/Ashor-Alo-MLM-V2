<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Transfer Subtree</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a wire:navigate href="{{ route('leaders.all') }}">Leaders</a></li>
                                <li class="active">Transfer Subtree</li>
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Select Node to Transfer</h5>
                                        <input type="search" wire:model.live="search" class="form-control mb-3" placeholder="Search members...">
                                        
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Member No.</th>
                                                        <th>Name</th>
                                                        <th>Position</th>
                                                        <th>Sponsor</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($nodes as $node)
                                                        <tr wire:key="node-{{ $node->id }}" 
                                                            @if($selectedNode && $selectedNode->id === $node->id)
                                                                class="table-active"
                                                            @endif>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $node->member_number }}</td>
                                                            <td>
                                                                {{ $node->user->name }}
                                                                @if($node->user->id === auth()->id())
                                                                    <span class="badge bg-primary">You</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($node->position)
                                                                    <span class="badge bg-{{ $node->position === 'left' ? 'info' : 'success' }}">
                                                                        {{ ucfirst($node->position) }}
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-secondary">Root</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($node->sponsor_id)
                                                                    {{ $node->sponsor->user->name ?? 'N/A' }}
                                                                @else
                                                                    None
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-{{ $node->status ? 'success' : 'warning' }}">
                                                                    {{ $node->status ? 'Active' : 'Inactive' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <button wire:click="selectNode({{ $node->id }})" 
                                                                        class="btn btn-sm btn-{{ $selectedNode && $selectedNode->id === $node->id ? 'primary' : 'outline-primary' }}">
                                                                    {{ $selectedNode && $selectedNode->id === $node->id ? 'Selected' : 'Select' }}
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center py-4">No members found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        {{ $nodes->links() }}
                                    </div>
                    
                                    <div class="col-md-6">
                                        @if($selectedNode)
                                            <div class="border p-3 mb-3">
                                                <h5>Selected Node</h5>
                                                <p><strong>Member:</strong> {{ $selectedNode->user->name }}</p>
                                                <p><strong>Member Number:</strong> {{ $selectedNode->member_number }}</p>
                                                <p><strong>Total in Subtree:</strong> {{ $selectedNode->descendants()->count() + 1 }} members</p>
                                            </div>

                                            <div class="border p-3">
                                                <h5>Transfer To</h5>
                                                <div class="mb-3">
                                                    <label>New Sponsor ID</label>
                                                    <input type="text" wire:model.live="newSponsorId" wire:keyup="checkPositions($event.target.value)" class="form-control">
                                                    @error('newSponsorId') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>

                                                @if(count($availablePositions) > 0)
                                                    <div class="mb-3">
                                                        <label>Available Positions</label>
                                                        <select wire:model="position" class="form-select">
                                                            @foreach($availablePositions as $pos)
                                                                <option value="{{ $pos }}">{{ ucfirst($pos) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>


                                                    <!-- Button to trigger modal (replace your existing button) -->
                                                    <button type="button" 
                                                            class="btn btn-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#confirmTransferModal"
                                                            @if(!$selectedNode || !$newSponsorId) disabled @endif>
                                                        Confirm Transfer
                                                    </button>
                                                @else
                                                    <div class="alert alert-warning">
                                                        No available positions under this sponsor
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Bootstrap Modal for Confirmation -->
                                            <div class="modal fade" id="confirmTransferModal" tabindex="-1" aria-labelledby="confirmTransferModalLabel" aria-hidden="true" wire:ignore.self>
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="confirmTransferModalLabel">Confirm Subtree Transfer</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to move {{ $selectedNode->user->name ?? '' }} and all {{ $selectedNode->descendants()->count() ?? 0 }} members under {{ $newSponsorId }}?</p>
                                                            <p class="text-danger"><strong>Warning:</strong> This action cannot be undone!</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="button" class="btn btn-primary" wire:click="confirmTransfer" data-bs-dismiss="modal">Confirm Transfer</button>
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
        </div>
    </div>
</div>