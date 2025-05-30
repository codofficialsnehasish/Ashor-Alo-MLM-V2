<?php

namespace App\Livewire\Report;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\User;
use App\Models\Payout;
use Illuminate\Support\Facades\DB;
use Excel;
use PDF;

class PayoutReport extends Component
{
    use WithPagination;

    public $title = 'Payout Report';
    public $startDate;
    public $endDate;
    public $search = '';
    public $perPage = 10;
    public $showFullReport = false;
    public $fullStartDate;
    public $fullEndDate;


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

    public function showFullDetails($start_date, $end_date)
    {
        $this->fullStartDate = $start_date;
        $this->fullEndDate = $end_date;
        $this->showFullReport = true;
    }


    public function backToSummary()
    {
        $this->showFullReport = false;
    }

    protected function getQuery()
    {
        return Payout::select(
                    'start_date',
                    'end_date',
                    DB::raw('SUM(total_payout) as total_payout'),
                    DB::raw('COUNT(DISTINCT user_id) as total_user_count')
                )
                ->groupBy('start_date', 'end_date')
                ->orderBy('start_date', 'desc');
    }

    protected function getFullDetailsQuery()
    {
        // dd($this->fullStartDate);
        return Payout::whereDate('start_date', $this->fullStartDate)
            ->whereDate('end_date', $this->fullEndDate)
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
        if ($this->showFullReport) {
            return view('livewire.report.payout-full-report', [
                'title' => 'Payout Report',
                'items' => $this->getFullDetailsQuery()->paginate($this->perPage),
            ]);
        }

        return view('livewire.report.payout-report', [
            'title' => $this->title,
            'items' => $this->getQuery()->paginate($this->perPage),
        ]);
    }
}
