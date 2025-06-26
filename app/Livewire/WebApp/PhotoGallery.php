<?php

namespace App\Livewire\WebApp;

use Livewire\Component;

use App\Models\PhotoGallary;

class PhotoGallery extends Component
{
    public function render()
    {
        return view('livewire.web-app.photo-gallery',[
            'photo_gallarys' => PhotoGallary::where('is_active',1)->get(),
        ])->layout('livewire.web-app.layout');
    }
}
