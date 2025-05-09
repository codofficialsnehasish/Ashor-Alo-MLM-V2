<?php

namespace App\Livewire\KYC;

use Livewire\Component;
use App\Models\Kyc;

class KycActivityLog extends Component
{
    public $kycId;
    public $kyc;
    public $userName;

    public function mount($kycId)
    {
        $this->kycId = $kycId;
        $this->loadData();
    }

    public function loadData()
    {
        $this->kyc = Kyc::with(['activities.causer', 'user'])
            ->find($this->kycId);
        
        if ($this->kyc) {
            $this->userName = $this->kyc->user->name ?? 'Unknown';
        }
    }

    public function render()
    {
        return view('livewire.k-y-c.kyc-activity-log', [
            'activities' => $this->kyc ? $this->kyc->activities()->latest()->get() : collect(),
        ]);
    }
}