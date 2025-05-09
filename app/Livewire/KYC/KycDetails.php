<?php

namespace App\Livewire\KYC;

use Livewire\Component;
use App\Models\Kyc;
use App\Models\User;
use Livewire\Attributes\On; // Add this import

class KycDetails extends Component
{
    public $kyc;
    public $user;
    public $statusFields = [];
    public $remarksFields = [];
    public $selectedProof;
    public $showModal = false;
    public $modalRemarks = '';
    public $showImageModal = false; // Add this for image preview
    public $currentImageUrl = ''; // Add this for image preview

    protected $rules = [
        'statusFields.*' => 'required|in:0,1,2',
        'remarksFields.*' => 'nullable|string|max:255',
        'modalRemarks' => 'required_if:showModal,true|string|max:255'
    ];

    public function mount(Kyc $kyc)
    {
        $this->kyc = $kyc;
        $this->user = $kyc->user;

        foreach (['identity_proof', 'address_proof', 'bank_proof', 'pan_proof'] as $collection) {
            $media = $kyc->getFirstMedia($collection);
            $this->statusFields[$collection] = $media?->getCustomProperty('status') ?? 0;
            $this->remarksFields[$collection] = $media?->getCustomProperty('remarks') ?? '';
        }
    }

    public function updatedStatusFields($value, $key)
    {
        $this->validateOnly("statusFields.$key");
        
        if ($value == 2) { // Cancelled
            $this->selectedProof = $key;
            $this->showModal = true;
        } else {
            $this->saveStatus($key, $value);
        }
    }

    public function saveRemarks()
    {
        $this->validateOnly('modalRemarks');
        
        $this->remarksFields[$this->selectedProof] = $this->modalRemarks;
        $this->saveStatus($this->selectedProof, $this->statusFields[$this->selectedProof]);
        $this->reset(['modalRemarks', 'showModal', 'selectedProof']);
    }

    protected function saveStatus($field, $value)
    {
        $media = $this->kyc->getFirstMedia($field);
        if ($media) {
            $media->setCustomProperty('status', $value);
            $media->setCustomProperty('remarks', $this->remarksFields[$field] ?? '');
            $media->save();
        }
        
        // Also update the KYC model if needed
        $this->kyc->{$field.'_status'} = $value;
        $this->kyc->save();
        
        $this->dispatch('status-updated');
    }

    // Add these methods for image preview
    #[On('openImage')]
    public function showImage($url)
    {
        $this->currentImageUrl = $url;
        $this->showImageModal = true;
    }

    public function closeImage()
    {
        $this->showImageModal = false;
        $this->currentImageUrl = '';
    }

    public function render()
    {
        return view('livewire.k-y-c.kyc-details');
    }
}