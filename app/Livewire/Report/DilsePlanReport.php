<?php

namespace App\Livewire\Report;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TopUp;
use Excel;
use PDF;
use App\Exports\InvestorReturnReportExport;

class DilsePlanReport extends Component
{
    use WithPagination;

    public $title = 'Dilse Plan Report';
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
        $fileName = 'investor-return-report-' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(
            new InvestorReturnReportExport($data),
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

        $pdf = PDF::loadView('exports.report.sales-report-pdf', $data);
        return $pdf->download('sales-report-' . now()->format('Y-m-d') . '.pdf');
    }

    protected function getQuery()
    {
        return TopUp::query()
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereDate('start_date', '>=', $this->startDate)
                      ->whereDate('start_date', '<=', $this->endDate);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->Where('total_amount', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function ($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      })
                      ->orWhereHas('binaryNode', function ($q) {
                          $q->where('member_number', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->whereNull('add_on_against_order_id')
            ->where('is_provide_roi',1)
            ->where('is_provide_level',0)
            ->where('is_provide_direct',0)
            ->orderBy($this->sortField, $this->sortDirection)
            ->with('user'); // Assuming TopUp has a user relationship
    }

    public function render()
    {
        return view('livewire.report.dilse-plan-report',[
            'title' => $this->title,
            'items' => $this->getQuery()->paginate($this->perPage),
        ]);
    }
}
