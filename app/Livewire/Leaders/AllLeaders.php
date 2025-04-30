<?php

namespace App\Livewire\Leaders;

use Livewire\Component;
use App\Models\User;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AllLeaders extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $query = ''; // For search functionality
    public $targetRole = ['Leader']; // The role you want to include

    public function render()
    {
        $users = $this->getUsers();
        return view('livewire.leaders.all-leaders', [
            'users' => $users
        ]);
    }

    protected function getUsers()
    {
        return User::whereHas('roles', function ($query) {
                $query->whereIn('name', $this->targetRole);
            })
            ->when($this->query, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%'.$this->query.'%')
                      ->orWhere('email', 'like', '%'.$this->query.'%');
                });
            })
            ->with(['binaryNode', 'roles'])
            ->paginate(10);
    }

    public function exportPDF()
    {
        $users = $this->getFilteredUsersForExport();
        
        $pdf = Pdf::loadView('exports.users-pdf', [
            'users' => $users,
            'query' => $this->query
        ]);
        
        return response()->streamDownload(
            fn () => print($pdf->output()),
            "leaders-export-".now()->format('Y-m-d').".pdf"
        );
    }

    public function exportExcel()
    {
        return Excel::download(
            new UsersExport($this->getFilteredUsersForExport()), 
            "leaders-export-".now()->format('Y-m-d').".xlsx"
        );
    }

    protected function getFilteredUsersForExport()
    {
        return User::whereHas('roles', function ($query) {
                $query->whereIn('name', $this->targetRole);
            })
            ->when($this->query, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%'.$this->query.'%')
                      ->orWhere('email', 'like', '%'.$this->query.'%');
                });
            })
            ->with(['binaryNode', 'roles'])
            ->get();
    }
}