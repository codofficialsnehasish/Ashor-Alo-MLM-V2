<?php

namespace App\Livewire\KYC;

use Livewire\Component;
use App\Models\Kyc;
use App\Models\User;

class KycList extends Component
{
    public $kycs;
    public $selectedKycId = null;
    public $statusFilter;

    public function mount()
    {
        // Extract status from URL (e.g., "/kyc/pending" → "pending")
        $path = request()->path(); // "kyc/pending"
        $segments = explode('/', $path); // ["kyc", "pending"]
        $this->statusFilter = end($segments) ?: 'all'; // Default to 'all'

        // Ensure only valid statuses are allowed
        if (!in_array($this->statusFilter, ['all', 'pending', 'completed', 'cancelled'])) {
            $this->statusFilter = 'all';
        }

        $this->loadKycs();
    }

    public function loadKycs()
    {
        $query = Kyc::with('user')->latest();
        
        switch($this->statusFilter) {
            case 'pending':
                $query->where('status', 0);
                break;
            case 'completed':
                $query->where('status', 1);
                break;
            case 'cancelled':
                $query->where('status', 2);
                break;
            // 'all' case doesn't need filtering
        }
        
        $this->kycs = $query->get();
    }

    public function updatedStatusFilter($value)
    {
        $this->loadKycs();
    }

    public function showDetails($id)
    {
        $this->selectedKycId = $id;
    }

    public function closeDetails()
    {
        $this->selectedKycId = null;
    }

    public function render()
    {
        $selectedKyc = $this->selectedKycId ? Kyc::find($this->selectedKycId) : null;
        return view('livewire.k-y-c.kyc-list', [
            'selectedKyc' => $selectedKyc,
            'statusFilter' => $this->statusFilter,
        ]);
    }
}