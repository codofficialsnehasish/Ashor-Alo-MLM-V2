<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Tree Wise Business Report</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Reports</a></li>
                                <li class="active">Tree Wise Business Report</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form wire:submit.prevent="">
                                            <div class="row align-items-center">
                                                <div class="col-md-4">
                                                    <label for="startDate">Start Date</label>
                                                    <input type="date" class="form-control" id="startDate" wire:model.live="start_date">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="endDate">End Date</label>
                                                    <input type="date" class="form-control" id="endDate" wire:model.live="end_date">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="search-report">Search User</label>
                                                    <div class="search-container">
                                                        <input type="text" class="form-control" id="search-report" 
                                                            placeholder="Search by name or member number..." 
                                                            wire:model.live="search"
                                                            wire:keydown.escape="searchResults = []"
                                                            autocomplete="off">
                                                        
                                                        @if(count($searchResults) > 0)
                                                            <div class="search-results dropdown-menu show" style="display: block; width: 31%;">
                                                                @foreach($searchResults as $result)
                                                                    <a href="javascript:void(0)" 
                                                                       class="dropdown-item" 
                                                                       style="white-space: normal; 
                                                                              word-wrap: break-word;
                                                                              padding: 8px 12px;
                                                                              display: block;"
                                                                        wire:click="selectUser({{ $result['id'] }})">
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
                                            </div>
                                        </form>
                                        <div class="body genealogy-body genealogy-scroll">
                                            <div class="genealogy-tree">
                                                <ul>
                                                    <li>
                                                        <a href="javascript:void(0);">
                                                            <div class="member-view-box n-ppost">
                                                                <div class="member-header">
                                                                    <span></span>
                                                                </div>
                                                                <div class="member-image">
                                                                    <img src="{{ $rootNode->user->getFirstMediaUrl('profile-image') ?: asset('assets/images/treeUser/user.png') }}" 
                                                                        style="width: 50px;height: 50px;border-radius: 50%;object-fit: cover;border: 3px solid {{ $rootNode->status == 1 ? 'green' : 'red' }};" 
                                                                        alt="Member" class="rounded-circle">
                                                                </div>
                                                                <div class="member-footer">
                                                                    <div class="name"><span>{{ $rootNode->user?->name ?? 'N/A' }}</span></div>
                                                                    <div class="downline"><span>({{ $rootNode->member_number ?? 'N/A' }})</span></div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <ul class="active">
                                                            <li>
                                                                <a href="javascript:void(0)">
                                                                    <div class="member-view-box n-ppost">
                                                                        <div class="member-footer">
                                                                            <div class="name"><span>Left Business</span></div>
                                                                            <div class="downline"><span>{{ $left_business }}</span></div>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="javascript:void(0) ">
                                                                    <div class="member-view-box n-ppost">
                                                                        <div class="member-footer">
                                                                            <div class="name"><span>Right Business</span></div>
                                                                            <div class="downline"><span>{{ $right_business }}</span></div>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
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
    </div>
</div>