<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MlmSetting extends Model
{
    use LogsActivity;

    protected $fillable = [
        'minimum_purchase_amount',
        'agent_direct_bonus',
        'tds',
        'repurchase',
        'service_charge',
        'add_on_percentage',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('mlm-setting');
    }
}
