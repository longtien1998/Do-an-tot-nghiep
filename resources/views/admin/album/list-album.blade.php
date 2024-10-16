@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách album</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách album</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="form-group">
        <div class="col-sm-12 my-3">
            <a href="{{route('add-album')}}" class="btn btn-success">Thêm album</a>
        </div>
    </div>
    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên album</th>
                <th scope="col">Ca sĩ</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Lượt nghe</th>
                <th scope="col">Hành dộng</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Album 1</td>
                <td>Vũ</td>
                <td>03/10/1998</td>
                <td><img width="50px" height="50px" src="/admin/image/singer/unnamed.jpg" alt=""></td>
                <td>12</td>
                <td>
                    <a href="{{route('update-album')}}"> <i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="" class="p-2"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
        </tbody>
    </table>

</div>

@endsection
