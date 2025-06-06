<?php

namespace App\Livewire\Report;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use Excel;
use PDF;
use App\Exports\ProductDeliveryReportExport;
use Illuminate\Support\Facades\Gate;

class ProductDeliveryReport extends Component
{
    use WithPagination;

    public $title = 'Product Delivery Report';
    public $startDate;
    public $endDate;
    public $status;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected function checkPermission($permission)
    {
        if (!Gate::allows($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }

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
        $fileName = 'product-delivery-report-' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(
            new ProductDeliveryReportExport($data),
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

        $pdf = PDF::loadView('exports.report.product-delivery-report-pdf', $data);
        return response()->streamDownload(
            fn () => print($pdf->output()),
            'product-delivery-report-'.now()->format('Y-m-d').'.pdf'
        );
    }

    protected function getQuery()
    {
        return Order::query()
                    ->when($this->startDate && $this->endDate, function ($query) {
                        $query->whereDate('created_at', '>=', $this->startDate)
                            ->whereDate('created_at', '<=', $this->endDate);
                    })
                    ->when($this->search, function ($query) {
                        $query->where(function ($q) {
                            $q->where('price_total', 'like', '%' . $this->search . '%')
                            ->orWhere('payment_method', 'like', '%' . $this->search . '%')
                            ->orWhere('order_number', 'like', '%' . $this->search . '%')
                            ->orWhere('placed_by', 'like', '%' . $this->search . '%')
                            ->orWhereHas('user', function ($q) {
                                $q->where('name', 'like', '%' . $this->search . '%');
                            })
                            ->orWhereHas('category', function ($q) {
                                $q->where('name', 'like', '%' . $this->search . '%');
                            })
                            ->orWhereHas('user.binaryNode', function ($q) {
                                $q->where('member_number', 'like', '%' . $this->search . '%');
                            });
                        });
                    })
                    ->when($this->status !== null && $this->status != '-1', function ($query) {
                        $query->where('status', $this->status); // Adjust column name if different
                    })
                    ->orderBy($this->sortField, $this->sortDirection)
                    ->with('user');

    }

    public function render()
    {
        $this->checkPermission('Product Delivery Report');
        return view('livewire.report.product-delivery-report', [
            'title' => $this->title,
            'items' => $this->getQuery()->paginate($this->perPage),
        ]);
    }
}
