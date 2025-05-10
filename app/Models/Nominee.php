<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Nominee extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id',
        'nominee_name',
        'nominee_relation',
        'nominee_dob',
        'nominee_address',
        'nominee_state_id',
        'nominee_city_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('nominee');
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
