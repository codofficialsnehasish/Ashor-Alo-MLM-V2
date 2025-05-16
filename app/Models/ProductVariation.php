<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ProductVariation extends Model
{
    use SoftDeletes, LogsActivity;
    
    protected $fillable = [
        'product_id',
        'attribute', // e.g., 'weight', 'color'
        'value',     // e.g., '500gm', 'Red'
        'price_override',
        'stock',
        'sku',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function comboItems()
    {
        return $this->hasMany(ComboItem::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('product-variation');
    }
}
