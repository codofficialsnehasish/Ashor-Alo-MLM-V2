<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Privacy Policy</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Legal</a></li>
                                <li class="active">Privacy Policy</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form wire:submit.prevent="save">
                                            <div class="mb-4">
                                                <label for="privacyEditor" class="form-label">Content</label>
                                                <textarea wire:model="privacy_policy" id="privacyEditor" class="form-control" rows="15"></textarea>
                                                @error('privacy_policy') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary px-4">
                                                    <i class="ti-save me-2"></i> Save Changes
                                                </button>
                                            </div>
                                        </form>
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
