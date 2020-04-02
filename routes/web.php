<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Client\HomeController@home')->name('client.home');

Route::get('clone', 'Client\CloneController@clone');

Route::get('video', 'Client\VideoController@list')->name('client.video');
Route::get('{nameCategory}/{title}-{id}.html', 'Client\PostController@detail')->where(array('id' => '[0-9]+', 'title' => '[a-z0-9\-]+', 'nameCategory' => '[a-z0-9\-]+'))->name('client.detail');
Route::get('tin-tuc/{soure}', 'Client\NewsSoureController@newsSoure')->name('client.news_soure');
Route::get('tim-kiem', 'Client\NewsSoureController@keywordSearch')->name('client.search');

Route::get('{category}.html', 'Client\CategoryController@category')->name('client.category');
Route::get('{category}/{subCategory}.html', 'Client\CategoryController@subCategory')->name('client.sub_cate');

Route::get('test', function(){
	$html = file_get_html('https://www.24h.com.vn/bong-da-c48.html');
	echo $html;
});

Route::group(['prefix' => 'admin'], function(){
	Route::group(['prefix' => 'category'], function(){
		Route::get('list', 'Admin\CategoryController@list')->name('admin.category.list');
		Route::post('add', 'Admin\CategoryController@add')->name('admin.category.add');
	});

	Route::group(['prefix' => 'video'], function(){
		Route::get('list', 'Admin\VideoController@list')->name('admin.video.list');
		Route::post('add', 'Admin\VideoController@add')->name('admin.video.add');
	});

	Route::group(['prefix' => 'sub-category'], function(){
		Route::get('list', 'Admin\CategoryController@subCategoryList')->name('admin.sub-category.list');
		Route::post('add', 'Admin\CategoryController@subCategoryAdd')->name('admin.sub-category.add');
	});
});

Route::get('category/add', 'Client\CloneController@createCategory');
