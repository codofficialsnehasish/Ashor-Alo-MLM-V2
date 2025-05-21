<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AccountTransaction extends Model
{
    use LogsActivity;
    
    protected $fillable = [
        'user_id',
        'amount',
        'which_for',
        'status',
        'generated_against_user_id',
        'topup_id',
    ];

    protected $casts = [
        'status' => 'boolean',
        'amount' => 'decimal:2',
    ];

    /**
     * Get the user associated with the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user against whom this transaction was generated.
     */
    public function generatedAgainstUser()
    {
        return $this->belongsTo(User::class, 'generated_against_user_id');
    }

    /**
     * Get the topup associated with the transaction.
     */
    public function topup()
    {
        return $this->belongsTo(TopUp::class, 'topup_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('account-transaction');
    }
}
