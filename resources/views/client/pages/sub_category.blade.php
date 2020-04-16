@extends('client.layouts.index')

@section('title', 'Tin tức ' . $subCategory->name . ' - ' . $subCategory->category->name)

@section('content')
	<div class="page-title" style="margin: 0px">
		<div class="row" style="background: #f1f9ff">
			<div class="container">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0px">
					<ol class="breadcrumb breadcrumb-custom">
						<li class="active">
							<a style="text-transform: capitalize; color: #c90000" href="{{ route('client.category', ['slug' => $subCategory->category->slug]) }}">
								{{ $subCategory->category->name }}
							</a>
						</li>
						@foreach ($subCategory->category->subCategory as $subCate)
							<li>
								<a style="text-transform: capitalize;" href="{{ route('client.sub_cate', ['cate' => $subCate->category->slug, 'sub_cate' => $subCate->slug]) }}">
									{{ $subCate->name }}
								</a>
							</li>
						@endforeach
					</ol>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row" style="margin-top: 20px">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<ol class="breadcrumb breadcrumb-custom-sub" style="float: left;">
						<li class="active">
							<a href="{{ route('client.category', ['slug' => $subCategory->category->slug]) }}">{{ $subCategory->category->name }}</a>
						</li>
						<li>
							<a href="{{ route('client.sub_cate', ['cate' => $subCategory->category->slug, 'sub_cate' => $subCategory->slug]) }}">
								{{ $subCategory->name }}
							</a>
						</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<main class="page_main_wrapper">
		<section class="slider-inner">
			<div class="container">
				<div class="row thm-margin">
					<div class="col-xs-12 col-sm-6 col-md-6 thm-padding">
						<div class="slider-wrapper">
							<div id="owl-slider" class="owl-carousel owl-theme">
								@foreach ($postSlides as $post)
									<!-- Slider item one -->
									<div class="item">
										<div class="slider-post post-height-1">
											<a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="news-image">
												<img data-src='{{asset("upload/og_images/$post->image")}}' alt="{{ $post->title }}" class="lazy img-responsive">
											</a>
											<div class="post-text">
												{{-- <span class="post-category" style="text-transform: capitalize;">{{ $post->subCategory->name }}</span> --}}
												<h2 title="{{ $post->title }}">
													<a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}">
														{{ $post->title }}
													</a>
												</h2>
												<ul class="authar-info">
													<li class="date">{{ getWeekday($post->date) }}, {{ date('H:i d/m/Y', strtotime($post->date)) }}</li>
												</ul>
											</div>
										</div>
									</div>
									<!-- /.Slider item one -->
								@endforeach
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 thm-padding">
						<div class="row slider-right-post thm-margin">
							@foreach ($postTop as $post)
								<div class="col-xs-6 col-sm-6 col-md-6 thm-padding">
									<div class="slider-post post-height-2">
										<a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="news-image">
											<img src='{{asset("upload/og_images/$post->image")}}' alt="{{ $post->title }}" class="img-responsive">
										</a>
										<div class="post-text">
											{{-- <span class="post-category" style="text-transform: capitalize;">{{ $post->subCategory->name }}</span> --}}
											<h4><a href="#">{{ $post->title }}</a></h4>
											<ul class="authar-info">
												{{-- <li class="authar hidden-xs hidden-sm"><a href="#">by david hall</a></li> --}}
												<li class="hidden-xs">{{ date('d/m/Y', strtotime($post->date)) }}</li>
											</ul>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</section>
		<div class="container">
			<div class="row row-m">
				<div class="col-sm-8 col-p">
					<div class="theiaStickySidebar">
						@if (count($postList) > 0)
						<div class="post-inner categoty-style-1">
							<div class="post-body" style="padding: 15px 15px 15px 0px">
								@foreach ($postList as $post)
									<div class="news-list-item articles-list">
                                        <div class="img-wrapper">

                                            <a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="thumb">
                                            	<img src="{{ asset("upload/thumbnails/$post->image") }}" alt="{{ $post->title }}" class="img-responsive"></a>
                                        </div>
                                        <div class="post-info-2">
                                            <h4 title="{{ $post->title }}"><a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="title">{{ $post->title }}</a></h4>
                                            <ul class="authar-info">
                                                <li><i class="ti-timer"></i> {{ getWeekday($post->date) }}, {{ date('H:i d/m/Y', strtotime($post->date)) }}</li>
                                            </ul>
                                            <p class="hidden-sm description" style="margin-bottom: 10px">{{ $post->summury }}</p>
                                            <p style="margin-bottom: 0px;">
												<a class="web" href="{{ route('client.news_soure', ['web' => urlencode($post->web)]) }}">{{ $post->web }}</a>
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
					<div class="col-sm-4 col-p sidebar" style="padding: 5px">
						<div class="theiaStickySidebar">
							<!-- START SOCIAL ICON -->
							@include('client.includes.weather')
							<!-- END OF /. SOCIAL ICON -->
							<!-- START ADVERTISEMENT -->
							<div class="add-inner">
								<img src="assets/images/add320x270-1.jpg" class="img-responsive" alt="">
							</div>
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
@endsection
