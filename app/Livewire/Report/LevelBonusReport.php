<?php

namespace App\Livewire\Report;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AccountTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Excel;
use PDF;

class LevelBonusReport extends Component
{
    use WithPagination;

    public $title = 'Level Bonus Report';
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
        $fileName = 'level-bonus-report-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            protected $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function collection()
            {
                return $this->data;
            }

            public function headings(): array
            {
                return [
                    'User ID',
                    'Total Amount',
                    'First Transaction Date'
                ];
            }
        }, $fileName);
    }

    public function exportFullExcel()
    {
        $data = $this->getFullDetailsQuery()->get();
        $fileName = 'level-bonus-full-report-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            protected $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function collection()
            {
                return $this->data;
            }

            public function headings(): array
            {
                return [
                    'Transaction ID',
                    'Amount',
                    'Type',
                    'Date',
                    'Status'
                ];
            }
        }, $fileName);
    }

    public function exportPDF()
    {
        $data = [
            'title' => $this->title,
            'items' => $this->getQuery()->get(),
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ];

        $pdf = PDF::loadView('exports.level-bonus-report-pdf', $data);
        return $pdf->download('level-bonus-report-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportFullPDF()
    {
        $data = [
            'title' => 'Level Bonus Full Report - ' . $this->selectedUserName,
            'items' => $this->getFullDetailsQuery()->get(),
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'userName' => $this->selectedUserName
        ];

        $pdf = PDF::loadView('exports.level-bonus-full-report-pdf', $data);
        return $pdf->download('level-bonus-full-report-' . $this->selectedUserId . '-' . now()->format('Y-m-d') . '.pdf');
    }

    protected function getQuery()
    {
        return AccountTransaction::query()
            ->whereIn('which_for', ['Level Bonus', 'Level Bonus on Hold'])
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
            ->whereIn('which_for', ['Level Bonus', 'Level Bonus on Hold'])
            ->where('user_id', $this->selectedUId)
            ->when($this->startDate && $this->endDate, function ($query) {
                $query->whereDate('created_at', '>=', $this->startDate)
                      ->whereDate('created_at', '<=', $this->endDate);
            });
    }

    public function render()
    {
        if ($this->showFullReport) {
            return view('livewire.report.level-bonus-full-report', [
                'title' => 'Level Bonus Full Report - ' . $this->selectedUserName,
                'items' => $this->getFullDetailsQuery()->paginate($this->perPage),
                'userName' => $this->selectedUserName,
                'userId' => $this->selectedUserId
            ]);
        }

        return view('livewire.report.level-bonus-report', [
            'title' => $this->title,
            'items' => $this->getQuery()->paginate($this->perPage),
        ]);
    }
}
