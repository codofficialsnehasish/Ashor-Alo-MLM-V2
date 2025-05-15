<?php

namespace App\Livewire\Leaders\TreePartials;

use Livewire\Component;
use App\Models\BinaryTree;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;

class TreeNode extends Component
{
    public $node;
    public $currentDepth;
    public $maxDepth;

    public function mount($node, $currentDepth, $maxDepth)
    {
        $this->node = $node;
        $this->currentDepth = $currentDepth;
        $this->maxDepth = $maxDepth;

        // $this->dispatch('test-event', message: 'Component mounted');
    }

    // public function setAsRoot($userId)
    // {
    //     $this->loadTree($userId);
    // }

    public function render()
    {
        return view('livewire.leaders.tree-partials.tree-node');
    }
}