<?php

namespace App\Livewire\WebApp\User;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // you can pass data here if needed
        return view('livewire.web-app.user.dashboard')
               ->layout('livewire.web-app.user.user_dashboard.layout'); // your layout file
    }
}
