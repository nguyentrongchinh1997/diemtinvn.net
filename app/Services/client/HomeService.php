<?php

namespace app\Services\client;

use App\Model\Post;
use Carbon\Carbon;
use App\Model\SubCategory;
use App\Model\Video;
use App\Model\GoldTyGia;
use App\Model\OilTyGia;

class HomeService
{
	protected $post, $subCate, $video, $gold, $oil;

	public function __construct(Post $post, SubCategory $subCate, Video $video, GoldTyGia $gold, OilTyGia $oil)
	{
		$this->post = $post;
		$this->subCate = $subCate;
		$this->video = $video;
		$this->gold = $gold;
		$this->oil = $oil;
	}

	public function home()
	{
		$date = date('Y-m-d');
		$golds = $this->gold->all();
		$oil = $this->oil->latest()->first();
		$oils = $this->oil->where('date', $oil->date)->get();
		$postSlideHome = $this->post
						   	  ->latest('date')
						   	  ->first();
		$postRightSlide = $this->post
						   	   ->latest('date')
						   	   ->offset(1)
						   	   ->limit(6)
						   	   ->get();
		$subCates = $this->subCate->all();
		$postLatest = $this->post->latest('date')->offset(7)->limit(15)->get();

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
		$video = $this->video->latest()->first();

		$data = [
		    'oils' => $oils,
		    'golds' => $golds,
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
			'video' => $video,
			'subCates' => $subCates,
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
						  ->limit(4)
						  ->get();
	}
}