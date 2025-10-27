<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\BinaryTree;
use App\Models\TopUp;

class BinaryTreeApiController extends Controller
{
    /*public function direct(Request $request){
        $user = User::find($request->user()->id);
        if($user){
            $leader = $user->binaryTreeNode;
            $directMembers = BinaryTree::where('sponsor_id', $leader->id)->with('user')->get();
            return apiResponse(true, 'Direct Members.', ['direct_members'=>$directMembers], 200);
        }
        return apiResponse(false, 'User not found.', null, 200);
    }*/

    public function direct(Request $request)
    {
        $perPage = $request->get('per_page', 10); // Default to 10 if not provided
        $query = $request->get('query'); // Optional search parameter

        $user = User::find($request->user()->id);

        if ($user) {
            $leader = $user->binaryTreeNode;

            // $directMembers = BinaryTree::where('sponsor_id', $leader->id)
            //     ->with('user')
            //     ->paginate($perPage); // Apply pagination

            // Base query
            $directQuery = BinaryTree::where('sponsor_id', $leader->id)
                ->with('user');

            // If query parameter exists, apply search filter
            if (!empty($query) && strlen($query) >= 2) {
                $directQuery->whereHas('user', function ($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%');
                })
                ->orWhere('member_number', 'like', '%' . $query . '%');
            }

            // Paginate after filter (if any)
            $directMembers = $directQuery->paginate($perPage);

            return apiResponse(true, 'Direct Members.', [
                'members_data' => $directMembers->items(), // Current page data
                'pagination' => [
                    'total' => $directMembers->total(),
                    'per_page' => $directMembers->perPage(),
                    'current_page' => $directMembers->currentPage(),
                    'last_page' => $directMembers->lastPage(),
                ]
            ], 200);
        }

        return apiResponse(false, 'User not found.', null, 200);
    }


    /*public function left_side_members(Request $request){
        $user = User::find($request->user()->id);
        if($user){
            $leader = $user->binaryTreeNode;
            $leftMembers = $leader->leftUsers;
            return apiResponse(true, 'Left Members.', ['left_members'=>$leftMembers], 200);
        }
        return apiResponse(false, 'User not found.', null, 200);
    }*/

    public function left_side_members(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $page = (int) $request->get('page', 1);

        $user = User::find($request->user()->id);

        if ($user) {
            $leader = $user->binaryTreeNode;

            // This is a collection from the accessor
            $leftMembersCollection = $leader->leftUsers;

            // Get paginated slice
            $paginated = $leftMembersCollection->forPage($page, $perPage)->values();

            // Create pagination metadata manually
            $pagination = [
                'total' => $leftMembersCollection->count(),
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => ceil($leftMembersCollection->count() / $perPage),
            ];

            return apiResponse(true, 'Left Members.', [
                'members_data' => $paginated,
                'pagination' => $pagination
            ], 200);
        }

        return apiResponse(false, 'User not found.', null, 200);
    }



    /*public function right_side_members(Request $request){
        $user = User::find($request->user()->id);
        if($user){
            $leader = $user->binaryTreeNode;
            $rightMembers = $leader->rightUsers;
            return apiResponse(true, 'Right Members.', ['right_members'=>$rightMembers], 200);
        }
        return apiResponse(false, 'User not found.', null, 200);
    }*/

    public function right_side_members(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $page = (int) $request->get('page', 1);

        $user = User::find($request->user()->id);

        if ($user) {
            $leader = $user->binaryTreeNode;

            // This is a collection from accessor
            $rightMembersCollection = $leader->rightUsers;

            // Paginate manually
            $paginated = $rightMembersCollection->forPage($page, $perPage)->values();

            $pagination = [
                'total' => $rightMembersCollection->count(),
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => ceil($rightMembersCollection->count() / $perPage),
            ];

            return apiResponse(true, 'Right Members.', [
                'members_data' => $paginated,
                'pagination' => $pagination
            ], 200);
        }

        return apiResponse(false, 'User not found.', null, 200);
    }


    /*public function all_members(Request $request) {
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
    }*/

    public function all_members(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $page = (int) $request->get('page', 1);

        $user = User::find($request->user()->id);

        if ($user) {
            $leader = $user->binaryTreeNode;

            $leftMembers = $leader->leftUsers ?? collect();
            $rightMembers = $leader->rightUsers ?? collect();

            // Merge both collections
            $allMembersCollection = $leftMembers->merge($rightMembers);

            // Optional: sort if you need them ordered (e.g., by id or created_at)
            // $allMembersCollection = $allMembersCollection->sortByDesc('id')->values();

            // Manual pagination
            $paginated = $allMembersCollection->forPage($page, $perPage)->values();

            $pagination = [
                'total' => $allMembersCollection->count(),
                'per_page' => $perPage,
                'current_page' => $page,
                'last_page' => ceil($allMembersCollection->count() / $perPage),
            ];

            return apiResponse(true, 'All Members.', [
                'members_data' => $paginated,
                'pagination' => $pagination
            ], 200);
        }

        return apiResponse(false, 'User not found.', null, 200);
    }

    
    // public function member_search(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'query' => 'required',
    //     ]);
    
    //     if ($validator->fails()) {
    //         return apiResponse(false, 'Validation Errors', $validator->errors(), 422);
    //     }
    
    //     if (strlen($request->input('query')) < 2) {
    //         return apiResponse(false, 'Search query must be at least 2 characters long.', null, 200);
    //     }
    
    //     $value = $request->input('query'); 
    
    //     $searchResults = BinaryTree::with('user')
    //         ->whereHas('user', function($query) use ($value) {
    //             $query->where('name', 'like', '%'.$value.'%')
    //                   ->orWhere('email', 'like', '%'.$value.'%')
    //                   ->orWhere('member_number', 'like', '%'.$value.'%');
    //         })
    //         ->get()
    //         ->map(function($tree) {
    //             return [
    //                 'id' => $tree->user_id,
    //                 'name' => $tree->user->name,
    //                 'member_number' => $tree->user->member_number,
    //                 'email' => $tree->user->email,
    //                 'phone' => $tree->user->phone
    //             ];
    //         });
    
    //     return apiResponse(true, 'Search Results of '.$request->input('query'), ['results' => $searchResults], 200);
    // }

    public function member_search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', $validator->errors(), 422);
        }

        if (strlen($request->input('query')) < 2) {
            return apiResponse(false, 'Search query must be at least 2 characters long.', null, 200);
        }

        $value = $request->input('query'); 

        // Get logged in user
        $user = User::find($request->user()->id);

        if (!$user || !$user->binaryTreeNode) {
            return apiResponse(false, 'No binary tree data found.', [], 404);
        }

        // Get all members (left + right) under this user
        $leader = $user->binaryTreeNode;
        $leftMembers  = $leader->leftUsers ?? collect();
        $rightMembers = $leader->rightUsers ?? collect();

        $allMembersCollection = $leftMembers->merge($rightMembers);

        // Search inside this collection only
        $searchResults = $allMembersCollection->filter(function ($member) use ($value) {
            return str_contains(strtolower($member->user->name), strtolower($value))
                // || str_contains(strtolower($member->user->email), strtolower($value))
                || str_contains(strtolower($member->member_number), strtolower($value));
        })->map(function ($member) {
            return [
                'id' => $member->user->id,
                'name' => $member->user->name,
                'member_number' => $member->member_number,
                // 'email' => $member->user->email,
                'phone' => $member->user->phone
            ];
        })->values();

        return apiResponse(true, 'Search Results of '.$request->input('query'), ['results' => $searchResults], 200);
    }

    public function level_member_search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', $validator->errors(), 422);
        }

        if (strlen($request->input('query')) < 2) {
            return apiResponse(false, 'Search query must be at least 2 characters long.', null, 200);
        }

        $value = strtolower($request->input('query'));

        // Get logged in user
        $user = User::find($request->user()->id);

        if (!$user || !$user->binaryTreeNode) {
            return apiResponse(false, 'No binary tree data found.', [], 404);
        }

        $rootNode = $user->binaryTreeNode;

        // Collect all members up to 40 levels
        $levels = [];
        $total_members = 0;
        $this->buildSponsorLevelNodes($rootNode->id, $levels, 0, 40, $total_members);

        // Flatten all members into a single collection
        $allMembers = collect();
        foreach ($levels as $nodes) {
            foreach ($nodes as $node) {
                $allMembers->push($node); // here $node is an ARRAY
            }
        }

        // return $allMembers;

        // Search inside this collection
        $searchResults = $allMembers->map(function ($member) {
            return (array)$member; // convert object -> array
            })->filter(function ($member) use ($value) {
                return str_contains(strtolower($member['user']->name), $value)
                    || str_contains(strtolower($member['member_number']), $value);
            })->map(function ($member) {
                return [
                    'id'            => $member['user_id'],
                    'name'          => $member['user']->name,
                    'member_number' => $member['member_number'],
                    // 'phone'         => $member['user']->phone ?? null,
                ];
            })->values();


        return apiResponse(true, 'Search Results of '.$request->input('query'), [
            'results' => $searchResults
        ], 200);
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

    public function get_user_details_on_tree(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric|exists:users,id',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', $validator->errors(), 422);
        }

        $user = User::find($request->user_id);
        $leader = $user->binaryTreeNode;
        $data = [
            'name' => $user->name,
            'left' => [
                'sponsor_id' => $user->sponsor->member_number ?? '',
                'joining_date' => formated_date($user->created_at),
                'register_left' => $user->binaryNode?->leftUsers->where('status', 0)->count() ?? 0,
                'activated_left' => $user->binaryNode?->leftUsers->where('status', 1)->count() ?? 0,
                'total_left' => count($user->binaryNode?->leftUsers) ?? 0,
                'total_user' => (count($user->binaryNode?->leftUsers) + count($user->binaryNode?->rightUsers)) ?? 0,
                'left_business' => $leader->calculateLeftBusiness()
            ],
            'right' => [
                'rank' => $user->rank ?? 'N/A',
                'confirm_date' => $user->binaryNode?->activated_at ? formated_date($user->binaryNode?->activated_at) : 'N/A',
                'register_right' => $user->binaryNode?->rightUsers->where('status', 0)->count() ?? 0,
                'activated_right' => $user->binaryNode?->rightUsers->where('status', 1)->count() ?? 0,
                'total_right' => count($user->binaryNode?->rightUsers) ?? 0,
                'right_business' => $leader->calculateRightBusiness()

            ]
        ];

        return apiResponse(true, 'User Details', $data, 200);
    }

    /*public function getTreeLevels(Request $request, $maxLevels = 40)
    //  public function getTreeLevels($rootId = null, $maxLevels = 4, Request $request)
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
        
        $rootId = $request->user()->id;
        // return $rootId;

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

        // Convert the level data to array of objects
        $formattedLevels = [];
        foreach ($levelData as $level => $nodes) {
            $formattedLevels[] = (object)[
                'level' => $level + 1, // Level numbers start at 1
                'nodes' => array_map(function($node) {
                    return (object)$node;
                }, $nodes)
            ];
            
            if ($level + 1 >= 40) {
                break;
            }
        }

        return response()->json([
            'root' => $rootId,
            'levels' => $formattedLevels
        ]);
    }*/

    /*protected function collectLevelData($node, $currentLevel, $maxLevels, $withClosure, &$levelData)
    {
        if (!$node) return;

        if (!isset($levelData[$currentLevel])) {
            $levelData[$currentLevel] = [];
        }
        
        // if($maxLevels > $currentLevel) return;

        $formattedNode = [
            'user_id' => $node->user_id,
            'member_number' => $node->member_number,
            'status' => $node->status,
            'position' => $node->position,
            'user' => $node->user ? (object)[
                'id' => $node->user->id,
                'name' => $node->user->name,
                'profile_image' => $node->user->getFirstMediaUrl('profile-image'),
                'register_left' => $node->user->register_left ?? 0,
                'register_right' => $node->user->register_right ?? 0,
                'activated_left' => $node->user->activated_left ?? 0,
                'activated_right' => $node->user->activated_right ?? 0,
            ] : null
        ];

        $levelData[$currentLevel][] = $formattedNode;

        $node->load([
            'left.user' => $withClosure,
            'right.user' => $withClosure,
        ]);

        if ($node->left) {
            $this->collectLevelData($node->left, $currentLevel + 1, $maxLevels, $withClosure, $levelData);
        }
        if ($node->right) {
            $this->collectLevelData($node->right, $currentLevel + 1, $maxLevels, $withClosure, $levelData);
        }
    }*/
    
    /*public function getTreeLevels(Request $request, $maxLevels = 40)
    {
        $rootUser = $request->user(); // Root user
    
        if (!$rootUser) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
    
        $levels = [];         // Store level-wise data
        $total_members = 0;   // Total downline count
        
        
        $root = BinaryTree::where('user_id', $rootUser->id)->first();
    
        // Start building levels
        $this->buildSponsorLevels($root->id, $levels, 1, $maxLevels, $total_members);
    
        // Format for API response
        $level_response = [];
        foreach ($levels as $level => $members) {
            $level_response[] = [
                'level' => $level,
                'customers' => array_map(function ($member) {
                    return [
                        // 'reg_date'   => optional($member->created_at)->format('d-m-Y'),
                        'id'         => $member['user_id'], // Assuming user_id is unique code
                        'member_number'       => $member['member_number'],
                        'position'   => $member['position'], // If needed
                        'sponsor_id' => $member['sponsor_id'], // Direct sponsor
                        'status'     => $member['status'],
                    ];
                }, $members)
            ];
        }
    
        return response()->json([
            'success' => true,
            'total_members' => $total_members,
            'levels' => $level_response
        ]);
    }*/
    
    
    
    /*protected function buildSponsorLevels($leaderId, &$levels, $level, $maxLevels, &$total_members)
    {
        if ($level > $maxLevels) return;
    
        // Get all direct members (where sponsor_id = leaderId)
        $directMembers = BinaryTree::where('sponsor_id', $leaderId)
            ->with('user')
            ->get()
            // ->pluck('user')
            ->filter(); // Remove null users
    
        if ($directMembers->isEmpty()) return;
    
        // Add current level members
        $levels[$level] = $directMembers->toArray();
        $total_members += $directMembers->count();
    
        // Recurse for each direct member
        foreach ($directMembers as $member) {
            $this->buildSponsorLevels($member->id, $levels, $level + 1, $maxLevels, $total_members);
        }
    }*/
    
    
    /* main code */
    /*public function getTreeLevels(Request $request, $maxLevels = 40)
    {
        $rootUser = $request->user();

        if (!$rootUser) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $levels = [];         // Store level-wise data
        $total_members = 0;   // Total downline count

        $root = BinaryTree::where('user_id', $rootUser->id)
            ->with(['user'])
            ->first();

        if (!$root) {
            return response()->json([
                'success' => false,
                'message' => 'Tree not found'
            ], 404);
        }

        // Build levels using sponsor relationship
        $this->buildSponsorLevelNodes($root->id, $levels, 0, $maxLevels, $total_members);

        // Format levels into array of objects (like old API)
        $formattedLevels = [];
        foreach ($levels as $level => $nodes) {
            $formattedLevels[] = (object)[
                'level' => $level + 1, // Level numbers start at 1
                'nodes' => array_map(function ($node) {
                    return (object)$node;
                }, $nodes)
            ];

            if ($level + 1 >= $maxLevels) {
                break;
            }
        }

        return response()->json([
            'root' => $rootUser->id,
            'levels' => $formattedLevels
        ]);
    }

    protected function buildSponsorLevelNodes($leaderId, &$levels, $currentLevel, $maxLevels, &$total_members)
    {
        if ($currentLevel >= $maxLevels) return;

        // Get direct referrals
        $directMembers = BinaryTree::where('sponsor_id', $leaderId)
            ->with(['user'])
            ->get();

        if ($directMembers->isEmpty()) return;

        foreach ($directMembers as $memberNode) {
            $user = $memberNode->user;

            if ($user) {
                $formattedNode = [
                    'user_id'         => $user->id,
                    'member_number'   => $memberNode->member_number,
                    'status'          => $memberNode->status,
                    'position'        => $memberNode->position,
                    'sponsor_id'      => $memberNode->sponsor?->member_number,
                    'register_date'   => formated_date($user->created_at),
                    'total_business'  => TopUp::where('user_id',$user->id)->where('is_show_on_business',1)->sum('total_amount'),
                    'user' => (object)[
                        'id'               => $user->id,
                        'name'             => $user->name,
                        'profile_image'    => $user->getFirstMediaUrl('profile-image'),
                        'register_left'    => $user->leftUsers()->count(),
                        'register_right'   => $user->rightUsers()->count(),
                        'activated_left'   => $user->leftUsers()->where('status', 1)->count(),
                        'activated_right'  => $user->rightUsers()->where('status', 1)->count(),
                    ]
                ];

                $levels[$currentLevel][] = $formattedNode;
                $total_members++;
            }

            // Recurse into this member’s direct referrals
            $this->buildSponsorLevelNodes($memberNode->id, $levels, $currentLevel + 1, $maxLevels, $total_members);
        }
    }*/




    /* optimal test code */
    public function getTreeLevels(Request $request, $maxLevels = 40)
    {
        $rootUser = $request->user();

        if (!$rootUser) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        $levels = [];         // Store level-wise data
        $total_members = 0;   // Total downline count

        $root = BinaryTree::where('user_id', $rootUser->id)
            ->with(['user'])
            ->first();

        if (!$root) {
            return response()->json([
                'success' => false,
                'message' => 'Tree not found'
            ], 404);
        }

        // Get parameters for pagination
        $startLevel = $request->get('start_level', 0); // Start from level (0-based)
        $levelsCount = $request->get('levels_count', 2); // Number of levels to load
        $endLevel = min($startLevel + $levelsCount - 1, $maxLevels - 1);

        // Build only requested levels
        $this->buildSponsorLevelNodes($root->id, $levels, $startLevel, $endLevel, $total_members);

        // Format levels into array of objects (like old API)
        $formattedLevels = [];
        foreach ($levels as $level => $nodes) {
            if ($level >= $startLevel && $level <= $endLevel) {
                $formattedLevels[] = (object)[
                    'level' => $level + 1, // Level numbers start at 1
                    'nodes' => array_map(function ($node) {
                        return (object)$node;
                    }, $nodes)
                ];
            }
        }

        return response()->json([
            'root' => $rootUser->id,
            'levels' => $formattedLevels,
            'pagination' => [
                'start_level' => $startLevel + 1,
                'end_level' => $endLevel + 1,
                'levels_count' => $levelsCount,
                'has_more' => ($endLevel + 1) < $maxLevels,
                'next_start_level' => $endLevel + 1
            ]
        ]);
    }

    protected function buildSponsorLevelNodes($leaderId, &$levels, $currentLevel, $maxLevel, &$total_members)
    {
        if ($currentLevel > $maxLevel) return;

        // Get direct referrals with pagination for large levels
        $directMembers = BinaryTree::where('sponsor_id', $leaderId)
            ->with(['user', 'sponsor'])
            ->get();

        if ($directMembers->isEmpty()) return;

        foreach ($directMembers as $memberNode) {
            $user = $memberNode->user;

            if ($user) {
                $formattedNode = [
                    'user_id'         => $user->id,
                    'member_number'   => $memberNode->member_number,
                    'status'          => $memberNode->status,
                    'position'        => $memberNode->position,
                    'sponsor_id'      => $memberNode->sponsor?->member_number,
                    'register_date'   => formated_date($user->created_at),
                    'total_business'  => TopUp::where('user_id',$user->id)->where('is_show_on_business',1)->sum('total_amount'),
                    'user' => (object)[
                        'id'               => $user->id,
                        'name'             => $user->name,
                        'profile_image'    => $user->getFirstMediaUrl('profile-image'),
                        'register_left'    => $user->leftUsers()->count(),
                        'register_right'   => $user->rightUsers()->count(),
                        'activated_left'   => $user->leftUsers()->where('status', 1)->count(),
                        'activated_right'  => $user->rightUsers()->where('status', 1)->count(),
                    ]
                ];

                $levels[$currentLevel][] = $formattedNode;
                $total_members++;
            }

            // Recurse into this member's direct referrals for next levels
            if ($currentLevel < $maxLevel) {
                $this->buildSponsorLevelNodes($memberNode->id, $levels, $currentLevel + 1, $maxLevel, $total_members);
            }
        }
    }
}