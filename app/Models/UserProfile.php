<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class UserProfile extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id',
        'father_or_husband_name',
        'date_of_birth',
        'gender',
        'marital_status',
        'qualification',
        'occupation',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('user-profile');
    }

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Nominee
    public function nominee()
    {
        return $this->hasOne(Nominee::class);
    }

    // Relationship with BankDetails
    public function bankDetails()
    {
        return $this->hasOne(BankDetail::class);
    }

    // Relationship with Address
    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
