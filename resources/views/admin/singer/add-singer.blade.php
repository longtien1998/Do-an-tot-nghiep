@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Thêm ca sĩ</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm ca sĩ</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card" style="border: none; border-radius: 0px;">
        <div class="card-body">
            <form class="form-horizontal form-material" action="{{route('singer.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="col-md-12">Tên ca sĩ <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="singer_name" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Hình ảnh</label>
                    <div class="col-md-12">
                        <input type="file" name="singer_image" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Ngày sinh</label>
                    <div class="col-md-12">
                        <input type="date" name="singer_birth_date" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Tiểu sử</label>
                    <div class="col-md-12">
                        <textarea name="singer_biography" class="form-control form-control-line" id="editor1"></textarea>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Giới tính</label>
                    <div class="col-md-12">
                        <select class="form-select" name="singer_gender" aria-label="Default select example">
                            <option selected>Chọn giới tính</option>
                            <option value="1">Nam</option>
                            <option value="2">Nữ</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Quê quán</label>
                    <div class="col-md-12">
                        <input type="text" name="singer_country" value="" class="form-control form-control-line">
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
