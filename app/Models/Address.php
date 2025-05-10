<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Address extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id',
        'shipping_address',
        'country',
        'address',
        'state',
        'city',
        'pin_code',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('address');
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
