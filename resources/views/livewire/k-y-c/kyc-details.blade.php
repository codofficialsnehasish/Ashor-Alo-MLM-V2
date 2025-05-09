@push('styles')
    <style>
        .modal-backdrop {
            opacity: 0.5;
        }
        .document-preview {
            max-width: 100px;
            max-height: 100px;
            cursor: pointer;
        }
        .image-modal {
            max-width: 90vw;
            max-height: 90vh;
        }
        [x-cloak] { display: none !important; }
    </style>
@endpush
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>KYC</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a wire:navigate href="{{ route('kyc.all') }}">KYC</a></li>
                                <li class="active">KYC Details</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <h3 class="text-center text-success mb-4">KYC Details of {{ $user->name }}</h3>

                            @foreach([
                                'identity_proof' => 'Identity Proof',
                                'address_proof' => 'Address Proof',
                                'bank_proof' => 'Bank A/C Proof',
                                'pan_proof' => 'PAN Card Proof',
                            ] as $collection => $label)
                                @php
                                    $media = $kyc->getFirstMedia($collection);
                                @endphp

                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-white">
                                        {{ $label }}
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <strong>Proof Type:</strong>
                                                {{ str_replace('_', ' ', $media?->getCustomProperty('type')) ?? '-' }}
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Proof:</strong><br>
                                                @if($media)
                                                    @if(str($media->mime_type)->contains('image'))
                                                        <img 
                                                            src="{{ $media->getFullUrl() }}" 
                                                            wire:click="$dispatch('openImage', { url: '{{ $media->getFullUrl() }}' })" 
                                                            class="document-preview img-thumbnail"
                                                            alt="{{ $label }}"
                                                        >
                                                    @else
                                                        <a href="{{ $media->getFullUrl() }}" target="_blank" class="btn btn-sm btn-info">
                                                            View Document
                                                        </a>
                                                    @endif
                                                @else
                                                    <em>No document</em>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Status:</strong>
                                                <select wire:model.live="statusFields.{{ $collection }}" class="form-select">
                                                    <option value="0">Pending</option>
                                                    <option value="1">Approved</option>
                                                    <option value="2">Rejected</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <strong>Remarks:</strong><br>
                                                {{ $remarksFields[$collection] ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Remarks Modal -->
                            @if($showModal)
                                <div x-data="{ show: @entangle('showModal') }" x-show="show" x-cloak>
                                    <div class="modal-backdrop fade show"></div>
                                    <div class="modal fade show d-block" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Enter Remarks</h5>
                                                    <button type="button" class="btn-close" @click="show = false"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <textarea wire:model.defer="modalRemarks" class="form-control" rows="4" 
                                                            placeholder="Enter reason for rejection..."></textarea>
                                                    @error('modalRemarks') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" wire:click="saveRemarks" class="btn btn-primary">
                                                        Save
                                                    </button>
                                                    <button type="button" @click="show = false" class="btn btn-secondary">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Image Preview Modal -->
                            @if($showImageModal)
                                <div x-data="{ show: @entangle('showImageModal') }" x-show="show" x-cloak>
                                    <div class="modal-backdrop fade show"></div>
                                    <div class="modal fade show d-block" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Document Preview</h5>
                                                    <button type="button" class="btn-close" @click="show = false"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ $currentImageUrl }}" class="img-fluid image-modal" alt="Document Preview">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" @click="show = false" class="btn btn-secondary">
                                                        Close
                                                    </button>
                                                </div>
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