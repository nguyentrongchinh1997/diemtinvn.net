<?php

namespace app\Services\client;

use App\Model\Category;
use App\Model\Post;
use App\Model\SubCategory;
use App\Model\NewsDay;

class CategoryService
{
	protected $category, $post, $subCategory, $newsDay;

	public function __construct(Category $category, Post $post, SubCategory $subCategory, NewsDay $newsDay)
	{
		$this->category = $category;
		$this->post = $post;
		$this->subCategory = $subCategory;
		$this->newsDay = $newsDay;
	}

	public function category($slug)
	{
		$listId = array();
		$category = $this->category->where('slug', $slug)->first();

		if (isset($category)) {
			$categoryId = $category->id;
			
			if (count($category->subCategory) > 2) {
				$limit = 2;
			} else {
				$limit = 1;
			}
			$subCate = $this->subCategory->where('category_id', $categoryId)->get()->random($limit);
// 			$postSlide = $this->post->where('category_id', $categoryId)
// 									->latest('date')
// 									->first();
// 			$postTop = $this->post->where('category_id', $categoryId)
// 								  ->latest('date')
// 								  ->offset(1)
// 								  ->limit(6)
// 								  ->get();

// 			if (isset($postTop) && count($postTop) > 3) {
				// $postList = $this->post->where('category_id', $categoryId)
				// 				   ->latest('date')
				// 				   ->where('date', '<', $postTop[5]->date)
				// 				   ->paginate(27);
			    $postList = $this->post->where('category_id', $categoryId)
								   ->latest('date')
								   ->paginate(27);
// 			} else {
// 				$postList = array();
// 			}
// 			$listId = $this->getId($postSlide, $postTop, $postList);

			return [
				'subCate' => $subCate,
				'postList' => $postList,
				// 'postTop' => $postTop,
				// 'postSlide' => $postSlide,
				'category' => $category,
				'listId' => $listId,
			];
		} else {
			return NULL;
		}
	}

	public function newsToday()
	{
		$date = date('Y-m-d');
		$post = $this->newsDay->where('date', $date)->first();

		return [
			'post' => $post,
			'date' => $date,
		];
	}

	public function newsDay($date)
	{
		$post = $this->newsDay->where('date', $date)->first();

		return [
			'post' => $post,
			'dateFormat' => date('d/m/Y', strtotime($date)),
			'date' => $date,
		];
	}

	public function news()
	{
		$posts = $this->newsDay->latest('date')->paginate(5);

		return [
			'posts' => $posts
		];
	}

	public function getId($postSlide, $postTop, $postList)
	{
		$listId = array();
		$listId[] = $postSlide->id;

		foreach ($postTop as $post) {
			$listId[] = $post->id;
		}

		if (count($postList) > 0) {
			foreach ($postList as $post) {
				$listId[] = $post->id;
			}
		}

		return $listId;
	}

	public function subCategory($subCategory)
	{
		$listId = array();
		$subCategory = $this->subCategory->where('slug', $subCategory)->first();

		if (isset($subCategory)) {
			$subCategoryId = $subCategory->id;

			if (count($subCategory->category->subCategory) > 2) {
				$limit = 2;
			} else {
				$limit = 1;
			}
			$cateChild = $this->subCategory->where('category_id', $subCategory->category->id)
										 ->where('id', '!=', $subCategoryId)
										 ->get()->random($limit);
// 			$postSlide = $this->post->where('sub_category_id', $subCategoryId)
// 									->latest('date')
// 									->first();
// 			$postTop = $this->post->where('sub_category_id', $subCategoryId)
// 								  ->latest('date')
// 								  ->offset(1)
// 								  ->limit(6)
// 								  ->get();
// 			if (isset($postTop) && count($postTop) > 3) {
// 				$postList = $this->post->where('sub_category_id', $subCategoryId)
// 								   ->latest('date')
// 								   ->where('date', '<', $postTop[5]->date)
// 								   ->paginate(27);
				$postList = $this->post->where('sub_category_id', $subCategoryId)
								   ->latest('date')
								   ->paginate(27);
// 			} else {
// 				$postList = array();
// 			}

// 			$listId = $this->getId($postSlide, $postTop, $postList);

			return [
				'cateChild' => $cateChild,
				'listId' => $listId,
				'postList' => $postList,
				// 'postTop' => $postTop,
				// 'postSlide' => $postSlide,
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
