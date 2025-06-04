<?php

namespace App\Exports;

use App\Models\BinaryTree;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IdActivationExport implements FromCollection, WithHeadings, WithMapping
{
    protected $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function collection()
    {
        return $this->items;
    }

    public function headings(): array
    {
        return [
            'Name',
            'Member ID',
            'Amount',
            'Activation Date',
            'Activated By'
        ];
    }

    public function map($item): array
    {
        return [
            $item->user?->name,
            $item->member_number,
            $item->joining_amount,
            $item->activated_at,
            $item->joinedBy->name ?? 'N/A',
        ];
    }
}