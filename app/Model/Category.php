<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';
	
    protected $fillable = [
        'name',
        'slug',
    ];

    public function subCategory()
    {
    	return $this->hasMany(SubCategory::class);
    }

    public function post()
    {
        return $this->hasManyThrough(Post::class, SubCategory::class);
    }
}
