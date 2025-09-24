<div class="d-flex align-items-center justify-content-center py-5 bg-light">
    <div class="card shadow-lg border-0" style="max-width: 420px; width: 100%;">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h1 class="h3 fw-bold mb-1">User Login</h1>
                <p class="text-muted small">Sign in to access your dashboard</p>
            </div>

            <form wire:submit.prevent="login">
                {{-- User ID --}}
                <div class="mb-3">
                    <label class="form-label">Enter Your ID</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                        <input type="text" wire:model="member_number" class="form-control @error('member_number') is-invalid @enderror" placeholder="Enter Your ID">
                        @error('member_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                        <input type="password" wire:model="password" class="form-control" placeholder="Enter your password">
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </button>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('password.request') }}" class="text-decoration-none small">Forgot Password?</a>
                    <a href="{{ route('user.register') }}" class="text-decoration-none small">Create Account</a>
                </div>
            </form>
        </div>
    </div>
</div>
