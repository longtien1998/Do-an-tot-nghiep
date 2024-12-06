@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Chi tiết tài khoản</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('users.list')}}" class="text-decoration-none">Danh sách tài khoản</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Chi tiết tài khoản</li>
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
            <form class="form-horizontal form-material" action="{{route('users.update', $users->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group mt-3">
                    <label class="col-md-12">Tên <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="name" value="{{old('name', $users->name)}}" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Email <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="email" name="email" value="{{old('email', $users->email)}}" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12">Số điện thoại</label>
                        <div class="col-md-12">
                            <input type="text" name="phone" value="{{old('phone', $users->phone)}}" class="form-control form-control-line">
                        </div>
                    </div>

                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12">Giới tính</label>
                        <select class="form-select" name="gender" >
                            <option value="">Chọn giới tính</option>
                            <option value="Nam" {{ old('gender', $users->gender) == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ old('gender', $users->gender) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                        </select>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12">Sinh nhật</label>
                        <div class="col-md-12">
                            <input type="date" name="birthday" value="{{old('birthday', $users->birthday)}}" class="form-control form-control-line">
                        </div>
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12">Loại người dùng</label>
                        <select class="form-select" name="users_type" >
                            <option value="Basic" {{ old('users_type', $users->users_type) == 'Basic' ? 'selected' : '' }}>Basic</option>
                            <option value="Plus" {{ old('users_type', $users->users_type) == 'Plus' ? 'selected' : '' }}>Plus</option>
                            <option value="Premium" {{ old('users_type', $users->users_type) == 'Premium' ? 'selected' : '' }}>Premium</option>
                        </select>
                    </div>

                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12">Ngày hết hạn</label>
                        <div class="col-md-12">
                            <input type="date" name="expiry_date" value="{{old('expiry_date', $users->expiry_date)}}" class="form-control form-control-line">
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="col-md-12">Hình ảnh</label>
                    <div class="col-md-12">
                        <input type="file" name="image" id="user-image" value="{{old('image', $users->image)}}" class="form-control form-control-line">
                    </div>
                    <img class="mt-3" id="previewImage" src="{{$users->image}}" width="400px" height="500px" alt="">
                </div>
                <div class="form-group mt-3">
                    <div class="col-sm-12">
                        <button class="btn btn-success" type="submit">Cập nhật</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updatePass">
                            Cập nhật mật khẩu
                        </button>

                    </div>
                </div>
            </form>
            <!-- Modal -->
            <div class="modal fade" id="updatePass" tabindex="-1" aria-labelledby="updatePassLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="updatePassLabel">Cập nhật mật khẩu</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('users.updatePass', $users->id)}}" id="uppass" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="passUpdate" class="form-label">Mật khẩu</label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control" id="passUpdate">
                                        <span class="input-group-text" id="togglePassword">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="button" id="savePass" class="btn btn-primary">Lưu</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    const previewImage = document.getElementById('previewImage');
    if (previewImage.src !== undefined && previewImage.src !== null) {
        previewImage.classList.remove('d-none');
    }

    // const button = document.getElementById('editBtn');
    // button.addEventListener('click', function() {
    //     const inputs = document.querySelectorAll('#formedit .update, #formedit #submit');

    //     inputs.forEach(input => {
    //         if (input.hasAttribute('disabled')) {
    //             input.removeAttribute('disabled');
    //         } else {
    //             input.setAttribute('disabled', '');
    //         }
    //     });

    //     // Đổi nội dung nút giữa "Chỉnh sửa" và "Khóa lại"
    //     button.textContent = button.textContent === 'Chỉnh sửa' ? 'Khóa lại' : 'Chỉnh sửa';
    // });


    document.getElementById('user-image').addEventListener('change', function(event) {
        const file = event.target.files[0]; // Lấy file đầu tiên từ input
        const preview = document.getElementById('previewImage'); // Thẻ <img> để hiển thị ảnh

        if (file) {
            const reader = new FileReader(); // Tạo FileReader để đọc file

            reader.onload = function(e) {
                preview.src = e.target.result; // Đặt src của <img> bằng kết quả đọc file
            };

            reader.readAsDataURL(file); // Đọc file dưới dạng URL
            preview.classList.remove('d-none'); // Hiển thị ảnh preview
        } else {
            preview.src = ''; // Nếu không có file, bỏ ảnh preview
        }
    });
    $(document).ready(function() {
        $('#savePass').on('click', function() {
            $('#uppass').submit();
        });
        $('#togglePassword').on('click', function() {
            const passwordField = $('#passUpdate');
            const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
            passwordField.attr('type', type);

            // Đổi biểu tượng mắt
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');

        });
    });
</script>

@endsection
