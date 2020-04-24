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
		return Post::where('category_id', $categoryId)->limit(6)->get();
	}

	public static function subCategoryPost($subCateId, $listId, $limit)
	{
		return Post::where('sub_category_id', $subCateId)
					->whereNotIn('id', $listId)
					->latest('date')
					->limit($limit)
					->get();
	}
}
