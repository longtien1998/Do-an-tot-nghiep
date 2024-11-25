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
            <form class="form-horizontal form-material" action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mt-3">
                    <label class="col-md-12">Tên <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="name" class="form-control form-control-line" value="{{old('name')}}">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Mật khẩu <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="password" class="form-control form-control-line" value="{{old('password')}}">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Email <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="email" name="email" class="form-control form-control-line" value="{{old('email')}}">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Số điện thoại</label>
                    <div class="col-md-12">
                        <input type="text" name="phone" class="form-control form-control-line" value="{{old('phone')}}">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Hình ảnh</label>
                    <div class="col-md-12">
                        <input type="file" name="image" class="form-control form-control-line" value="{{old('image')}}">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Giới tính</label>
                    <select class="form-select" name="gender" id="" value="{{old('gender')}}">
                        <option value="">Chọn giới tính</option>
                        <option value="nam">Nam</option>
                        <option value="nu">Nữ</option>

                    </select>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Loại người dùng</label>
                    <select class="form-select" name="users_type" id="" value="{{old('users_type')}}">
                        <option value="Basic" selected>Basic</option>
                        <option value="Plus">Plus</option>
                        <option value="Premium">Premium</option>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Sinh nhật</label>
                    <div class="col-md-12">
                        <input type="date" name="birthday" id="birthday" value="{{old('birthday')}}" class="form-control form-control-line">
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
@section('js')
<script>
    $(document).ready(function() {
        // validate ngày
        const dateInput = $('#birthday');

        // Lấy ngày hôm nay ở định dạng YYYY-MM-DD
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0-11, cần +1
        const dd = String(today.getDate()).padStart(2, '0'); // Ngày trong tháng

        // Thiết lập giá trị tối đa cho thẻ input là hôm nay
        const maxDate = `${yyyy}-${mm}-${dd}`;
        dateInput.attr('max', maxDate);

        // Xử lý sự kiện thay đổi trên input để kiểm tra tính hợp lệ (nếu cần)
        dateInput.on('change', function() {
            if (new Date(dateInput.val()) > new Date(maxDate)) {
                dateInput.addClass('is-invalid');
                dateInput.val(''); // Xóa giá trị nếu chọn không hợp lệ
            } else {
                dateInput.addClass('is-valid');
            }
        });
    });
</script>
@endsection
