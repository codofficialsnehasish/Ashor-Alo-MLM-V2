<?php

namespace App\Livewire\Leaders;

use Livewire\Component;
use App\Models\BinaryTree;
use Illuminate\Support\Facades\Log;
// use Livewire\Attributes\On;

class BinaryTreeView extends Component
{
    public $root;
    public $currentRootId = null;
    public $levelsToShow = 4;

    public function mount()
    {
        $this->loadTree();
    }

    public function loadTree($rootId = null)
    {
        
        Log::info("$rootId");
        // Eager load user with all necessary relationships and counts
        $withClosure = function ($query) {
            $query->with([
                // Add any direct relationships you need
                // 'sponsor',     
                // 'rank'
            ])->withCount([
                'leftUsers as register_left',
                'rightUsers as register_right',
                'leftUsers as activated_left' => function ($q) {
                    $q->where('status', 1);
                },
                'rightUsers as activated_right' => function ($q) {
                    $q->where('status', 1);
                },
                // Add other counts you need
            ]);
        };

        if ($rootId) {
            $this->currentRootId = $rootId;
            $this->root = BinaryTree::with([
                'user' => $withClosure,
                'left.user' => $withClosure,
                'right.user' => $withClosure,
            ])->where('user_id',$rootId)->first();
        } else {
            $this->currentRootId = null;
            $this->root = BinaryTree::with([
                'user' => $withClosure,
                'left.user' => $withClosure,
                'right.user' => $withClosure,
            ])->whereNull('parent_id')->first();
        }

        // Load the next 4 levels with all required user data
        if ($this->root) {
            $this->loadLevels($this->root, $this->levelsToShow, $withClosure);
        }
    }

    protected function loadLevels(&$node, $levelsRemaining, $withClosure)
    {
        if ($levelsRemaining <= 0) return;

        // Eager load left and right with their users and counts
        $node->load([
            'left.user' => $withClosure,
            'right.user' => $withClosure,
        ]);
        
        if ($node->left) {
            $this->loadLevels($node->left, $levelsRemaining - 1, $withClosure);
        }
        if ($node->right) {
            $this->loadLevels($node->right, $levelsRemaining - 1, $withClosure);
        }
    }

    public function setAsRoot($userId)
    {
        $this->loadTree($userId);
    }
    

    // #[On('set-as-root')]
    // public function setAsRoot($userId)
    // {
    //     Log::info("Setting root to: " . $userId);
        
    //     // Validate user exists
    //     if (!BinaryTree::where('user_id', $userId)->exists()) {
    //         $this->dispatch('error', message: 'User not found in binary tree');
    //         return;
    //     }

    //     // Update the tree view
    //     $this->loadTree($userId);
        
    //     // Dispatch event if you need to notify other components
    //     $this->dispatch('root-changed', userId: $userId);
    // }

    public function render()
    {
        return view('livewire.leaders.binary-tree-view');
    }
}