<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BinaryTree;
use App\Models\TopUp;
use App\Models\BankDetail;
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
            $data['top_ups'] = TopUp::whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->where('user_id',$request->user()->id)->get();
        }else{
            $data['top_ups'] = TopUp::where('user_id',$request->user()->id)->get();
        }

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
}