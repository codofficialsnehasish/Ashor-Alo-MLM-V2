<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Order extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'order_number',
        'user_id',
        'price_subtotal',
        'price_gst',
        'price_shipping',
        'discounted_price',
        'price_total',
        'payment_method',
        'transaction_id',
        'payment_proof',
        'payment_status',
        'status',
        'order_status',
        'delivered_date',
        'placed_by',
        'delivered_by',
    ];

    protected $casts = [
        'price_subtotal' => 'decimal:2',
        'price_gst' => 'decimal:2',
        'price_shipping' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'price_total' => 'decimal:2',
        'delivered_date' => 'datetime',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with OrderItems
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('order');
    }
}
