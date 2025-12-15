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

    public $search = '';
    public $searchResults = [];
    
    // Infinite scroll properties
    public $loadedLevels = 1; // Number of levels to load initially
    public $levelsPerLoad = 1; // Levels to load each time
    public $maxLevels = 40;
    public $isLoading = false;
    public $hasMoreLevels = true;
    public $initialLoad = false; // Track if initial data has been loaded

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
        
        // Load initial data only if filters are set
        if ($this->start_date || $this->end_date || $this->user_id || $this->position) {
            $this->initialLoad = true;
            $this->loadLevels();
        }
    }

    public function updatedSearch($value)
    {
        if (strlen($value) < 2) {
            $this->searchResults = [];
            return;
        }

        $this->searchResults = BinaryTree::with('user')
            ->whereHas('user', function($query) use ($value) {
                $query->where('name', 'like', '%'.$value.'%')
                      ->orWhere('email', 'like', '%'.$value.'%')
                      ->orWhere('member_number', 'like', '%'.$value.'%');
            })
            ->limit(10)
            ->get()
            ->map(function($tree) {
                return [
                    'id' => $tree->user_id,
                    'name' => $tree->user->name,
                    'member_number' => $tree->user->member_number,
                    'email' => $tree->user->email
                ];
            });
    }

    public function selectUser($userId)
    {
        $this->user_id = $userId;
        $selectedUser = User::find($userId);
        $this->search = $selectedUser ? "{$selectedUser->name} ({$selectedUser->member_number})" : '';
        $this->searchResults = [];
        $this->generateReport();
    }


    public function render()
    {
        $this->checkPermission('Level Wise Business Report');
        return view('livewire.report.level-wise-business-report');
    }

    public function generateReport()
    {
        $this->initialLoad = true;
        $this->resetReportData();
        $this->loadLevels();
    }

    public function loadLevels()
    {
        if ($this->isLoading) return;

        $this->isLoading = true;

        // Determine the root user
        if ($this->user_id) {
            $rootNode = BinaryTree::where('user_id', $this->user_id)->first();
        } else {
            $rootNode = BinaryTree::whereNull('parent_id')->first();
        }

        if (!$rootNode) {
            $this->isLoading = false;
            return;
        }

        // Build sponsor-level data only for levels we haven't loaded yet
        $levels = [];
        $total_members = 0;

        $this->buildSponsorLevelNodes($rootNode->id, $levels, 0, $this->loadedLevels - 1, $total_members);

        // Flatten all levels into one array to collect all user IDs
        $allMembers = collect($levels)->flatten(1);
        $buyer_ids = $allMembers->pluck('user_id')->toArray();

        if (!empty($buyer_ids)) {
            // Query TopUps of all members
            $query = TopUp::whereIn('user_id', $buyer_ids)
                ->where('is_show_on_business', 1);

            if ($this->start_date && $this->end_date) {
                $query->whereDate('start_date', '>=', $this->start_date)
                    ->whereDate('start_date', '<=', $this->end_date);
            }

            $total_businesss = $query->orderBy('id', 'ASC')->get();

            // Combine topup data into level-wise business report
            foreach ($levels as $level => $members) {
                foreach ($members as $member) {
                    $topup = $total_businesss->firstWhere('user_id', $member['user_id']);

                    // Skip if not matching position filter
                    if ($this->position && strtolower($member['position']) !== strtolower($this->position)) {
                        continue;
                    }

                    if ($topup) {
                        $member['total_business'] = $topup;
                        $this->groupedBusiness[$level][] = $member;
                        $this->total_amount += $topup->total_amount;
                        $this->total_user_count += 1;
                    }
                }
            }
        }

        ksort($this->groupedBusiness);

        // Check if there are more levels to load
        $this->hasMoreLevels = $this->loadedLevels < $this->maxLevels;

        // Set report title
        $this->title = 'Level Wise Business Report of ' . ($rootNode->user?->name ?? 'Unknown');
        if ($this->start_date && $this->end_date) {
            $this->title .= ' from ' . formated_date($this->start_date) . ' to ' . formated_date($this->end_date);
        }

        $this->isLoading = false;
    }

    public function loadMore()
    {
        if ($this->hasMoreLevels && !$this->isLoading) {
            $this->loadedLevels += $this->levelsPerLoad;
            $this->loadLevels();
        }
    }

    public function resetLevels()
    {
        $this->loadedLevels = 1;
        $this->hasMoreLevels = true;
        $this->generateReport();
    }

    protected function buildSponsorLevelNodes($leaderId, &$levels, $currentLevel, $maxLevels, &$total_members)
    {
        if ($currentLevel > $maxLevels) return;

        // Get direct referrals
        $directMembers = BinaryTree::where('sponsor_id', $leaderId)
            ->with(['user'])
            ->get();

        if ($directMembers->isEmpty()) return;

        foreach ($directMembers as $memberNode) {
            $user = $memberNode->user;

            if ($user) {
                $formattedNode = [
                    'user_id'         => $user->id,
                    'name'            => $user->name,
                    'phone'           => $user->phone,
                    'member_number'   => $memberNode->member_number,
                    'status'          => $memberNode->status,
                    'position'        => $memberNode->position,
                    'sponsor_id'      => $memberNode->sponsor?->member_number,
                    'register_date'   => formated_date($user->created_at),
                    'total_business'  => TopUp::where('user_id',$user->id)->where('is_show_on_business',1)->sum('total_amount'),
                    'user' => (object)[
                        'id'               => $user->id,
                        'name'             => $user->name,
                        'profile_image'    => $user->getFirstMediaUrl('profile-image'),
                        'register_left'    => $user->leftUsers()->count(),
                        'register_right'   => $user->rightUsers()->count(),
                        'activated_left'   => $user->leftUsers()->where('status', 1)->count(),
                        'activated_right'  => $user->rightUsers()->where('status', 1)->count(),
                    ]
                ];

                $levels[$currentLevel][] = $formattedNode;
                $total_members++;
            }

            // Recurse into this member's direct referrals
            if ($currentLevel < $maxLevels) {
                $this->buildSponsorLevelNodes($memberNode->id, $levels, $currentLevel + 1, $maxLevels, $total_members);
            }
        }
    }

    protected function resetReportData()
    {
        $this->groupedBusiness = [];
        $this->total_amount = 0;
        $this->total_user_count = 0;
        $this->loadedLevels = 1;
        $this->hasMoreLevels = true;
        $this->isLoading = false;
    }

    public function exportPdf()
    {
        // Load all levels for export
        $originalLoadedLevels = $this->loadedLevels;
        $this->loadedLevels = $this->maxLevels;
        $this->loadLevels();
        
        $data = [
            'groupedBusiness' => $this->groupedBusiness,
            'total_amount' => $this->total_amount,
            'total_user_count' => $this->total_user_count,
            'title' => $this->title,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ];

        $pdf = Pdf::loadView('exports.report.level-wise-business-pdf', $data);
        
        // Restore original loaded levels
        $this->loadedLevels = $originalLoadedLevels;
        $this->loadLevels();
        
        return response()->streamDownload(
            fn () => print($pdf->output()),
            'level-wise-business-report-'.now()->format('Y-m-d').'.pdf'
        );
    }

    public function exportExcel()
    {
        // Load all levels for export
        $originalLoadedLevels = $this->loadedLevels;
        $this->loadedLevels = $this->maxLevels;
        $this->loadLevels();
        
        $exportData = [];
        
        foreach ($this->groupedBusiness as $level => $users) {
            foreach ($users as $user) {
                $exportData[] = [
                    'Level' => $level + 1,
                    'User ID' => $user['user_id'] ?? '',
                    'Name' => $user['name'] ?? '',
                    'Phone' => $user['phone'] ?? '',
                    'Registration Date' => $user['register_date'] ?? '',
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

        // Restore original loaded levels
        $this->loadedLevels = $originalLoadedLevels;
        $this->loadLevels();
        
        return Excel::download(new LevelWiseBusinessExport($exportData, $this->title), 'level-wise-business-report-'.now()->format('Y-m-d').'.xlsx');
    }
}