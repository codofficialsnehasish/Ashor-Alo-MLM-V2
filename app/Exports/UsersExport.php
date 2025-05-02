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
            $sponsorName = $user->binaryNode?->sponsor?->user?->name ?? '';
            $sponsorNumber = $user->binaryNode?->sponsor?->member_number ?? '';
            
            if (!empty($sponsorName) && !empty($sponsorNumber)) {
                $sponsorName .= " ($sponsorNumber)";
            }

            return [
                'Sl No.' => $user->id,
                'Reg Date' => format_datetime($user->created_at),
                'Active Date' => !empty($user->binaryNode->activated_at) ? format_datetime($user->binaryNode->activated_at) : '',
                'Name' => $user->name . '(' . $user->binaryNode->member_number . ')',
                'Position' => ucfirst($user->binaryNode->position) ?? '',
                'Mobile' => $user->phone,
                'Email' => $user->email,
                'Status' => $user->binaryNode->status == 1 ? 'Active' : 'Inactive',
                'Sponsor Name' => $sponsorName,
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
            'Email',
            'Status',
            'Sponsor Name'
        ];
    }
}