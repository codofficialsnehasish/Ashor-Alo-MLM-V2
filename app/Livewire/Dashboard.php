<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;

use App\Models\BinaryTree;
use App\Models\TopUp;
use App\Models\Kyc;
use App\Models\User;
use App\Models\Payout;
use App\Models\TDSAccount;
use App\Models\RepurchaseAccount;
use App\Models\ServiceChargeAccount;
use App\Models\ContactUs;

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
        $data['total_payment'] = Payout::where('paid_unpaid','1')->sum('total_payout');


        $data['last_week_payment'] = Payout::select(DB::raw('SUM(total_payout) as total_payout'))
                       ->groupBy('start_date', 'end_date')
                       ->orderBy('start_date', 'desc')
                       ->first()->total_payout;
        $data['hold_amount'] = Payout::select(DB::raw('SUM(hold_amount) as hold_amount'))
                       ->groupBy('start_date', 'end_date')
                       ->orderBy('start_date', 'desc')
                       ->first()->hold_amount;
        $data['tds'] = TDSAccount::sum('amount');
        $data['repurchase_wallet'] = RepurchaseAccount::sum('amount');
        $data['service_charge'] = ServiceChargeAccount::sum('amount');
        $data['pending_kyc'] = Kyc::where('status',0)->count();
        $data['contac_us'] = ContactUs::all()->count();
        $rootNode = BinaryTree::whereNull('parent_id')->first();
        $data['current_week_business'] = $rootNode->calculateLeftBusiness() + $rootNode->calculateRightBusiness();
        return view('livewire.dashboard')->with($data);
    }
}
