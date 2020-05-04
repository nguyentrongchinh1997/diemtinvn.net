<?php

namespace app\Services\client;

use App\Model\Post;
use App\Model\Category;

class PostService
{
	protected $post, $category;

	public function __construct(Post $post, Category $category)
	{
		$this->post = $post;
		$this->category = $category;
	}

	public function detail($request, $title)
	{
		try {
			$postId = $request->p;
			$post = $this->post->findOrFail($postId);
			$categoryId = $post->subCategory->category->id;
			$newPost = $this->post->latest()
			                      ->where('category_id', $categoryId)
			                      ->whereNotIn('id', [$postId])
			                      ->limit(10)
			                      ->get();
			$bestViewPost = $this->post->latest('view')
			                      ->where('category_id', $categoryId)
			                      ->whereNotIn('id', $this->getId($newPost))
			                      ->limit(10)
			                      ->get();
			$postSameCategory = $this->post->where('sub_category_id', $post->sub_category_id)->get()->random(9);
			$otherCategory = $this->category->all()->random(3);
			$post->increment('view');
			$idPostRelate = array();

			if ($post->keyword != '') {
				$keywords = explode(',', $post->keyword);

				foreach ($keywords as $keyword) {
					$postRelate = $this->post->latest('date')
											 ->whereNotIn('id', $idPostRelate)
											 ->where('id', '!=', $postId)
											 ->where('category_id', $categoryId)
											 ->where(function($query) use ($keyword){
											 	$query->where('keyword', 'like', '%' . $keyword . '%')
											 		  ->orWhere('title', 'like', '%' . $keyword . '%');
											 })
											 ->get();
					foreach ($postRelate as $postRelate) {
						$idPostRelate[] = $postRelate->id;
						if (count($idPostRelate) > 8) {
							break;
						}
					}
					if (count($idPostRelate) > 8) {
						break;
					}
				}
			} else {
				$keywords = [];
				$idPostRelate = [];
			}

			if (count($idPostRelate) < 8) {
				$limit = 9 - count($idPostRelate);
				$postRelateRandom = $this->post->whereNotIn('id', $idPostRelate)
											   ->where('category_id', $categoryId)
											   ->get()
											   ->random($limit);
				foreach ($postRelateRandom as $postRelate) {
					$idPostRelate[] = $postRelate->id;
				}
			}

	    	$data = [
	    	    'bestViewPost' => $bestViewPost,
	    	    'newPost' => $newPost,
	    		'keywords' => $keywords,
	    		'post' => $post,
	            'month' => date('Y-m', strtotime($post->date)),
	            'postSameCategory' => $postSameCategory,
	            'idPostRelate' => $idPostRelate,
	            'otherCategory' => $otherCategory,
	    	];

	    	return $data;
		} catch (\Exception $e) {
			return NULL;
		}
	}
	
	public function getId($posts)
	{
	    $idList = array();
	    
	    foreach ($posts as $post) {
	        $idList[] = $post->id;
	    }
	    
	    return $idList;
	}
}