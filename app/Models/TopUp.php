<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TopUp extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'entry_by',
        'user_id',
        'order_id',
        'add_on_against_order_id',
        'is_provide_direct',
        'is_provide_roi',
        'is_provide_level',
        'is_show_on_business',
        'start_date',
        'end_date',
        'total_amount',
        'total_paying_amount',
        'installment_amount_per_month',
        'installment_amount_per_day',
        'total_disbursed_amount',
        'percentage',
        'return_percentage',
        'total_installment_month',
        'total_installment_days',
        'month_count',
        'days_count',
        'is_completed',
    ];

    /**
     * The user associated with the top-up.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The main order associated with the top-up.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * The add-on order associated with the top-up.
     */
    public function addOnAgainstOrder()
    {
        return $this->belongsTo(Order::class, 'add_on_against_order_id');
    }

    public function addonChildren()
    {
        return $this->hasMany(TopUp::class, 'add_on_against_order_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('top-up');
    }

    public function transactions()
    {
        return $this->hasMany(AccountTransaction::class);
    }
}
