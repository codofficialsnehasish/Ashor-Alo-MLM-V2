<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Spatie\Activitylog\Models\Activity;

use App\Models\BinaryTree;
use App\Models\TopUp;
use App\Models\Kyc;

class Dashboard extends Component
{
    public $title = "Dashboard";
    public function render()
    {
        $today = Carbon::now();
        $lastSaturday = $today->isSaturday() ? $today : $today->previous(Carbon::SATURDAY); // Get last Saturday's date
        $current_day = Carbon::now();
        
        $data['title'] = 'Dashboard';
        $data['customer_count'] = BinaryTree::all()->count();
        $data['active_count'] = BinaryTree::where('status',1)->count();
        $data['todays_business'] = TopUp::whereDate("created_at",date('Y-m-d'))->sum('total_amount');
        $data['total_business'] = TopUp::all()->sum('total_amount');
        // $data['total_payment'] = Payout::where('paid_unpaid','1')->sum('total_payout');
        // $lastFridayPayout = Payout::select(DB::raw('SUM(total_payout) as total_payout'))
        //                             ->where('paid_unpaid', 1)
        //                             ->where(DB::raw('WEEKDAY(end_date)'), 4) // Checks if the end_date is a Friday (4 = Friday in WEEKDAY)
        //                             ->orderBy('end_date', 'desc')
        //                             ->groupBy('start_date', 'end_date')
        //                             ->first();
        // $data['total_payment'] = $lastFridayPayout->total_payout + Payout::where('paid_unpaid','1')->sum('total_payout');


        // $data['last_week_payment'] = Payout::whereBetween(DB::raw('DATE(created_at)'), [format_date_for_db($lastSaturday), format_date_for_db($current_day)])->sum('total_payout');
        // $data['hold_amount'] = User::all()->sum('hold_balance');
        // $account = Account::first();
        // $data['tds'] = $account->tds_balance;
        // $data['repurchase_wallet'] = $account->repurchase_balance;
        // $data['service_charge'] = $account->service_charge_balance;
        // $data['active_customer_count'] = User::where("role","=","agent")->where('status',1)->count();
        // $data['inactive_customer_count'] = User::where("role","=","agent")->where('status',0)->count();
        // $data['lavel_count'] = Lavel_masters::all()->count();
        // $data['products_count'] = Products::all()->count();
        // $data['todays_orders'] = Orders::whereDate('created_at',date('Y-m-d'))->count();
        $data['pending_kyc'] = Kyc::where('status',0)->count();
        // $data['contac_us'] = ContactUs::all()->count();
        // $root = User::whereNull('parent_id')->where('role','agent')->first();
        // return calculate_left_current_week_business($root->id);
        // $data['current_week_business'] = calculate_left_current_week_business($root->id) + calculate_right_current_week_business($root->id);
        return view('livewire.dashboard')->with($data);
    }
}
