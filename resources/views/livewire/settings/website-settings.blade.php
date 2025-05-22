<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Site Settings</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="active">Site Settings</li>
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
                                        <form wire:submit.prevent="saveSettings">
                                            <!-- General Settings -->
                                            <div class="mb-5 border-bottom pb-4">
                                                <h4 class="mb-4 text-primary">General Settings</h4>
                                                
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="site_name" class="form-label">Site Name</label>
                                                        <input type="text" class="form-control" id="site_name" wire:model="site_name" required>
                                                        @error('site_name') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                    
                                                    <div class="col-md-6 mb-3">
                                                        <label for="site_description" class="form-label">Site Description</label>
                                                        <textarea class="form-control" id="site_description" wire:model="site_description" rows="2"></textarea>
                                                        @error('site_description') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Contact Information -->
                                            <div class="mb-5 border-bottom pb-4">
                                                <h4 class="mb-4 text-primary">Contact Information</h4>
                                                
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="contact_email" class="form-label">Contact Email</label>
                                                        <input type="email" class="form-control" id="contact_email" wire:model="contact_email">
                                                        @error('contact_email') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label for="contact_number" class="form-label">Contact Number</label>
                                                        <input type="text" class="form-control" id="contact_number" wire:model="contact_number">
                                                        @error('contact_number') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label for="contact_address" class="form-label">Contact Address</label>
                                                        <textarea class="form-control" id="contact_address" wire:model="contact_address" rows="2"></textarea>
                                                        @error('contact_address') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Branding -->
                                            <div class="mb-5 border-bottom pb-4">
                                                <h4 class="mb-4 text-primary">Branding</h4>
                                                
                                                <div class="row">
                                                    <!-- Logo -->
                                                    <div class="col-md-6 mb-4">
                                                        <label class="form-label">Site Logo</label>
                                                        
                                                        @if($existingLogo)
                                                            <div class="d-flex align-items-center mb-3">
                                                                <img src="{{ asset($existingLogo) }}" alt="Current Logo" class="img-thumbnail me-3" style="max-height: 80px;">
                                                            </div>
                                                        @endif
                                                        
                                                        <input class="form-control" type="file" wire:model="logo" accept="image/*">
                                                        @error('logo') <span class="text-danger">{{ $message }}</span> @enderror
                                                        <div class="form-text">Recommended size: 200x50 pixels</div>
                                                    </div>

                                                    <!-- Favicon -->
                                                    <div class="col-md-6 mb-4">
                                                        <label class="form-label">Favicon</label>
                                                        
                                                        @if($existingFavicon)
                                                            <div class="d-flex align-items-center mb-3">
                                                                <img src="{{ asset($existingFavicon) }}" alt="Current Favicon" class="img-thumbnail me-3" style="max-height: 80px;">
                                                            </div>
                                                        @endif
                                                        
                                                        <input class="form-control" type="file" wire:model="favicon" accept="image/*">
                                                        @error('favicon') <span class="text-danger">{{ $message }}</span> @enderror
                                                        <div class="form-text">Recommended size: 32x32 pixels</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Maintenance Mode -->
                                            <div class="mb-5 border-bottom pb-4">
                                                <h4 class="mb-4 text-primary">Maintenance Mode</h4>
                                                
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" id="maintenance_mode" wire:model.live="maintenance_mode">
                                                    <label class="form-check-label" for="maintenance_mode">Enable Maintenance Mode</label>
                                                </div>
                                                <p class="text-muted mb-3">When enabled, only administrators can access the site.</p>
                                                
                                                @if($maintenance_mode)
                                                    <div class="mt-3">
                                                        <label for="maintenance_message" class="form-label">Maintenance Message</label>
                                                        <textarea class="form-control" id="maintenance_message" wire:model="maintenance_message" rows="3"></textarea>
                                                        @error('maintenance_message') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- SEO Settings -->
                                            <div class="mb-5 border-bottom pb-4">
                                                <h4 class="mb-4 text-primary">SEO Settings</h4>
                                                
                                                <div class="mb-3">
                                                    <label for="seo_meta_description" class="form-label">Meta Description</label>
                                                    <textarea class="form-control" id="seo_meta_description" wire:model="seo_meta_description" rows="3"></textarea>
                                                    @error('seo_meta_description') <span class="text-danger">{{ $message }}</span> @enderror
                                                    <div class="form-text">Brief description for search engines (160 characters max)</div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="seo_meta_keywords" class="form-label">Meta Keywords</label>
                                                    <textarea class="form-control" id="seo_meta_keywords" wire:model="seo_meta_keywords" rows="2"></textarea>
                                                    @error('seo_meta_keywords') <span class="text-danger">{{ $message }}</span> @enderror
                                                    <div class="form-text">Comma-separated keywords for search engines</div>
                                                </div>
                                            </div>

                                            <!-- Custom Scripts -->
                                            <div class="mb-4">
                                                <h4 class="mb-4 text-primary">Custom Scripts</h4>
                                                
                                                <div class="mb-4">
                                                    <label for="header_scripts" class="form-label">Header Scripts</label>
                                                    <textarea class="form-control font-monospace" id="header_scripts" wire:model="header_scripts" rows="4"></textarea>
                                                    @error('header_scripts') <span class="text-danger">{{ $message }}</span> @enderror
                                                    <div class="form-text">Scripts that will be added before the closing &lt;/head&gt; tag</div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="footer_scripts" class="form-label">Footer Scripts</label>
                                                    <textarea class="form-control font-monospace" id="footer_scripts" wire:model="footer_scripts" rows="4"></textarea>
                                                    @error('footer_scripts') <span class="text-danger">{{ $message }}</span> @enderror
                                                    <div class="form-text">Scripts that will be added before the closing &lt;/body&gt; tag</div>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary px-4">
                                                    <i class="ti-save me-2"></i> Save Settings
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
