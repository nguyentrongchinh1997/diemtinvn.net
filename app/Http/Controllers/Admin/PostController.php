<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post;

class PostController extends Controller
{
    public function list()
    {
    	$posts = Post::latest('date')->paginate(10);
    	$data = [
    		'stt' => 0,
    		'posts' => $posts,
    	];

    	return view('admin.pages.posts.list', $data);
    }

    public function delete($id)
    {
    	$post = Post::findOrFail($id);
    	$link = route('client.detail', ['title' => $post->slug, 'p' => $post->id]);

    	if (file_exists(public_path('upload/thumbnails/' . $post->image))) {
    		unlink(public_path('upload/thumbnails/' . $post->image));
    	}

    	if (file_exists(public_path('upload/og_images/' . $post->image))) {
    		unlink(public_path('upload/og_images/' . $post->image));
    	}

    	$html = file_get_html($link);

    	foreach ($html->find('.bk-content .image-detail img') as $image) {
    		$file = $image->src;

    		if (file_exists(public_path($file))) {
    			unlink($file);
    		}
    	}

    	$post->delete();

    	return back()->with('thongbao', 'Xóa thành công');
    }
}
