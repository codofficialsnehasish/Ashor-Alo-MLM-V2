<?php

namespace App\Livewire\MasterData\LevelBonus;

use Livewire\Component;
use App\Models\LevelBonusMaster;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function delete($id)
    {
        LevelBonusMaster::findOrFail($id)->delete();
        session()->flash('message', 'Level Bonus deleted successfully.');
    }

    public function render()
    {
        $levelBonuses = LevelBonusMaster::where('level_name', 'like', '%' . $this->search . '%')
            ->orderBy('level_number')
            ->paginate(10);

        return view('livewire.master-data.level-bonus.index', [
            'levelBonuses' => $levelBonuses
        ]);
    }
}
