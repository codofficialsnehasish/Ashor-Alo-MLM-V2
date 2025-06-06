<?php

namespace App\Livewire\Report;

use Livewire\Component;
use App\Models\User;
use App\Models\BinaryTree;
use App\Models\TopUp;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;

class TreeWiseBusinessReport extends Component
{
    use WithPagination;

    public $start_date;
    public $end_date;
    public $user_id;
    public $position;
    public $users;
    public $rootNode;
    public $left_business = 0;
    public $right_business = 0;
    public $title = 'Tree Wise Business Report';
    public $search = '';
    public $searchResults = [];

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
        $this->checkPermission('Tree Wise Business Report');
        $this->generateReport();
        return view('livewire.report.tree-wise-business-report');
    }

    public function generateReport()
    {
        // $this->resetReportData();

        if ($this->user_id) {
            $this->rootNode = BinaryTree::where('user_id', $this->user_id)->first();
            if($this->start_date && $this->end_date){
                $this->left_business = $this->rootNode->calculateLeftBusiness($this->start_date, $this->end_date);
                $this->right_business = $this->rootNode->calculateRightBusiness($this->start_date, $this->end_date);
            }else{
                $this->left_business = $this->rootNode->calculateLeftBusiness();
                $this->right_business = $this->rootNode->calculateRightBusiness();
            }
        }else{
            $this->rootNode = BinaryTree::whereNull('parent_id')->first();
            if($this->start_date && $this->end_date){
                $this->left_business = $this->rootNode->calculateLeftBusiness($this->start_date, $this->end_date);
                $this->right_business = $this->rootNode->calculateRightBusiness($this->start_date, $this->end_date);
            }else{
                $this->left_business = $this->rootNode->calculateLeftBusiness();
                $this->right_business = $this->rootNode->calculateRightBusiness();
            }
        }
    }

    // protected function resetReportData()
    // {
    //     $this->left_business = 0;
    //     $this->right_business = 0;
    // }
}
