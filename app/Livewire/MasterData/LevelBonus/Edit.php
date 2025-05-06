<?php

namespace App\Livewire\MasterData\LevelBonus;

use Livewire\Component;
use App\Models\LevelBonusMaster;

class Edit extends Component
{
    public $levelBonus;
    public $level_name, $level_number, $level_percentage, $is_visible;

    public function mount($id)
    {
        $this->levelBonus = LevelBonusMaster::findOrFail($id);
        $this->level_name = $this->levelBonus->level_name;
        $this->level_number = $this->levelBonus->level_number;
        $this->level_percentage = $this->levelBonus->level_percentage;
        $this->is_visible = (bool) $this->levelBonus->is_visible;
    }

    public function update()
    {
        $this->validate([
            'level_name' => 'nullable|string',
            'level_number' => 'required|integer',
            'level_percentage' => 'required|numeric|min:0|max:100',
            'is_visible' => 'boolean',
        ]);

        $this->levelBonus->update([
            'level_name' => $this->level_name,
            'level_number' => $this->level_number,
            'level_percentage' => $this->level_percentage,
            'is_visible' => $this->is_visible,
        ]);

        session()->flash('message', 'Level Bonus updated successfully.');
        return redirect()->route('level-bonus.index');
    }

    public function render()
    {
        return view('livewire.master-data.level-bonus.edit');
    }
}
