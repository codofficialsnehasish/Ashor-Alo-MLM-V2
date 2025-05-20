<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Remuneration Benefit</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-8 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Master Data</a></li>
                                <li><a wire:navigate href="{{ route('remuneration-benefit.index') }}">Remuneration Benefit</a></li>
                                <li class="active">Edit</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            @if (session()->has('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form wire:submit.prevent="update">
                                <div class="mb-3">
                                    <label>Rank Name</label>
                                    <input type="text" wire:model="rank_name" class="form-control">
                                    @error('rank_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Matching Target</label>
                                    <input type="number" wire:model="matching_target" class="form-control">
                                    @error('matching_target') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Bonus</label>
                                    <input type="number" wire:model="bonus" class="form-control">
                                    @error('bonus') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Month Validity</label>
                                    <input type="number" wire:model="month_validity" class="form-control">
                                    @error('month_validity') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="form-check mb-3">
                                    <input type="checkbox" wire:model="is_visible" class="form-check-input" id="visible">
                                    <label class="form-check-label" for="visible">Visible</label>
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('remuneration-benefit.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
