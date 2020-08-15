@extends('client.layouts.index')

@section('title', $key . ': Tìm kiếm tin tức liên quan đến ' . $key)

@section('content')
<main class="page_main_wrapper">
	<div class="container">
		<div class="row" style="margin-top: 20px">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<ol class="breadcrumb breadcrumb-custom-sub breadcrumb-custom" style="float: left;">
					<li class="active">
						<a style="text-transform: capitalize;">
							@if ($type == 'search')
								Từ khóa:
							@elseif ($type == 'soure')
								Báo:
							@endif
							{{ $key }}
						</a>
					</li>
				</ol>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row row-m">
			<div class="col-sm-8 col-p">
				<div class="theiaStickySidebar">
					<div class="post-inner categoty-style-1">
						<div class="post-body post-list-category" style="padding: 15px 15px 15px 0px">
							@foreach ($posts as $post)
								<div class="news-list-item articles-list">
                                    <div class="img-wrapper">
                                        <a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}" class="thumb">
                                        	<img data-src="{{$post->image}}" alt="{{ $post->title }}" class="lazy img-responsive"></a>
                                    </div>
                                    <div class="post-info-2">
                                        <h4 title="{{ $post->title }}"><a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}" class="title">{{ $post->title }}</a></h4>
                                        <ul class="authar-info">
                                            <li><i class="ti-timer"></i> {{ getWeekday($post->date) }}, {{ date('H:i d/m/Y', strtotime($post->date)) }}</li>
                                        </ul>
                                        <p class="hidden-sm description" style="margin-bottom: 10px">{{ $post->summury }}</p>
                                        <p>
											<a class="sub-category" href="{{ route('client.sub_cate', ['category' => $post->subCategory->category->slug, 'sub' => $post->subCategory->slug]) }}">{{ $post->subCategory->name }}</a> | <a class="soure" href="{{route('client.news_soure', ['web' => $post->web])}}">{{ $post->web }}</a>
										</p>
                                    </div>
                                </div>
                            @endforeach
						</div>
						<!-- Post footer -->
						<div class="post-footer" style="border-top: 0px"> 
							<div class="row thm-margin">
								<div class="col-xs-12 col-sm-12 col-md-12 thm-padding">
									{{ $posts->links() }}
								</div>
							</div>
						</div> <!-- /.Post footer-->
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-p sidebar">
				@include('client.includes.news_new')
			</div>
		</div>
	</div>
</main>
@endsection
