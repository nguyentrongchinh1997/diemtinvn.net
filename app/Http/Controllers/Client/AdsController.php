<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post;

class AdsController extends Controller
{
    public function ads()
    {
    	$postList = Post::latest('date')->get()->random(4);
    	$data = [
    		'rand' => rand(1,9),
    		'postList' => $postList,
    	];

    	return view('client.pages.ads', $data);
    	//return response()->json($posts, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
