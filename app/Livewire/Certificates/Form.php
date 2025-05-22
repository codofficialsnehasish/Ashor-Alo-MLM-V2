<?php

namespace App\Livewire\Certificates;

use App\Models\Certificate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Form extends Component
{
    use WithFileUploads;

    public $certificate;
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

    public function mount($certificate = null)
    {
        $this->certificate = $certificate ? Certificate::findOrFail($certificate) : new Certificate();

        if ($this->certificate->exists) {
            $this->fill([
                'title' => $this->certificate->title,
                'description' => $this->certificate->description,
                'is_active' => $this->certificate->is_active,
                'existingImage' => $this->certificate->getFirstMediaUrl('certificate_images')
            ]);
        }
    }

    public function save()
    {
        $this->validate();

        $this->certificate->fill([
            'title' => $this->title,
            'description' => $this->description,
            'is_active' => $this->is_active ?? false,
        ])->save();

        // Handle new image uploads
        if ($this->uploadedImage) {  // Note the singular property name
            // First clear any existing images
            $this->certificate->clearMediaCollection('certificate_images');
            
            // Add the new single image
            $this->certificate->addMedia($this->uploadedImage->getRealPath())
                ->usingName($this->uploadedImage->getClientOriginalName())
                ->toMediaCollection('certificate_images');
        }

        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'Certificate saved successfully.'
        ]));
    }

    public function render()
    {
        return view('livewire.certificates.form');
    }
}
