<?php

namespace App\Livewire\Report;

use Livewire\Component;
use App\Models\User;
use App\Models\BinaryTree;
use Excel;
use PDF;
use App\Exports\IdActivationExport;
use Illuminate\Support\Facades\Gate;

class IdActivationReport extends Component
{
    public $title = 'ID Activation Report';
    public $startDate;
    public $endDate;
    public $activatedBy = null;
    public $items = [];
    public $admins = [];

    protected function checkPermission($permission)
    {
        if (!Gate::allows($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function mount()
    {
        $excludedRoles = ['Leader'];

        $this->admins = User::whereDoesntHave('roles', function ($query) use ($excludedRoles) {
            $query->whereIn('name', $excludedRoles);
        })->get();

        $this->loadData();
    }

    public function loadData()
    {
        $query = BinaryTree::where('status', 1);

        if ($this->startDate && $this->endDate) {
            $query->whereDate('activated_at', '>=', $this->startDate)
                  ->whereDate('activated_at', '<=', $this->endDate);
        }

        if (!empty($this->activatedBy)) {
            $query->where('join_by', $this->activatedBy);
        }

        $this->items = $query->get();
    }

    public function generateReport()
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $this->loadData();
    }

     public function exportExcel()
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $this->loadData();

        return Excel::download(new IdActivationExport($this->items), 'id-activation-report.xlsx');
    }

    public function exportPDF()
    {
        $this->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
        ]);

        $this->loadData();

        $pdf = PDF::loadView('exports.report.id-activation-pdf', [
            'title' => $this->title,
            'items' => $this->items,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            "id-activation-report-".now()->format('Y-m-d').".pdf"
        );
    }

    public function render()
    {
        $this->checkPermission('ID Activation Report');
        return view('livewire.report.id-activation-report', [
            'title' => $this->title,
            'items' => $this->items,
            'admins' => $this->admins,
        ]);
    }
}
