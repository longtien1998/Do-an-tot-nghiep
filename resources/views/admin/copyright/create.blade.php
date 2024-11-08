@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Thêm bản quyền</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm bản quyền</li>
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
                <div class="form-group mt-3">
                    <label class="col-md-12">Bài hát</label>
                    <div class="col-md-12">
                        <select class="form-select" name="song_id" aria-label="Default select example">
                            <option selected>Chọn bài hát</option>
                            <option value="1">Những lời hứa bỏ quên</option>
                            <option value="2">Nàng thơ</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Nhà xuất bản</label>
                    <div class="col-md-12">
                        <select class="form-select" name="publisher_id" aria-label="Default select example">
                            <option selected>Chọn nhà xuất bản</option>
                            <option value="1">Sơn Tùng</option>
                            <option value="2">Vũ</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Loại giấy phép</label>
                    <div class="col-md-12">
                        <input type="text" name="license_type" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Ngày phát hành</label>
                    <div class="col-md-12">
                        <input type="date" name="issue_day" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Ngày hết hạn</label>
                    <div class="col-md-12">
                        <input type="date" name="expiry_day" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Quyền sử dụng</label>
                    <div class="col-md-12">
                        <input type="text" name="usage_rights" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Điều khoản</label>
                    <div class="col-md-12">
                        <input type="text" name="terms" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Giấy phép</label>
                    <div class="col-md-12">
                        <input type="text" name="license_file" value="" class="form-control form-control-line">
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
