<?php

namespace App\Livewire\Report;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TopUp;
use Excel;
use PDF;
use App\Exports\SalesReportExport;

class SalesReport extends Component
{
    use WithPagination;

    public $title = 'Sales Report';
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
        // Optionally set default dates (e.g., current month)
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
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

    // public function exportExcel()
    // {
    //     $data = $this->getQuery()->get();
    //     $fileName = 'sales-report-' . now()->format('Y-m-d') . '.xlsx';

    //     return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection {
    //         protected $data;

    //         public function __construct($data)
    //         {
    //             $this->data = $data;
    //         }

    //         public function collection()
    //         {
    //             return $this->data;
    //         }
    //     }, $fileName);
    // }

    public function exportExcel()
    {
        $data = $this->getQuery()->get();
        $fileName = 'sales-report-' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(
            new SalesReportExport($data),
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
                      ->orWhereHas('order', function ($q) {
                          $q->where('payment_method', 'like', '%' . $this->search . '%');
                          $q->where('placed_by', 'like', '%' . $this->search . '%');
                      })
                      ->orWhereHas('order.category', function ($q) {
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
        return view('livewire.report.sales-report', [
            'title' => $this->title,
            'items' => $this->getQuery()->paginate($this->perPage),
        ]);
    }
}
