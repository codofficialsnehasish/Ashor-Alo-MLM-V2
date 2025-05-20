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
}