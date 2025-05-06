<?php

namespace App\Livewire\MasterData\RemunerationBenefit;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RemunerationBenefitMaster;

class Index extends Component
{
    use WithPagination;
    public $search = '';

    public function updatingSearch() { $this->resetPage(); }

    public function delete($id)
    {
        RemunerationBenefitMaster::findOrFail($id)->delete();
        session()->flash('success', 'Deleted successfully.');
    }

    public function render()
    {
        $items = RemunerationBenefitMaster::where('rank_name', 'like', "%{$this->search}%")
            ->orderBy('id', 'desc')->paginate(10);

        return view('livewire.master-data.remuneration-benefit.index', compact('items'));
    }
}
