<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Advance extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id',
        'admin_id',
        'original_amount',
        'cut_percentage',
        'due_amount',
        'balance',
        'status',
        'notes'
    ];

    protected $casts = [
        'original_amount' => 'decimal:2',
        'cut_percentage' => 'decimal:2',
        'due_amount' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('advance');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function transactions()
    {
        return $this->hasMany(AdvanceTransaction::class);
    }

    // Helper method to add credit transaction
    public function credit($amount, $description = null, $payoutId = null)
    {
        return $this->transactions()->create([
            'type' => 'credit',
            'amount' => $amount,
            'description' => $description,
            'payout_id' => $payoutId
        ]);
    }

    // Helper method to add debit transaction
    public function debit($amount, $description = null, $payoutId = null)
    {
        return $this->transactions()->create([
            'type' => 'debit',
            'amount' => $amount,
            'description' => $description,
            'payout_id' => $payoutId
        ]);
    }
}
