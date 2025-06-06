<?php

namespace App\Livewire\Report;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AccountTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Excel;
use PDF;
use App\Exports\TDSReportExport;
use App\Exports\TDSReportFullExport;
use Illuminate\Support\Facades\Gate;

class DirectBonusReport extends Component
{
    use WithPagination;

    public $title = 'Direct Bonus Report';
    public $startDate;
    public $endDate;
    public $search = '';
    public $perPage = 10;
    public $showFullReport = false;
    public $selectedUserId;
    public $selectedUId;
    public $selectedUserName;

    protected $queryString = [
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'showFullReport' => ['except' => false],
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
        $fileName = 'direct-bonus-report-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(
            new TDSReportExport($data),
            $fileName
        );
    }

    public function exportFullExcel()
    {
        $data = $this->getFullDetailsQuery()->get();
        $fileName = 'direct-bonus-full-report-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(
            new TDSReportFullExport($data),
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

        $pdf = PDF::loadView('exports.report.tds-report-pdf', $data);
        return response()->streamDownload(
            fn () => print($pdf->output()),
            "direct-bonus-report-".now()->format('Y-m-d').".pdf"
        );
    }

    public function exportFullPDF()
    {
        $data = [
            'title' => 'Direct Bonus Full Report - ' . $this->selectedUserName,
            'items' => $this->getFullDetailsQuery()->get(),
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'userName' => $this->selectedUserName
        ];

        $pdf = PDF::loadView('exports.report.tds-full-report-pdf', $data);
        return response()->streamDownload(
            fn () => print($pdf->output()),
            "direct-bonus-full-report-".now()->format('Y-m-d').".pdf"
        );
    }

    protected function getQuery()
    {
        return AccountTransaction::query()
            ->whereIn('which_for', ['Direct Bonus', 'Direct Bonus on Hold'])
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereDate('created_at', '>=', $this->startDate)
                      ->whereDate('created_at', '<=', $this->endDate);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('user', function ($q2) {
                        $q2->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('user.binaryNode', function ($q3) {
                        $q3->where('member_number', 'like', '%' . $this->search . '%');
                    });
                });
            })

            ->select('user_id', DB::raw('SUM(amount) as total_amount'), DB::raw('MIN(created_at) as first_transaction'))
            ->groupBy('user_id')
            ->with('user');
    }

    protected function getFullDetailsQuery()
    {
        return AccountTransaction::query()
            ->whereIn('which_for', ['Direct Bonus', 'Direct Bonus on Hold'])
            ->where('user_id', $this->selectedUId)
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereDate('created_at', '>=', $this->startDate)
                      ->whereDate('created_at', '<=', $this->endDate);
            });
    }

    public function render()
    {
        $this->checkPermission('Direct Bonus Report');
        if ($this->showFullReport) {
            return view('livewire.report.direct-bonus-full-report', [
                'title' => 'Direct Bonus Full Report - ' . $this->selectedUserName,
                'items' => $this->getFullDetailsQuery()->paginate($this->perPage),
                'userName' => $this->selectedUserName,
                'userId' => $this->selectedUserId
            ]);
        }

        return view('livewire.report.direct-bonus-report', [
            'title' => $this->title,
            'items' => $this->getQuery()->paginate($this->perPage),
        ]);
    }
}
