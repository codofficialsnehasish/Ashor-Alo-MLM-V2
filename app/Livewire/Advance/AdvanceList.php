<?php

namespace App\Livewire\Advance;

use Livewire\Component;
use App\Models\Advance;
use Illuminate\Support\Facades\Gate;

class AdvanceList extends Component
{
    public $search = '';
    public $statusFilter = 'all';

    protected $listeners = ['loanAdded' => '$refresh'];

    protected function checkPermission($permission)
    {
        if (!Gate::allows($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function render()
    {
        $this->checkPermission('Advance List');

        $loans = Advance::with(['user', 'admin'])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.advance.advance-list', [
            'loans' => $loans
        ]);
    }


    public function delete($id)
    {
        $this->checkPermission('Advance Delete');

        $loan = Advance::findOrFail($id);
        $loan->delete();
        
        // Emit an event to show a success message
        $this->dispatch('show-toast', type: 'success', message: 'Advance deleted successfully');
    }
}
