@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Thêm quảng cáo</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Quảng cáo</li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm quảng cáo</li>
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
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <h5>Thông báo !</h5>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <form class="form-horizontal form-material" action="{{route('advertisements.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="col-md-12">Tên quảng cáo <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="ads_name" class="form-control form-control-line" value="{{old('ads_name')}}">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Mô tả <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="ads_description" class="form-control form-control-line" value="{{old('ads_description')}}">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Đường dẫn <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="file" name="file_path" class="form-control form-control-line" accept="audio/mp3" value="{{old('file_path')}}">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Hình ảnh <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="file" name="image_path" class="form-control form-control-line" accept="jpg/jpeg/png/gif" value="{{old('image_path')}}">
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
