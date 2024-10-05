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
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm bài hát</li>
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
                    <label class="col-md-12">Tên bài hát <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="song_name" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Mô tả</label>
                    <div class="col-md-12">
                        <input type="text" name="description" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Lời bài hát</label>
                    <div class="col-md-12">
                        <textarea name="lyrics" class="form-control form-control-line" id="editor1"></textarea>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Ca sĩ</label>
                    <div class="col-md-12">
                        <select class="form-select" name="singers_id" aria-label="Default select example">
                            <option selected>Chọn ca sĩ</option>
                            <option value="1">Vũ</option>
                            <option value="2">Sơn Tùng</option>
                            <option value="3">Vương Anh Tú</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Thể loại</label>
                    <div class="col-md-12">
                        <select class="form-select" name="categorie_id" aria-label="Default select example">
                            <option selected>Chọn thể loại</option>
                            <option value="1">Pop</option>
                            <option value="2">Balad</option>
                            <option value="3">Rap</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Hình ảnh</label>
                    <div class="col-md-12">
                        <input type="file" name="song_image">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Ngày phát hành</label>
                    <div class="col-md-12">
                        <input type="date" name="release_date" value="" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Có chi viết nớ</label>
                    <div class="col-md-12">
                        <textarea name="content" class="form-control form-control-line" id="editor1"></textarea>
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
