<h3 class="title-sidebar">
	Tin mới
</h3>
<div class="tab-content">
	<div role="tabpanel" class="tab-pane fade active in" id="home">
		<div class="most-viewed post-list-category-sidebar">
			<ul id="most-today" class="content tabs-content">
				@php $stt = 1; @endphp
				@foreach ($newPostsSidebar as $post)
					{{-- @if ($stt++ == 1) --}}
						<div class="news-list-item articles-list">
							<div>
								<h4 title="{{ $post->title }}" style="font-weight: normal; line-height: 22px; font-size: 16px">
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
					{{-- @else
						<li>
							<a style="font-weight: bold" href="{{ route('client.detail', ['category' => $post->subCategory->slug, 'title' => $post->slug, 'id' => $post->id]) }}">
								{{ $post->title }}
							</a>
							<p style="margin-top: 10px; font-size: 13px; color: #727272">
							    <span>{{ date('d/m', strtotime($post->date)) }}</span> | <span style="text-transform: capitalize;">{{ $post->subCategory->name }}</span>
							</p>
						</li>
					@endif --}}
				@endforeach
			</ul>
		</div>
	</div>
</div>

