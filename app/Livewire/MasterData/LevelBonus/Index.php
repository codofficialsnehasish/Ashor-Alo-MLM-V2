<?php

namespace App\Livewire\MasterData\LevelBonus;

use Livewire\Component;
use App\Models\LevelBonusMaster;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected function checkPermission($permission)
    {
        if (!Gate::allows($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function delete($id)
    {
        $this->checkPermission('Delete Level Bonus');
        LevelBonusMaster::findOrFail($id)->delete();
        session()->flash('message', 'Level Bonus deleted successfully.');
    }

    public function render()
    {
        $this->checkPermission('View Level Bonus');
        $levelBonuses = LevelBonusMaster::where('level_name', 'like', '%' . $this->search . '%')
            ->orderBy('level_number')
            ->paginate(10);

        return view('livewire.master-data.level-bonus.index', [
            'levelBonuses' => $levelBonuses
        ]);
    }
}
