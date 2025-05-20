<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\BinaryTree;

class BinaryTreeApiController extends Controller
{
    public function direct(Request $request){
        $user = User::find($request->user()->id);
        if($user){
            $leader = $user->binaryTreeNode;
            $directMembers = BinaryTree::where('sponsor_id', $leader->id)->with('user')->get();
            return apiResponse(true, 'Direct Members.', ['direct_members'=>$directMembers], 200);
        }
        return apiResponse(false, 'User not found.', null, 200);
    }

    public function left_side_members(Request $request){
        $user = User::find($request->user()->id);
        if($user){
            $leader = $user->binaryTreeNode;
            $leftMembers = $leader->leftUsers;
            return apiResponse(true, 'Left Members.', ['left_members'=>$leftMembers], 200);
        }
        return apiResponse(false, 'User not found.', null, 200);
    }

    public function right_side_members(Request $request){
        $user = User::find($request->user()->id);
        if($user){
            $leader = $user->binaryTreeNode;
            $rightMembers = $leader->rightUsers;
            return apiResponse(true, 'Right Members.', ['right_members'=>$rightMembers], 200);
        }
        return apiResponse(false, 'User not found.', null, 200);
    }

    public function all_members(Request $request) {
        $user = User::find($request->user()->id);
        if ($user) {
            $leader = $user->binaryTreeNode;
            
            // Get both left and right members
            $leftMembers = $leader->leftUsers ?? collect();
            $rightMembers = $leader->rightUsers ?? collect();
            
            // Combine both collections
            $allMembers = $leftMembers->merge($rightMembers);
            
            return apiResponse(true, 'All Members.', ['all_members' => $allMembers], 200);
        }
        
        return apiResponse(false, 'User not found.', null, 200);
    }

    public function getTree(Request $request,$rootId = null, $levels = 4)
    {
        $withClosure = function ($query) {
            $query->withCount([
                'leftUsers as register_left',
                'rightUsers as register_right',
                'leftUsers as activated_left' => function ($q) {
                    $q->where('status', 1);
                },
                'rightUsers as activated_right' => function ($q) {
                    $q->where('status', 1);
                },
            ]);
        };

        if ($rootId) {
            $root = BinaryTree::with([
                'user' => $withClosure,
                'left.user' => $withClosure,
                'right.user' => $withClosure,
            ])->where('user_id', $rootId)->first();
        } else {
            $root = BinaryTree::with([
                'user' => $withClosure,
                'left.user' => $withClosure,
                'right.user' => $withClosure,
            ])->where('user_id',$request->user()->id)->first();
        }

        if (!$root) {
            return response()->json(['message' => 'Tree not found'], 404);
        }

        $treeData = $this->formatTreeData($root, $levels, $withClosure);

        return response()->json([
            'root' => $rootId,
            'levels' => $levels,
            'tree' => $treeData
        ]);
    }

    protected function formatTreeData($node, $levelsRemaining, $withClosure)
    {
        if (!$node || $levelsRemaining <= 0) return null;

        $node->load([
            'left.user' => $withClosure,
            'right.user' => $withClosure,
        ]);

        $formatted = [
            'user_id' => $node->user_id,
            'member_number' => $node->member_number,
            'status' => $node->status,
            'user' => $node->user ? [
                'id' => $node->user->id,
                'name' => $node->user->name,
                'profile_image' => $node->user->getFirstMediaUrl('profile-image'),
                'register_left' => $node->user->register_left ?? 0,
                'register_right' => $node->user->register_right ?? 0,
                'activated_left' => $node->user->activated_left ?? 0,
                'activated_right' => $node->user->activated_right ?? 0,
            ] : null,
            'left' => null,
            'right' => null,
        ];

        if ($levelsRemaining > 1) {
            if ($node->left) {
                $formatted['left'] = $this->formatTreeData($node->left, $levelsRemaining - 1, $withClosure);
            }
            if ($node->right) {
                $formatted['right'] = $this->formatTreeData($node->right, $levelsRemaining - 1, $withClosure);
            }
        }

        return $formatted;
    }

    public function getTreeLevels($rootId = null, $maxLevels = 4)
    {
        $withClosure = function ($query) {
            $query->withCount([
                'leftUsers as register_left',
                'rightUsers as register_right',
                'leftUsers as activated_left' => function ($q) {
                    $q->where('status', 1);
                },
                'rightUsers as activated_right' => function ($q) {
                    $q->where('status', 1);
                },
            ]);
        };

        if ($rootId) {
            $root = BinaryTree::with([
                'user' => $withClosure,
                'left.user' => $withClosure,
                'right.user' => $withClosure,
            ])->where('user_id', $rootId)->first();
        } else {
            $root = BinaryTree::with([
                'user' => $withClosure,
                'left.user' => $withClosure,
                'right.user' => $withClosure,
            ])->whereNull('parent_id')->first();
        }

        if (!$root) {
            return response()->json(['message' => 'Tree not found'], 404);
        }

        $levelData = [];
        $this->collectLevelData($root, 0, $maxLevels, $withClosure, $levelData);

        $formattedLevels = [];
        foreach ($levelData as $level => $nodes) {
            $formattedLevels[(string)($level + 1)] = $nodes; // Level numbers start at 1
        }

        return response()->json([
            'root' => $rootId,
            // 'max_levels' => $maxLevels,
            'levels' => $formattedLevels
        ]);
    }

    protected function collectLevelData($node, $currentLevel, $maxLevels, $withClosure, &$levelData)
    {
        // if (!$node || $currentLevel >= $maxLevels) return;
        if (!$node) return;

        // Initialize level array if not exists
        if (!isset($levelData[$currentLevel])) {
            $levelData[$currentLevel] = [];
        }

        // Format node data
        $formattedNode = [
            'user_id' => $node->user_id,
            'member_number' => $node->member_number,
            'status' => $node->status,
            'position' => $node->position, // 'left' or 'right' of parent if applicable
            'user' => $node->user ? [
                'id' => $node->user->id,
                'name' => $node->user->name,
                'profile_image' => $node->user->getFirstMediaUrl('profile-image'),
                'register_left' => $node->user->register_left ?? 0,
                'register_right' => $node->user->register_right ?? 0,
                'activated_left' => $node->user->activated_left ?? 0,
                'activated_right' => $node->user->activated_right ?? 0,
            ] : null
        ];

        // Add node to its level
        $levelData[$currentLevel][] = $formattedNode;

        // Load relationships if not at max level
        // if ($currentLevel < $maxLevels - 1) {
            $node->load([
                'left.user' => $withClosure,
                'right.user' => $withClosure,
            ]);

            // Process left and right children
            if ($node->left) {
                $this->collectLevelData($node->left, $currentLevel + 1, $maxLevels, $withClosure, $levelData);
            }
            if ($node->right) {
                $this->collectLevelData($node->right, $currentLevel + 1, $maxLevels, $withClosure, $levelData);
            }
        // }
    }
}