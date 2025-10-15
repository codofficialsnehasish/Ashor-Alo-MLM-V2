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
    public $cut_percentage;
    public $notes;
    public $is_new_advance = true; // Track if creating new advance or adding to existing
    
    protected function checkPermission($permission)
    {
        if (!Gate::allows($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'original_amount' => 'required|numeric|min:1',
        'cut_percentage' => 'required|numeric',
        'notes' => 'nullable|string|max:500',
    ];

    public function render()
    {
        $this->checkPermission('Advance Create');

        return view('livewire.advance.create-advance', [
            'users' => User::whereHas('roles', function ($query) {
                            $query->whereIn('name', ['Leader']);
                        })->get()
        ]);
    }

    public function updatedUserId($value)
    {
        // Check if user already has an advance account
        $this->is_new_advance = !Advance::where('user_id', $value)->exists();
    }

    public function save()
    {
        $this->checkPermission('Advance Create');
        $this->validate();

        $user = User::findOrFail($this->user_id);
        // dd($this->original_amount);
        if ($this->is_new_advance) {
            // Create new advance account
            $advance = Advance::create([
                'user_id' => $this->user_id,
                'admin_id' => Auth::id(),
                'original_amount' => $this->original_amount,
                'cut_percentage' => $this->cut_percentage,
                'due_amount' => $this->original_amount,
                'balance' => $this->original_amount,
                'notes' => $this->notes,
                'status' => 'active',
            ]);

            $message = 'Advance account created successfully.';
        } else {
            // Add to existing advance
            $advance = Advance::where('user_id', $this->user_id)->firstOrFail();
            
            // Update advance totals
            $advance->update([
                'original_amount' => $advance->original_amount + $this->original_amount,
                'due_amount' => $advance->due_amount + $this->original_amount,
                'balance' => $advance->balance + $this->original_amount,
                'status' => 'active',
            ]);

            $message = 'Additional advance added successfully.';
        }

        // Create credit transaction
        $advance->credit($this->original_amount, $this->notes ?? 'Additional advance');

        $this->reset(['user_id', 'original_amount', 'notes']);

        $this->dispatch('toastMessage', json_encode([
            'type' => 'success',
            'message' => $message
        ]));

        $this->dispatch('advance-created');
    }
}