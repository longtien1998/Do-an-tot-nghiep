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
            <form class="form-horizontal row form-material" action="{{route('singer.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="col-md-12">Tên ca sĩ <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="singer_name" value="{{old('singer_name')}}" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label class="col-md-12">Ảnh đại diện</label>
                    <div class="col-md-12">
                        <input type="file" name="singer_image" id="image" value="{{old('singer_image')}}" class="form-control form-control-line">
                    </div>
                    <img id="previewImage" src="" alt="Image Preview" style="max-width: 300px; margin-top: 10px;" class="d-none">
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label class="col-md-12">Hình nền</label>
                    <div class="col-md-12">
                        <input type="file" name="singer_background" id="image2" value="{{old('singer_background')}}"  class="form-control form-control-line">
                    </div>
                    <img id="previewImage2" src="" alt="Image Preview" style="max-width: 300px; margin-top: 10px;" class="d-none">
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Ngày sinh</label>
                    <div class="col-md-12">
                        <input type="date" name="singer_birth_date" id="singer_birth_date" value="{{old('singer_birth_date')}}" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Tiểu sử</label>
                    <div class="col-md-12">
                        <textarea name="singer_biography" class="form-control form-control-line" id="editor1">{{old('singer_biography')}}</textarea>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Giới tính</label>
                    <div class="col-md-12">
                        <select class="form-select" name="singer_gender" aria-label="Default select example">
                            <option value="">Chọn giới tính</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Quê quán</label>
                    <div class="col-md-12">
                        <input type="text" name="singer_country" value="{{old('singer_country')}}" class="form-control form-control-line">
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
        $('#image').on('change', function() {
            previewImage(this,'previewImage')
        });
        $('#image2').on('change', function() {
            previewImage(this,'previewImage2')
        });

        validateDay('#singer_birth_date', 'max');
    });
</script>

@endsection
