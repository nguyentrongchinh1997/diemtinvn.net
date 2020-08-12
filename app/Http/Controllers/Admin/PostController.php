<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post;
use App\Model\Category;
use App\Model\SubCategory;
use Intervention\Image\ImageManagerStatic as Image;


class PostController extends Controller
{
    public function __construct()
    {
        $this->categories = Category::all();
        $this->subCategories = SubCategory::all();
    }

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
        $post->status = 0;
        $post->save();
    	$link = route('client.detail', ['cate' => $post->category->slug, 'sub' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]);
    	// if (file_exists(public_path('upload/thumbnails/' . $post->image))) {
    	// 	unlink(public_path('upload/thumbnails/' . $post->image));
    	// }

    	// if (file_exists(public_path('upload/og_images/' . $post->image))) {
    	// 	unlink(public_path('upload/og_images/' . $post->image));
    	// }
    	$html = file_get_html($link);

    	foreach ($html->find('.bk-content .image-detail img') as $image) {
    		$file = $image->src;

    		if (file_exists(public_path($file))) {
    			unlink($file);
    		}
    	}

    	return back()->with('thongbao', 'Xóa thành công');
    }

    public function search(Request $request)
    {
        $key = $request->key;
        $posts = Post::where('title', 'like', $key . '%')->get();
        $data = [
            'posts' => $posts,
            'stt' => 1,
        ];

        return view('admin.pages.posts.search', $data);
    }

    public function addForm()
    {
        $data = [
            'categories' => $this->categories,
            'subCategories' => $this->subCategories,
        ];

        return view('admin.pages.posts.add', $data);
    }

    public function editForm($id)
    {
        $post = Post::findOrFail($id);
        $data = [
            'post' => $post,
            'categories' => $this->categories,
            'subCategories' => $this->subCategories,
        ];

        return view('admin.pages.posts.edit', $data);
    }

    public function add(Request $request)
    {
        $inputs = $request->all();
        
        Post::create([
            'title' => $inputs['title'],
            'slug' => str_slug($inputs['title']),
            'summury' => $inputs['summury'],
            'content' => $inputs['content'],
            'content_soure' => $inputs['content'],
            'image' => $this->image($inputs['image'], $inputs['title']),
            'keyword' => $inputs['keyword'],
            'sub_category_id' => $inputs['sub_category_id'],
            'category_id' => $inputs['category_id'],
            'url_md5' => md5($inputs['url_origin']),
            'url_origin' => $inputs['url_origin'],
            'web' => $inputs['web'],
            'web_name' => $inputs['web_name'],
            'date' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('admin.post.add_form')->with('thongbao', 'Thêm tin thành công');
    }

    public function edit(Request $request, $id)
    {
        $inputs = $request->all();
        $post = Post::findOrFail($id);

        if (empty($inputs['image'])) {
            $image = $inputs['image_old'];
        } else {
            $image = $this->image($inputs['image'], $inputs['title']);

            if (file_exists(public_path('upload/thumbnails/' . $post->image))) {
                unlink(public_path('upload/thumbnails/' . $post->image));
            }

            if (file_exists(public_path('upload/og_images/' . $post->image))) {
                unlink(public_path('upload/og_images/' . $post->image));
            }
        }
        Post::updateOrCreate(
            [
                'id' => $id,
            ],
            [
                'title' => $inputs['title'],
                'slug' => str_slug($inputs['title']),
                'summury' => $inputs['summury'],
                'content' => $inputs['content'],
                'content_soure' => $inputs['content'],
                'image' => $image,
                'keyword' => $inputs['keyword'],
                'sub_category_id' => $inputs['sub_category_id'],
                'category_id' => $inputs['category_id'],
                'url_md5' => md5($inputs['url_origin']),
                'url_origin' => $inputs['url_origin'],
                'web' => $inputs['web'],
                'web_name' => $inputs['web_name'],
                'date' => date('Y-m-d H:i:s'),
            ]
        );

        return redirect()->route('admin.post.list')->with('thongbao', 'Sửa thành công');
    }

    public function image($image, $title)
    {
        $format = $image->getClientOriginalExtension();
		$nameFile = str_slug($title) . '-' . rand() . '.jpg';
		$data = getimagesize($image->getRealPath());
        $width = $data[0];
        $height = $data[1];
        $widthThumbnailResize = 360;
        $widthOgImageResize = 460;
        $heightThumbnailResize = ($height * $widthThumbnailResize) / $width;
        $heightOgImageResize = ($height * $widthOgImageResize) / $width;
    //resize thumbnail
	    $thumbnail_resize = Image::make($image);              
	    $img = $thumbnail_resize->resize($widthThumbnailResize, $heightThumbnailResize)->encode('jpg');
	    $fullpath = 'photos/thumbnails/' . $nameFile;
	    \Storage::disk('s3')->put($fullpath, (string)$img, 'public');
	    //$img = $thumbnail_resize->resize($widthThumbnailResize, $heightThumbnailResize)->encode('jpg');
	    //$thumbnail_resize->save(public_path('upload/thumbnails/' . $nameFile));
	// resize og:image
	    $og_image_resize = Image::make($image);              
	    $img1 = $og_image_resize->resize($widthOgImageResize, $heightOgImageResize)->encode('jpg');
	    $fullpath = 'photos/og_images/' . $nameFile;
	    \Storage::disk('s3')->put($fullpath, (string)$img1, 'public');
	    //$og_image_resize->save(public_path('upload/og_images/' . $nameFile));

	    return $nameFile;
    }
}
