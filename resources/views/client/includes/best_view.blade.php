<h3 class="title-sidebar">
	Đọc nhiều nhất
</h3>
<div class="tab-content best-view-sidebar">
	<div role="tabpanel" class="tab-pane fade active in" id="home">
		<div class="most-viewed post-list-category-sidebar">
			<ul id="most-today" class="content tabs-content">
				@foreach ($bestViewSidebar as $post)
					<div class="news-list-item articles-list">
						<div>
							<h4 style="line-height: 22px; margin-top: 0px; font-weight: normal; font-size: 16px" title="{{ $post->title }}">
								<a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="title">{{ $post->title }}</a></h4>
						</div>

						<div class="img-wrapper" style="float: left;">
							<a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="thumb">
								<img src='{{ asset("upload/thumbnails/$post->image") }}' alt="{{ $post->title }}" class="img-responsive"></a>
						</div>
						<div class="post-info-2" style="float: left;">
							<p class="description">
								{{ $post->summury }}
							</p>	                            
						</div>
					</div>
				@endforeach
			</ul>
		</div>
	</div>
</div>