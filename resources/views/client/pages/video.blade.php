@extends('client.layouts.index')

@section('title', 'Video')


@section('content')
	<main class="page_main_wrapper" style="margin-top: 30px">
		<div class="container">
			<a class="title-popalar" href="">
				Video
			</a>
			<div class="row" style="margin-top: 20px">
				<div class="col-lg-8">
					<iframe width="100%" style="height: 400px" src="https://www.youtube.com/embed/{{ $bestNewVideo->code }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
				<div class="col-lg-4">
					<h3 style="margin-top: 0px">
						{{ $bestNewVideo->title }}
					</h3>
					<p>
						{{ $bestNewVideo->description }}
					</p>
					<p class="date">
						{{ getWeekday($bestNewVideo->created_at) }}, {{date('d/m/Y', strtotime($bestNewVideo->created_at))}}
					</p>
					<div width='100%' class="fb-comments" data-href="{{ url()->current() }}" data-numposts="5"></div>
				</div>
			</div>
			<br>
			<div class="row">
				@foreach ($videoList as $video)
				<div class="col-lg-3">
					<iframe width="100%" style="height: auto" src="https://www.youtube.com/embed/{{ $video->code }}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					<h4 class="title-video">
						<a href="{{ route('client.video.detail', ['slug' => $video->slug, 'id' => $video->id]) }}">
							{{ $video->title }}
						</a>
					</h4>
					<p class="date">
						{{ getWeekday($video->created_at) }}, {{date('d/m/Y', strtotime($video->created_at))}}
					</p>
				</div>
				@endforeach
			</div>
			<br>
			<div class="row">
				<div class="col-lg-12">
					{{ $videoList->links() }}
				</div>
			</div>
		</div>
	</main>
@endsection
@section('script')
		<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v5.0&appId=2581255835435003&autoLogAppEvents=1"></script>
@endsection