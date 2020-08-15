<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class NewsDay extends Model
{
    protected $table = 'news_day';

    protected $fillable = [
        'date',
        'description',
        'content',
    ];
}
