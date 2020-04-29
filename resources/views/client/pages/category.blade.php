@extends('client.layouts.index')

@section('title', 'Tin tức ' . $category->name)


@section('content')
	<div class="page-title" style="margin: 0px">
		<div class="container">
			<div class="row" style="margin-top: 10px">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<ol class="breadcrumb breadcrumb-custom breadcrumb-custom-sub">
						<li class="active">
							<a style="text-transform: capitalize; color: #c90000" href="{{ route('client.category', ['slug' => $category->slug]) }}">
								{{ $category->name }}
							</a>
						</li>
						@foreach ($category->subCategory as $subCategory)
							<li>
								<a style="text-transform: capitalize; color: #6c757d" href="{{ route('client.sub_cate', ['cate' => $subCategory->category->slug, 'sub_cate' => $subCategory->slug]) }}">
									{{ $subCategory->name }}
								</a>
							</li>
						@endforeach
					</ol>
				</div>
			</div>
		</div>
	</div>
	<main class="page_main_wrapper">
		<div class="container">
			<div class="row row-m">
				<div class="col-sm-8 col-p post-list-category">
					@if (!empty($postSlide))
						<div class="row" style="margin-bottom: 20px">
		                    <div class="col-md-7">
		                    	<a href="{{ route('client.detail', ['title' => $postSlide->slug, 'p' => $postSlide->id]) }}">
		                    		<img width="100%" alt="{{$postSlide->title}}" src='{{asset("upload/og_images/$postSlide->image")}}'>
		                    	</a>
		                    </div>
		                    <div class="col-md-5">
		                        <h2 class="title-top-page">
		                            <a href="{{ route('client.detail', ['title' => $postSlide->slug, 'p' => $postSlide->id]) }}" style="font-size: 20px">
		                                {{ $postSlide->title }}
		                            </a>
		                        </h2>
		                        <p class="summury">
		                            {{ $postSlide->summury }} 
		                        </p>
		                        <p class="date">
		                           {{ date('d/m/Y H:i', strtotime($postSlide->date)) }} GMT+7
		                        </p>
		                        <p>
		                            <a class="sub-category" href="{{ route('client.sub_cate', ['cate' => $postSlide->category->slug, 'sub_cate' => $postSlide->subCategory->slug]) }}">{{ $postSlide->subCategory->name }}</a> | <a href="{{ route('client.news_soure', ['web' => $postSlide->web]) }}" class="soure">{{ $postSlide->web }}</a>
		                        </p>
		                    </div>
		                </div>
	                @endif
	                <div class="row" style="margin-bottom: 20px">
	                    <div class="col-sm-12">
	                        <div class="featured-inner" style="padding: 0px">
	                            <div id="featured-owl" class="owl-carousel">
	                                @foreach ($postTop as $post)
	                                    <div class="item">
	                                        <div class="featured-post">
	                                            <a href="{{ route('client.detail', ['title' => $post->slug, 'p' => $post->id]) }}" class="news-image">
	                                                <img title="{{$post->title}}" src='{{asset("upload/og_images/$post->image")}}' alt="{{$post->title}}" class="img-responsive">
	                                            </a>
	                                            <h4>
	                                                <a href="{{ route('client.detail', ['title' => $post->slug, 'p' => $post->id]) }}">
	                                                    {{ $post->title }}
	                                                </a>
	                                            </h4>
	                                            <p>
	                                                <a class="sub-category" href="{{ route('client.sub_cate', ['cate' => $post->category->slug, 'sub_cate' => $post->subCategory->slug]) }}">{{ $post->subCategory->name }}</a>
	                                            </p>
	                                            <p>
	                                            	<a class="soure" href="{{ route('client.news_soure', ['web' => $post->web]) }}">{{ $post->web }}</a>
	                                            </p>
	                                        </div>
	                                    </div>
	                                @endforeach
	                                
	                            </div>
	                        </div>
	                    </div>
	                </div>
					<div class="theiaStickySidebar">
						@if (count($postList) > 0)
							<div class="post-inner categoty-style-1">
								<div class="post-body" style="padding: 15px 15px 15px 0px">
									@foreach ($postList as $post)
										<div class="news-list-item articles-list">
	                                        <div class="img-wrapper">
	                                            <a href="{{ route('client.detail', ['title' => $post->slug, 'p' => $post->id]) }}" class="thumb">
	                                            	<img data-src="{{ asset("upload/og_images/$post->image") }}" alt="{{ $post->title }}" class="lazy img-responsive"></a>
	                                        </div>
	                                        <div class="post-info-2">
	                                            <h4 title="{{ $post->title }}"><a href="{{ route('client.detail', ['title' => $post->slug, 'p' => $post->id]) }}" class="title">{{ $post->title }}</a></h4>
	                                            <ul class="authar-info">
	                                                <li><i class="ti-timer"></i> {{ getWeekday($post->date) }}, {{ date('H:i d/m/Y', strtotime($post->date)) }}</li>
	                                            </ul>
	                                            <p class="hidden-sm description" style="margin-bottom: 10px">{{ trim($post->summury) }}</p>
	                                            <p style="margin-bottom: 0px;">
													<a class="sub-category" href="{{ route('client.sub_cate', ['category' => $post->subCategory->category->slug, 'sub' => $post->subCategory->slug]) }}">{{ $post->subCategory->name }}</a> <span style="color: #adb5bd">|</span> <a class="soure" href="{{ route('client.news_soure', ['web' => urlencode($post->web)]) }}">{{ $post->web }}</a>
												</p>
	                                        </div>
	                                    </div>
                                    @endforeach
								</div>
								<!-- Post footer -->
								<div class="post-footer" style="border-top: 0px"> 
									<div class="row thm-margin">
										<div class="col-xs-12 col-sm-12 col-md-12 thm-padding">
											{{ $postList->links() }}
										</div>
									</div>
								</div> <!-- /.Post footer-->
							</div>
						@endif
					</div>
				</div>
					<!-- END OF /. MAIN CONTENT -->
					<!-- START SIDE CONTENT -->
					<div class="col-sm-4 col-p sidebar">
						<div class="theiaStickySidebar">
							@include('client.includes.weather')
							<div class="add-inner">
								<img src="assets/images/add320x270-1.jpg" class="img-responsive" alt="">
							</div>
							@foreach ($subCate as $cate)
								<h3 class="title-sidebar" style="text-transform: capitalize;">
									{{ $cate->name }}
								</h3>
								<div class="tab-content best-view-sidebar" style="margin-bottom: 20px">
									<div role="tabpanel" class="tab-pane fade active in" id="home">
										<div class="most-viewed post-list-category-sidebar">
											<ul id="most-today" class="content tabs-content">
												@foreach (\App\Helper\helper::subCategoryPost($cate->id, $listId, 6) as $post)
													<div class="news-list-item articles-list">
														<div class="sidebar-img-wrapper img-wrapper">
															<a href="{{ route('client.detail', ['title' => $post->slug, 'p' => $post->id]) }}" class="thumb">
																<img src='{{ asset("upload/thumbnails/$post->image") }}' alt="{{ $post->title }}" class="img-responsive"></a>
														</div>
														<h4 title="{{ $post->title }}">
																<a href="{{ route('client.detail', ['title' => $post->slug, 'p' => $post->id]) }}" class="title">{{ $post->title }}</a></h4>
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
							@endforeach
							<!-- END OF /. ADVERTISEMENT -->
							<!-- START NAV TABS -->
							@include('client.includes.best_view')
							<!-- END OF /. NAV TABS -->
						</div>
					</div>
					<!-- END OF /. SIDE CONTENT -->
				</div>
		</div>
	</main>
	<input type="hidden" class="input" id="{{$category->slug}}{{$category->id}}" value="{{$category->id}}">
@endsection