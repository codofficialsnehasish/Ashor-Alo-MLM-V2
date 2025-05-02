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
                    // Search in user table fields
                    $q->where('name', 'like', '%'.$this->query.'%')
                      ->orWhere('email', 'like', '%'.$this->query.'%')
                      ->orWhere('phone', 'like', '%'.$this->query.'%')
                      ->orWhere('created_at', 'like', '%'.$this->query.'%')
                      
                      // Search in binaryNode relationship fields
                      ->orWhereHas('binaryNode', function($nodeQuery) {
                            $nodeQuery->where('member_number', 'like', '%'.$this->query.'%')
                            ->orWhere('position', 'like', '%'.$this->query.'%')
                            ->orWhere(function($statusQuery) {
                                // Convert search term to lowercase for case-insensitive matching
                                $searchTerm = strtolower($this->query);
                                if ($searchTerm === 'active' || $searchTerm === 'act') {
                                    $statusQuery->where('status', 1);
                                } elseif ($searchTerm === 'inactive' || $searchTerm === 'inact') {
                                    $statusQuery->where('status', 0);
                                } else {
                                    // Fallback to numeric search if they enter 0 or 1 directly
                                    $statusQuery->where('status', 'like', '%'.$this->query.'%');
                                }
                            })
                            ->orWhere('activated_at', 'like', '%'.$this->query.'%');
                      })
                      
                      // Search in sponsor's name
                      ->orWhereHas('binaryNode.sponsor.user', function($sponsorQuery) {
                          $sponsorQuery->where('name', 'like', '%'.$this->query.'%');
                      })
                      // Search in sponsor's id
                      ->orWhereHas('binaryNode.sponsor', function($sponsorQuery) {
                        $sponsorQuery->where('member_number', 'like', '%'.$this->query.'%');
                    });
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