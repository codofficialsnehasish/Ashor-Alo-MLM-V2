<?php

namespace App\Livewire\Report;

use Livewire\Component;
use App\Models\User;
use App\Models\BinaryTree;
use App\Models\TopUp;
use Livewire\WithPagination;

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
                return [
                    'id' => $node->user_id,
                    'level' => $node->depth - $rootNode->depth, // Calculate level based on depth
                    'user_id' => optional($node->user)->user_id,
                    'name' => optional($node->user)->name,
                    'phone' => optional($node->user)->phone,
                    'reg_date' => optional($node->user)->created_at,
                    'position' => $node->position,
                    'sponsor_id' => $node->sponsor_id,
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
        // Implement PDF export logic similar to your original controller method
        // You can reuse most of the code from level_wise_business_exportPdf
    }

    public function exportExcel()
    {
        // Implement Excel export logic similar to your original controller method
        // You can reuse most of the code from level_wise_business_exportExcel
    }
}
