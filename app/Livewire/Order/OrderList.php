<?php

namespace App\Livewire\Order;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;

class OrderList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $dateFilter = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'dateFilter' => ['except' => ''],
        'perPage',
        'sortField',
        'sortDirection'
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'dateFilter']);
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.order.order-list', [
            'orders' => Order::query()
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('order_number', 'like', '%'.$this->search.'%')
                          ->orWhereHas('user', function ($q) {
                              $q->where('name', 'like', '%'.$this->search.'%');
                          });
                    });
                })
                ->when($this->statusFilter, function ($query) {
                    $query->where('payment_status', $this->statusFilter);
                })
                ->when($this->dateFilter, function ($query) {
                    $query->whereDate('created_at', $this->dateFilter);
                })
                ->with(['user', 'items'])
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage)
        ]);
    }

    public function delete($id)
    {
        Order::find($id)->delete();
        session()->flash('message', 'Record deleted successfully.');
    }
}