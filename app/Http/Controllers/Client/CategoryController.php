<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\client\CategoryService;

class CategoryController extends Controller
{
	protected $category;

	public function __construct(CategoryService $category)
	{
		$this->categoryService = $category;
	}

    public function category($slug)
    {
    	$category = $this->categoryService->category($slug);

    	if (!empty($category)) {
    		return view('client.pages.category', $category);
    	} else {
    		return redirect()->route('client.home');
    	}

    }

    public function subCategory($category, $subCategory)
    {
    	$subCategory = $this->categoryService->subCategory($subCategory);

    	return view('client.pages.sub_category', $subCategory);
    }

    public function newsToday()
    {
        return view('client.pages.news_today', $this->categoryService->newsToday());
    }

    public function news()
    {
        return view('client.pages.news', $this->categoryService->news());
    }

    public function newsDay($date)
    {
        return view('client.pages.news_day', $this->categoryService->newsDay($date));
    }
}
