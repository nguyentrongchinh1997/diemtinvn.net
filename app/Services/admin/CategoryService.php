<?php

namespace app\Services\admin;

use App\Model\Category;
use App\Model\SubCategory;

class CategoryService
{
	protected $category, $subCategory;

	public function __construct(Category $category, SubCategory $subCategory)
	{
		$this->category = $category;
		$this->subCategory = $subCategory;
	}

	public function add($inputs)
	{
		$check = $this->category->where('slug', str_slug($inputs['name']))->first();

		if (isset($check)) {
			return NULL;
		} else {
			return $this->category->create(
				[
					'name' => $inputs['name'],
					'slug' => str_slug($inputs['name'])
				]
			);
		}
	}

	public function subCategoryAdd($inputs)
	{
		$check = $this->subCategory
					  ->where('slug', str_slug($inputs['name']))
					  ->first();

		if (isset($check)) {
			return NULL;
		} else {
			return $this->subCategory->create(
				[
					'name' => $inputs['name'],
					'slug' => str_slug($inputs['name']),
					'category_id' => $inputs['category_id'],
				]
			);
		}
	}

	public function list()
	{
		return ['categories' => $this->category->all()];
	}

	public function subCategoryList()
	{
		return [
					'subCategories' => $this->subCategory->all(),
					'categories' => $this->category->all(),
			   ];
	}
}