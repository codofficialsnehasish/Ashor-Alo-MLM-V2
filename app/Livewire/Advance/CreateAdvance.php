<?php

namespace App\Livewire\Advance;

use Livewire\Component;
use App\Models\Advance;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CreateAdvance extends Component
{
    public $user_id;
    public $original_amount;
    public $notes;
    
    protected function checkPermission($permission)
    {
        if (!Gate::allows($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'original_amount' => 'required|numeric|min:1',
        'notes' => 'nullable|string|max:500',
    ];

    public function render()
    {
        $this->checkPermission('Advance Create');

        return view('livewire.advance.create-advance', [
            'users' => User::where('id', '!=', Auth::id())->get()
        ]);
    }

    public function save()
    {
        $this->checkPermission('Advance Create');
        
        $this->validate();

        Advance::create([
            'user_id' => $this->user_id,
            'admin_id' => Auth::id(),
            'original_amount' => $this->original_amount,
            'due_amount' => $this->original_amount,
            'notes' => $this->notes,
        ]);

        $this->reset(['user_id', 'original_amount', 'notes']);

        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'Advance assigned successfully.'
        ]));
    }

}
