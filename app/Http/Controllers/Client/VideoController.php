<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Video;

class VideoController extends Controller
{
    public function list()
    {
    	$bestNewVideo = Video::latest()->first();
    	$videoList = Video::where('id', '!=', $bestNewVideo->id)->paginate(10);
    	$data = [
    		'bestNewVideo' => $bestNewVideo,
    		'videoList' => $videoList,
    	];

    	return view('client.pages.video', $data);
    }

    public function detail($title, $id)
    {
    	$bestNewVideo = Video::findOrFail($id);
    	$videoList = Video::where('id', '!=', $bestNewVideo->id)->paginate(10);
    	$data = [
    		'bestNewVideo' => $bestNewVideo,
    		'videoList' => $videoList,
    	];

    	return view('client.pages.video', $data);
    }
}
