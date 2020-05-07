@extends('client.layouts.index')

@section('title', $post->title)
@section('description', html_entity_decode($post->summury, ENT_QUOTES, 'UTF-8'))
@section('keywords', html_entity_decode($post->keyword, ENT_QUOTES, 'UTF-8'))
@section('image', asset('upload/og_images/' . $post->image))
@section('json')
    <meta property="og:url"                content="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' =>$post->subCategory->slug, 'p' => $post->id]) }}" />
    <meta property="og:type"               content="article" />
    <meta property="og:title"              content="{{$post->title}}" />
    <meta property="og:description"        content="{{html_entity_decode($post->summury, ENT_QUOTES, 'UTF-8')}}" />
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "BreadcrumbList",
          "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "name": "Trang chủ",
            "item": "https://diembao24h.net/"
          },{
            "@type": "ListItem",
            "position": 2,
            "name": "{{$post->category->name}}",
            "item": "{{ route('client.category', ['cate' => $post->category->slug]) }}"
          },{
            "@type": "ListItem",
            "position": 3,
            "name" : "{{$post->subCategory->name}}",
            "item": "{{ route('client.sub_cate', ['cate' => $post->category->slug, 'sub' => $post->subCategory->slug]) }}"
          },{
            "@type": "ListItem",
            "position": 4,
            "name" : "{{$post->title}}"
          }]
        }
    </script>
@endsection

@section('content')
<main class="page_main_wrapper">
	<!-- START PAGE TITLE --> 
	<div class="page-title" style="margin: 0px">
		<div class="container">
			<div class="row" style="margin-top: 20px">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<ol class="breadcrumb breadcrumb-custom-sub breadcrumb-custom" style="float: left;">
						<li class="active">
							<a style="text-transform: capitalize; color: #c90000" href="{{ route('client.category', ['slug' => $post->subCategory->category->slug]) }}">
								{{ $post->subCategory->category->name }}
							</a>
						</li>
						@foreach($post->subCategory->category->subCategory as $category)
							<li>
								<a style="text-transform: capitalize; color:@if ($category->slug == $post->subCategory->slug){{'#c90000'}}@else{{'#6c757d'}}@endif" href="{{ route('client.sub_cate', ['cate' => $category->category->slug, 'sub_cate' => $category->slug]) }}">{{ $category->name }}</a>
							</li>
						@endforeach
					</ol>
					
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row row-m">
			<div class="col-sm-8 col-p  main-content">
				<div>
					<div class="post_details_inner">
						<div class="post_details_block details_block2">
							<div class="post-header">
								<h2 title="{{ $post->title }}" style="font-weight: bold;">{{ $post->title }}</h2>
								<p style="font-size: 14px; color: #777">
									<span style="text-transform: capitalize;">
										<a style="color: #777" href="{{ route('client.sub_cate', ['category' => $post->category->slug, 'sub_category' => $post->subCategory->slug]) }}">
											<b>{{ $post->subCategory->name }}</b>
										</a>
									</span>
									<span>|</span>
									<span>
										{{getWeekday($post->date)}}, {{ date('d/m/Y', strtotime($post->date)) }} {{ date('H:i', strtotime($post->date)) }} GMT+7
									</span><span>|</span>
									<span>
										{{ $post->view }} lượt xem
									</span>
								</p>
								<div class="fb-like" data-href="{{ url()->current() }}" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="true"></div>
								<hr>
								<p class="detail-summury">
									{!! html_entity_decode($post->summury, ENT_QUOTES, 'UTF-8') !!}
								</p>
							</div> 
							
							<div class="bk-content">
								{!! $post->content !!}
							</div>
							<p style="text-align: right;">
								<b>Nguồn:</b> <a target="_blank" rel="notfollow" href="{{ $post->url_origin }}">{{ $post->web }}</a>
							</p>
						</div>
					</div>
					@if (count($keywords) > 0)
						<div>
							<p><b>Từ khóa</b></p>
							<ul class="td-category">
								@foreach ($keywords as $keyword)
								<li><a class="post-category" href="{{ route('client.search', ['key' => $keyword]) }}">#{{trim($keyword)}}</a></li>
								@endforeach
							</ul>
						</div>
					@endif
					<div class="post-inner post-inner-2">
						<!--post header-->
						<div class="post-head">
							<h2 class="title"><strong>Bình luận </strong></h2>
							<div width='100%' class="fb-comments" data-href="{{ url()->current() }}" data-numposts="5"></div>
						</div>
					</div>
					<div class="post-head">
						<h2 class="title"><strong>Tin liên quan </strong></h2>
					</div>
					<div class="row" style="margin-bottom: 20px">
	                    <div class="col-sm-12">
	                        <div class="featured-inner" style="padding: 0px">
	                            <div id="featured-owl" class="owl-carousel">
	                                @foreach ($idPostRelate as $newsId)
	                                	@php $postRealte = \App\Helper\helper::getNews($newsId) @endphp
	                                    <div class="item">
	                                        <div class="featured-post">
	                                            <a href="{{ route('client.detail', ['cate' => $postRealte->category->slug, 'sub-cate' => $postRealte->subCategory->slug,'title' => $postRealte->slug, 'p' => $postRealte->id]) }}" class="news-image">
	                                                <img title="{{$post->title}}" src='{{asset("upload/thumbnails/$postRealte->image")}}' alt="{{$postRealte->title}}" class="img-responsive">
	                                            </a>
	                                            <h4>
	                                                <a href="{{ route('client.detail', ['cate' => $postRealte->category->slug, 'sub-cate' => $postRealte->subCategory->slug,'title' => $postRealte->slug, 'p' => $postRealte->id]) }}">
	                                                    {{ $postRealte->title }}
	                                                </a>
	                                            </h4>
	                                            <p>
	                                            	<a style="color: #777" href="{{ route('client.news_soure', ['web' => $postRealte->web]) }}">{{ $postRealte->web }}</a>
	                                            </p>
	                                        </div>
	                                    </div>
	                                @endforeach
	                            </div>
	                        </div>
	                    </div>
	                </div>
					<div class="post-inner post-inner-2 category-same-post">
						<div class="post-head">
							<h2 class="title"><strong>Cùng chuyên mục </strong></h2>
						</div>
						<br>
						<div class="row">
							@foreach ($postSameCategory as $post)
								<div class="col-xs-6 col-sm-4">
	                                <article>
	                                    <figure class="post-list-category">
	                                        <a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug,'title' => $post->slug, 'p' => $post->id]) }}">
	                                            <img data-src="{{ asset("upload/thumbnails/$post->image") }}" alt="{{ $post->title }}" title="{{ $post->title }}" class="lazy img-responsive">
	                                        </a>
	                                    </figure>
	                                    <div class="post-info">
	                                        <h3 title="{{ $post->title }}"><a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug,'title' => $post->slug, 'p' => $post->id]) }}" class="title">{{ $post->title }}</a></h3>
	                                    </div>
	                                </article>
	                            </div>
                            @endforeach
						</div>
						<div class="row" style="margin-top: 30px">
							@foreach ($otherCategory as $category)
								@if (count(\App\Helper\helper::categoryPost($category->id)) > 0)
									<div class="col-sm-4 col-md-4 sub-cate-random">
										<a class="title-popalar" href="{{ route('client.category', ['cate' => $category->slug]) }}">
											{{ $category->name }}
										</a>
										@foreach (\App\Helper\helper::categoryPost($category->id) as $categoryOtherPost)
											<div class="news-list-item articles-list category-other-post" style="border-bottom: 0px">
												<div class="img-wrapper">
													<a class="thumb" href="{{ route('client.detail', ['cate' => $categoryOtherPost->category->slug, 'sub-cate' => $categoryOtherPost->subCategory->slug, 'title' => $categoryOtherPost->slug, 'p' => $categoryOtherPost->id]) }}">
														<img data-src='{{ asset("upload/thumbnails/$categoryOtherPost->image") }}' alt="{{ $categoryOtherPost->title }}" class="lazy img-responsive">
													</a>
												</div>
												<h4 class="title-top-page-cate">
													<a href="{{ route('client.detail', ['cate' => $categoryOtherPost->category->slug, 'sub-cate' => $categoryOtherPost->subCategory->slug, 'title' => $categoryOtherPost->slug, 'p' => $categoryOtherPost->id]) }}">
														{{ $categoryOtherPost->title }}
													</a>
												</h4>
											</div>
											@php break; @endphp
										@endforeach
										@php 
											$dem = 0;
										@endphp
										<ul id="most-today">
											@foreach (\App\Helper\helper::categoryPost($category->id) as $categoryOtherPost)
												@if ($dem++ > 0)
													<li style="padding: 5px 0px">
														<a href="{{ route('client.detail', ['cate' => $categoryOtherPost->category->slug, 'sub-cate' => $categoryOtherPost->subCategory->slug, 'title' => $categoryOtherPost->slug, 'p' => $categoryOtherPost->id]) }}">
															{{ $categoryOtherPost->title }}
														</a>
													</li>
													<hr>
												@endif
											@endforeach
										</ul>
									</div>
								@else
									{{ $category->name }}
								@endif
							@endforeach
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4 col-p sidebar">
				<h3 class="title-sidebar">
                	Tin mới
                </h3>
                <br>
                <div class="tab-content best-view-sidebar">
                	<div role="tabpanel" class="tab-pane fade active in" id="home">
                		<div class="most-viewed post-list-category-sidebar">
                			<ul id="most-today" class="content tabs-content">
                				@foreach ($newPost as $post)
                					<div class="news-list-item articles-list">
                						<div class="sidebar-img-wrapper img-wrapper">
                							<a class="thumb" href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}">
                								<img src='{{ asset("upload/thumbnails/$post->image") }}' alt="{{ $post->title }}" title="{{ $post->title }}" class="img-responsive"></a>
                						</div>
                						<h4 title="{{ $post->title }}">
                							<a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}" class="title">{{ $post->title }}</a>
                						</h4>
                						<div class="hidden-sm hidden-md hidden-lg">
                							<p class="summury" style="font-size: 13px; max-height: 40px; overflow: hidden;">
                								{!! $post->summury !!}
                							</p>
                							<p>
                								<a class="sub-category" href="">{{$post->subCategory->name}}</a><span> | </span><a class="soure" href="">{{$post->web}}</a>
                							</p>
                							<p class="soure">
                								{{ getWeekday($post->date) }}, {{ date('d/m/Y H:i', strtotime($post->date)) }} +GMT7
                							</p>
                						</div>
                					</div>
                				@endforeach
                			</ul>
                		</div>
                	</div>
                </div>
				<hr>
				<h3 class="title-sidebar">
                	Đọc nhiều nhất
                </h3>
                <br>
                <div class="tab-content best-view-sidebar">
                	<div role="tabpanel" class="tab-pane fade active in" id="home">
                		<div class="most-viewed post-list-category-sidebar">
                			<ul id="most-today" class="content tabs-content">
                				@foreach ($bestViewPost as $post)
                					<div class="best-view-item-sidebar news-list-item articles-list">
                						<div class="post-info-2">
                							<h4 title="{{ $post->title }}">
                								<a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}" class="title">{{ $post->title }}</a></h4>                         
                						</div>
                						<div class="img-wrapper">
                							<a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}" class="thumb">
                								<img src='{{ asset("upload/thumbnails/$post->image") }}' title="{{ $post->title }}" alt="{{ $post->title }}" class="img-responsive"></a>
                						</div>
                					</div>
                				@endforeach
                			</ul>
                		</div>
                	</div>
                </div>
			</div>
		</div>
	</div>
	<div class="zoom-image">
		<div id="image-full">
			<p style="color: #fff; text-align: right;">
				<button class="close-zoom-image" type="button">
					<i class="ti-close"></i>
				</button>
			</p>
			<img class="image-full" src="">
		</div>
	</div>
</main>
<input type="hidden" class="input" id="{{$post->subCategory->category->slug}}{{$post->subCategory->category->id}}" value="{{$post->subCategory->category->id}}">
{{-- <style type="text/css">
	@php 
		$webException = ['tuoitre.vn', 'laodong.vn', 'vietnamplus.vn', 'cand.com.vn', 'nongnghiep.vn', 'baotintuc.vn', 'nld.com.vn', 'baotintuc.vn', 'cand.com.vn'];
	@endphp
	@if (!in_array($post->web, $webException))
		.bk-content p:last-child{
			text-align: right;
		}
	@endif
</style> --}}
@section('script')
	{{-- <script type="text/javascript">
		if ($('.bk-content img').length) {
			title = '{{ $post->slug }}';
			month = '{{ $month }}';
			var numItems = $('.bk-content img').length;
			for (i = 0; i < numItems; i++) {
				k = $('.bk-content img:eq(' + i + ')').attr('src');
				$('.bk-content img:eq(' + i + ')').attr('src', '{{asset("upload/images/$month")}}' + '/' + title + '-' + k + '.jpg');
			}
		}
	</script> --}}
	<script type="text/javascript">
		// if ($('.bk-content p').length) {
		// 	number_tag_p = $('.bk-content p').length - 1;
		// 	$('.bk-content p:eq(' + number_tag_p + ')').css({'text-align':'right'});
		// }
		if ($('.bk-content a').length) {
			var numItems = $('.bk-content a').length;
			for (i = 0; i < numItems; i++) {
				$('.bk-content a:eq(' + i + ')').attr('href', '#');
			}
		}
	</script>
	<script type="text/javascript">
		$('.bk-content img').click(function(){
			url = $(this).attr('src');
			$('.image-full').attr('src', url);
			$('.zoom-image').addClass('zoom-image-active');
		})
		$('.post_details_block figure img').click(function(){
			url = $(this).attr('src');
			$('.image-full').attr('src', url);
			$('.zoom-image').addClass('zoom-image-active');
		});
		$('.close-zoom-image').click(function(){
			$('.zoom-image').removeClass('zoom-image-active');
		})
	</script>
@endsection

@endsection