<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class LevelBonusMaster extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'level_name',
        'level_number',
        'level_percentage',
        'is_visible',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('level-bonus-master');
    }
}
