<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class OrderItem extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_variation_id',
        'product_title',
        'product_unit_price',
        'quantity',
        'product_gst_rate',
        'product_gst',
        'total_price',
    ];

    protected $casts = [
        'product_unit_price' => 'decimal:2',
        'product_gst_rate' => 'decimal:2',
        'product_gst' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    // Relationship with Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('order-item');
    }
}
