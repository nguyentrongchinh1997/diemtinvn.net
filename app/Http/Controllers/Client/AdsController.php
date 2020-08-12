<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post;
use Illuminate\Support\Facades\Cache;

class AdsController extends Controller
{
    public function ads()
    {
        if (Cache::has('ads')) {
			   return $newPost = Cache::get('ads');
        } else {
            $postList = Post::latest('date')->get()->random(4);
        	$data = [
        		'rand' => rand(1,9),
        		'postList' => $postList,
        	];

        	$html =  view('client.pages.ads', $data)->render();
        	Cache::put('ads', $html, 180);
        	return $html;
        	
        }
    	
    	//return response()->json($posts, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
