<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LevelBonusMaster extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'level_name',
        'level_number',
        'level_percentage',
        'is_visible',
    ];
}
