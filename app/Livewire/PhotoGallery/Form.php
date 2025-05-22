<?php

namespace App\Livewire\PhotoGallery;

use App\Models\PhotoGallary;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Form extends Component
{
    use WithFileUploads;

    public $gallery;
    public $title;
    public $description;
    public $is_active = true;
    public $uploadedImage = null;
    public $existingImage = null;
    public $imagesToDelete = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        // 'is_active' => 'boolean',
        'uploadedImage' => 'nullable|image|max:10240', // 10MB max
    ];

    public function mount($gallery = null)
    {
        $this->gallery = $gallery ? PhotoGallary::findOrFail($gallery) : new PhotoGallary();
        
        if ($this->gallery->exists) {
            $this->fill([
                'title' => $this->gallery->title,
                'description' => $this->gallery->description,
                'is_active' => $this->gallery->is_active,
                'existingImage' => $this->gallery->getFirstMediaUrl('gallery_images')
            ]);
        }
    }

    public function save()
    {
        $this->validate();

        $this->gallery->fill([
            'title' => $this->title,
            'description' => $this->description,
            'is_active' => $this->is_active ?? false,
        ])->save();

        // Handle new image uploads
        if ($this->uploadedImage) {  // Note the singular property name
            // First clear any existing images
            $this->gallery->clearMediaCollection('gallery_images');
            
            // Add the new single image
            $this->gallery->addMedia($this->uploadedImage->getRealPath())
                ->usingName($this->uploadedImage->getClientOriginalName())
                ->toMediaCollection('gallery_images');
        }

        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'Gallery saved successfully.'
        ]));
    }

    public function render()
    {
        return view('livewire.photo-gallery.form');
    }
}
