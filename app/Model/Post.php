<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
	
    protected $fillable = [
        'title',
        'slug',
        'summury',
        'content',
        'image',
        'view',
        'keyword',
        'sub_category_id',
        'category_id',
        'url_md5',
        'url_origin',
        'web',
        'web_name',
        'date',
    ];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
