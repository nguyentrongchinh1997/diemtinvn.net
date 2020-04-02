<?php

namespace app\Services\client;

use App\Model\Post;
use Carbon\Carbon;
use App\Model\SubCategory;

class HomeService
{
	protected $post, $subCate;

	public function __construct(Post $post, SubCategory $subCate)
	{
		$this->post = $post;
		$this->subCate = $subCate;
	}

	public function home()
	{
		$date = date('Y-m-d');
		$postSlideHome = $this->post
						   	  ->latest('date')
						   	  ->limit(5)
						   	  ->get();
		$postRightSlide = $this->post
						   	   ->latest('date')
						   	   ->offset(5)
						   	   ->limit(2)
						   	   ->get();
		$postLatest = $this->post->latest('date')->offset(7)->limit(10)->get();
		$keywordPopular = $this->post->latest('view')->value('keyword');

		$firstPostXaHoi = $this->firstPostCategory(config('config.category.xa_hoi.xh'));
		$listPostXaHoi = $this->listPostCategory(config('config.category.xa_hoi.xh'), $firstPostXaHoi->id);

		$firstPostDoiSong = $this->firstPostCategory(config('config.category.doi_song.ds'));
		$listPostDoiSong = $this->listPostCategory(config('config.category.doi_song.ds'), $firstPostDoiSong->id);

		$fistPostKinhTe = $this->firstPostCategory(config('config.category.kinh_te.kt'));
		$listPostKinhTe = $this->listPostCategory(config('config.category.kinh_te.kt'), $fistPostKinhTe->id);

		$firstPostGiaoDuc = $this->firstPostCategory(config('config.category.giao_duc.gd'));
		$listPostGiaoDuc = $this->listPostCategory(config('config.category.giao_duc.gd'), $firstPostGiaoDuc->id);

		$subCateXaHoi = $this->subCategory(config('config.category.xa_hoi.xh'));
		$subCateDoiSong = $this->subCategory(config('config.category.doi_song.ds'));
		$subCateKinhTe = $this->subCategory(config('config.category.kinh_te.kt'));
		$subCateGiaoDuc = $this->subCategory(config('config.category.giao_duc.gd'));	 

		$data = [
			'postSlideHome' => $postSlideHome,
			'postRightSlide' => $postRightSlide,
			'postLatest' => $postLatest,
			'subCateXaHoi' => $subCateXaHoi,
			'listPostXaHoi' => $listPostXaHoi,
			'firstPostXaHoi' => $firstPostXaHoi,
			'listPostDoiSong' => $listPostDoiSong,
			'subCateDoiSong' => $subCateDoiSong,
			'firstPostDoiSong' => $firstPostDoiSong,
			'subCateKinhTe' => $subCateKinhTe,
			'fistPostKinhTe' => $fistPostKinhTe,
			'listPostKinhTe' => $listPostKinhTe,
			'subCateGiaoDuc' => $subCateGiaoDuc,
			'firstPostGiaoDuc' => $firstPostGiaoDuc,
			'listPostGiaoDuc' => $listPostGiaoDuc,
			'keywordPopular' => explode(',', $keywordPopular),
		];

		return $data;
	}

	public function subCategory($categoryId)
	{
		$subCate = $this->subCate
					    ->where('category_id', $categoryId)
					    ->get();		

		return $subCate;
	}

	public function firstPostCategory($categoryId)
	{
		return $this->post->where('category_id', $categoryId)
				    	  ->latest('date')
				    	  ->first();
	}

	public function listPostCategory($categoryId, $postId)
	{
		return $this->post->where('category_id', $categoryId)
						  ->where('id', '!=', $postId)
						  ->latest('date')
						  ->limit('4')
						  ->get();
	}
}