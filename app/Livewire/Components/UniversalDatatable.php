<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\GenericExport;

class UniversalDatatable extends Component
{
    use WithPagination;

    public $model; // Pass model class from Blade
    public $search = '';
    public $perPage = 10;
    public $columns = [];

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function exportExcel()
    {
        return Excel::download(new GenericExport($this->model, $this->search, $this->columns), 'data.xlsx');
    }

    public function exportPdf()
    {
        $data = $this->model::query()
            ->when($this->search, function ($q) {
                foreach ($this->columns as $col) {
                    $q->orWhere($col, 'like', '%' . $this->search . '%');
                }
            })
            ->get();

        $pdf = Pdf::loadView('exports.pdf', ['data' => $data]);
        return response()->streamDownload(fn () => print($pdf->output()), 'data.pdf');
    }


    public function render()
    {
        $records = $this->model::query()
            ->when($this->search, function ($q) {
                foreach ($this->columns as $col) {
                    $q->orWhere($col, 'like', '%' . $this->search . '%');
                }
            })
            ->paginate($this->perPage);

        return view('livewire.components.universal-datatable', [
            'records' => $records,
        ]);
    }
}

