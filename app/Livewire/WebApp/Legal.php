<?php

namespace App\Livewire\WebApp;

use Livewire\Component;

use App\Models\Certificate;

class Legal extends Component
{
    public function render()
    {
        return view('livewire.web-app.legal',[
            'certificates' => Certificate::where('is_active',1)->get(),
        ])->layout('livewire.web-app.layout');
    }
}
