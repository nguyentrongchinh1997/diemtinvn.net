@extends('admin.layouts.index')

@section('content')
	<div class="page-content">
		<div class="page-header">
			<div class="page-title">
				<h3>Thêm chuyên mục</h3>
			</div>
		</div>
		<div class="breadcrumb-line">
			<ul class="breadcrumb">
				<li><a href="">Trang chủ</a></li>
				<li><a href="tables_dynamic.html">Thêm chuyên mục</a></li>
			</ul>
			<div class="visible-xs breadcrumb-toggle">
				<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
			</div>
		</div>
        @if (session('alert'))
            <div class="alert alert-danger">
                {{ session('alert') }}
            </div>
        @endif
        @if (count($errors->all()) > 0)
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif
		<div class="panel panel-default">
            <div class="panel-body">
            <form action="#" method="post">
                @csrf
                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input required="required" type="text" placeholder="VD: Thì hiện tại hoàn thành...." class="form-control" name="title">
                </div>
                <div class="form-group">
                    <label class="control-label">Từ khóa (nhập và ấn enter)</label>
                    <input required="required" name="keyword" type="text" id="tags2" class="tags">
                </div>
                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea required="required" name="description" class="form-control" rows="5" placeholder="Mô tả..."></textarea>
                </div>
                <div class="form-group">
                    <label>Đườg dẫn tài liệu và đáp án</label>
                    <input required="required" name="link" type="text" placeholder="Đường dẫn tài liệu" class="form-control" name="link">
                </div>
                <div class="form-group">
                    <label>Nội dung</label>
                    <textarea required="required" name="content" required="required" name="content" id="content-ckeditor" class="form-control ckeditor"></textarea>
                </div>
                <div class="form-group">
                    <center>    
                        <button class="btn btn-primary">Thêm</button>
                    </center>
                </div>
            </form>
            </div>
        </div>
	</div>
</div>
@endsection
