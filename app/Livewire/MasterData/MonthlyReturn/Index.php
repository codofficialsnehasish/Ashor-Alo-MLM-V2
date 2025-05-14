<?php

namespace App\Livewire\MasterData\MonthlyReturn;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\MonthlyReturnMaster;
use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonthlyReturnMastersExport;
use PDF;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = true;
    public $selectedRows = [];
    public $selectAll = false;

    public function render()
    {
        $returns = MonthlyReturnMaster::with(['category', 'product'])
            ->when($this->search, function($query) {
                return $query->where(function($q) {
                    $q->where('form_amount', 'like', '%'.$this->search.'%')
                      ->orWhere('to_amount', 'like', '%'.$this->search.'%')
                      ->orWhere('percentage', 'like', '%'.$this->search.'%')
                      ->orWhere('return_persentage', 'like', '%'.$this->search.'%')
                      ->orWhereHas('category', function($q) {
                          $q->where('name', 'like', '%'.$this->search.'%');
                      })
                      ->orWhereHas('product', function($q) {
                          $q->where('title', 'like', '%'.$this->search.'%');
                      });
                });
            })
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.master-data.monthly-return.index', [
            'returns' => $returns
        ]);
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedRows = MonthlyReturnMaster::pluck('id')->toArray();
        } else {
            $this->selectedRows = [];
        }
    }

    public function exportExcel()
    {
        return Excel::download(new MonthlyReturnMastersExport($this->selectedRows), 'monthly-return-masters.xlsx');
    }

    public function exportPDF()
    {
        $data = MonthlyReturnMaster::with(['category', 'product'])
            ->whereIn('id', $this->selectedRows)
            ->get();

        $pdf = PDF::loadView('exports.monthly-return-masters-pdf', [
            'returns' => $data
        ]);

        return $pdf->download('monthly-return-masters.pdf');
    }

    public function deleteSelected()
    {
        MonthlyReturnMaster::whereIn('id', $this->selectedRows)->delete();
        $this->selectedRows = [];
        $this->selectAll = false;
        session()->flash('message', 'Selected records deleted successfully.');
    }

    public function delete($id)
    {
        MonthlyReturnMaster::find($id)->delete();
        session()->flash('message', 'Record deleted successfully.');
    }
}
