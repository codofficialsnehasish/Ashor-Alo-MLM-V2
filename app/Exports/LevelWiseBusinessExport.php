<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LevelWiseBusinessExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $data;
    protected $title;

    public function __construct($data, $title)
    {
        $this->data = collect($data);
        $this->title = $title;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Level',
            'User ID',
            'Name',
            'Phone',
            'Registration Date',
            'Position',
            'Sponsor ID',
            'Status',
            'Amount'
        ];
    }

    public function title(): string
    {
        return 'Level Wise Business';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
            
            // Style the last row (total) as bold with background color
            count($this->data) => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFD9D9D9'],
                ],
            ],
        ];
    }
}