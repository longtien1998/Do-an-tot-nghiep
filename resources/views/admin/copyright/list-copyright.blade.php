@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách bản quyền</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách bản quyền</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
<div class="form-group">
        <div class="col-sm-12 my-3">
            <a href="{{route('add-copyright')}}" class="btn btn-success">Thêm bản quyền</a>
        </div>
    </div>
    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên bài hát</th>
                <th scope="col">Nhà xuất bản</th>
                <th scope="col">Loại giấy phép</th>
                <th scope="col">Ngày phát hành</th>
                <th scope="col">Ngày hết hạn</th>
                <th scope="col">Quyền sử dụng</th>
                <th scope="col">Điều khoản</th>
                <th scope="col">Giấy phép</th>
                <th scope="col">Hành dộng</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Bài hát</td>
                <td>Vũ</td>
                <td>Giấy phép 1</td>
                <td>03/10/2024</td>
                <td>03/10/2026</td>
                <td>Quyền</td>
                <td>Điều khoản 1</td>
                <td>Giấy phép 1</td>
                <td>
                    <a href="{{route('update-copyright')}}" > <i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="" class="p-2"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
        </tbody>
    </table>

</div>

@endsection
