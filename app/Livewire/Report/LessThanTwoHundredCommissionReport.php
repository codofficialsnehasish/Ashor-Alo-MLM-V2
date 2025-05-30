<?php

namespace App\Livewire\Report;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payout;
use Excel;
use PDF;
use App\Exports\SalesReportExport;

class LessThanTwoHundredCommissionReport extends Component
{
    use WithPagination;

    public $title = 'Commission Report of < 200';
    public $startDate;
    public $endDate;
    public $status;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'search' => ['except' => ''],
        'status' => ['except' => '-1'],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount()
    {
        // Optionally set default dates (e.g., current month)
        // $this->startDate = now()->startOfMonth()->format('Y-m-d');
        // $this->endDate = now()->endOfMonth()->format('Y-m-d');
        $this->status = '-1';
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
        $lastDates = Payout::select('start_date', 'end_date')
                            ->orderBy('end_date', 'desc')
                            ->first();

        if ($lastDates) {
            return Payout::where('start_date', $lastDates->start_date)
                ->where('end_date', $lastDates->end_date)
                ->where('hold_wallet', '!=', '0.00')
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->where('total_payout', 'like', '%' . $this->search . '%')
                            ->orWhereHas('user', function ($q) {
                                $q->where('name', 'like', '%' . $this->search . '%');
                            })
                            ->orWhereHas('user.binaryNode', function ($q) {
                                $q->where('member_number', 'like', '%' . $this->search . '%');
                            });
                    });
                });
        } else {
            return collect();
        }
    }

    public function render()
    {
        return view('livewire.report.less-than-two-hundred-commission-report', [
            'title' => $this->title,
            'items' => $this->getQuery()->paginate($this->perPage),
        ]);
    }
}
