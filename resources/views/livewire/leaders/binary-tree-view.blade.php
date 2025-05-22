<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-end">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active">Home</li>
                                 
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body table-responsive" style="/*display:flex;justify-content:center;*/">       
                                {{-- <div class="d-flex justify-content-between align-items-center">
                                    <!-- Search Form -->
                                    <div>
                                        <form action="" method="get" class="d-flex" id="search-form">
                                            <input type="search" id="search-query" class="form-control form-control-sm me-2" placeholder="Search by name or ID" name="query" aria-controls="datatable-buttons" minlength="3" autocomplete="off">
                                        </form>
                                        
                                        <!-- Suggestions Dropdown -->
                                        <div id="suggestions" class="list-group position-absolute" style="display: none; z-index: 999;"></div>
                                        
                                    </div>
                                
                                </div> --}}
                                <div class="body genealogy-body genealogy-scroll">
                                    <!-- Loading overlay - shows during Livewire updates -->
                                    <div wire:loading class="loading-overlay">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading tree...</span>
                                        </div>
                                    </div>
                                    @if($root)
                                        <div class="d-flex justify-content-between mb-3">
                                            @if($currentRootId)
                                                <button wire:click="loadTree()" class="btn btn-sm btn-primary">
                                                    Back to Root
                                                </button>
                                            @else
                                                <div></div> <!-- Empty spacer -->
                                            @endif
                                        </div>
                                
                                        <div class="genealogy-tree">
                                            <ul id="tree-container">
                                                <livewire:leaders.tree-partials.tree-node
                                                    :node="$root" 
                                                    :currentDepth="1" 
                                                    :maxDepth="$levelsToShow"
                                                    wire:key="node-{{ $root->user_id }}"
                                                />
                                            </ul>
                                        </div>
                                    @else
                                        <p class="text-center">No tree data found.</p>
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