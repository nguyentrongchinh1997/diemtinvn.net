<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post;
use App\Services\client\PostService;

class PostController extends Controller
{
    protected $post;

    public function __construct(PostService $post)
    {
        $this->post = $post;
    }

    public function detail($category, $title, $postId)
    {
    	$data = $this->post->detail($category, $title, $postId);

    	if (!empty($data)) {
    		return view('client.pages.detail', $data);
    	} else {
    		return redirect()->route('client.home');
    	}
    }
}

