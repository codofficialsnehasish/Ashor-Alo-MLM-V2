<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
        'tds_persentage',
        'repurchase_persentage',
        'service_charge_persentage',
        'direct_bonus',
        'direct_bonus_tds_deduction',
        'direct_bonus_repurchase_deduction',
        'lavel_bonus',
        'lavel_bonus_tds_deduction',
        'lavel_bonus_repurchase_deduction',
        'remuneration_bonus',
        'remuneration_bonus_tds_deduction',
        'remuneration_bonus_repurchase_deduction',
        'dilse_payout_amount',
        'dilse_service_charge_deduction',
        'roi',
        'roi_tds_deduction',
        'hold_amount_added',
        'hold_amount',
        'hold_wallet_added',
        'hold_wallet',
        'previous_unpaid_amount',
        'total_payout',
        'paid_unpaid',
        'paid_date',
        'paid_mode',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'paid_date' => 'date',
        'direct_bonus' => 'decimal:2',
        'direct_bonus_tds_deduction' => 'decimal:2',
        'direct_bonus_repurchase_deduction' => 'decimal:2',
        'lavel_bonus' => 'decimal:2',
        'lavel_bonus_tds_deduction' => 'decimal:2',
        'lavel_bonus_repurchase_deduction' => 'decimal:2',
        'remuneration_bonus' => 'decimal:2',
        'remuneration_bonus_tds_deduction' => 'decimal:2',
        'remuneration_bonus_repurchase_deduction' => 'decimal:2',
        'dilse_payout_amount' => 'decimal:2',
        'dilse_service_charge_deduction' => 'decimal:2',
        'roi' => 'decimal:2',
        'roi_tds_deduction' => 'decimal:2',
        'hold_amount_added' => 'decimal:2',
        'hold_amount' => 'decimal:2',
        'hold_wallet_added' => 'decimal:2',
        'hold_wallet' => 'decimal:2',
        'previous_unpaid_amount' => 'decimal:2',
        'total_payout' => 'decimal:2',
    ];

    /**
     * Get the user that owns the payout.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
