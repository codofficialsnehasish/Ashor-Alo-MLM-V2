<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DilsePlanReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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

    public function map($item): array
    {
        return [
            $item->user->name ?? 'N/A',
            $item->binaryNode->member_number,
            $item->total_amount,
            $item->total_installment_month,
            $item->installment_amount_per_month,
            $item->month_count,
            $item->total_disbursed_amount,
            abs($item->total_paying_amount - $item->total_disbursed_amount),
            $item->start_date
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
        ];
    }
}