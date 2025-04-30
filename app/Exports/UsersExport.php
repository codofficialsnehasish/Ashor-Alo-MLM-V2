<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users->map(function ($user) {
            return [
                'Sl No.' => $user->id,
                'Reg Date' => $user->created_at,
                'Active Date' => $user->created_at,
                'Name' => $user->name,
                'Position' => $user->binaryNode->position ?? '',
                'Mobile' => '',
                'Password' => '',
                'Email' => $user->email,
                'Status' => $user->binaryNode->status ?? '',
                'Sponsor Name' => $user->binaryNode->sponsor_id ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Sl No.',
            'Reg Date',
            'Active Date',
            'Name',
            'Position',
            'Mobile',
            'Password',
            'Email',
            'Status',
            'Sponsor Name'
        ];
    }
}