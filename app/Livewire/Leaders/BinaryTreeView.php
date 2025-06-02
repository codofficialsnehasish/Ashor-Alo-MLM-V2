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
    public $searchResults = [];
    public $search = '';

    public function mount()
    {
        $this->loadTree();
    }

    public function updatedSearch($value)
    {
        if (strlen($value) < 2) {
            $this->searchResults = [];
            return;
        }

        $this->searchResults = BinaryTree::with('user')
            ->whereHas('user', function($query) use ($value) {
                $query->where('name', 'like', '%'.$value.'%')
                      ->orWhere('email', 'like', '%'.$value.'%')
                      ->orWhere('member_number', 'like', '%'.$value.'%');
            })
            ->limit(10)
            ->get()
            ->map(function($tree) {
                return [
                    'id' => $tree->user_id,
                    'name' => $tree->user->name,
                    'member_number' => $tree->user->member_number,
                    'email' => $tree->user->email
                ];
            });
    }

    public function resetSearch()
    {
        $this->searchResults = [];
        $this->search = '';
    }

    public function loadTree($rootId = null)
    {
        if ($rootId) {
            
            $this->currentRootId = $rootId;
            $this->root = BinaryTree::with(['user', 'left.user', 'right.user'])
                ->where('user_id', $rootId)
                ->first();
            // dd($this->root->sponsor_id);
        } else {
            $this->currentRootId = null;
            $this->root = BinaryTree::with(['user', 'left.user', 'right.user'])
                ->whereNull('parent_id')
                ->first();
        }

        // Load the next 4 levels
        if ($this->root) {
            $this->loadLevels($this->root, $this->levelsToShow);
        }

        $this->resetSearch();
    }

    protected function loadLevels(&$node, $levelsRemaining)
    {
        if ($levelsRemaining <= 0) return;

        $node->load(['left.user', 'right.user']);

        if ($node->left) {
            $this->loadLevels($node->left, $levelsRemaining - 1);
        }
        if ($node->right) {
            $this->loadLevels($node->right, $levelsRemaining - 1);
        }
    }

    public function setAsRoot($userId)
    {
        $this->loadTree($userId);
    }

    public function render()
    {
        return view('livewire.leaders.binary-tree-view');
    }
}