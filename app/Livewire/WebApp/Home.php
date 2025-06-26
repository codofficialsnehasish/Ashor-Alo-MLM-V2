<?php

namespace App\Livewire\WebApp;

use Livewire\Component;

use App\Models\Category;
use App\Models\Product;
use App\Models\BannerSlider;
use App\Models\OfferSlider;
use App\Models\WebsiteSetting;
use App\Models\Notice;

class Home extends Component
{
    public function render()
    {
        return view('livewire.web-app.home',[
            'categories' => Category::where('is_visible',1)->get(),
            'products' => Product::where('is_visible',1)->latest()->take(8)->get(),
            'sliders' => BannerSlider::where('is_active', true)->get(),
            'offer_sliders' => OfferSlider::where('is_active', true)->get(),
            'setting' => WebsiteSetting::first(),
            'notices' => Notice::where('start_date', '<=', date('Y-m-d'))
                      ->where('end_date', '>=', date('Y-m-d'))
                      ->orderBy('start_date', 'desc')
                      ->get(),
        ])->layout('livewire.web-app.layout');
    }
}
