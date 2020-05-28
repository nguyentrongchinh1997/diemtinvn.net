<!DOCTYPE html>
<html lang="en">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
		<title>Trang quản trị admin</title>
		<base href="{{ asset('/') }}">
		<link href="{{ asset('css/admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('css/admin/css/londinium-theme.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('css/admin/css/styles.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('css/admin/css/icons.css') }}" rel="stylesheet" type="text/css">
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">

		<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script> -->
		<script src="{{ asset('js/admin/jquery.min.js') }}"></script>
		<script src="{{ asset('js/admin/jquery-ui.min.js') }}"></script>
		<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script> -->
		{{-- <script src="{{ asset('js/admin/admin.js') }}"></script> --}}
		<script type="text/javascript" src="{{ asset('js/admin/plugins/charts/sparkline.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/forms/uniform.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/forms/select2.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/forms/inputmask.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/forms/autosize.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/forms/inputlimit.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/forms/listbox.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/forms/multiselect.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/forms/validate.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/forms/tags.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/forms/switch.min.js') }}"></script>

		<script type="text/javascript" src="{{ asset('js/admin/plugins/forms/uploader/plupload.full.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/forms/uploader/plupload.queue.min.js') }}"></script>

		<script type="text/javascript" src="{{ asset('js/admin/plugins/forms/wysihtml5/wysihtml5.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/forms/wysihtml5/toolbar.js') }}"></script>

		<script type="text/javascript" src="{{ asset('js/admin/plugins/interface/daterangepicker.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/interface/fancybox.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/interface/moment.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/interface/jgrowl.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/interface/datatables.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/interface/colorpicker.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/interface/fullcalendar.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/plugins/interface/timepicker.min.js') }}"></script>

		<script type="text/javascript" src="{{ asset('js/admin/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/admin/application.js') }}"></script>
	</head>
	<body>
		<div class="login-wrapper">
			<form role="form" method="post" action="{{ route('admin.login.post') }}">
				@csrf
				@if (session('error'))
					<div class="alert alert-danger">
						{{ session('error') }}
					</div>
				@endif
				@if (count($errors->all()) > 0)
					@foreach ($errors->all() as $error)
				    	<div class="alert alert-danger">
							{{ $error }}
						</div>
				  	@endforeach
				@endif
				<div class="popup-header">
					<a href="#" class="pull-left"><i class="icon-user-plus"></i></a>
					<span class="text-semibold">Đăng nhâp Admin</span>
					<div class="btn-group pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cogs"></i></a>
	                    <ul class="dropdown-menu icons-right dropdown-menu-right">
							<li><a href="#"><i class="icon-people"></i> Change user</a></li>
							<li><a href="#"><i class="icon-info"></i> Forgot password?</a></li>
							<li><a href="#"><i class="icon-support"></i> Contact admin</a></li>
							<li><a href="#"><i class="icon-wrench"></i> Settings</a></li>
	                    </ul>
					</div>
				</div>
				<div class="well">
					<div class="form-group has-feedback">
						<label>Username</label>
						<input type="text" class="form-control" name="username" required="required" placeholder="Username">
						<i class="icon-users form-control-feedback"></i>
					</div>

					<div class="form-group has-feedback">
						<label>Password</label>
						<input name="password" type="password" class="form-control" required="required" placeholder="Password">
						<i class="icon-lock form-control-feedback"></i>
					</div>

					<div class="row form-actions">
						<div class="col-xs-12" style="padding: 0px">
							<button style="width: 100%" type="submit" class="btn btn-warning pull-right"> ĐĂNG NHẬP</button>
						</div>
					</div>
				</div>
	    	</form>
		</div>  
	</body>
</html>
