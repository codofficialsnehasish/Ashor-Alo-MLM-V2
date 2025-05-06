<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RemunerationBenefitMaster extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'rank_name',
        'matching_target',
        'bonus',
        'month_validity',
        'is_visible',
    ];
}
 