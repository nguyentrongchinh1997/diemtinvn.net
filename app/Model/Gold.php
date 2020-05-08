<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Gold extends Model
{
    protected $table = 'golds';

    protected $fillable = [
        'type',
        'buy',
        'sell',
    ];
}
