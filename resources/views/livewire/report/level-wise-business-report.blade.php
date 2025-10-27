<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Level Wise Business Report</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Reports</a></li>
                                <li class="active">Level Wise Business Report</li>
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
                                        <form wire:submit.prevent="generateReport">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="startDate">Start Date</label>
                                                    <input type="date" class="form-control" id="startDate" wire:model.live="start_date">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="endDate">End Date</label>
                                                    <input type="date" class="form-control" id="endDate" wire:model.live="end_date">
                                                </div>
                                                <div class="mb-0 col-md-4">
                                                    <label class="form-label">Choose Agents</label>
                                                    <select class="form-control select2" wire:model="user_id">
                                                        <option selected disabled value="">Select...</option>
                                                        @foreach($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }} ( {{ $user->member_number ?? 'N/A' }} )</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-0 col-md-2">
                                                    <label class="form-label">Choose Position</label>
                                                    <select class="form-control" wire:model="position">
                                                        <option value="">All Positions</option>
                                                        <option value="left">Left</option>
                                                        <option value="right">Right</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2" style="margin-top: 29px !important;">
                                                    <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">
                                                        <span wire:loading.remove>Search Report</span>
                                                        <span wire:loading>Loading...</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Show loading state -->
                        @if($isLoading && empty($groupedBusiness))
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2">Loading report data...</p>
                            </div>
                        </div>
                        @endif

                        <!-- Show data when available -->
                        @if(count($groupedBusiness) > 0)
                            <div class="card">
                                <div class="card-body text-center">
                                    <h3><strong>{{ $title }}</strong></h3>
                                    <button wire:click="exportPdf" class="btn btn-primary" wire:loading.attr="disabled">
                                        <i class="fas fa-file-pdf me-2"></i> Export To PDF
                                    </button>
                                    <button wire:click="exportExcel" class="btn btn-primary" wire:loading.attr="disabled">
                                        <i class="fas fa-file-excel me-2"></i> Export To Excel
                                    </button>
                                </div>
                            </div>

                            <!-- Levels Container for Infinite Scroll -->
                            <div id="levels-container">
                                @foreach ($groupedBusiness as $level => $business)
                                <div class="card shadow mb-4 level-card" data-level="{{ $level }}">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Level {{ $level + 1 }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered dt-responsive nowrap datatable-buttons" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="text-wrap">Sl. No.</th>
                                                        <th class="text-wrap">Name</th>
                                                        <th class="text-wrap">Position</th>
                                                        <th class="text-wrap">Phone</th>
                                                        <th class="text-wrap">Sponsor Id</th>
                                                        <th class="text-wrap">Date</th>
                                                        <th class="text-wrap">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $amount = 0 @endphp
                                                    @foreach($business as $item)
                                                    @php 
                                                        $amount += $item['total_business']->total_amount;
                                                    @endphp
                                                    <tr>
                                                        <td class="text-wrap">{{ $loop->iteration }}</td>
                                                        <td class="text-wrap">{{ $item['name'] }} ({{ $item['user_id'] }}) </td>
                                                        <td class="text-wrap">{{ $item['position'] }}</td>
                                                        <td class="text-wrap">{{ $item['phone'] }}</td>
                                                        <td class="text-wrap">{{ $item['sponsor_id'] }}</td>
                                                        <td class="text-wrap">{{ formated_date($item['total_business']->start_date,'-') }}</td>
                                                        <td class="text-wrap">{{ $item['total_business']->total_amount }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><b>Total Amount - {{ $amount }}</b></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Loading Indicator for more levels -->
                            @if($isLoading)
                            <div class="text-center p-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2">Loading more levels...</p>
                            </div>
                            @endif

                            <!-- Load More Trigger -->
                            @if($hasMoreLevels && !$isLoading)
                            <div class="text-center mb-4" 
                                 x-data="{
                                    init() {
                                        const observer = new IntersectionObserver((entries) => {
                                            entries.forEach(entry => {
                                                if (entry.isIntersecting) {
                                                    @this.call('loadMore')
                                                }
                                            })
                                        }, { threshold: 0.5 })
                                        
                                        observer.observe(this.$el)
                                    }
                                 }"
                                 x-init="init">
                                <div class="card">
                                    <div class="card-body">
                                        {{-- <p class="text-muted">Scroll down to load more levels...</p> --}}
                                        <button wire:click="loadMore" class="btn btn-primary">
                                            Load Next {{ $levelsPerLoad }} Levels
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @elseif(!$hasMoreLevels && count($groupedBusiness) > 0)
                            <div class="text-center mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="text-success">All levels loaded!</p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="card">
                                <div class="card-body text-center">
                                    <b>Total Member : <strong>{{ $total_user_count }}</strong></b> | 
                                    <b>Total Amount : <strong>{{ $total_amount }}</strong></b>
                                    <br>
                                    <small class="text-muted">Showing levels 1 to {{ min($loadedLevels, $maxLevels) }} of {{ $maxLevels }}</small>
                                </div>
                            </div>
                        @elseif($initialLoad && !$isLoading)
                            <!-- Show only when search was performed but no data found -->
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4>No data found. Please adjust your search criteria.</h4>
                                </div>
                            </div>
                        @elseif(!$initialLoad)
                            <!-- Show initial state before search -->
                            <div class="card">
                                <div class="card-body text-center">
                                    <h4>Please set your search criteria and click "Search Report" to generate the report.</h4>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script()
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize select2 if needed
        $('.select2').select2();
        
        // Infinite scroll observer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !@this.isLoading && @this.hasMoreLevels) {
                    @this.call('loadMore');
                }
            });
        }, { threshold: 0.5 });

        const loadMoreTrigger = document.querySelector('[x-data]');
        if (loadMoreTrigger) {
            observer.observe(loadMoreTrigger);
        }
    });
</script>
@endscript