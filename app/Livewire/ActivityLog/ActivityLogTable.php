<?php

namespace App\Livewire\ActivityLog;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ActivityLogTable extends Component
{
    use WithPagination;

    public $from_date;
    public $to_date;
    public $user_id;

    public function render()
    {
        $logs = Activity::query()
            ->when($this->from_date, fn($q) => $q->whereDate('created_at', '>=', $this->from_date))
            ->when($this->to_date, fn($q) => $q->whereDate('created_at', '<=', $this->to_date))
            ->when($this->user_id, fn($q) => $q->where('causer_id', $this->user_id))
            ->with('causer.roles') // assuming Spatie role package
            ->latest()
            ->paginate(10);

        // $users = User::with('roles')->orderBy('name')->get();
        $excludedRoles = ['Leader'];

        $users = User::whereDoesntHave('roles', function ($query) use ($excludedRoles) {
            $query->whereIn('name', $excludedRoles);
        })->get();

        return view('livewire.activity-log.activity-log-table', [
            'logs' => $logs,
            'users' => $users,
        ]);
    }
  
    public function updating($field)
    {
        // Reset to page 1 when filters change
        $this->resetPage();
    }
}
