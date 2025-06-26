<?php

namespace App\Livewire\WebApp;

use Livewire\Component;

use App\Models\Product;

class Products extends Component
{
    public function render()
    {
        return view('livewire.web-app.products',[
            'products' => Product::where('is_visible',1)->latest()->take(8)->get(),
        ])->layout('livewire.web-app.layout');
    }
}
