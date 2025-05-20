<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\MlmSetting;

class MlmSettings extends Component
{
    public $minimum_purchase_amount, $agent_direct_bonus, $tds, $repurchase, $service_charge, $add_on_percentage;

    public function mount()
    {
        $settings = MlmSetting::first();

        if ($settings) {
            $this->fill($settings->toArray());
        }
    }

    public function save()
    {
        $this->validate([
            'minimum_purchase_amount' => 'required|numeric|min:0',
            'agent_direct_bonus' => 'required|numeric|min:0|max:100',
            'tds' => 'required|numeric|min:0|max:100',
            'repurchase' => 'required|numeric|min:0|max:100',
            'service_charge' => 'required|numeric|min:0|max:100',
            'add_on_percentage' => 'required|numeric|min:0|max:100',
        ]);

        MlmSetting::updateOrCreate(['id' => 1], [
            'minimum_purchase_amount' => $this->minimum_purchase_amount,
            'agent_direct_bonus' => $this->agent_direct_bonus,
            'tds' => $this->tds,
            'repurchase' => $this->repurchase,
            'service_charge' => $this->service_charge,
            'add_on_percentage' => $this->add_on_percentage,
        ]);

        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'Settings saved successfully!'
        ]));
    }

    public function render()
    {
        return view('livewire.settings.mlm-settings');
    }
}
