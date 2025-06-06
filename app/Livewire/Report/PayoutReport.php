<?php

namespace App\Livewire\Report;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\User;
use App\Models\Payout;
use Illuminate\Support\Facades\DB;
use Excel;
use PDF;
use App\Exports\PayoutFullReportExport;
use Illuminate\Support\Facades\Gate;

class PayoutReport extends Component
{
    use WithPagination;

    public $title = 'Payout Report';
    public $startDate;
    public $endDate;
    public $search = '';
    public $perPage = 10;
    public $showFullReport = false;
    public $showPayoutStatement = false;
    public $fullStartDate;
    public $fullEndDate;
    public $showStatusModal = false;
    public $selectedItemId;
    public $paymentDate;
    public $paymentMode = 'Cash';
    public $paymentUpdated = false;

    protected function checkPermission($permission)
    {
        if (!Gate::allows($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }

    protected $queryString = [
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'showFullReport' => ['except' => false],
    ];

    protected $rules = [
        'selectedItemId' => 'required|numeric',
        'paymentDate' => 'required|date',
        'paymentMode' => 'required|in:Cash,NEFT,UPI',
    ];

    public function mount()
    {
        // $this->startDate = now()->startOfMonth()->format('Y-m-d');
        // $this->endDate = now()->endOfMonth()->format('Y-m-d');
        $this->paymentDate = now()->format('Y-m-d');
    }

    public function openStatusModal($itemId)
    {
        $this->selectedItemId = $itemId;
        $this->showStatusModal = true;
    }

    public function handleCheckboxClick($itemId, $isCurrentlyChecked)
    {
        $this->selectedItemId = $itemId;
        // dd($isCurrentlyChecked);
        if (!$isCurrentlyChecked) {
            // Open modal if currently unchecked
            $this->showStatusModal = true;
        } else {
            // Dispatch browser event for confirmation if currently checked
            // $this->dispatch('confirm-uncheck', ['itemId' => $itemId]);
            $this->js(<<<'JS'
                if (confirm('Are you sure you want to mark this as unpaid?')) {
                    $wire.uncheckItem();
                }else{
                    document.querySelector(`input[wire\\:click="handleCheckboxClick(${$wire.selectedItemId}, true)"]`).checked = true;
                }
            JS);
        }
    }

    public function uncheckItem()
    {
        $payout = Payout::find($this->selectedItemId);
        
        if ($payout) {

            $payout->paid_unpaid = '0';
            $payout->paid_date = null;
            $payout->paid_mode = null;
            $payout->update();
            
            $this->showStatusModal = false;
            $this->dispatch('toastMessage', json_encode([
                'type'=>'success',
                'message' => 'Unchecked successfully.'
            ]));
        }
    }

    public function updatePaymentStatus()
    {
        // dd('hello world');
        // $this->validate();
        
        $payout = Payout::find($this->selectedItemId);
        
        if ($payout) {

            $payout->paid_unpaid = '1';
            $payout->paid_date = $this->paymentDate;
            $payout->paid_mode = $this->paymentMode;
            $payout->update();
            
            $this->showStatusModal = false;
            $this->dispatch('toastMessage', json_encode([
                'type'=>'success',
                'message' => 'Payment status updated successfully.'
            ]));
        }
    }

    public function closeStatusModal()
    {
        $this->showStatusModal = false;
        $this->resetValidation();
    }

    public function showFullDetails($start_date, $end_date)
    {
        $this->fullStartDate = $start_date;
        $this->fullEndDate = $end_date;
        $this->showFullReport = true;
    }

    public function payout_statement($id)
    {
        $this->selectedItemId = $id;
        $this->showPayoutStatement = true;
    }


    public function backToSummary()
    {
        $this->showFullReport = false;
    }

    protected function getQuery()
    {
        return Payout::select(
                    'start_date',
                    'end_date',
                    DB::raw('SUM(total_payout) as total_payout'),
                    DB::raw('COUNT(DISTINCT user_id) as total_user_count')
                )
                ->groupBy('start_date', 'end_date')
                ->orderBy('start_date', 'desc');
    }

    protected function getFullDetailsQuery()
    {
        $query = Payout::with(['user' => function($q) {
                    $q->select('id', 'name', 'email', 'phone');
                }, 'user.bankDetails'])
                ->whereDate('start_date', $this->fullStartDate)
                ->whereDate('end_date', $this->fullEndDate)
                ->where('total_payout', '>', 0)
                ->whereHas('user', function ($query) {
                    $query->where('is_block', 0)
                    ->whereHas('kyc', function ($kycQuery) {
                        $kycQuery->where('status', 1);
                    });
                });

        // Add search functionality
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->whereHas('user', function($userQuery) {
                    $userQuery->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%')
                    ->orWhere('phone', 'like', '%'.$this->search.'%');
                })
                ->orWhereHas('user.binaryNode', function ($q3) {
                    $q3->where('member_number', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('user.bankDetails', function($bankQuery) {
                    $bankQuery->where('account_name', 'like', '%'.$this->search.'%')
                    ->orWhere('bank_name', 'like', '%'.$this->search.'%')
                    ->orWhere('account_number', 'like', '%'.$this->search.'%')
                    ->orWhere('ifsc_code', 'like', '%'.$this->search.'%')
                    ->orWhere('account_type', 'like', '%'.$this->search.'%')
                    ->orWhere('upi_type', 'like', '%'.$this->search.'%')
                    ->orWhere('upi_number', 'like', '%'.$this->search.'%')
                    ->orWhere('upi_name', 'like', '%'.$this->search.'%');
                })
                ->orWhere('total_payout', 'like', '%'.$this->search.'%');
            });
        }

        // Order by user name ascending
        $query->join('users', 'payouts.user_id', '=', 'users.id')
            ->orderBy('users.name', 'asc')
            ->select('payouts.*'); // Select all fields from payouts

        return $query;
    }

    public function exportFullExcel()
    {
        $data = $this->getFullDetailsQuery()->get();
        return Excel::download(new PayoutFullReportExport($data, $this->fullStartDate, $this->fullEndDate), 
                'payout-report-'.$this->fullStartDate.'-to-'.$this->fullEndDate.'.xlsx');
    }

    public function exportFullPDF(){
        $data = [
            'title' => $this->title,
            'items' => $this->getFullDetailsQuery()->get()
        ];

        $pdf = PDF::loadView('exports.report.payout-full-report-pdf', $data);
        return response()->streamDownload(
            fn () => print($pdf->output()),
            "payout-full-report-".now()->format('Y-m-d').".pdf"
        );
    }

    public function render()
    {
        $this->checkPermission('Payout Report');
        if($this->showPayoutStatement){
            return view('livewire.report.payout-statement', [
                'title' => 'Payout Report',
                'payout' => Payout::find($this->selectedItemId),
            ]);
        }

        if ($this->showFullReport) {
            return view('livewire.report.payout-full-report', [
                'title' => 'Payout Report',
                'items' => $this->getFullDetailsQuery()->paginate($this->perPage),
            ]);
        }

        return view('livewire.report.payout-report', [
            'title' => $this->title,
            'items' => $this->getQuery()->paginate($this->perPage),
        ]);
    }
}
