<?php

namespace App\Livewire\MasterData\RemunerationBenefit;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RemunerationBenefitMaster;
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

    public function updatingSearch() { $this->resetPage(); }

    public function delete($id)
    {
        $this->checkPermission('Delete Remuneration Benefit');

        RemunerationBenefitMaster::findOrFail($id)->delete();
        session()->flash('success', 'Deleted successfully.');
    }

    public function render()
    {
        $this->checkPermission('View Remuneration Benefit');

        $items = RemunerationBenefitMaster::where('rank_name', 'like', "%{$this->search}%")
            ->orderBy('id', 'desc')->paginate(10);

        return view('livewire.master-data.remuneration-benefit.index', compact('items'));
    }
}
