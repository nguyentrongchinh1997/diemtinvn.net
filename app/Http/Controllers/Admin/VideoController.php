<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Video;

class VideoController extends Controller
{
    public function add(Request $request)
    {
    	$inputs = $request->all();

    	Video::create([
    		'title' => $inputs['title'],
    		'slug' => str_slug($inputs['title']),
    		'description' => $inputs['description'],
    		'code' => $inputs['code'],
    		'keyword' => $inputs['keyword'],
    	]);

    	return back()->with('success', 'Thêm thành công');
    }

    public function list()
    {
    	$videos = Video::paginate(10);

    	return view('admin.pages.video.list', ['videos' => $videos, 'stt' => 0]);
    }
}
