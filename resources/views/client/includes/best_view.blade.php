<h3 class="title-sidebar">
	Đọc nhiều nhất
</h3>
<br>
<div class="tab-content best-view-sidebar">
	<div role="tabpanel" class="tab-pane fade active in" id="home">
		<div class="most-viewed post-list-category-sidebar">
			<ul id="most-today" class="content tabs-content">
				@foreach ($bestViewSidebar as $post)
					<div class="best-view-item-sidebar news-list-item articles-list">
						<div class="post-info-2">
							<h4 title="{{ $post->title }}">
								<a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="title">{{ $post->title }}</a></h4>                         
						</div>
						<div class="img-wrapper">
							<a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="thumb">
								<img src='{{ asset("upload/thumbnails/$post->image") }}' alt="{{ $post->title }}" class="img-responsive"></a>
						</div>
					</div>
				@endforeach
			</ul>
		</div>
	</div>
</div>