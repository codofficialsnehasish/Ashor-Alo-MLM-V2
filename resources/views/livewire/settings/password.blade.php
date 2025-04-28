<section class="w-full">
    {{-- @include('partials.settings-heading') --}}

    <x-settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
        <form wire:submit="updatePassword" class="mt-4">
            <div class="mb-3">
                <label for="current_password" class="form-label">{{ __('Current password') }}</label>
                <input
                    wire:model="current_password"
                    type="password"
                    id="current_password"
                    class="form-control"
                    required
                    autocomplete="current-password"
                >
            </div>
        
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('New password') }}</label>
                <input
                    wire:model="password"
                    type="password"
                    id="password"
                    class="form-control"
                    required
                    autocomplete="new-password"
                >
            </div>
        
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <input
                    wire:model="password_confirmation"
                    type="password"
                    id="password_confirmation"
                    class="form-control"
                    required
                    autocomplete="new-password"
                >
            </div>
        
            <div class="d-flex justify-content-between align-items-center mt-4" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary w-100">
                    {{ __('Save') }}
                </button>
        
                {{-- <div wire:loading.remove wire:target="updatePassword" class="ms-3 text-success">
                    <span wire:transition.fade wire:loading.class="d-none" wire:poll.750ms>
                        <span wire:target="updatePassword" wire:loading.remove>
                            {{ __('Saved.') }}
                        </span>
                    </span>
                </div> --}}
            </div>
        </form>
        
    </x-settings.layout>
</section>
