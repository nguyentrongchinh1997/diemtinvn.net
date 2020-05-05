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
        'content_soure',
        'image',
        'view',
        'keyword',
        'sub_category_id',
        'category_id',
        'url_md5',
        'url_origin',
        'web',
        'web_name',
        'status',
        'date',
    ];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
