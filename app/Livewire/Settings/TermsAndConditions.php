<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\WebsiteSetting;

class TermsAndConditions extends Component
{
    public $terms_and_conditions;

    protected $rules = [
        'terms_and_conditions' => 'required|string',
    ];

    public function mount()
    {
        $settings = WebsiteSetting::first();
        $this->terms_and_conditions = $settings->terms_and_conditions ?? '';
    }

    public function save()
    {
        $this->validate();

        $settings = WebsiteSetting::firstOrCreate([]);
        $settings->update([
            'terms_and_conditions' => $this->terms_and_conditions
        ]);

        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'Terms & Conditions updated successfully!'
        ]));
    }

    public function render()
    {
        return view('livewire.settings.terms-and-conditions');
    }
}
