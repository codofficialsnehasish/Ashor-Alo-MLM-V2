<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Url;
use Livewire\WithFileUploads;

class EditUser extends Component
{
    use WithFileUploads;
    public $name;
    public $image;
    public $email;
    public $password;
    public $userId;
    public $roles = [];
    public $selectedRoles = [];
    public $user;
    public $existingImage;
    public $data = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'password' => '',
        'status' => false,
    ];
    public $userRoles;
    protected $listeners = ['selectedRoles' => 'HandleselectedRoles', 'refreshComponent' => 'loadUsers'];
    protected $rules = ['name' => 'required|string|min:3'];
       // 'email' => 'required|string|email|max:255|unique:users,email',
      //  'password' => 'required|string|min:6|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
       // 'selectedRoles' => 'required',

    public function mount($id)
    {
        try {
            $decryptedId = Crypt::decryptString($id); // Decrypt the ID
            $this->user = User::findOrFail($decryptedId);   // Fetch the item
            $this->data = [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
                'status' => (bool) $this->user->status,
            ];
            $this->userId = $decryptedId;
            $this->existingImage = $this->user->getFirstMediaUrl('user');
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            $this->dispatch('toastMessage', json_encode([
                'type'=>'error',
                'message' => 'Invalid ID'
            ]));
            return redirect()->route('users')->with('error', 'Invalid ID');
        }

        // $this->roles = Role::pluck('name', 'name')->toArray();
        $allRoles = Role::pluck('name', 'name')->toArray();
        $excludedRoles = ['Leader']; // Roles to exclude
        
        $this->roles = array_diff($allRoles, $excludedRoles);
        $this->selectedRoles = $this->user->roles->pluck('name')->toArray();
    }

    public function updateUser()
    { //dd($this->userId);
        //$this->validate();
        $this->user = User::findOrFail($this->userId);
       // dd($this->selectedRoles);
        $this->user->update($this->data);
        $this->user->syncRoles($this->selectedRoles);

        if($this->password){
            $this->user->update([
                'password' => Hash::make($this->pull('password')),
            ]);
        }

        if ($this->image) {
            $this->user->clearMediaCollection('user');
            $this->user->addMedia($this->image)->toMediaCollection('user');
            $this->existingImage = $this->user->getFirstMediaUrl('user');
        }


        $this->dispatch('refreshComponent');
        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'User Updated successfully'
        ]));

    }

    public function HandleselectedRoles($Roles)
    {
        $this->selectedRoles = $Roles;
    }

    public function render()
    {
        return view('livewire.users.edit-user');
    }
}
