<?php

namespace App\Livewire\Report;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TopUp;
use Excel;
use PDF;
use App\Exports\SalesReportExport;

class InvestorReturnReport extends Component
{
    public function render()
    {
        return view('livewire.report.investor-return-report');
    }
}
