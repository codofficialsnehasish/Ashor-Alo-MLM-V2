<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RemunerationReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
            'Rank',
            'Target Achived',
            'Amount',
            'Month Validity',
            'Month Paid',
            'Start Date'
        ];
    }

    public function map($sale): array
    {
        return [
            $item->user->name ?? 'N/A',
            $item->user->member_number,
            $item->rank,
            $item->target,
            $item->amount,
            $item->month_validity,
            $item->month_count,
            formated_date($item->start_date),
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