<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepurchaseAccount extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'which_for',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'status' => 'integer',
    ];

    /**
     * Get the user that owns the repurchase account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
