<section class="w-full">
    {{-- @include('partials.settings-heading') --}}

    <x-settings.layout :heading="__('Profile')" :title="__('Settings')">
        <div class="card-body" style="padding: 22px;">
            <h4>Update your name and email address</h4>
            <form wire:submit.prevent="updateProfileInformation" class="row g-4">

                <!-- Name -->
                <div class="col-md-6">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input type="text" id="name" wire:model="name" class="form-control" required autofocus autocomplete="name">
                    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="email" id="email" wire:model="email" class="form-control" required autocomplete="email">
                    @error('email') <div class="text-danger small">{{ $message }}</div> @enderror

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                        <div class="mt-2">
                            <small class="text-warning">{{ __('Your email address is unverified.') }}</small>
                            <br>
                            <a href="#" class="text-primary text-decoration-underline" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </a>

                            @if (session('status') === 'verification-link-sent')
                                <div class="text-success mt-1 small">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div>
                        {{-- <button type="submit" class="btn btn-primary px-4 m-5 " style="margin: 9px;">
                            <i class="bi bi-save me-2"></i>{{ __('Save') }}
                        </button> --}}

                        <button type="submit" class="btn btn-primary px-4 m-5 " style="margin: 9px;">
                            <span wire:loading wire:target="updateProfileInformation">
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span> Loading...
                            </span>
                            <span wire:loading.remove wire:target="updateProfileInformation">
                                Save 
                            </span>
                        </button>

                    </div>

                    {{-- <x-action-message on="profile-updated" class="text-success fw-semibold">
                        {{ __('Saved.') }}
                    </x-action-message> --}}
                </div>
            </form>
        </div>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
