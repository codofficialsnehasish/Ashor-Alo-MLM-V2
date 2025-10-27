<?php

namespace App\Livewire\Report;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AccountTransaction;
use App\Models\User;
use App\Models\Payout;
use Illuminate\Support\Facades\DB;
use Excel;
use PDF;
use App\Exports\PayoutHistoryReportExport;
use App\Exports\PayoutHistoryFullReportExport;
use Illuminate\Support\Facades\Gate;

class PayoutHistoryReport extends Component
{
    use WithPagination;

    public $title = 'Payout History Report';  
    public $startDate;
    public $endDate;
    public $search = '';
    public $perPage = 10;
    public $showFullReport = false;
    public $selectedUserId;
    public $selectedUId;
    public $selectedUserName;

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
        'perPage' => ['except' => 10],
        'showFullReport' => ['except' => false],
    ];

    public function mount()
    {
        // $this->startDate = now()->startOfMonth()->format('Y-m-d');
        // $this->endDate = now()->endOfMonth()->format('Y-m-d');
    }

    public function showFullDetails($userId)
    {
        $this->selectedUserId = User::find($userId)->member_number ?? 'N/A';
        $this->selectedUId = $userId;
        $this->selectedUserName = User::find($userId)->name ?? 'N/A';
        $this->showFullReport = true;
    }

    public function backToSummary()
    {
        $this->showFullReport = false;
        $this->selectedUserId = null;
    }

    public function exportExcel()
    {
        $data = $this->getQuery()->get();
        $fileName = 'payout-history-report-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(
            new PayoutHistoryReportExport($data),
            $fileName
        );
    }

    public function exportFullExcel()
    {
        $data = $this->getFullDetailsQuery()->get();
        $fileName = 'payout-history-full-report-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(
            new PayoutHistoryFullReportExport($data),
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

        $pdf = PDF::loadView('exports.report.payout-history-report-pdf', $data);
        return response()->streamDownload(
            fn () => print($pdf->output()),
            "payout-history-report-".now()->format('Y-m-d').".pdf"
        );
    }

    public function exportFullPDF()
    {
        $data = [
            'title' => 'Payout History Full Report - ' . $this->selectedUserName,
            'items' => $this->getFullDetailsQuery()->get(),
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'userName' => $this->selectedUserName
        ];

        $pdf = PDF::loadView('exports.report.payout-history-full-report-pdf', $data);
        return response()->streamDownload(
            fn () => print($pdf->output()),
            "payout-history-full-report-".now()->format('Y-m-d').".pdf"
        );
    }

    protected function getQuery()
    {
        return Payout::select(
                    'user_id',
                    DB::raw('SUM(total_payout) as total_payout'),
                    // DB::raw('(SELECT id FROM payouts AS p WHERE p.user_id = payouts.user_id ORDER BY p.created_at DESC LIMIT 1) as last_payout_id')
                )
                ->when($this->search, function($query) {
                    $query->where(function($q) {
                        $q->whereHas('user', function($userQuery) {
                            $userQuery->where('name', 'like', '%'.$this->search.'%')
                            ->orWhere('email', 'like', '%'.$this->search.'%')
                            ->orWhere('phone', 'like', '%'.$this->search.'%');
                        })
                        ->orWhereHas('user.binaryNode', function ($q3) {
                            $q3->where('member_number', 'like', '%' . $this->search . '%');
                        });
                    });
                })
                ->groupBy('user_id');

    }

    protected function getFullDetailsQuery()
    {
        return Payout::where('user_id',$this->selectedUId)->orderBy('id','desc');
    }

    public function render()
    {
        $this->checkPermission('Payout History Report');
        if ($this->showFullReport) {
            return view('livewire.report.payout-history-full-report', [
                'title' => 'Payout History Full Report - ' . $this->selectedUserName,
                'items' => $this->getFullDetailsQuery()->paginate($this->perPage),
                'userName' => $this->selectedUserName,
                'userId' => $this->selectedUserId
            ]);
        }

        return view('livewire.report.payout-history-report', [
            'title' => $this->title,
            'items' => $this->getQuery()->paginate($this->perPage),
        ]);
    }
}
