<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryBonus extends Model
{
    protected $fillable = [
        'user_id',
        'remuneration_benefit_id',
        'start_date',
        'amount',
        'month_count',
    ];

    protected $casts = [
        'start_date' => 'date',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the user associated with the salary bonus.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the remuneration benefit associated with the salary bonus.
     */
    public function remunerationBenefit()
    {
        return $this->belongsTo(RemunerationBenefitMaster::class);
    }
}
