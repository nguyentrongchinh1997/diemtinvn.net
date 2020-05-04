@extends('admin.layouts.index')

@section('content')
	<div class="page-content">
		<div class="page-header">
			<div class="page-title">
				<h3>Danh sách tin tức</h3>
			</div>
		</div>
		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="">Trang chủ</a></li>
				<li><a href="tables_dynamic.html">Danh sách</a></li>
			</ul>

			<div class="visible-xs breadcrumb-toggle">
				<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
			</div>
		</div>
        @if (session('thongbao'))
            <div class="alert alert-success">
                {{ session('thongbao') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
		<div class="panel panel-default">
            <div class="datatable">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Chuyên mục</th>
                            <th>Lượt xem</th>
                            <th>Nguồn</th>
                            <th>Ngày đăng</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody id="result-search">
                    	@foreach ($posts as $post)
                            <tr>
                                <td>
                                    {{ ++$stt }}
                                </td>
                                <td>
                                    <img src='{{asset("upload/thumbnails/$post->image")}}' width="100px">
                                </td>
                                <td>
                                    <a target="_blank" href="{{route('client.detail', ['slug' => $post->slug, 'p' => $post->id])}}">
                                        {{ $post->title }}
                                    </a>
                                </td>
                                <td>
                                    {{ $post->subCategory->name }} <br>({{ $post->subCategory->category->name }})
                                </td>
                                <td>
                                    {{ $post->view }}
                                </td>
                                <td>
                                    <a href="{{$post->url_origin}}" target="_blank">
                                        {{ $post->web }}
                                    </a>
                                </td>
                                <td>
                                    {{ $post->date }}
                                </td>
                                <td>
                                    <a onclick="return question()" href="{{ route('admin.post.delete', ['id' => $post->id]) }}">
                                        <i class="icon-remove3"></i>
                                    </a>
                                </td>
                                <script type="text/javascript">
                                    function question()
                                    {
                                        if (confirm('Bạn có muốn xóa không')) {
                                            return true;
                                        } else {
                                            return false;
                                        }
                                    }
                                </script>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $posts->links() }}
            </div>
        </div>
        
	</div>
</div>
<style type="text/css">
    .datatable-footer{
        display: none;
    }
</style>
@endsection

