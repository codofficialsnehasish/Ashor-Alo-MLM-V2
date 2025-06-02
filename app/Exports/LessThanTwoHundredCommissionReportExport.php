<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LessThanTwoHundredCommissionReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
            'Total Hold Wallet Amount',
            'Total Hold Amount',
            'Payout Date',
            'Account Name (As Per Bank)',
            'Bank Name',
            'Account Number',
            'IFSC',
            'Account Type',
            'UPI Type',
            'UPI Number',
            'UPI Name',
        ];
    }

    public function map($item): array
    {
        return [
            $item->user?->name ?? 'N/A',
            $item->user?->member_number ?? 'N/A',
            $item->hold_wallet,
            $item->hold_amount,
            formated_date($item->start_date) .'-'. formated_date($item->end_date),
            $item->user?->bankDetails?->account_name ?? '',
            $item->user?->bankDetails?->bank_name ?? '',
            (string) $item->user?->bankDetails?->account_number ?? '',
            $item->user?->bankDetails?->ifsc_code ?? '',
            $item->user?->bankDetails?->account_type ?? '',
            $item->user?->bankDetails?->upi_type ?? '',
            $item->user?->bankDetails?->upi_number ?? '',
            $item->user?->bankDetails?->upi_name ?? '',
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