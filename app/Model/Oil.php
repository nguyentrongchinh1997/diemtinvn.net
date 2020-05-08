<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Oil extends Model
{
    protected $table = 'oils';

    protected $fillable = [
        'oil_name',
        'price_1',
        'price_2',
        'date',
    ];
}
