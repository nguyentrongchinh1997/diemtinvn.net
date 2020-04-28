<h3 class="title-sidebar">
	Tin mới
</h3>
<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade active in" id="home">
		<div class="most-viewed post-list-category-sidebar">
			<ul id="most-today" class="content tabs-content">
				@php $stt = 1; @endphp
				@foreach ($newPostsSidebar as $post)
					<div class="news-list-item articles-list">
						<div class="sidebar-img-wrapper img-wrapper">
							<a class="thumb" href="{{ route('client.detail', ['title' => $post->slug, 'p' => $post->id]) }}">
								<img src='{{ asset("upload/thumbnails/$post->image") }}' alt="{{ $post->title }}" title="{{ $post->title }}" class="img-responsive"></a>
						</div>
						<h4 title="{{ $post->title }}">
							<a href="{{ route('client.detail', ['title' => $post->slug, 'p' => $post->id]) }}" class="title">{{ $post->title }}</a>
						</h4>
					</div>
				@endforeach
			</ul>
		</div>
	</div>
</div>

