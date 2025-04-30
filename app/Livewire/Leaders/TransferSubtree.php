<?php

namespace App\Livewire\Leaders;

use Livewire\Component;
use App\Services\BinaryTreeService;
use App\Models\BinaryTree;

class TransferSubtree extends Component
{
    public $search;
    public $selectedNode;
    public $newSponsorId;
    public $position = 'left';
    public $availablePositions = [];
    public $confirmationModal = false;

    public function render()
    {
        $nodes = BinaryTree::with('user')
            ->when($this->search, function ($query) {
                $query->whereHas('user', function($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%')
                      ->orWhere('phone', 'like', '%'.$this->search.'%');
                });
            })
            ->paginate(10);

        return view('livewire.leaders.transfer-subtree', [
            'nodes' => $nodes
        ]);
    }

    public function selectNode($nodeId)
    {
        $this->selectedNode = BinaryTree::with('user')->find($nodeId);
        $this->dispatch('node-selected');
    }

    public function checkPositions($sponsorId)
    {
        $sponsor = BinaryTree::find($sponsorId);
        $this->availablePositions = [];
        
        if (!$sponsor) return;
        
        if (!$sponsor->left_user_id) {
            $this->availablePositions[] = 'left';
        }
        if (!$sponsor->right_user_id) {
            $this->availablePositions[] = 'right';
        }
    }

    public function confirmTransfer(BinaryTreeService $binaryTreeService)
    {
        $this->validate([
            'selectedNode' => 'required',
            'newSponsorId' => 'required|exists:binary_tree,user_id',
            'position' => 'required|in:left,right'
        ]);

        try {
            $binaryTreeService->transferSubtree(
                $this->selectedNode->id,
                $this->newSponsorId,
                $this->position
            );
            
            session()->flash('message', 'Subtree transferred successfully');
            $this->reset(['selectedNode', 'newSponsorId', 'position']);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }
}