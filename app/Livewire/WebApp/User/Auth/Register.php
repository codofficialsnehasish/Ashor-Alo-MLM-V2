<?php

namespace App\Livewire\WebApp\User\Auth;

use Livewire\Component;
use App\Models\BinaryTree;
use Illuminate\Support\Facades\Validator;
use App\Services\BinaryTreeService;

class Register extends Component
{
    public $sponsor_id;
    public $sponsorName = '';
    public $name;
    public $position;
    public $email;
    public $phone;
    public $terms = false;
    public $showConfirmModal = false; // flag to show modal
    public $showSuccessModal = false; // flag to show modal
    public $generated_member_number = "";
    public $generated_password = "";
    public $user_name = "";

    public function mount()
    {
        // Capture query params from URL
        $this->sponsor_id = request()->query('sponsorid'); // from ?sponsorid=...
        $this->position   = request()->query('position');  // from ?position=...

        // If sponsor_id exists, automatically fetch sponsor name
        if ($this->sponsor_id) {
            $sponsor = BinaryTree::where('member_number', $this->sponsor_id)
                ->with('user')
                ->first();

            if ($sponsor && $sponsor->user) {
                $this->sponsorName = $sponsor->user->name;
            } else {
                $this->sponsorName = 'Sponsor not found';
            }
        }
    }


    public function updatedSponsorId($value)
    {
        $this->sponsorName = '';

        if ($value) {
            // Look up sponsor in BinaryTree by member_number
            $sponsor = BinaryTree::where('member_number', $value)
                ->with('user') // so we can access $sponsor->user
                ->first();

            if ($sponsor && $sponsor->user) {
                // take name from related user
                $this->sponsorName = $sponsor->user->name;
            } else {
                $this->sponsorName = 'Sponsor not found';
            }
        }
    }

    public function submit()
    {
        $this->validate([
            'sponsor_id' => 'required|exists:binary_trees,member_number',
            'name' => 'required|string|max:255',
            'position' => 'required|in:left,right',
            'phone' => 'required|digits:10|regex:/^[6789]/',
            'email' => 'nullable|email',
            'terms' => 'accepted'
        ]);

        // open confirmation modal
        $this->showConfirmModal = true;
    }

    public function register(BinaryTreeService $binaryTreeService)
    {
        // Validate again before submit:
        $validator = Validator::make([
            'sponsor_id'         => $this->sponsor_id,
            'name'               => $this->name,
            'email'              => $this->email,
            'phone'              => $this->phone,
            'preferred_position' => $this->position,
        ], [
            'sponsor_id'         => 'required|exists:binary_trees,member_number',
            'name'               => 'required|string|max:255',
            'email'              => 'nullable|email',
            'phone'              => 'required|digits:10|regex:/^[6789]/|unique:users,phone',
            'preferred_position' => 'required|in:left,right',
        ]);

        if ($validator->fails()) {
            $this->showConfirmModal = false;
            $this->setErrorBag($validator->errors());
            // dd($validator->errors());
            return;
        }

        try {
            $this->showConfirmModal = false;

            $result = $binaryTreeService->createNode(
                [
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone
                ],
                $this->sponsor_id,
                $this->position
            );

            $this->generated_member_number = $result['node']->member_number;
            $this->generated_password = $result['user']->decoded_password;
            $this->user_name = $result['user']->name;

            $this->showSuccessModal = true;
            // dd($result);


            // session()->flash('success', 'Member registered successfully! Member number: ' . $result['node']->member_number);

            $this->reset(['sponsor_id', 'sponsorName', 'name', 'email', 'phone', 'position', 'terms']);

        } catch (\Exception $e) {
            $this->addError('form', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.web-app.user.auth.register')
            ->layout('livewire.web-app.layout');
    }
}
