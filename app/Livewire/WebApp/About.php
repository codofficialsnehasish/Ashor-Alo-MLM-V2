<?php

namespace App\Livewire\WebApp;

use Livewire\Component;
use App\Models\WebsiteSetting;

class About extends Component
{
    public function render()
    {
        return view('livewire.web-app.about',[
            'setting' => WebsiteSetting::first(),
        ])->layout('livewire.web-app.layout');
    }
}
