<?php

namespace App\Livewire\Report;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payout;
use Excel;
use PDF;
use App\Exports\SalesReportExport;

class PaidUnpaidPaymentReport extends Component
{
    use WithPagination;

    public $title = 'Paid Unpaid Payment Report';
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
        return Payout::query()
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereDate('start_date', '>=', $this->startDate)
                    ->whereDate('end_date', '<=', $this->endDate);
            })
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
            })
            ->when($this->status !== null && $this->status != '-1', function ($query) {
                $query->where('paid_unpaid', $this->status); // Adjust column name if different
            })
            ->where('total_payout', '>', 0)
            ->whereHas('user', function ($query) {
                $query->where('is_block', 0)
                ->whereHas('kyc', function ($kycQuery) {
                    $kycQuery->where('status', 1);
                });
            });

    }

    public function render()
    {
        return view('livewire.report.paid-unpaid-payment-report', [
            'title' => $this->title,
            'items' => $this->getQuery()->paginate($this->perPage),
        ]);
    }
}
