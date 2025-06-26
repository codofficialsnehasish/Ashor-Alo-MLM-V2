<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\WebsiteSetting;
use Livewire\WithFileUploads;

class AboutUs extends Component
{
    use WithFileUploads;

    public $about_us;
    public $about_us_title;
    public $uploadedImage = null;
    public $existingImage = null;

    protected $rules = [
        'about_us_title' => 'required|string',
        'about_us' => 'required|string',
        'uploadedImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
    ];

    public function mount()
    {
        $settings = WebsiteSetting::first();
        $this->about_us_title = $settings->about_us_title ?? '';
        $this->about_us = $settings->about_us ?? '';
        if($settings){
            $this->existingImage = $settings->getFirstMediaUrl('about-image') ?? null;
        }
    }

    public function save()
    {
        $this->validate();

        $settings = WebsiteSetting::firstOrCreate([]);
        $settings->update([
            'about_us_title' => $this->about_us_title,
            'about_us' => $this->about_us
        ]);

        if ($this->uploadedImage) {  // Note the singular property name
            // First clear any existing images
            $settings->clearMediaCollection('about-image');
            
            // Add the new single image
            $settings->addMedia($this->uploadedImage->getRealPath())
                ->usingName($this->uploadedImage->getClientOriginalName())
                ->toMediaCollection('about-image');
            $this->uploadedImage = null;
            $this->existingImage = $settings->getFirstMediaUrl('about-image');
        }

        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'About Us updated successfully!'
        ]));
    }

    public function render()
    {
        return view('livewire.settings.about-us');
    }
}
