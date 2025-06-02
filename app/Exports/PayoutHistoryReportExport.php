<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PayoutHistoryReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
            'Sl. No.',
            'Name',
            'ID',
            'Total Payout Amount'
        ];
    }

    public function map($item): array
    {
        return [
            $this->getRowNumber(),
            $item->user->name ?? 'N/A',
            $item->user->member_number ?? 'N/A',
            $item->total_payout
        ];
    }
    private $rowNumber = 0;

    public function getRowNumber()
    {
        return ++$this->rowNumber;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
        ];
    }
}