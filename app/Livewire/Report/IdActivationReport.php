<?php

namespace App\Livewire\Report;

use Livewire\Component;
use App\Models\User;
use App\Models\BinaryTree;

class IdActivationReport extends Component
{
    public $title = 'ID Activation Report';
    public $startDate;
    public $endDate;
    public $activatedBy = null;
    public $items = [];
    public $admins = [];

    public function mount()
    {
        $excludedRoles = ['Leader'];

        $this->admins = User::whereDoesntHave('roles', function ($query) use ($excludedRoles) {
            $query->whereIn('name', $excludedRoles);
        })->get();

        $this->loadData();
    }

    public function loadData()
    {
        $query = BinaryTree::where('status', 1);

        if ($this->startDate && $this->endDate) {
            $query->whereDate('activated_at', '>=', $this->startDate)
                  ->whereDate('activated_at', '<=', $this->endDate);
        }

        if (!empty($this->activatedBy)) {
            $query->where('join_by', $this->activatedBy);
        }

        $this->items = $query->get();
    }

    public function generateReport()
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $this->loadData();
    }

    public function render()
    {
        return view('livewire.report.id-activation-report', [
            'title' => $this->title,
            'items' => $this->items,
            'admins' => $this->admins,
        ]);
    }
}
