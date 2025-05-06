<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Level Bonus Create</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Master Data</a></li>
                                <li><a wire:navigate href="{{ route('level-bonus.index') }}">Level Bonus</a></li>
                                <li class="active">Level Bonus Create</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <h4>Create Level Bonus</h4>

                            <form wire:submit.prevent="save">
                                <div class="mb-3">
                                    <label>Level Name</label>
                                    <input type="text" class="form-control" wire:model="level_name">
                                    @error('level_name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Level Number</label>
                                    <input type="number" class="form-control" wire:model="level_number">
                                    @error('level_number') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3">
                                    <label>Percentage (%)</label>
                                    <input type="number" class="form-control" wire:model="level_percentage" step="0.01">
                                    @error('level_percentage') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" wire:model="is_visible" id="visible">
                                    <label class="form-check-label" for="visible">Visible</label>
                                </div>

                                <button type="submit" class="btn btn-success">Save</button>
                                <a href="{{ route('level-bonus.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
