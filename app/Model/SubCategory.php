<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
   	protected $table = 'sub_categories';
	
    protected $fillable = [
        'name',
        'slug',
        'category_id'
    ];

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }

    public function post()
    {
        return $this->hasMany(Post::class);
    }
}
