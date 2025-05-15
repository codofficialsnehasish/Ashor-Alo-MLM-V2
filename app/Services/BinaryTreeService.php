<?php

namespace App\Services;

use App\Models\User;
use App\Models\BinaryTree;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class BinaryTreeService
{
    public function createNode($userData, $sponsorId = null, $preferredPosition = null)
    {
        // Create user with auto-generated password
        $password = Str::random(12);
        $user = User::create(array_merge($userData, [
            'password' => Hash::make($password),
            'decoded_password' => $password
        ]));

        $user->assignRole('Leader');

        // Insert into binary tree
        $node = $this->insertNode($user->id, $sponsorId, $preferredPosition);

        return [
            'user' => $user,
            'node' => $node,
            'password' => $password // Return plain password for notification
        ];
    }

    public function insertNode($userId, $sponsorId = null, $preferredPosition = null)
    {
        $user = User::findOrFail($userId);
        $memberNumber = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);

        if (!$sponsorId) {
            return BinaryTree::create([
                'user_id' => $userId,
                'member_number' => $memberNumber,
                'parent_id' => null,
                'sponsor_id' => null,
                'status' => 0,
            ]);
        }

        $sponsorNode = BinaryTree::where('member_number', $sponsorId)->firstOrFail();

        // Try preferred position first
        if ($preferredPosition) {
            $positionField = $preferredPosition . '_user_id';
            if (empty($sponsorNode->$positionField)) {
                $node = BinaryTree::create([
                    'user_id' => $userId,
                    'member_number' => $memberNumber,
                    'parent_id' => $sponsorNode->id,
                    'sponsor_id' => $sponsorNode->id,
                    'position' => $preferredPosition,
                    'status' => 0,
                ]);
                
                $sponsorNode->update([$positionField => $node->id]);
                return $node;
            }
        }

        // If preferred position not available, find the deepest node in the preferred direction
        if ($preferredPosition) {
            $deepestNode = $preferredPosition === 'left' 
                ? $this->findDeepestLeft($sponsorNode) 
                : $this->findDeepestRight($sponsorNode);
                
            $positionField = $preferredPosition . '_user_id';
            if (empty($deepestNode->$positionField)) {
                $node = BinaryTree::create([
                    'user_id' => $userId,
                    'member_number' => $memberNumber,
                    'parent_id' => $deepestNode->id,
                    'sponsor_id' => $sponsorNode->id,
                    'position' => $preferredPosition,
                    'status' => 0,
                ]);
                
                $deepestNode->update([$positionField => $node->id]);
                return $node;
            }
        }

        // BFS to find next available position (fallback)
        $queue = [$sponsorNode];
        while (!empty($queue)) {
            $current = array_shift($queue);

            foreach (['left', 'right'] as $position) {
                $positionField = $position . '_user_id';
                if (empty($current->$positionField)) {
                    $node = BinaryTree::create([
                        'user_id' => $userId,
                        'member_number' => $memberNumber,
                        'parent_id' => $current->id,
                        'sponsor_id' => $sponsorNode->id,
                        'position' => $position,
                        'status' => 0,
                    ]);
                    
                    $current->update([$positionField => $node->id]);
                    return $node;
                }
            }

            if ($current->left_user_id) {
                $queue[] = BinaryTree::find($current->left_user_id);
            }
            if ($current->right_user_id) {
                $queue[] = BinaryTree::find($current->right_user_id);
            }
        }

        throw new \Exception('No available position in binary tree');
    }

    private function findDeepestLeft($node)
    {
        while ($node->left_user_id) {
            $node = BinaryTree::find($node->left_user_id);
        }
        return $node;
    }

    private function findDeepestRight($node)
    {
        while ($node->right_user_id) {
            $node = BinaryTree::find($node->right_user_id);
        }
        return $node;
    }

    public function transferSubtree($fromNodeId, $toSponsorId, $position)
    {
        DB::transaction(function () use ($fromNodeId, $toSponsorId, $position) {
            $node = BinaryTree::findOrFail($fromNodeId);
            $newSponsor = BinaryTree::where('user_id', $toSponsorId)->firstOrFail();

            // Validate position is available
            $positionField = $position . '_user_id';
            if (!empty($newSponsor->$positionField)) {
                throw new \Exception('Position already occupied');
            }

            // Detach from old parent
            $oldParent = BinaryTree::find($node->parent_id);
            if ($oldParent) {
                $oldPositionField = $node->position . '_user_id';
                $oldParent->update([$oldPositionField => null]);
            }

            // Attach to new sponsor
            $node->update([
                'parent_id' => $newSponsor->id,
                'sponsor_id' => $toSponsorId,
                'position' => $position
            ]);

            $newSponsor->update([$positionField => $node->id]);
        });
    }
}