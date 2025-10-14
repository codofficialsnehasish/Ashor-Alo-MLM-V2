<?php

namespace App\Services;

use App\Models\User;
use App\Models\BinaryTree;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Services\SMSService;

class BinaryTreeService
{
    public function createNode($userData, $sponsorId = null, $preferredPosition = null)
    {
        // Create user with auto-generated password
        //$password = Str::random(12
        $password = rand(1000, 9999);
        $user = User::create(array_merge($userData, [
            'password' => Hash::make($password),
            'decoded_password' => $password
        ]));

        $user->assignRole('Leader');

        // Insert into binary tree
        $node = $this->insertNode($user->id, $sponsorId, $preferredPosition);
        
        // ✅ Send SMS
        try {
            $smsService = new SMSService();
            $smsService->sendSMS($user->phone, $node->member_number, $password);
        } catch (\Exception $e) {
            \Log::info('Failed to send SMS for user '.$node->member_number.': '.$e->getMessage());
        }

        return [
            'user' => $user,
            'node' => $node,
            'password' => $password // Return plain password for notification
        ];
    }

    public function insertNode($userId, $sponsorId = null, $preferredPosition = null)
    {
        $user = User::findOrFail($userId);
        // $memberNumber = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);

        // Generate a unique member number
        do {
            $memberNumber = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
        } while (BinaryTree::where('member_number', $memberNumber)->exists());


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
        return DB::transaction(function () use ($fromNodeId, $toSponsorId, $position) {
            $node = BinaryTree::findOrFail($fromNodeId);
            $newSponsor = BinaryTree::where('member_number', $toSponsorId)->firstOrFail();

            // Prevent moving to its own descendant
            if ($newSponsor->isDescendantOf($node)) {
                throw new \Exception('Cannot move a node to its own descendant');
            }

            $positionField = $position . '_user_id';
            $originalParent = $node->parent;

            // Step 1: Detach node from original parent
            if ($originalParent) {
                $oldPositionField = $node->position . '_user_id';
                $originalParent->update([$oldPositionField => null]);
            }

            // Step 2: If sponsor already has a child at the target position,
            // we'll push it down into the subtree (after attaching)
            $existingChildId = $newSponsor->$positionField;

            // Step 3: Attach node to new sponsor
            $node->update([
                'parent_id' => $newSponsor->id,
                'sponsor_id' => $newSponsor->id,
                'position' => $position,
                '_lft' => 0,
                '_rgt' => 0
            ]);
            $newSponsor->update([$positionField => $node->id]);

            // Step 4: If there was an existing child, push it into the subtree
            if (!empty($existingChildId)) {
                $existingChild = BinaryTree::findOrFail($existingChildId);

                // Find the deepest available node in the new subtree (node)
                $target = $this->findDeepestNodeWithEmptyPosition($node);
                if (!$target) {
                    throw new \Exception('No space found in subtree to push down the existing child');
                }

                // Decide which side is empty (prefer left)
                $targetPosition = empty($target->left_user_id) ? 'left' : 'right';

                // Move the existing child under the subtree
                $target->update([
                    $targetPosition . '_user_id' => $existingChild->id
                ]);
                $existingChild->update([
                    'parent_id' => $target->id,
                    'position' => $targetPosition,
                    'sponsor_id' => $target->id,
                    '_lft' => 0,
                    '_rgt' => 0
                ]);
            }

            // Step 5: Rebuild the tree
            BinaryTree::fixTree();

            return [
                'success' => true,
                'message' => 'Subtree transferred and existing node pushed into subtree.',
                'new_position' => $position
            ];
        });
    }


    protected function findDeepestNodeWithEmptyPosition($node, $preferredSide = 'left')
    {
        $queue = [$node];
        while (!empty($queue)) {
            $current = array_shift($queue);

            if ($preferredSide === 'left' && empty($current->left_user_id)) {
                return $current;
            }
            if ($preferredSide === 'right' && empty($current->right_user_id)) {
                return $current;
            }

            if ($current->left_user_id) {
                $queue[] = BinaryTree::find($current->left_user_id);
            }
            if ($current->right_user_id) {
                $queue[] = BinaryTree::find($current->right_user_id);
            }
        }

        return null;
    }


}