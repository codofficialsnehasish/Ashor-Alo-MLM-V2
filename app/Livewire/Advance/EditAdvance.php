<?php

namespace App\Livewire\Advance;

use Livewire\Component;
use App\Models\Advance;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EditAdvance extends Component
{
    public $advanceId;
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

    public function mount($advanceId)
    {
        $this->advanceId = $advanceId;
        $advance = Advance::findOrFail($advanceId);
        
        $this->user_id = $advance->user_id;
        $this->original_amount = $advance->original_amount;
        $this->notes = $advance->notes;
    }

    public function render()
    {
        $this->checkPermission('Advance Edit');

        return view('livewire.advance.edit-advance', [
            'users' => User::where('id', '!=', Auth::id())->get()
        ]);
    }

    public function update()
    {
        $this->checkPermission('Advance Edit');

        $this->validate();

        $advance = Advance::findOrFail($this->advanceId);
        
        $advance->update([
            'user_id' => $this->user_id,
            'original_amount' => $this->original_amount,
            'due_amount' => $this->original_amount,
            'notes' => $this->notes,
        ]);

        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'Advance updated successfully.'
        ]));
    }
}