<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class RemunerationBenefitMaster extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'rank_name',
        'matching_target',
        'bonus',
        'month_validity',
        'is_visible',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('remuneration-benefit-master');
    }

    public function salaryBonuses()
    {
        return $this->hasMany(SalaryBonus::class);
    }
}
 