@extends('client.layouts.index')

@section('title', $category->name . ': Cập nhật liên tục tin tức ' . $category->name . ' mới nhất 24h')
@section('description', 'Tổng hợp tin tức ' . $category->name . ' mới nhất 24h qua. Diembao24h.net - Website cập nhật tin tức báo chí đầy đủ, nhanh chóng, chính xác, tin cậy')
@section('keywords', 'tin tức ' . $category->name . ', thông tin ' . $category->name . ', ' . $category->name . ' 24h, tin mới ' . $category->name . ', đọc báo ' . $category->name)
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
            "name": "{{$category->name}}",
            "item": "{{ route('client.category', ['cate' => $category->slug]) }}"
          }]
        }
    </script>
@endsection

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
				    {{--
					@if (!empty($postSlide))
						<div class="row" style="margin-bottom: 20px">
		                    <div class="col-md-7">
		                    	<a href="{{ route('client.detail', ['cate' => $postSlide->category->slug, 'sub-cate' => $postSlide->subCategory->slug, 'title' => $postSlide->slug, 'p' => $postSlide->id]) }}">
		                    		<img width="100%" alt="{{$postSlide->title}}" src='{{asset("$server/thumbnails/$postSlide->image")}}'>
		                    	</a>
		                    </div>
		                    <div class="col-md-5">
		                        <h2 class="title-top-page">
		                            <a href="{{ route('client.detail', ['cate' => $postSlide->category->slug, 'sub-cate' => $postSlide->subCategory->slug, 'title' => $postSlide->slug, 'p' => $postSlide->id]) }}" style="font-size: 20px">
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
	                @endif --}}
	                {{-- <div class="row responsive slider" style="margin-top: 30px">
	                    @foreach ($postTop as $post)
		                    <div class="news-slide">
		                        <a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}">
		                            <img title="{{$post->title}}" src='{{asset("$server/og_images/$post->image")}}' alt="{{$post->title}}" class="img-responsive">
		                        </a>
		                        <h4>
		                            <a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}">
		                                {{$post->title}}
		                            </a>
		                        </h4>
		                        <p>
		                            <a class="sub-category" href="{{ route('client.sub_cate', ['cate' => $post->category->slug, 'sub_cate' => $post->subCategory->slug]) }}">{{ $post->subCategory->name }}</a>
		                        </p>
		                        <p>
		                            <a class="soure" href="{{ route('client.news_soure', ['web' => $post->web]) }}">{{ $post->web }}</a>
		                        </p>
		                    </div>
	                    @endforeach
	                </div> --}}
					<div class="theiaStickySidebar">
						@if (count($postList) > 0)
							<div class="post-inner categoty-style-1">
								<div class="post-body" style="padding: 15px 15px 15px 0px">
									@foreach ($postList as $post)
										<div class="news-list-item articles-list">
											<div class="row" style="margin: 0px">
		                                        <div class="col-xs-5 col-sm-4 col-md-4 col-lg-4 news-list-item-left">
		                                            <a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}" class="thumb">
		                                            	<img data-src="{{ asset("$server/og_images/$post->image") }}" alt="{{ $post->title }}" class="lazy img-responsive"></a>
		                                        </div>
		                                        <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8 news-list-item-right">
		                                            <h4 title="{{ $post->title }}">
		                                            	<a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}" class="title">{{ $post->title }}</a>
		                                            </h4>
		                                            <ul class="authar-info">
		                                                <li><i class="ti-timer"></i> {{ getWeekday($post->date) }}, {{ date('H:i d/m/Y', strtotime($post->date)) }}</li>
		                                            </ul>
		                                            <p class="hidden-xs hidden-sm description" style="margin-bottom: 10px">{{ trim($post->summury) }}</p>
		                                            <p style="margin-bottom: 0px;">
														<a class="sub-category" href="{{ route('client.sub_cate', ['category' => $post->subCategory->category->slug, 'sub' => $post->subCategory->slug]) }}">{{ $post->subCategory->name }}</a> <span style="color: #adb5bd">|</span> <a class="soure" href="{{ route('client.news_soure', ['web' => urlencode($post->web)]) }}">{{ $post->web }}</a>
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
					      <div style="padding:20px; background-color:#FAFAFA; margin-bottom:20px">
			        <center>Độc giả cùng làm báo. Nếu bạn đam mê báo chí và muốn chia sẻ tin tức cập nhật tới mọi người
			        <br><br>
			        <a href="mailto:contact@diembao24h.net" class="btn btn-danger">Gửi Bài</a>
			        </center>
			    </div>
				<div class="theiaStickySidebar">
					@include('client.includes.weather')
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
													<a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}" class="thumb">
														<img src='{{ asset("$server/thumbnails/$post->image") }}' alt="{{ $post->title }}" class="img-responsive"></a>
												</div>
												<h4 title="{{ $post->title }}">
														<a href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}" class="title">{{ $post->title }}</a></h4>
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
					@include('client.includes.best_view')
				</div>
					</div>
					<!-- END OF /. SIDE CONTENT -->
				</div>
		</div>
	</main>
	<input type="hidden" class="input" id="{{$category->slug}}{{$category->id}}" value="{{$category->id}}">
@endsection