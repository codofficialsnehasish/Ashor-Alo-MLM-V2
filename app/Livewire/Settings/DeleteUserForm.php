<?php

namespace App\Livewire\Settings;

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

class DeleteUserForm extends Component
{
    public string $password = '';
    public bool $confirmingUserDeletion = false;
    public $showDeleteModal= false;

    /**
     * Delete the currently authenticated user.
     */ 
    public function openDeleteModal(){
        $this->showDeleteModal = true;
    }
    public function closeDeleteModal(){
        $this->showDeleteModal = false;
    }

    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        try {
            tap(Auth::user(), $logout(...))->delete();
            
            $this->dispatch('close-modal', id: 'confirm-user-deletion');
            $this->redirect('/', navigate: true);
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'password' => __('Failed to delete account. Please try again.'),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.settings.delete-user-form');
    }
}