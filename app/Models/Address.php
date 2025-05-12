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
        'country_id',
        'address',
        'state_id',
        'city_id',
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

    public function country()
    {
        return $this->belongsTo(LocationCountrie::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(LocationState::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(LocationCitie::class, 'city_id');
    }

}
