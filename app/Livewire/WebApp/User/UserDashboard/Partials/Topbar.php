<?php

namespace App\Livewire\WebApp\User\UserDashboard\Partials;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Topbar extends Component
{
    public function logout()
    {
        Auth::guard('user')->logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('user.login'); // adjust route if needed
    }
    
    public function render()
    {
        return view('livewire.web-app.user.user-dashboard.partials.topbar');
    }
}
