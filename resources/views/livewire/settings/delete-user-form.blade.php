<section class="mt-5">
    <div class="mb-4">
        <h4 class="fw-bold">{{ __('Delete Account') }}</h4>
        <p class="text-muted">{{ __('Delete your account and all of its resources.') }}</p>
    </div>

    <!-- Trigger Button -->
    <button type="button" class="btn btn-danger" wire:click="openDeleteModal">
        {{ __('Delete Account') }}
    </button>

    <!-- Modal -->
    @if($showDeleteModal)
    <div class="modal show d-block" id="confirmDeleteModal" data-bs-backdrop="static" role="dialog" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="background: rgba(0, 0, 0, .6);">
        <div class="modal-dialog modal-dialog-centered">
            <form wire:submit.prevent="deleteUser" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="confirmDeleteModalLabel">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Close') }}"></button>
                </div>

                <div class="modal-body">
                    <p>
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
                        {{ __('Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input type="password" wire:model.defer="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeDeleteModal">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" class="btn btn-danger">
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</section>
