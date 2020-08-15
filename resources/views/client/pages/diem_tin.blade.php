@extends('client.layouts.index')

@section('title', 'Điểm tin trong ngày ' . date('d/m/Y') . ' | Tin tức mới nhất trong ngày')

@section('content')
<div class="page-title" style="margin: 0px">
	<div class="container">
		<div class="row" style="margin-top: 10px">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<ol class="breadcrumb breadcrumb-custom breadcrumb-custom-sub">
					<li class="active" style="text-transform: unset !important; width: 100%">
						<a style="color: #c90000">
							Điểm tin trong ngày - {{date('d/m/Y')}}
						</a>
						<span onclick="redirect()" style="float: right; margin-top: 10px; cursor: pointer;">
							<i class="ti-angle-double-right"></i> Xem tất cả
						</span>
					</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<main class="page_main_wrapper" style="padding-bottom: 30px">
	<div class="container">
		<div class="row">
			@foreach($posts as $postItem)
				<div class="col-lg-4">
					<div class="diem-tin-item">
						<h1 title="{{$postItem->title}}">
							<a href="{{ route('client.detail', ['cate' => $postItem->category->slug, 'sub-cate' => $postItem->subCategory->slug, 'title' => $postItem->slug, 'p' => $postItem->id]) }}">
								{{$postItem->title}}
							</a>
						</h1>
					</div>
				</div>
			@endforeach
		</div>
		<div class="row">
			<div class="col-lg-12">
				<center>
					{{$posts->links()}}
				</center>
			</div>
		</div>
	</div>
</main>
<style type="text/css">
	.pagination{
		float: none;
	}
</style>
<script type="text/javascript">
	function redirect()
	{
		window.location.href = 'https://khotracnghiem.vn';
	}
</script>
@endsection