<?php

namespace app\Services\client;

use App\Model\Post;

class NewsSoureService
{
	protected $post;

	public function __construct(Post $post)
	{
		$this->post = $post;
	}

	public function newsSoure($web)
	{
		$posts = $this->post->where('web', $web)->paginate(40);

		if (count($posts) > 0) {
			$data = [
				'posts' => $posts,
				'key' => $posts[0]->web_name,
				'type' => 'soure',
			];

			return $data;
		} else {
			return NULL;
		}
	}

	public function keywordSearch($key)
	{
		$posts = $this->post->latest('date')
							->where('keyword', 'like', '%' . $key . '%')
							->orWhere('title', 'like', '%' . $key . '%')
							->orWhere('content', 'like', '%' . $key . '%')
							->paginate(40);

		if (count($posts) > 0) {
			$data = [
				'posts' => $posts,
				'type' => 'search',
				'key' => $key,
			];

			return $data;
		} else {
			return NULL;
		}
	}
}