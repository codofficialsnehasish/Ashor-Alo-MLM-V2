<?php
namespace App\Livewire\Users;
use App\Models\User;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;

class Usermanagement extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $user;
    public $userId;
    public $data = [];
    public $name;
    public $email;
    public $password;
    public $userRoles;
    public $roles;
    protected $listeners = ['deleteItem', 'refreshComponent' => 'loadUsers'];
    
    public function mount()
    {
        // $this->users = User::with('media')->get();
        // $this->roles = Role::pluck('name','name')->all();
    }

    protected function checkPermission($permission)
    {
        if (!Gate::allows($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function render()
    {
        $this->checkPermission('View User');
        // $users = User::paginate(10);
        $excludedRoles = ['Leader']; // array of role names

        $users = User::whereDoesntHave('roles', function ($query) use ($excludedRoles) {
            $query->whereIn('name', $excludedRoles);
        })->paginate(10);

        return view('livewire.users.usermanagement', [
            'roles' => $this->roles,
            'users' => $users
        ]);
    }


    public function deleteItem($id)
    {
        $this->checkPermission('Delete User');
        $item = User::find($id);
        if ($item) {
            $item->delete();
            $this->dispatch('refreshComponent');

            $this->dispatch('toastMessage', json_encode([
                'type'=>'success',
                'message' => 'The user has been successfully deleted.'
            ]));
        }
    }

    public function loadUsers()
    {
        // $this->users = User::all();
        // $this->roles = Role::pluck('name','name')->all();
    }
}
