<?php

namespace App\Livewire\Report;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SalaryBonus;
use Excel;
use PDF;
use App\Exports\RemunerationReportExport;

class RemunerationReport extends Component
{
    use WithPagination;

    public $title = 'Investor Return Report';
    public $startDate;
    public $endDate;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'start_date';
    public $sortDirection = 'desc';

    protected $queryString = [
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'start_date'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount()
    {
        // $this->startDate = now()->startOfMonth()->format('Y-m-d');
        // $this->endDate = now()->endOfMonth()->format('Y-m-d');
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function exportExcel()
    {
        $data = $this->getQuery()->get();
        $fileName = 'remuneration-report-' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(
            new RemunerationReportExport($data),
            $fileName
        );
    }

    public function exportPDF()
    {
        $data = [
            'title' => $this->title,
            'items' => $this->getQuery()->get(),
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ];

        $pdf = PDF::loadView('exports.report.remuneration-report-pdf', $data);
        return response()->streamDownload(
            fn () => print($pdf->output()),
            "remuneration-report-".now()->format('Y-m-d').".pdf"
        );
    }

    protected function getQuery()
    {
        return SalaryBonus::query()
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereDate('start_date', '>=', $this->startDate)
                      ->whereDate('start_date', '<=', $this->endDate);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->Where('amount', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function ($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      })
                      ->orWhereHas('binaryNode', function ($q) {
                          $q->where('member_number', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->with('user'); // Assuming TopUp has a user relationship
    }

    public function render()
    {
        return view('livewire.report.remuneration-report',[
            'title' => $this->title,
            'items' => $this->getQuery()->paginate($this->perPage),
        ]);
    }
}
