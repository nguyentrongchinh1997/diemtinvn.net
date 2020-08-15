<h3 class="title-sidebar">
	Tin mới
</h3>
<br>
<div class="tab-content best-view-sidebar">
	<div role="tabpanel" class="tab-pane fade active in" id="home">
		<div class="most-viewed post-list-category-sidebar">
			<ul id="most-today" class="content tabs-content">
				@php $stt = 1; @endphp
				@foreach ($newPostsSidebar as $post)
					<div class="news-list-item articles-list">
						<div class="sidebar-img-wrapper img-wrapper">
							<a class="thumb" href="{{ route('client.detail', ['cate' => $post->category->slug, 'sub-cate' => $post->subCategory->slug, 'title' => $post->slug, 'p' => $post->id]) }}">
								<img src='{{$post->image}}' alt="{{ $post->title }}" title="{{ $post->title }}" class="img-responsive"></a>
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

