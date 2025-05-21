<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Payout;

class PayoutApiController extends Controller
{
    public function all_payouts(Request $request){
        $payouts = Payout::where('user_id',$request->user()->id)->orderBy('id','desc')->get();
        return apiResponse(true, 'All Payouts', ["payouts" => $payouts], 200);
    }

    public function payout_details(Request $request,$id){
        if(Payout::where('user_id',$request->user()->id)->where('id',$id)->exists()){
            $payouts = Payout::where('user_id',$request->user()->id)->where('id',$id)->first();
            return apiResponse(true, 'Payout History', [
                                                            'statement_link' => route('payout.payout-statement.app',$id),
                                                            "payout" => $payouts
                                                        ], 200);
        }
        return apiResponse(true, 'Payout Not Found', null, 200);
    }

    public function payout_statement_app($id){
        $data['title'] = 'Payout Statement';
        $data['payout'] = Payout::where('id',$id)->first();
        return view('payout.payout_statement_app')->with($data);
    }

    public function payout_history(Request $request){
        $payout_history = Payout::where('user_id', $request->user()->id)
                ->orderBy('id', 'desc')
                ->get()
                ->map(function ($payout, $index) {
                    return [
                        'iteration' => $index + 1,
                        'end_date' => formated_date($payout->end_date, '-'),
                        'total_payout' => $payout->total_payout,
                        'paid_date' => !empty($payout->paid_date) ? formated_date($payout->paid_date, '-') : '',
                        'paid_mode' => $payout->paid_mode,
                        'paid_unpaid' => strip_tags(paid_unpaid($payout->id)),
                    ];
                });

        return apiResponse(true, 'Payout History', ["payout_history" => $payout_history], 200);
    }
}