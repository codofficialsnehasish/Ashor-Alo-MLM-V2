<?php

namespace App\Livewire\Leaders;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BinaryTree;
use Carbon\Carbon;
use Excel;
use App\Exports\BinaryTreeExport;
use PDF;
use Illuminate\Pagination\LengthAwarePaginator;

class MembersOfLeader extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;
    public $memberNumber;
    public $tableSearch = '';
    public $perPage = 10;
    public $page = 1;
    public $sortField = 'activated_at';
    public $sortDirection = 'desc';
    public $selectedRows = [];
    public $selectAll = false;
    public $filtersApplied = false;

    protected $queryString = [
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'memberNumber' => ['except' => ''],
        'sortField',
        'sortDirection',
        'perPage',
    ];

    public function mount()
    {
        $this->startDate = now()->subMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function applyFilters()
    {
        $this->filtersApplied = true;
        $this->resetPage();
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

    public function resetFilters()
    {
        $this->reset([
            'startDate',
            'endDate',
            'memberNumber',
            'tableSearch',
            'selectedRows',
            'selectAll',
            'filtersApplied'
        ]);
        $this->startDate = now()->subMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->resetPage();
    }

    public function exportExcel()
    {
        $data = $this->getAllMembersCollection();
        return Excel::download(new BinaryTreeExport($data), 'binary-tree-report-' . now()->format('Y-m-d') . '.xlsx');
    }
 
    public function exportPDF()
    {
        $leader = BinaryTree::where('member_number', $this->memberNumber)->first();
        $members = $this->getMembersProperty();

        // print($members);die;
        $totalMembers = $members->total();
        $activeMembers = $members->filter(fn($m) => $m->status == 1)->count();
        $inactiveMembers = $members->filter(fn($m) => $m->status == 0)->count();

        $pdf = PDF::loadView('exports.member-of-leader-pdf', ['members' => $members,
            'leader' => $leader,
            'totalMembers' => $totalMembers,
            'activeMembers' => $activeMembers,
            'inactiveMembers' => $inactiveMembers,]);
            
        return $pdf->download('member-of-leader-report-' . now()->format('Y-m-d') . '.pdf');
    }

    private function getAllMembersCollection()
    {
        if (!$this->memberNumber) {
            return collect();
        }

        $leader = BinaryTree::where('member_number', $this->memberNumber)->first();

        $leftMembers = $leader->leftUsers ?? collect();
        $rightMembers = $leader->rightUsers ?? collect();

        $allMembers = $leftMembers->merge($rightMembers);
        
        // Apply date filters if they're set and filters have been applied
        if ($this->filtersApplied && $this->startDate && $this->endDate) {
            $allMembers = $allMembers->filter(function ($member) {
                $created = Carbon::parse($member->created_at)->format('Y-m-d');
                return $created >= $this->startDate && $created <= $this->endDate;
            });
        }

        // Apply search filter
        if (!empty($this->tableSearch)) {
            $searchTerm = strtolower($this->tableSearch);
            // Check if search term is specifically "left" or "right"
            if ($searchTerm === 'left') {
                $allMembers = $allMembers->filter(fn($m) => $m->position === 'left');
            } elseif ($searchTerm === 'right') {
                $allMembers = $allMembers->filter(fn($m) => $m->position === 'right');
            } elseif ($searchTerm === 'active') {
                $allMembers = $allMembers->filter(fn($m) => $m->status == 1);
            } elseif ($searchTerm === 'inactive') {
                $allMembers = $allMembers->filter(fn($m) => $m->status == 0);
            } else {
                $allMembers = $allMembers->filter(function ($member) use ($searchTerm) {
                    return str_contains(strtolower($member->user->name), $searchTerm) ||
                        str_contains(strtolower($member->member_number), $searchTerm) ||
                        str_contains(strtolower($member->user->phone), $searchTerm) ||
                        (isset($member->sponsor->user->name) && str_contains(strtolower($member->sponsor->user->name), $searchTerm)) ||
                        (isset($member->sponsor->member_number) && str_contains(strtolower($member->sponsor->member_number), $searchTerm));
                });
            }   
        }

        // Apply sorting
        $sorted = $allMembers->sortBy(function ($member) {
            return $member->{$this->sortField};
        }, SORT_REGULAR, $this->sortDirection === 'desc');

        return $sorted->values();
    }

    private function paginateCollection($items)
    {
        $page = $this->page ?: 1;
        $perPage = $this->perPage;
        $total = $items->count();

        $results = $items->slice(($page - 1) * $perPage, $perPage)->values();

        return new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);
    }

    public function getMembersProperty()
    {
        $collection = $this->getAllMembersCollection();
        return $this->paginateCollection($collection);
    }

    public function render()
    {
        $members = $this->getMembersProperty();

        // print($members);die;
        $totalMembers = $members->total();
        $activeMembers = $members->filter(fn($m) => $m->status == 1)->count();
        $inactiveMembers = $members->filter(fn($m) => $m->status == 0)->count();

        return view('livewire.leaders.members-of-leader', [
            'members' => $members,
            'totalMembers' => $totalMembers,
            'activeMembers' => $activeMembers,
            'inactiveMembers' => $inactiveMembers,
        ]);
    }
}