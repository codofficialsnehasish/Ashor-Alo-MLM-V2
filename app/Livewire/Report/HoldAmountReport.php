<?php

namespace App\Livewire\Report;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payout;
use Illuminate\Support\Facades\DB;
use Excel;
use PDF;
use App\Exports\HoldAmountReportExport;
use Illuminate\Support\Facades\Gate;

class HoldAmountReport extends Component
{
    use WithPagination;

    public $title = 'Hold Amount Report';
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

    protected function checkPermission($permission)
    {
        if (!Gate::allows($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }

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
        $fileName = 'hold-amount-report-' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(
            new HoldAmountReportExport($data),
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

        $pdf = PDF::loadView('exports.report.hold-amount-report-pdf', $data);
        return response()->streamDownload(
            fn () => print($pdf->output()),
            "hold-amount-report-".now()->format('Y-m-d').".pdf"
        );
    }

    protected function getQuery()
    {
        return Payout::select('user_id', 'hold_amount', 'start_date', 'end_date', 'id')
                    ->where('hold_amount', '!=', 0)
                    ->whereIn(DB::raw('(user_id, end_date)'), function ($query) {
                        $query->select(DB::raw('user_id, MAX(end_date)'))
                            ->from('payouts')
                            ->where('hold_amount', '!=', 0)
                            ->groupBy('user_id');
                    });
    }

    public function render()
    {
        $this->checkPermission('Hold Amount Report');
        return view('livewire.report.hold-amount-report',[
            'title' => $this->title,
            'items' => $this->getQuery()->paginate($this->perPage),
        ]);
    }
}
