<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PayoutHistoryFullReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
            'Issue Date',
            'Amount',
            'Paid Date',
            'Mode',
            'Status'
        ];
    }

    public function map($item): array
    {
        return [
            $this->getRowNumber(),
            formated_date($item->end_date,'-'),
            $item->total_payout,
            !empty($item->paid_date) ? formated_date($item->paid_date,'-') : '',
            $item->paid_mode,
            paid_unpaid($item->id, $item->user_id, false)
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