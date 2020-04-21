<?php

namespace app\Helper;

use app\Model\Post;

class Helper
{
	public static function getNews($newsId)
	{
		return Post::findOrFail($newsId);
	}

	public static function categoryPost($categoryId)
	{
		return Post::where('category_id', $categoryId)->limit(11)->get();
	}
}
