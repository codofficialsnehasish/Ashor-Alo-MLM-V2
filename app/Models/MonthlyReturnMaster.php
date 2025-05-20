<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MonthlyReturnMaster extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'category_id',
        // 'product_id',
        'form_amount',
        'to_amount',
        'percentage',
        'return_persentage',
        'is_visible',
    ];

    protected $casts = [
        'form_amount' => 'decimal:2',
        'to_amount' => 'decimal:2',
        'is_visible' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('monthly-return-master');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // public function product()
    // {
    //     return $this->belongsTo(Product::class, 'product_id');
    // }
}
