@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Thêm album</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm album</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card" style="border: none; border-radius: 0px;">
        <div class="card-body">
            <form class="form-horizontal form-material" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="col-md-12">Tên album <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="lbum_name" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Ca sĩ</label>
                    <div class="col-md-12">
                        <select class="form-select" name="gender" aria-label="Default select example">
                            <option selected>Chọn ca sĩ</option>
                            <option value="1">Sơn Tùng</option>
                            <option value="2">Vũ</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Ngày tạo</label>
                    <div class="col-md-12">
                        <input type="date" name="creation_date" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Hình ảnh</label>
                    <div class="col-md-12">
                        <input type="file" name="image" value="" class="form-control form-control-line">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="col-md-12">Lượt nghe</label>
                    <div class="col-md-12">
                        <input type="text" name="country" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <div class="col-sm-12">
                        <button class="btn btn-success" type="submit">Thêm mới</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
