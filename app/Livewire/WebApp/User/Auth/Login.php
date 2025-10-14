<?php

namespace App\Livewire\WebApp\User\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\BinaryTree;

class Login extends Component
{
    public $member_number, $password;

    public function login()
    {
        $this->validate([
            'member_number' => 'required|digits:8|exists:binary_trees,member_number',
            'password' => 'required|min:4',
        ]);

        $sponsor = BinaryTree::where('member_number', $this->member_number)
            ->with('user')
            ->first();

        if (!$sponsor || !Hash::check($this->password, $sponsor->user->password)) {
            $this->addError('member_number', 'Invalid credentials.');
            return;
        }

        if (! $sponsor->user->hasRole('Leader')) {
            $this->addError('member_number', 'Unauthorized. Only Leaders can login.');
            return;
        }

        if ($sponsor->user->is_block == 1) {
            $this->addError('member_number', 'Your ID is Blocked.');
            return;
        }

        Auth::guard('user')->login($sponsor->user);
        // Auth::login($sponsor->user);

        return redirect()->route('user.dashboard');
    }

    public function render()
    {
        return view('livewire.web-app.user.auth.login')->layout('livewire.web-app.layout');
    }
}
