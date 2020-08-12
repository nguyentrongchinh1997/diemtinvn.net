@extends('client.layouts.index')

@section('title', $key . ': Đọc báo ' . $key . ', tin tức mới nhất trên ' . $key)
@section('description', 'Điểm tin ' . $key . ', tổng hợp tin tức mới nhất trên báo điện tử ' . $key . ', tin hot ' . $key . ', đọc báo ' . $key)
@section('keywords', 'tin tức ' . $key . ', đọc báo ' . $key . ', báo ' . $key . ', tin mới ' . $key)
@section('json')
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "BreadcrumbList",
          "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "name": "Trang chủ",
            "item": "http://diembao24h.net/"
          },{
            "@type": "ListItem",
            "position": 2,
            "name": "Điểm báo",
            "item": "{{url()->current()}}"
          },{
            "@type": "ListItem",
            "position": 2,
            "name": "{{$key}}"
          }]
        }
    </script>
@endsection

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
									<div class="row" style="margin: 0px">
										<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 news-list-item-left">
	                                        <a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}" class="thumb">
	                                        	<img data-src="{{ asset("$server/thumbnails/$post->image") }}" alt="{{ $post->title }}" class="lazy img-responsive"></a>
	                                    </div>
	                                    <div class="col-xs-6 col-sm-8 col-md-8 col-lg-8 news-list-item-right">
	                                        <h4 style="margin-top: 0px" title="{{ $post->title }}"><a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}" class="title">{{ $post->title }}</a></h4>
	                                        <ul class="authar-info">
	                                            <li><i class="ti-timer"></i> {{ getWeekday($post->date) }}, {{ date('H:i d/m/Y', strtotime($post->date)) }}</li>
	                                        </ul>
	                                        <p class="hidden-xs hidden-sm description" style="margin-bottom: 10px">{{ $post->summury }}</p>
	                                        <p>
												<a class="sub-category" href="{{ route('client.sub_cate', ['category' => $post->subCategory->category->slug, 'sub' => $post->subCategory->slug]) }}">{{ $post->subCategory->name }}</a> | <a class="soure" href="{{route('client.news_soure', ['web' => $post->web])}}">{{ $post->web }}</a>
											</p>
	                                    </div>
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
