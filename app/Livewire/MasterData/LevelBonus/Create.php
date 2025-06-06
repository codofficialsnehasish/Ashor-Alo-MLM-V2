<?php

namespace App\Livewire\MasterData\LevelBonus;

use Livewire\Component;
use App\Models\LevelBonusMaster;
use Illuminate\Support\Facades\Gate;

class Create extends Component
{
    public $level_name, $level_number, $level_percentage, $is_visible;

    protected function checkPermission($permission)
    {
        if (!Gate::allows($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function save()
    {
        $this->checkPermission('Create Level Bonus');
        $this->validate([
            'level_name' => 'nullable|string',
            'level_number' => 'required|integer',
            'level_percentage' => 'required|numeric|min:0|max:100',
            'is_visible' => 'boolean',
        ]);

        LevelBonusMaster::create([
            'level_name' => $this->level_name,
            'level_number' => $this->level_number,
            'level_percentage' => $this->level_percentage,
            'is_visible' => $this->is_visible,
        ]);

        session()->flash('message', 'Level Bonus created successfully.');
        return redirect()->route('level-bonus.index');
    }

    public function render()
    {
        $this->checkPermission('Create Level Bonus');
        return view('livewire.master-data.level-bonus.create');
    }
}
