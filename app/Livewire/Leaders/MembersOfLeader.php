<?php

namespace App\Livewire\Leaders;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\BinaryTree;
use Carbon\Carbon;
use Excel;
use App\Exports\BinaryTreeExport;
use PDF;

class MembersOfLeader extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;
    public $memberNumber;
    public $tableSearch = '';
    public $perPage = 10;
    public $sortField = 'activated_at';
    public $sortDirection = 'desc';
    public $selectedRows = [];
    public $selectAll = false;

    protected $queryString = [
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'memberNumber' => ['except' => ''],
        'sortField',
        'sortDirection',
        'perPage'
    ];

    public function mount()
    {
        $this->startDate = now()->subMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedRows = $this->members->pluck('id')->toArray();
        } else {
            $this->selectedRows = [];
        }
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
            'selectAll'
        ]);
        $this->startDate = now()->subMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function exportExcel()
    {
        $data = $this->getQuery()->get();
        return Excel::download(new BinaryTreeExport($data), 'binary-tree-report-'.now()->format('Y-m-d').'.xlsx');
    }

    public function exportPDF()
    {
        $data = $this->getQuery()->get();
        $pdf = PDF::loadView('exports.binary-tree-pdf', ['members' => $data]);
        return $pdf->download('binary-tree-report-'.now()->format('Y-m-d').'.pdf');
    }

    private function getQuery()
    {
        return BinaryTree::with(['user', 'sponsor.user', 'parent.user'])
            ->when($this->startDate, function ($query) {
                $query->whereDate('activated_at', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('activated_at', '<=', $this->endDate);
            })
            ->when($this->memberNumber, function ($query) {
                $query->where('member_number', 'like', '%' . $this->memberNumber . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function getMembersProperty()
    {
        return $this->getQuery()->paginate($this->perPage);
    }

    public function render()
    {
        $query = $this->getQuery();
        
        return view('livewire.leaders.members-of-leader', [
            'members' => $this->members,
            'totalMembers' => $query->count(),
            'activeMembers' => $query->clone()->where('status', 'active')->count(),
            'inactiveMembers' => $query->clone()->where('status', 'inactive')->count(),
        ]);
    }
}