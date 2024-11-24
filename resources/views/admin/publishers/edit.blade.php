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
                        <li class="breadcrumb-item">
                            <a href="{{route('publishers.index')}}">Nhà xuất bản</a>
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
            <form class="form-horizontal form-material row" id="formedit" action="{{route('publishers.update',$publisher->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    <label class="col-md-12">Tên nhà xuất bản <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="publisher_name" value="{{$publisher->publisher_name}}" class="form-control form-control-line update" disabled>
                    </div>
                </div>
                <div class="form-group col-md-4 mt-3">
                    <label class="col-md-12">Tên gọi khác </label>
                    <div class="col-md-12">
                        <input type="text" name="alias_name" value="{{$publisher->alias_name}}" class="form-control form-control-line update" disabled>
                    </div>
                </div>
                <div class="form-group col-md-4 mt-3">
                    <label class="col-md-12">Quốc gia</label>
                    <div class="col-md-12">
                        <input type="text" name="country" value="{{$publisher->country}}" class="form-control form-control-line update" disabled>
                    </div>
                </div>
                <div class="form-group col-md-4 mt-3">
                    <label class="col-md-12">Thành phố </label>
                    <div class="col-md-12">
                        <input type="text" name="city" value="{{$publisher->city}}" class="form-control form-control-line update" disabled>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Địa chỉ </label>
                    <div class="col-md-12">
                        <input type="text" name="address" value="{{$publisher->address}}" class="form-control form-control-line update" disabled>
                    </div>
                </div>
                <div class="form-group col-md-4 mt-3">
                    <label class="col-md-12">Trang web </label>
                    <div class="col-md-12">
                        <input type="text" name="website" value="{{$publisher->website}}" class="form-control form-control-line update" disabled>
                    </div>
                </div>
                <div class="form-group col-md-4 mt-3">
                    <label class="col-md-12">Email </label>
                    <div class="col-md-12">
                        <input type="email" name="email" value="{{$publisher->email}}" class="form-control form-control-line update" disabled>
                    </div>
                </div>
                <div class="form-group col-md-4 mt-3">
                    <label class="col-md-12">Số điện thoại</label>
                    <div class="col-md-12">
                        <input type="text" name="phone" value="{{$publisher->phone}}" class="form-control form-control-line update" disabled>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Logo</label>
                    <div class="col-md-12">
                        <input type="file" name="logo" value="{{$publisher->logo}}" id="logoImage" accept="image/*" class="form-control form-control-line update" disabled>
                    </div>
                    <img id="previewImage" src="{{$publisher->logo}}" alt="Image Preview" style="max-width: 300px; margin-top: 10px;" class="d-none">
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Mô tả</label>
                    <div class="col-md-12">
                        <textarea name="description" class="form-control form-control-line update" id="editor1" disabled>{{$publisher->description}}</textarea>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Ngày tạo: {{$publisher->created_at}}</label>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Ngày update: {{$publisher->updated_at}}</label>
                </div>
                <div class="form-group mt-3" style="margin-bottom: 30px;">
                    <div class="col-sm-12">
                        <button class="btn btn-warning" id="editBtn">Chỉnh sửa</button>
                        <button class="btn btn-success" id="submit"  type="submit" disabled>Lưu</button>
                    </div>
                </div>
            </form>
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

    const button = document.getElementById('editBtn');
    button.addEventListener('click', function(e) {
        const inputs = document.querySelectorAll('#formedit .update, #formedit #submit');
        e.preventDefault();
        inputs.forEach(input => {
            if (input.hasAttribute('disabled')) {
                input.removeAttribute('disabled');
            } else {
                input.setAttribute('disabled', '');
            }
        });

        // Đổi nội dung nút giữa "Chỉnh sửa" và "Khóa lại"
        button.textContent = button.textContent === 'Chỉnh sửa' ? 'Khóa lại' : 'Chỉnh sửa';
    });


    document.getElementById('logoImage').addEventListener('change', function(event) {
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
</script>

@endsection
