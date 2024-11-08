@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Thêm tài khoản</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tài khoản</li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm tài khoản</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card" style="border: none; border-radius: 0px;">
        <div class="card-body">
            <form class="form-horizontal form-material" action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mt-3">
                    <label class="col-md-12">Tên <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="name" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Mật khẩu <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="password" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Email <span class="text-danger">(*)</span></label>
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
                    <label class="col-md-12">Hình ảnh</label>
                    <div class="col-md-12">
                        <input type="file" name="image" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Giới tính</label>
                    <select class="form-select" name="gender" id="">
                        <option value="">Chọn giới tính</option>
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>

                    </select>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Quyền</label>
                    <select class="form-select" name="role_type" id="">
                        <option value="">Chọn quyền</option>
                        <option value="1">Nhân viên</option>
                        <option value="2">Người dùng</option>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Loại người dùng</label>
                    <select class="form-select" name="users_type" id="">
                        <option value="Basic" selected>Basic</option>
                        <option value="Plus">Plus</option>
                        <option value="Premium">Premium</option>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Sinh nhật</label>
                    <div class="col-md-12">
                        <input type="date" name="birthday" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <div class="col-sm-12">
                        <button class="btn btn-success" type="submit">Thêm mới</button>
                    </div>
                </div>
            </form>
            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5>Thông báo !</h5>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
