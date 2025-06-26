<?php

namespace App\Livewire\WebApp;

use Livewire\Component;
use App\Models\ContactUs;

class Contact extends Component
{
    public $name;
    public $email_or_phone;
    public $message;
    
    public $successMessage='';
    public $errorMessages = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email_or_phone' => 'required|string|max:255',
        'message' => 'required|string',
    ];

    public function submit()
    {
        $this->validate();

        try {
            // Create the contact message directly
            ContactUs::create([
                'name' => $this->name,
                'email_or_phone' => $this->email_or_phone,
                'message' => $this->message,
            ]);

            $this->successMessage = 'Contact message submitted successfully';
            $this->resetForm();
            $this->errorMessages = [];
        } catch (\Exception $e) {
            $this->errorMessages = ['An error occurred while submitting your message.'];
        }
    }

    private function resetForm()
    {
        $this->reset(['name', 'email_or_phone', 'message']);
    }

    public function render()
    {
        return view('livewire.web-app.contact')->layout('livewire.web-app.layout');
    }
}
