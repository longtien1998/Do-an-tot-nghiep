@extends('admin.layouts.app')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Chỉnh sửa album</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">Trang chủ</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('albums.list') }}">Danh sách album</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa album</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card" style="border: none; border-radius: 0px;">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h5>Thông báo !</h5>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <!-- Form Chỉnh Sửa Album -->
                <form action="{{ route('albums.update', $album->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="album_name">Tên album</label>
                        <input type="text" class="form-control" name="album_name" id="album_name"
                            value="{{ old('album_name', $album->album_name) }}">
                    </div>
                    <div class="form-group mt-3">
                        <label for="singer_id">Ca sĩ</label>
                        <select name="singer_id" id="singer_id" class="form-control">
                            @foreach ($singers as $singer)
                                <option value="{{ $singer->id }}" @if ( $album->singer_id == $singer->id ) selected @endif>{{ $singer->singer_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 my-3 position-relative">
                        <label for="validationTooltip01" class="form-label">Ảnh nền</label>
                        <input type="file" class="form-control" value="{{$album->image}}" name="image" id="imageAdd">
                        <img id="previewImageAdd" src="{{$album->image}}" alt="Image Preview"
                            style="max-width: 300px; margin-top: 10px;" class="d-none">
                        <div class="valid-tooltip">
                            Looks good!
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label for="creation_date">Ngày tạo</label>

                        <input type="text" class="form-control" value="{{ $album->creation_date }}"
                            disabled>
                    </div>

                    <div class="form-group mt-3">
                        <div class="col-sm-12">
                            <button class="btn btn-success" type="submit">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.getElementById('imageAdd').addEventListener('change', function(event) {
            const file = event.target.files[0]; // Lấy file đầu tiên từ input
            const preview = document.getElementById('previewImageAdd'); // Thẻ <img> để hiển thị ảnh

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

        $(document).ready(function(){
            const img = $('#previewImageAdd');
            if(img.attr('src')){
                img.removeClass('d-none'); // Hiển thị ảnh preview
            } else {
                img.addClass('d-none'); // Hiển thị ảnh preview
            }
        });
    </script>
@endsection
