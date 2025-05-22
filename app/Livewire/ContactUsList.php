<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ContactUs;

class ContactUsList extends Component
{
    use WithPagination;

    public $search = '';



    public function render()
    {
        $contacts = ContactUs::when($this->search, function ($query) {
            return $query->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email_or_phone', 'like', '%' . $this->search . '%')
                    ->orWhere('message', 'like', '%' . $this->search . '%');
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('livewire.contact-us-list', [
            'contacts' => $contacts
        ]);
    }

    public function delete($deleteId)
    {
        ContactUs::find($deleteId)->delete();
        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'Contact message deleted successfully.'
        ]));
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
