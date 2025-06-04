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
    public $forcePosition = false;
    public $showForceOption = false;

    public function render()
    {
        $nodes = BinaryTree::with('user')
                ->when($this->search, function ($query) {
                    $query->whereHas('user', function($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                    })->orWhereHas('user.binaryNode', function ($q3) {
                        $q3->where('member_number', 'like', '%' . $this->search . '%');
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
        $sponsor = BinaryTree::where('member_number',$sponsorId)->first();
        $this->availablePositions = [];
        $this->showForceOption = false;
        
        if (!$sponsor) return;
        
        // if (!$sponsor->left_user_id) {
        //     $this->availablePositions[] = 'left';
        // }
        // if (!$sponsor->right_user_id) {
        //     $this->availablePositions[] = 'right';
        // }

        // Show force option if both positions are occupied
        // if (count($this->availablePositions) === 0) {
            $this->showForceOption = true;
            $this->availablePositions = ['left', 'right'];
        // }
    }

    public function confirmTransfer(BinaryTreeService $binaryTreeService)
    {
        $this->validate([
            'selectedNode' => 'required',
            'newSponsorId' => [
                'required', 
                'exists:binary_trees,member_number',
                function ($attribute, $value, $fail) {
                    if ($this->selectedNode && $value == $this->selectedNode->member_number) {
                        $fail('Cannot transfer to the same node');
                    }
                }
            ],
            'position' => 'required|in:left,right'
        ]);

        try {
            $binaryTreeService->transferSubtree(
                $this->selectedNode->id,
                $this->newSponsorId,
                $this->position
            );
            
            $this->dispatch('toastMessage', json_encode([
                'type'=>'success',
                'message' => 'Subtree transferred successfully'
            ]));
            $this->reset(['selectedNode', 'newSponsorId', 'position']);
        } catch (\Exception $e) {
            $this->dispatch('toastMessage', json_encode([
                'type'=>'error',
                'message' => $e->getMessage()
            ]));
        }
    }
}