<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalaryBonus;

class RankWiseUserController extends Controller
{
    public function index()
    {
        // Fetch salary bonuses with related user & rank
        $salaryBonuses = SalaryBonus::with(['user', 'remunerationBenefit'])
            ->get();

        // return $salaryBonuses;

        // Group users by rank name
        $grouped = $salaryBonuses->groupBy(function ($item) {
            return $item->remunerationBenefit->rank_name ?? 'No Rank';
        })->map(function ($items, $rank) {
            return [
                'rank' => $rank,
                'users' => $items->map(function ($item) {
                    return [
                        'name'  => $item->user->name ?? 'N/A',
                        'image' => $item->user->getFirstMediaUrl('profile-image') ?? null, // assuming 'profile_image' column
                        'rank'  => $item->remunerationBenefit->rank_name ?? 'No Rank',
                    ];
                })->unique('name')->values(),
            ];
        })->values();

        return response()->json([
            'status' => true,
            'data' => $grouped
        ]);
    }
}
