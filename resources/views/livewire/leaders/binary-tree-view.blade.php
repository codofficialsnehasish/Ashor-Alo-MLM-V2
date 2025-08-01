<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Tree View</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-end">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a wire:navigate href="{{ route('leaders.all') }}">Leaders</a></li>
                                <li class="active">Tree View</li>
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
                                    {{-- <div wire:loading class="loading-overlay">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading tree...</span>
                                        </div>
                                    </div> --}}
                                    @if($root)
                                        <form wire:submit.prevent="">
                                            <div class="row align-items-center">
                                                <div class="col-md-5">
                                                    <div class="search-container">
                                                        <input type="text" class="form-control" id="search-report" 
                                                            placeholder="Search by name or member number..." 
                                                            wire:model.live="search"
                                                            wire:keydown.escape="searchResults = []"
                                                            autocomplete="off">
                                                        
                                                        @if(count($searchResults) > 0)
                                                          
                                                            
                                                            <div class="search-results dropdown-menu show" style="display: block; width: 35%;">
                                                                @foreach($searchResults as $result)
                                                                    <a href="javascript:void(0)" 
                                                                       class="dropdown-item" 
                                                                       style="white-space: normal; 
                                                                              word-wrap: break-word;
                                                                              padding: 8px 12px;
                                                                              display: block;"
                                                                       wire:click="setAsRoot({{ $result['id'] }})">
                                                                        <div style="display: flex; justify-content: space-between;">
                                                                            <span style="flex: 1; min-width: 0; margin-right: 8px;">
                                                                                {{ $result['name'] }}
                                                                            </span>
                                                                            <span style="color: #6c757d;">
                                                                                ({{ $result['member_number'] }})
                                                                            </span>
                                                                        </div>
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    @if($currentRootId)
                                                        <button wire:click="loadTree()" class="btn btn-sm btn-primary float-end">
                                                            Back to Root
                                                        </button>
                                                    @else
                                                        <div></div> <!-- Empty spacer -->
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                
                                        <div class="genealogy-tree">
                                            <ul id="tree-container">
                                                <livewire:leaders.tree-partials.tree-node
                                                    :node="$root" 
                                                    :currentDepth="1" 
                                                    :maxDepth="$levelsToShow"
                                                    wire:key="node-{{ $root->user_id }}-{{ uniqid() }}"
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