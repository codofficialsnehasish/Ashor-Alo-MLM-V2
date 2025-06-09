<?php

namespace App\Livewire\Advance;

use Livewire\Component;
use App\Models\Advance;
use App\Models\AdvanceTransaction;

use Illuminate\Support\Facades\Gate;

class AdvanceList extends Component
{
    public $search = '';
    public $statusFilter = 'all';

    public $expandedLoanId = null; // Track which loan is expanded
    public $transactionSearch = '';
    public $transactionTypeFilter = 'all';
    public $transactionDateFilter = '';

    protected $listeners = ['loanAdded' => '$refresh', 'transactionUpdated' => '$refresh'];

    protected function checkPermission($permission)
    {
        if (!Gate::allows($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function toggleTransactions($loanId)
    {
        if ($this->expandedLoanId === $loanId) {
            $this->expandedLoanId = null;
        } else {
            $this->expandedLoanId = $loanId;
        }
    }

    public function render()
    {
        $this->checkPermission('Advance List');

        $loans = Advance::with(['user', 'admin'])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('member_number', 'like', '%'.$this->search.'%');
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

    public function getTransactionsProperty()
    {
        if (!$this->expandedLoanId) return collect();

        return AdvanceTransaction::where('advance_id', $this->expandedLoanId)
            ->when($this->transactionSearch, function ($query) {
                $query->where('description', 'like', '%'.$this->transactionSearch.'%');
            })
            ->when($this->transactionTypeFilter !== 'all', function ($query) {
                $query->where('type', $this->transactionTypeFilter);
            })
            ->when($this->transactionDateFilter, function ($query) {
                $query->whereDate('created_at', $this->transactionDateFilter);
            })
            ->latest()
            ->get();
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
