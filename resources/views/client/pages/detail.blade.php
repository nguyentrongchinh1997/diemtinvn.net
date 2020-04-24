@extends('client.layouts.index')

@section('title', $post->title . ' - ' . ucwords($post->subCategory->name))
@section('description', html_entity_decode($post->summury, ENT_QUOTES, 'UTF-8'))
@section('keywords', html_entity_decode($post->keyword, ENT_QUOTES, 'UTF-8'))
@section('image', asset('upload/og_images/' . $post->image))

@section('content')
<main class="page_main_wrapper">
	<!-- START PAGE TITLE --> 
	<div class="page-title" style="margin: 0px">
{{-- 		<div class="row" style="background: #f1f9ff">
			<div class="container">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px">
					<ol class="breadcrumb breadcrumb-custom">
						<li class="active">
							<a style="text-transform: capitalize; color: #c90000" href="{{ route('client.category', ['slug' => $post->subCategory->category->slug]) }}">
								{{ $post->subCategory->category->name }}
							</a>
						</li>
						@foreach($post->subCategory->category->subCategory as $category)
							<li>
								<a style="text-transform: capitalize;" href="details_2-2.html">{{ $category->name }}</a>
							</li>
						@endforeach
					</ol>
				</div>
			</div>
		</div> --}}
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
						{{-- <li>
							<a href="{{ route('client.sub_cate', ['cate' => $post->subCategory->category->slug, 'sub_cate' => $post->subCategory->slug]) }}">
								{{ $post->subCategory->name }}
							</a>
						</li> --}}
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
					@if ($keywords > 0)
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
	                                            <a href="{{ route('client.detail', ['category' => $postRealte->subCategory->slug, 'title' => $postRealte->slug, 'id' => $postRealte->id]) }}" class="news-image">
	                                                <img title="{{$post->title}}" src='{{asset("upload/og_images/$postRealte->image")}}' alt="{{$postRealte->title}}" class="img-responsive" style="height: 100px; object-fit: cover; width: 100%">
	                                            </a>
	                                            <h4>
	                                                <a href="{{ route('client.detail', ['category' => $postRealte->subCategory->slug, 'title' => $postRealte->slug, 'id' => $postRealte->id]) }}">
	                                                    {{ $postRealte->title }}
	                                                </a>
	                                            </h4>
	                                            <p>
	                                                <a class="sub-category" href="{{ route('client.sub_cate', ['cate' => $postRealte->category->slug, 'sub_cate' => $postRealte->subCategory->slug]) }}">{{ $postRealte->subCategory->name }}</a> | 
	                                                <a style="color: #777" href="{{ route('client.news_soure', ['web' => $postRealte->web]) }}">{{ $postRealte->web }}</a>
	                                            </p>
	                                        </div>
	                                    </div>
	                                @endforeach
	                                
	                            </div>
	                        </div>
	                    </div>
	                </div>
					{{-- <div class="post-inner post-inner-2">
						<div class="post-head">
							<h2 class="title"><strong>Tin liên quan </strong></h2>
						</div>
						@if (count($idPostRelate) > 0)
							<div class="post-body">
								<div id="post-slider-2" class="owl-carousel owl-theme">
									<!-- item one -->
									<div class="item">
										<div class="news-grid-2">
											<div class="row row-margin news-relate">
												@foreach ($idPostRelate as $newsId)
													@php $postRealte = \App\Helper\helper::getNews($newsId) @endphp
													<div class="col-xs-6 col-sm-4 col-md-4 col-padding">
														<div class="grid-item">
															<div class="grid-item-img">
																<a href="{{ route('client.detail', ['category' => $postRealte->subCategory->slug, 'title' => $postRealte->slug, 'id' => $postRealte->id]) }}">
																	<img src='{{ asset("upload/thumbnails/$postRealte->image") }}' alt="{{ $postRealte->title }}' alt="{{ $postRealte->title }}">
																</a>
															</div>
															<h5 title="{{ $postRealte->title }}">
																<a href="{{ route('client.detail', ['category' => $postRealte->subCategory->slug, 'title' => $postRealte->slug, 'id' => $postRealte->id]) }}" class="title">
																	{{ $postRealte->title }}
																</a>
															</h5>
														</div>
													</div>
												@endforeach
											</div>
										</div>
									</div>
								</div>
							</div>
						@endif
					</div> --}}
					<div class="post-inner post-inner-2">
						<div class="post-head">
							<h2 class="title"><strong>Cùng chuyên mục </strong></h2>
						</div>
						<br>
						<div class="row">
							@foreach ($postSameCategory as $post)
								<div class="col-sm-4">
	                                <article>
	                                    <figure class="post-list-category">
	                                        <a href="#"><img data-src="{{ asset("upload/og_images/$post->image") }}" alt="{{ $post->title }}" class="lazy img-responsive"></a>
	                                    </figure>
	                                    <div class="post-info">
	                                        <h3 title="{{ $post->title }}"><a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="title">{{ $post->title }}</a></h3>
	                                    </div>
	                                </article>
	                            </div>
                            @endforeach
						</div>
						{{-- <div class="post-inner categoty-style-1 post-list-category">
							<div class="post-body" style="padding: 15px 15px 15px 0px">
								@foreach ($postSameCategory as $post)
									<div class="news-list-item articles-list">
                                        <div class="img-wrapper">
                                            <a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="thumb">
                                            	<img data-src="{{ asset("upload/og_images/$post->image") }}" alt="{{ $post->title }}" class="lazy img-responsive"></a>
                                        </div>
                                        <div class="post-info-2">
                                            <h4 title="{{ $post->title }}"><a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="title">{{ $post->title }}</a></h4>
                                            <ul class="authar-info">
                                                <li class="date"><i class="ti-timer"></i> {{ getWeekday($post->date) }}, {{ date('H:i d/m/Y', strtotime($post->date)) }}</li>
                                            </ul>
                                            <p class="hidden-sm description" style="margin-bottom: 10px">{{ trim($post->summury) }}</p>
                                            <p style="margin-bottom: 0px; color: #adb5bd">
												<a class="sub-category" href="{{ route('client.sub_cate', ['category' => $post->subCategory->category->slug, 'sub' => $post->subCategory->slug]) }}">{{ $post->subCategory->name }}</a> | <a class="soure" href="{{ route('client.news_soure', ['web' => urlencode($post->web)]) }}">{{ $post->web }}</a>
											</p>
                                        </div>
                                    </div>
                                @endforeach
							</div>
						</div> --}}
						{{-- <div class="row row-margin">
							@php 
								$stt1 = 1;
							@endphp
							@foreach ($postSameCategory as $postSame)
								@if ($stt1++ <= 6)
									<div class="col-xs-6 col-sm-4 col-md-4 col-padding news-same-category">
										<div class="grid-item">
											<div class="grid-item-img">
												<a href="{{ route('client.detail', ['category' => $postSame->subCategory->slug, 'title' => $postSame->slug, 'id' => $postSame->id]) }}">
													<img data-src='{{ asset("upload/thumbnails/$postSame->image") }}' class="lazy img-responsive" alt="{{ $postSame->title }}">
												</a>
											</div>
											<h5 title="{{ $postSame->title }}"><a href="{{ route('client.detail', ['category' => $postSame->subCategory->slug, 'title' => $postSame->slug, 'id' => $postSame->id]) }}" class="title">{{ $postSame->title }}</a></h5>
										</div>
									</div>
								@endif
							@endforeach
						</div> --}}
						<div class="row" style="margin-top: 30px">
							@foreach ($otherCategory as $category)
								@if (count(\App\Helper\helper::categoryPost($category->id)) > 0)
									<div class="col-md-4 sub-cate-random">
										<a class="title-popalar" href="{{ route('client.category', ['cate' => $category->slug]) }}">
											{{ $category->name }}
										</a>
										@foreach (\App\Helper\helper::categoryPost($category->id) as $categoryOtherPost)
											<div class="news-list-item articles-list category-other-post" style="border-bottom: 0px">
												<div class="img-wrapper">
													<a class="thumb" href="{{ route('client.detail', ['category' => $categoryOtherPost->subCategory->slug, 'title' => $categoryOtherPost->slug, 'id' => $categoryOtherPost->id]) }}">
														<img data-src='{{ asset("upload/thumbnails/$categoryOtherPost->image") }}' alt="{{ $categoryOtherPost->title }}" class="lazy img-responsive"></a>
												</div>
												<h4>
													<a href="{{ route('client.detail', ['category' => $categoryOtherPost->subCategory->slug, 'title' => $categoryOtherPost->slug, 'id' => $categoryOtherPost->id]) }}">
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
														<a href="{{ route('client.detail', ['category' => $categoryOtherPost->subCategory->slug, 'title' => $categoryOtherPost->slug, 'id' => $categoryOtherPost->id]) }}">
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
			<!-- END OF /. MAIN CONTENT -->
			<!-- START SIDE CONTENT -->
			<div class="col-sm-4 col-p sidebar" style="padding-left: 25px">
				@include('client.includes.news_new')
				<hr>
				@include('client.includes.best_view')
				<div class="add-inner rightSidebar">
                    <img src="assets/images/add320x270-1.jpg" class="img-responsive" alt="">
                </div>
			</div>
			<!-- END OF /. SIDE CONTENT -->
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