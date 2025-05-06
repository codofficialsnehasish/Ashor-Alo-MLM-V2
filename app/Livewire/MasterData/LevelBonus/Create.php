<?php

namespace App\Livewire\MasterData\LevelBonus;

use Livewire\Component;
use App\Models\LevelBonusMaster;

class Create extends Component
{
    public $level_name, $level_number, $level_percentage, $is_visible;

    public function save()
    {
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
        return view('livewire.master-data.level-bonus.create');
    }
}
