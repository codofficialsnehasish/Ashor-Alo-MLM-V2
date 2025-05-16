<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ComboItem extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'combo_id',
        'product_id',
        'variation_id',
        'quantity',
        'price_override',
    ];

    // Relationships
    public function combo()
    {
        return $this->belongsTo(Product::class, 'combo_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('combo-item');
    }
}
