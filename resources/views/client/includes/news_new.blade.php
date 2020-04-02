<h3 class="title-sidebar">
	Tin mới
</h3>
<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade active in" id="home">
		<div class="most-viewed">
			<ul id="most-today" class="content tabs-content">
				@php $stt = 1; @endphp
				@foreach ($newPostsSidebar as $post)
					@if ($stt++ == 1)
						<div class="news-list-item articles-list">
							<div>
								<h4 title="{{ $post->title }}">
									<a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}" class="title">{{ $post->title }}</a>
								</h4>
							</div>

							<div class="img-wrapper" style="float: left;">
								<a class="thumb" href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}">
									<img src='{{ asset("upload/thumbnails/$post->image") }}' alt="Rác thải bủa vây đường liên xã" class="img-responsive"></a>
							</div>
							<div class="post-info-2" style="float: left;">
								<p class="description">
									{{ $post->summury }}
								</p>	                            
							</div>
						</div>
					@else
						<li>
							<a href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}">
								{{ $post->title }}
							</a>
						</li>
					@endif
				@endforeach
			</ul>
		</div>
	</div>
</div>

