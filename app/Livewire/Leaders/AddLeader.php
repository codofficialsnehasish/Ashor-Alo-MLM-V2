<?php

namespace App\Livewire\Leaders;

use Livewire\Component;
use App\Services\BinaryTreeService;
use App\Models\User;
use App\Models\BinaryTree;
use Illuminate\Support\Facades\Hash;

class AddLeader extends Component
{
    public $sponsorId;
    public $sponsorName;
    public $name;
    public $email;
    public $phone;
    public $preferredPosition = 'left';
    public $showConfirmation = false;
    public $formData = [];

    protected $rules = [
        'sponsorId' => 'nullable|exists:binary_trees,member_number',
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|digits:10|regex:/^[6789]/|unique:users,phone',
        'preferredPosition' => 'required|in:left,right'
    ];

    public function mount()
    {
        
    }

    public function getSponsorName()
    {
        $this->validateOnly('sponsorId', ['sponsorId' => 'required|exists:binary_trees,member_number']);
        
        $sponsor = BinaryTree::where('member_number',$this->sponsorId)->with('user')->first();
        $this->sponsorName = $sponsor ? $sponsor->user->name : 'Not found';
    }

    public function submitForm()
    {
        $this->validate();
        
        $this->formData = [
            'Sponsor ID' => $this->sponsorId,
            'Sponsor Name' => $this->sponsorName,
            'Member Name' => $this->name,
            'Email' => $this->email,
            'Phone' => $this->phone,
            'Preferred Position' => ucfirst($this->preferredPosition)
        ];
        
        $this->showConfirmation = true;
    }

    public function confirmSubmission(BinaryTreeService $binaryTreeService)
    {
        $result = $binaryTreeService->createNode(
            [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone
            ],
            $this->sponsorId,
            $this->preferredPosition
        );

        // $result = $binaryTreeService->addMember([
        //     'sponsor_id' => $this->sponsorId, // user_id of the sponsor
        //     'position'   => $this->preferredPosition, // or 'right'
        //     'name'       => $this->name,
        //     'email'      => $this->email,
        //     'phone'      => $this->phone,
        //     'password'   => 'secret123',
        // ]);

        $this->showConfirmation = false;
        $this->resetForm();
        
        session()->flash('message', 
            "Member added successfully! \n" .
            "Temporary Password: {$result['password']} \n" .
            "Member Number: {$result['node']->member_number}");
    }

    public function resetForm()
    {
        $this->reset([
            'name',
            'email',
            'phone',
            'preferredPosition',
            'formData'
        ]);
    }

    public function render()
    {
        return view('livewire.leaders.add-leader');
    }
}