@extends('admin.layouts.index')

@section('content')
    <div class="page-content">
      <div class="page-header">
         <div class="page-title">
            <h3>Danh sách chuyên mục con</h3>
        </div>
    </div>
    <div class="breadcrumb-line">
     <ul class="breadcrumb">
        <li><a href="">Trang chủ</a></li>
        <li><a href="tables_dynamic.html">Danh sách</a></li>
    </ul>

    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('warring'))
        <div class="alert alert-danger">
            {{ session('warring') }}
        </div>
    @endif
    <div class="panel panel-default">
        <div class="datatable">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td colspan="4">
                            <button style="float: right;" type="button" class="input-control btn btn-primary" data-toggle="modal" data-target="#myModal">
                                <a style="color: #fff">
                                    Thêm
                                </a>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Chuyên mục</th>
                        <th>Tên không dấu</th>
                        <th>Sửa</th>
                    </tr>
                </thead>
                <tbody id="result-search">
                    @foreach ($subCategories as $category)
                        <tr>
                            <td>
                                {{ $category->id }}
                            </td>
                            <td style="text-transform: capitalize;">{{ $category->name }}</td>
                            <td style="text-transform: capitalize;">
                                {{ $category->category->name }}
                            </td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                <a href="#">
                                    <i class="icon-pencil3 edit-category" data-toggle="modal" data-target="#edit-category"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Thêm chuyên mục</h2>
                    {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
                </div>
                <div class="modal-body">
                    <div class="col-lg-12" style="margin-top: 20px">
                        <form method="post" action="{{ route('admin.sub-category.add') }}">
                            @csrf
                            <div class="form-group">
                                <label>Tên chuyên mục</label>
                                <input autofocus required="required" class="form-control" type="text" name="name" placeholder="Tên chuyên mục....">
                            </div>
                            <div class="form-group">
                                <label>Chuyên mục</label>
                                <select class="form-control" name="category_id">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Thêm</button>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

