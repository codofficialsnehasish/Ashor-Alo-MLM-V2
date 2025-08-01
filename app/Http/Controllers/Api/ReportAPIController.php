<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BinaryTree;
use App\Models\TopUp;
use App\Models\BankDetail;
use App\Models\AccountTransaction;
use App\Models\Nominee;
use App\Models\SalaryBonus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Advance;
use App\Models\AdvanceTransaction;

class ReportAPIController extends Controller
{
    public function topup_report(Request $request){
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        if(!empty($startDate) && !empty($endDate)){
            $topUps = TopUp::whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->where('user_id',$request->user()->id)->get();
        }else{
            $topUps = TopUp::where('user_id',$request->user()->id)->get();
        }

        $data['top_ups'] = $topUps->map(function ($item) {
            return [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'order_id' => $item->order_id,
                'add_on_against_order_id' => $item->add_on_against_order_id,
                'is_provide_direct' => $item->is_provide_direct,
                'is_provide_roi' => $item->is_provide_roi,
                'is_provide_level' => $item->is_provide_level,
                'is_show_on_business' => $item->is_show_on_business,
                'start_date' => $item->start_date,
                'end_date' => $item->end_date,
                'total_amount' => $item->total_amount,
                'total_paying_amount' => $item->total_paying_amount,
                'installment_amount_per_month' => $item->installment_amount_per_month,
                'installment_amount_per_day' => $item->installment_amount_per_day,
                'total_disbursed_amount' => $item->total_disbursed_amount,
                'percentage' => $item->percentage,
                'return_percentage' => $item->return_percentage,
                'total_installment_month' => $item->total_installment_month,
                'total_installment_days' => $item->total_installment_days,
                'month_count' => $item->month_count,
                'days_count' => $item->days_count,
                'is_completed' => $item->is_completed,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'deleted_at' => $item->deleted_at,
            ];
        });

        return apiResponse(true, 'Topup Report', $data, 200);
    }

    public function remuneration_report(Request $request){
        // return response()->json([  
        //     'status' => "true",
        //     'data' => SalaryBonus::leftJoin('remuneration_benefits','remuneration_benefits.id','salary_bonus.remuneration_benefit_id')
        //                             ->where('user_id',$request->user()->id)
        //                             ->get()
        // ], 200);

        $data = SalaryBonus::leftJoin('remuneration_benefit_masters','remuneration_benefit_masters.id','salary_bonuses.remuneration_benefit_id')
                                        ->where('user_id',$request->user()->id)
                                        ->get();

        // $data['remuneration_report'] = [
        //     "id"=> 5,
        //     "user_id"=> 21,
        //     "remuneration_benefit_id"=> 5,
        //     "start_date"=> "2025-05-15",
        //     "amount"=> "30000.00",
        //     "month_count"=> 1,
        //     "created_at"=> "2024-07-05T13:25:59.000000Z",
        //     "updated_at"=> "2024-10-03T12:18:41.000000Z",
        //     "rank"=> "Star 4",
        //     "target"=> "7500000.00",
        //     "bonus"=> 30000,
        //     "month_validity"=> 12,
        //     "visiblity"=> 1,
        //     "is_deleted"=> 0];
        return apiResponse(true, 'Remuneration Report', $data, 200);
    }
    
    public function daily_roi_report(Request $request){
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        if(!empty($startDate) && !empty($endDate)){
            $data['rois'] = AccountTransaction::whereIn('which_for',['ROI Daily','ROI Dailys'])->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->where('user_id',$request->user()->id)->get();
        }else{
            $data['rois'] = AccountTransaction::whereIn('which_for',['ROI Daily','ROI Dailys'])->where('user_id',$request->user()->id)->get();
        }

        return apiResponse(true, 'Daily Roi Report', $data, 200);
    }

    public function level_wise_business_report(Request $request){
        $validator = Validator::make($request->all(), [
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'position' => 'nullable|in:left,right',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', $validator->errors(), 422);
        }

        $user = $request->user();

        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $position = $request->position;

        // Reset report data
        $groupedBusiness = [];
        $totalAmount = 0;
        $totalUserCount = 0;
        $totalLeftAmount = 0;
        $totalRightAmount = 0;

        // Get the root user
        if ($user) {
            $rootNode = BinaryTree::where('user_id', $user->id)->first();
        } else {
            $rootNode = BinaryTree::whereNull('parent_id')->first();
        }

        if (!$rootNode) {
            return apiResponse(false, 'Root node not found', null, 200);
        }

        // Get all descendants with their level information
        $descendants = BinaryTree::with('user')
            ->whereDescendantOf($rootNode)
            ->defaultOrder()
            ->get()
            ->map(function ($node) use ($rootNode) {
                // $level = $node->depth - $rootNode->depth;
                $level = $node->ancestors()->whereDescendantOf($rootNode)->count();
                return [
                    'id' => $node->user_id,
                    'level' => $level,
                    'user_id' => $node->member_number,
                    'name' => optional($node->user)->name,
                    'phone' => optional($node->user)->phone,
                    'reg_date' => optional($node->user)->created_at,
                    'position' => $node->position,
                    'sponsor_id' => $node->sponsor->member_number,
                    'status' => $node->status,
                ];
            })
            ->filter()
            ->toArray();

        $buyerIds = array_column($descendants, 'id');

        $query = TopUp::whereIn('user_id', $buyerIds)
            ->where('is_show_on_business', 1);

        if ($startDate && $endDate) {
            $query->whereDate('start_date', '>=', $startDate)
                ->whereDate('start_date', '<=', $endDate);
        }

        $totalBusinesses = $query->orderBy('id', 'ASC')->get();

        $business = [];
        foreach ($totalBusinesses as $totalBusiness) {
            $matchingUser = array_filter($descendants, function ($user) use ($totalBusiness, $position) {
                if ($user['id'] != $totalBusiness->user_id) {
                    return false;
                }
                return $position ? strtolower($user['position']) === strtolower($position) : true;
            });
            
            if (!empty($matchingUser)) {
                $business[] = array_merge(current($matchingUser), [
                    'total_business' => [
                        'id' => $totalBusiness->id,
                        'user_id' => $totalBusiness->user_id,
                        'amount' => $totalBusiness->total_amount,
                        'start_date' => $totalBusiness->start_date,
                        'end_date' => $totalBusiness->end_date,
                    ],
                ]);
            }
        }

        $formattedGroupedBusiness = [];
        foreach ($business as $item) {
            $level = $item['level'];
            if (!isset($formattedGroupedBusiness[$level])) {
                $formattedGroupedBusiness[$level] = [
                    'level' => $level,
                    'total_amount' => 0,
                    'left_amount' => 0,    // New field per level
                    'right_amount' => 0,   // New field per level
                    'user_count' => 0,
                    'users' => []
                ];
            }
            
            $formattedGroupedBusiness[$level]['users'][] = $item;
            $formattedGroupedBusiness[$level]['total_amount'] += $item['total_business']['amount'];
            $formattedGroupedBusiness[$level]['user_count'] += 1;
            
            // Calculate left/right amounts
            if (strtolower($item['position']) === 'left') {
                $formattedGroupedBusiness[$level]['left_amount'] += $item['total_business']['amount'];
                $totalLeftAmount += $item['total_business']['amount'];
            } else {
                $formattedGroupedBusiness[$level]['right_amount'] += $item['total_business']['amount'];
                $totalRightAmount += $item['total_business']['amount'];
            }
            
            $totalAmount += $item['total_business']['amount'];
            $totalUserCount += 1;
        }

        // Sort by level
        ksort($formattedGroupedBusiness);
        // Reset array keys to 0-based index if needed
        $formattedGroupedBusiness = array_values($formattedGroupedBusiness);

        $title = 'Level Wise Business Report of ' . $rootNode->user?->name;

        $data = [
                    'levels' => $formattedGroupedBusiness,
                    'summary' => [
                        'total_amount' => $totalAmount,
                        'total_user_count' => $totalUserCount,
                        'left_business' => $totalLeftAmount,
                        'right_business' => $totalRightAmount,
                    ],
                    'root_user' => [
                        'id' => $rootNode->user_id,
                        'name' => $rootNode->user->name ?? 'Unknown',
                        'member_number' => $rootNode->member_number ?? null,
                    ]
                ];

        return apiResponse(true, $title, $data, 200);
    }

    public function tree_wise_business_report(Request $request){
        $validator = Validator::make($request->all(), [
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', $validator->errors(), 422);
        }

        $user = $request->user();

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        if ($user) {
            $rootNode = BinaryTree::where('user_id', $user->id)->first();
            if (!$rootNode) {
                return apiResponse(false, 'User not found in binary tree', null, 200);
            }
        } else {
            $rootNode = BinaryTree::whereNull('parent_id')->first();
            if (!$rootNode) {
                return apiResponse(false, 'Root node not found', null, 200);
            }
        }

        if ($startDate && $endDate) {
            $leftBusiness = $rootNode->calculateLeftBusiness($startDate, $endDate);
            $rightBusiness = $rootNode->calculateRightBusiness($startDate, $endDate);
        } else {
            $leftBusiness = $rootNode->calculateLeftBusiness();
            $rightBusiness = $rootNode->calculateRightBusiness();
        }

        $data = [
                    'user' => [
                        'user_name' => $rootNode->user->name,
                        'member_number' => $rootNode->user->member_number,
                        'status' => $rootNode->status,
                        'profile_image' => $rootNode->user->getFirstMediaUrl('profile-image'),
                    ],
                    'business' => [
                        'left_business' => $leftBusiness,
                        'right_business' => $rightBusiness,
                        'total_business' => $leftBusiness + $rightBusiness,
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                    ]

                ];

        return apiResponse(true, 'Tree Wise Business Report', $data, 200);
    }

    public function daily_dilse_report(Request $request){
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        if(!empty($startDate) && !empty($endDate)){
            $data['dilse'] = AccountTransaction::whereIn('which_for',['DILSE Daily'])->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->where('user_id',$request->user()->id)->get();
        }else{
            $data['dilse'] = AccountTransaction::whereIn('which_for',['DILSE Daily'])->where('user_id',$request->user()->id)->get();
        }

        return apiResponse(true, 'DILSE Daily Report', $data, 200);
    }

    public function advance_report(Request $request){
        $data = Advance::where('user_id',$request->user()->id)->get();

        return apiResponse(true, 'Advance Report', $data, 200);
    }

    public function advance_transaction_report(Request $request){
        $validator = Validator::make($request->all(), [
            'advance_id' => 'required|numeric|exists:advances,id',
        ]);

        // Return validation errors if any
        if ($validator->fails()) {
            return apiResponse(false, 'Validation Errors', ['error' => $validator->errors()], 422);
        }
        $data = AdvanceTransaction::where('user_id',$request->user()->id)->where('advance_id',$request->advance_id)->get();

        return apiResponse(true, 'Advance Transaction Report', $data, 200);
    }
}