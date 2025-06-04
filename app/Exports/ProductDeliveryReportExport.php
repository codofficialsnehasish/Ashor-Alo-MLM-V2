<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductDeliveryReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
            'Place Date',
            'Order ID',
            'Name',
            'ID',
            'Amount',
            'Category',
            'Payment Mode',
            'Payment Status',
            'Order Status',
            'Entry By',
            'Delivered At',
            'Delivered By'
        ];
    }

    public function map($item): array
    {
        return [
            format_datetime($item->created_at),
            $item->order_number,
            $item->user->name ?? 'N/A',
            $item->user->member_number,
            $item->price_total,
            $item->category?->name ?? 'N/A',
            $item->payment_method,
            $item->payment_status,
            $item->order_status,
            $item->placed_by,
            $item->status ? (!empty($item->delivered_date) ? format_datetime($item->delivered_date) : format_datetime($item->updated_at)) : null,
            $item->delivered_by ?? 'N/A',
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