@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Cập nhật nhà xuất bản</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Cập nhật nhà xuất bản</li>
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
                    <label class="col-md-12">Tên nhà xuất bản <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="publisher_name" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Tên gọi khác </label>
                    <div class="col-md-12">
                        <input type="text" name="alisas_name" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Quốc gia</label>
                    <div class="col-md-12">
                        <input type="text" name="country" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Thành phố </label>
                    <div class="col-md-12">
                        <input type="text" name="city" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Địa chỉ </label>
                    <div class="col-md-12">
                        <input type="text" name="address" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Trang web </label>
                    <div class="col-md-12">
                        <input type="text" name="website" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Email </label>
                    <div class="col-md-12">
                        <input type="email" name="email" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Số điện thoại</label>
                    <div class="col-md-12">
                        <input type="text" name="phone" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Logo</label>
                    <div class="col-md-12">
                        <input type="file" name="logo" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Mô tả</label>
                    <div class="col-md-12">
                        <textarea name="description" class="form-control form-control-line" id="editor1"></textarea>
                    </div>
                </div>
                <div class="form-group mt-3" style="margin-bottom: 30px;">
                    <div class="col-sm-12">
                        <button class="btn btn-success" type="submit">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
