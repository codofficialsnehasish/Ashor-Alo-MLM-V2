<?php

namespace App\Livewire\WebApp;

use Livewire\Component;
use App\Models\Notice;

class Header extends Component
{
    public function render()
    {
        return view('livewire.web-app.header',[
            'notices' => Notice::where('start_date', '<=', date('Y-m-d'))
                      ->where('end_date', '>=', date('Y-m-d'))
                      ->orderBy('start_date', 'desc')
                      ->get(),
        ]);
    }
}
