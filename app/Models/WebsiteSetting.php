<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class WebsiteSetting extends Model implements HasMedia
{
    use InteractsWithMedia, LogsActivity;

    protected $fillable = [
        'site_name',
        'site_description',
        'contact_email',
        'contact_number',
        'contact_address',
        'maintenance_mode',
        'maintenance_message',
        'header_scripts',
        'footer_scripts',
        'seo_meta_description',
        'seo_meta_keywords',
        'terms_and_conditions',
        'privacy_policy'
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('website-setting');
    }
}
