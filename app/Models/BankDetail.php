<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BankDetail extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_name',
        'ifsc_code',
        'account_number',
        'account_type',
        'upi_name',
        'upi_number',
        'upi_type',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('bank-detail');
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
