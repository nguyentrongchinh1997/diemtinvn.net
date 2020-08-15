@extends('client.layouts.index')

@section('title', 'Tổng hợp tin tức trong ngày mới nhất')

@section('content')
<div class="page-title" style="margin: 0px">
	<div class="container">
		<div class="row" style="margin-top: 10px">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<ol class="breadcrumb breadcrumb-custom breadcrumb-custom-sub">
					<li class="active" style="text-transform: unset !important; width: 100%">
						<a style="color: #c90000">
							Điểm tin trong ngày - {{date('d/m/Y')}}
						</a>
					</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<main class="page_main_wrapper" style="padding-bottom: 30px">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="post_details_inner">
					<div class="post_details_block details_block2">
						<div class="post-header">
							<h2 title="" style="font-weight: bold;">
								Tổng hợp tin tức trong ngày
							</h2>
							<p class="news-day-description">
								Tin thời sự hôm nay - Cập nhật tin tức trong ngày, các vấn đề xã hội nóng hổi, bản tin thời sự, chính trị trong nước mới nhất trên báo VietNamNet.
							</p>
							<p style="text-align: right; margin-top: 0px">
								<span class="icon-face">
									<i class="ti-facebook"></i>
								</span>
								<span class="icon-face" style="background: #d93025; margin-left: 10px">
									<i class="ti-google"></i>
								</span>
								<span style="font-weight: bold; margin-right: 15px; color: #898989;">Chọn ngày: </span><input value="" id="date" type="date" name="">
							</p>
						</div>
					</div>
				</div>
				@foreach($posts as $postItem)
					<h3>
						Tin tức ngày {{date('d/m/Y', strtotime($postItem->date))}}
					</h3>
					{!!$postItem->content!!}
				@endforeach
			</div>
			<div class="col-sm-4 col-p sidebar">
                @include('client.includes.best_view')
            </div>
		</div>
	</div>
</main>
<style type="text/css">
	.pagination{
		float: none;
	}
</style>
<script type="text/javascript">
	function redirect()
	{
		window.location.href = '{{route('diem-tin')}}';
	}

</script>
@endsection

@section('js')
	<script type="text/javascript">
		$(function(){
			$('#date').change(function(){
				date = $(this).val();
				window.location.href = "diem-tin-ngay-" + date;
			});
		});
	</script>
@endsection
