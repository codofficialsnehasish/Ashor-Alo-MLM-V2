<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InvestorReturnReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Name',
            'ID',
            'Amount',
            'Total Installment',
            'Installment Amount Per Month',
            'Paid Installment',
            'Paid Amount',
            'Due Paid',
            'Start Date'
        ];
    }

    public function map($sale): array
    {
        return [
            $sale->user->name ?? 'N/A',
            $sale->binaryNode->member_number ?? '',
            $sale->total_amount,
            $sale->total_installment_month,
            $sale->installment_amount_per_month,
            $sale->month_count,
            $sale->total_disbursed_amount,
            abs($sale->total_paying_amount - $sale->total_disbursed_amount),
            $sale->start_date
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
            
            // Apply currency format to amount column
            'D' => ['numberFormat' => ['formatCode' => '#,##0.00']],
        ];
    }
}