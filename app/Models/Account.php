<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'tds_balance',
        'repurchase_balance',
        'service_charge_balance',
    ];
}
