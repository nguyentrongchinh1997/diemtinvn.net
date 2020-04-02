<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\admin\CategoryService;

class CategoryController extends Controller
{
	protected $category;

	public function __construct(CategoryService $category)
	{
		$this->category = $category;
	}

    public function list()
    {
    	return view('admin.pages.category.list', $this->category->list());
    }

    public function add(Request $request)
    {
    	$result = $this->category->add($request->all());

    	if(empty($result)) {
    		return back()->with('warring', 'Chuyên mục này đã tồn tại');
    	} else {
    		return back()->with('success', 'Thêm thành công');
    	}
    }

    public function subCategoryList()
    {
    	return view('admin.pages.category.sub_list', $this->category->subCategoryList());
    }

    public function subCategoryAdd(Request $request)
    {
    	$result = $this->category->subCategoryAdd($request->all());

    	if(empty($result)) {
    		return back()->with('warring', 'Chuyên mục này đã tồn tại');
    	} else {
    		return back()->with('success', 'Thêm thành công');
    	}
    }
}
