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
        'product_type', // 'simple', 'variable', 'combo'
        'manages_variations',
        'price',
        'discount_rate',
        'no_discount',
        'discounted_price',
        'gst_rate',
        'gst_amount',
        'total_price',
        'stock',
        'is_visible',
        'is_bestseller',
        'short_desc',
        'description',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'combo_price', // Added for combo products
    ];

    /**
     * Relationship: Product belongs to a Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function comboItems()
    {
        return $this->hasMany(ComboItem::class, 'combo_id');
    }

    public function includedInCombos()
    {
        return $this->hasMany(ComboItem::class, 'product_id');
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
