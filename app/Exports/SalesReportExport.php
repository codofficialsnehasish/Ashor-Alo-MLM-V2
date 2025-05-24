<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
            'ID',
            'Name',
            'Amount',
            'Category',
            'Payment Mode',
            'Date',
            'Entry By'
        ];
    }

    public function map($sale): array
    {
        return [
            $sale->binaryNode->member_number,
            $sale->user->name ?? 'N/A',
            $sale->total_amount,
            $sale->order?->category?->name ?? 'N/A',
            $sale->order?->payment_method,
            $sale->start_date,
            $sale->order->placed_by
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