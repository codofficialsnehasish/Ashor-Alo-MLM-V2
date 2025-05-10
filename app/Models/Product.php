<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use SoftDeletes, LogsActivity, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'sku',
        'category_id',
        'price',
        'discount_rate',
        'no_discount',
        'discounted_price',
        'gst_rate',
        'gst_amount',
        'stock',
        'is_visible',
        'is_bestseller',
        'short_desc',
        'description',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'is_provide_direct',
        'is_provide_roi',
        'is_provide_level',
    ];

    /**
     * Relationship: Product belongs to a Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('product');
    }
}
