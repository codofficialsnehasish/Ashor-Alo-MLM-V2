<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AdvanceDeduction extends Model
{
    protected $fillable = [
        'loan_id',
        'payout_id',
        'deducted_amount'
    ];

    protected $casts = [
        'deducted_amount' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('advance-deduction');
    }

    public function advance()
    {
        return $this->belongsTo(Advance::class);
    }

    public function payout()
    {
        return $this->belongsTo(Payout::class);
    }

}
