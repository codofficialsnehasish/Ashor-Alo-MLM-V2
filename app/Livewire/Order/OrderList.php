<?php

namespace App\Livewire\Order;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

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

    public function updateOrderStatus($orderId, $newStatus)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->order_status = $newStatus;
            if($newStatus == 'Order Completed'){
                $order->status = 1;
                $order->delivered_date = now();
                $order->delivered_by = Auth::user()->name.'('.get_role(Auth::id()).')';
            }else{
                $order->status = 0;
                $order->delivered_date = null;
                $order->delivered_by = null;
            }
            $order->save();
            session()->flash('message', 'Order status updated successfully.');
        }
    }

    public function delete($id)
    {
        Order::find($id)->delete();
        session()->flash('message', 'Record deleted successfully.');
    }
}