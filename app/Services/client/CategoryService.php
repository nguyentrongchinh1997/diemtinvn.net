<?php

namespace app\Services\client;

use App\Model\Category;
use App\Model\Post;
use App\Model\SubCategory;

class CategoryService
{
	protected $category, $post, $subCategory;

	public function __construct(Category $category, Post $post, SubCategory $subCategory)
	{
		$this->category = $category;
		$this->post = $post;
		$this->subCategory = $subCategory;
	}

	public function category($slug)
	{
		$category = $this->category->where('slug', $slug)->first();

		if (isset($category)) {
			$categoryId = $category->id;
			$postSlides = $this->post->where('category_id', $categoryId)
									->latest('date')
									->offset(0)
									->limit(5)
									->get();
			$postTop = $this->post->where('category_id', $categoryId)
								  ->latest('date')
								  ->offset(5)
								  ->limit(4)
								  ->get();

			if (isset($postTop) && count($postTop) > 3) {
				$postList = $this->post->where('category_id', $categoryId)
								   ->latest('date')
								   ->where('date', '<', $postTop[3]->date)
								   ->paginate(20);
			} else {
				$postList = array();
			}
			//dd($postList);

			return [
				'postList' => $postList,
				'postTop' => $postTop,
				'postSlides' => $postSlides,
				'category' => $category,
			];
		} else {
			return NULL;
		}
	}

	public function subCategory($subCategory)
	{
		$subCategory = $this->subCategory->where('slug', $subCategory)->first();

		if (isset($subCategory)) {
			$subCategoryId = $subCategory->id;
			$postSlides = $this->post->where('sub_category_id', $subCategoryId)
									->latest('date')
									->offset(0)
									->limit(5)
									->get();
			$postTop = $this->post->where('sub_category_id', $subCategoryId)
								  ->latest('date')
								  ->offset(5)
								  ->limit(4)
								  ->get();
			if (isset($postTop) && count($postTop) > 3) {
				$postList = $this->post->where('sub_category_id', $subCategoryId)
								   ->latest('date')
								   ->where('date', '<', $postTop[3]->date)
								   ->paginate(20);
			} else {
				$postList = array();
			}

			return [
				'postList' => $postList,
				'postTop' => $postTop,
				'postSlides' => $postSlides,
				'subCategory' => $subCategory,
			];
		} else {
			return NULL;
		}
	}

	public function getPost($categoryId, $offset, $limit)
	{
		return $this->category->where('id', $categoryId)
							  ->with(['post' => function($query) use ($offset, $limit){
							 	$query->latest('date')->offset($offset)->limit($limit);
							  }])
							  ->first();
	}

	public function getPostPaginate($categoryId, $offset)
	{
		return $this->category->where('id', $categoryId)
							  ->with(['post' => function($query) use ($offset){
							 	$query->latest('date')->where('posts.id', '<', $offset)->paginate(5);
							  }])
							  ->first();
	}
}
