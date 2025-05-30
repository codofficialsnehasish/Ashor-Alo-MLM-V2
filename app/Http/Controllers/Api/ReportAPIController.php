<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BinaryTree;
use App\Models\TopUp;
use App\Models\BankDetail;
use App\Models\AccountTransaction;
use App\Models\Nominee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        $data['remuneration_report'] = [
            "id"=> 5,
            "user_id"=> 21,
            "remuneration_benefit_id"=> 5,
            "start_date"=> "2025-05-15",
            "amount"=> "30000.00",
            "month_count"=> 1,
            "created_at"=> "2024-07-05T13:25:59.000000Z",
            "updated_at"=> "2024-10-03T12:18:41.000000Z",
            "rank"=> "Star 4",
            "target"=> "7500000.00",
            "bonus"=> 30000,
            "month_validity"=> 12,
            "visiblity"=> 1,
            "is_deleted"=> 0];
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
}