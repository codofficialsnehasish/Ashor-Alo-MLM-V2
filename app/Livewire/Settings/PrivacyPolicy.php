<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\WebsiteSetting;

class PrivacyPolicy extends Component
{
    public $privacy_policy;

    protected $rules = [
        'privacy_policy' => 'required|string',
    ];

    public function mount()
    {
        $settings = WebsiteSetting::first();
        $this->privacy_policy = $settings->privacy_policy ?? '';
    }

    public function save()
    {
        $this->validate();

        $settings = WebsiteSetting::firstOrCreate([]);
        $settings->update([
            'privacy_policy' => $this->privacy_policy
        ]);

        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'Privacy Policy updated successfully!'
        ]));
    }

    public function render()
    {
        return view('livewire.settings.privacy-policy');
    }
}
