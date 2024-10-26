@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Thêm bài hát</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Bài hát</li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm bài hát</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mb-5">
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
            <form class="form-horizontal form-material" method="POST" enctype="multipart/form-data" action="{{route('store-music')}}">
                @csrf
                <div class="form-group">
                    <label class="col-md-12">Tên bài hát <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="song_name" value="{{old('song_name')}}" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Mô tả</label>
                    <div class="col-md-12">
                        <input type="text" name="description" value="{{old('description')}}" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Lời bài hát</label>
                    <div class="col-md-12">
                        <textarea name="lyrics" class="form-control form-control-line" id="editor1">{{old('lyrics')}}</textarea>
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12">Ca sĩ</label>
                        <select class="form-select" name="singers_id" aria-label="Default select example" value="{{old('singers_id')}}">
                            <option selected value="">Chọn ca sĩ</option>
                            <option value="1">Vũ</option>
                            <option value="2">Sơn Tùng</option>
                            <option value="hi">Vương Anh Tú</option>
                        </select>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12">Thể loại</label>
                        <select class="form-select" name="categories_id" aria-label="Default select example" value="{{old('categories_id')}}">
                            <option selected value="">Chọn thể loại</option>

                            @foreach ( $Categories as $category)
                            <option value="{{$category->id}}">{{$category->categorie_name}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12">Ngày phát hành</label>
                        <input type="date" name="release_day" value="{{old('release_day')}}" class="form-control form-control-line">

                    </div>
                </div>
                <div class="form-group row mt-3">
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12">Quốc gia</label>
                        <input type="text" name="country" class="form-control form-control-line" value="{{old('country')}}">
                        <select class="form-select" name="country" aria-label="Default select example" value="{{old('country')}}">
                            <option selected value="">Chọn quốc gia</option>

                            @foreach ( $Countries as $country)
                            <option value="{{$country->id}}">{{$country->name_country}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12">Nhà cung cấp</label>
                        <input type="text" name="provider" class="form-control form-control-line" value="{{old('provider')}}">
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12">Nhà soạn nhạc</label>
                        <input type="text" name="composer" class="form-control form-control-line" value="{{old('composer')}}">
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12">File nhạc Basic</label>
                        <input type="file" name="file_basic" accept="audio/mp3" >
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12">File nhạc Plus</label>
                        <input type="file" name="file_plus" accept="audio/mp3" >
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12">File nhạc Premium</label>
                        <input type="file" name="file_premium" accept="audio/mp3" >
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Hình ảnh</label>
                    <div class="col-md-12">
                        <input type="file" name="song_image" id="songImage" accept="image/*" >
                    </div>
                    <img id="previewImage" src="" alt="Image Preview" style="max-width: 300px; margin-top: 10px;" class="d-none">
                </div>
                <div class="form-group mt-4">
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
    document.getElementById('songImage').addEventListener('change', function(event) {
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
