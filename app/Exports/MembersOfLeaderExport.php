<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MembersOfLeaderExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
            'Reg Date',
            'Name',
            'ID',
            'Phone Number',
            'Position',
            'Sponsor Name',
            'Sponsor ID',
            'Status',
            'Activated Date'
        ];
    }

    public function map($member): array
    {
        return [
            format_datetime($member->created_at),
            $member->user->name,
            $member->member_number,
            $member->user->phone,
            ucfirst($member->position),
            $member->sponsor->user->name ?? 'N/A',
            $member->sponsor->member_number,
            $member->status == 1 ? 'Active' : 'Inactive',
            $member->activated_at ? $member->activated_at : 'Not activated'
                                                    
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