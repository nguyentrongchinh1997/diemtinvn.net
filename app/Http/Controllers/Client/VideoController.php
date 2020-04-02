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
    	$videoList = Video::where('id', '!=', $bestNewVideo->id)->get();
    	$data = [
    		'bestNewVideo' => $bestNewVideo,
    		'videoList' => $videoList,
    	];

    	return view('client.pages.video', $data);
    }
}
