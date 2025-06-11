<?php

namespace App\Livewire\Report;

use Livewire\Component;
use App\Models\User;
use App\Models\BinaryTree;
use App\Models\TopUp;
use Livewire\WithPagination;

use Excel;
use PDF;
use App\Exports\LevelWiseBusinessExport;
use Illuminate\Support\Facades\Gate;

class LevelWiseBusinessReport extends Component
{
    use WithPagination;

    public $start_date;
    public $end_date;
    public $user_id;
    public $position;
    public $users;
    public $groupedBusiness = [];
    public $total_amount = 0;
    public $total_user_count = 0;
    public $title = 'Level Wise Business Report';

    protected function checkPermission($permission)
    {
        if (!Gate::allows($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }

    protected $queryString = [
        'start_date' => ['except' => ''],
        'end_date' => ['except' => ''],
        'user_id' => ['except' => ''],
        'position' => ['except' => ''],
    ];

    public function mount()
    {
        $this->users = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Leader']);
        })->get();
    }

    public function render()
    {
        $this->checkPermission('Level Wise Business Report');
        $this->generateReport();
        return view('livewire.report.level-wise-business-report');
    }

    public function generateReport()
    {
        $this->resetReportData();

        // Get the root user
        // $user = isset($this->user_id) 
        //     ? User::where('user_id', $this->user_id)->first()
        //     : User::whereNull('parent_id')->where('role', 'agent')->first();

        // if (!$user) {
        //     return;
        // }

        // Get the binary tree node for this user
        if ($this->user_id) {
            $rootNode = BinaryTree::where('user_id', $user->id)->first();
        }else{
            $rootNode = BinaryTree::whereNull('parent_id')->first();
        }
        
        if (!$rootNode) {
            return;
        }

        // Get all descendants with their level information
        $descendants = BinaryTree::with('user')
            ->whereDescendantOf($rootNode)
            ->defaultOrder()
            ->get()
            ->map(function ($node) use ($rootNode) {
                $level = $node->ancestors()->whereDescendantOf($rootNode)->count();
                return [
                    'id' => $node->user_id,
                    'level' => $level, // Calculate level based on depth
                    'user_id' => optional($node->user)->member_number,
                    'name' => optional($node->user)->name,
                    'phone' => optional($node->user)->phone,
                    'reg_date' => optional($node->user)->created_at,
                    'position' => $node->position,
                    'sponsor_id' => $node->sponsor?->member_number,
                    'status' => $node->status,
                ];
            })
            ->filter() // Remove any null entries if user relationship fails
            ->toArray();

        $buyer_ids = array_column($descendants, 'id');

        $query = TopUp::whereIn('user_id', $buyer_ids)
            ->where(function($query) {
                $query->where('is_show_on_business', 1);
            });

        if ($this->start_date && $this->end_date) {
            $query->whereDate('start_date', '>=', $this->start_date)
                ->whereDate('start_date', '<=', $this->end_date);
        }

        $total_businesss = $query->orderBy('id', 'ASC')->get();

        $business = [];
        foreach ($total_businesss as $total_business) {
            $matchingUser = array_filter($descendants, function ($user) use ($total_business) {
                if ($user['id'] != $total_business->user_id) {
                    return false;
                }
                return $this->position ? strtolower($user['position']) === strtolower($this->position) : true;
            });
            
            if (!empty($matchingUser)) {
                $business[] = array_merge(current($matchingUser), [
                    'total_business' => $total_business,
                ]);
            }
        }

        foreach ($business as $item) {
            $level = $item['level'];
            if (!isset($this->groupedBusiness[$level])) {
                $this->groupedBusiness[$level] = [];
            }
            $this->groupedBusiness[$level][] = $item;
            
            $this->total_amount += $item['total_business']->total_amount;
            $this->total_user_count += 1;
        }

        ksort($this->groupedBusiness);

        $this->title = 'Level Wise Business Report of ' . $rootNode->user?->name;
        if ($this->start_date && $this->end_date) {
            $this->title .= ' from ' . formated_date($this->start_date) . ' to ' . formated_date($this->end_date);
        }
    }

    protected function resetReportData()
    {
        $this->groupedBusiness = [];
        $this->total_amount = 0;
        $this->total_user_count = 0;
    }

    public function exportPdf()
    {
        $data = [
            'groupedBusiness' => $this->groupedBusiness,
            'total_amount' => $this->total_amount,
            'total_user_count' => $this->total_user_count,
            'title' => $this->title,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ];

        $pdf = Pdf::loadView('exports.report.level-wise-business-pdf', $data);
        
        return response()->streamDownload(
            fn () => print($pdf->output()),
            'level-wise-business-report-'.now()->format('Y-m-d').'.pdf'
        );
    }

    public function exportExcel()
    {
        $exportData = [];
        
        foreach ($this->groupedBusiness as $level => $users) {
            foreach ($users as $user) {
                $exportData[] = [
                    'Level' => $level,
                    'User ID' => $user['user_id'] ?? '',
                    'Name' => $user['name'] ?? '',
                    'Phone' => $user['phone'] ?? '',
                    'Registration Date' => $user['reg_date'] ? $user['reg_date']->format('Y-m-d') : '',
                    'Position' => $user['position'] ?? '',
                    'Sponsor ID' => $user['sponsor_id'] ?? '',
                    'Status' => $user['status'] ?? '',
                    'Amount' => $user['total_business']->total_amount ?? 0,
                ];
            }
        }

        // Add summary row
        $exportData[] = [
            'Level' => 'Total',
            'User ID' => '',
            'Name' => '',
            'Phone' => '',
            'Registration Date' => '',
            'Position' => '',
            'Sponsor ID' => '',
            'Status' => '',
            'Amount' => $this->total_amount,
        ];

        return Excel::download(new LevelWiseBusinessExport($exportData, $this->title), 'level-wise-business-report-'.now()->format('Y-m-d').'.xlsx');
    }
}
