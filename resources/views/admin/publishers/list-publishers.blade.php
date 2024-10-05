@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách nhà xuất bản</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách nhà xuất bản</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên nhà xuất bản</th>
                <th scope="col">Tên khác</th>
                <th scope="col">Quốc gia</th>
                <th scope="col">Thành phố</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Trang web</th>
                <th scope="col">Email</th>
                <th scope="col">SĐT</th>
                <th scope="col">Logo</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Vũ</td>
                <td>Nguyễn</td>
                <td>Việt Nam</td>
                <td>TP.HCM</td>
                <td>123</td>
                <td>https://www.nguyenvu.com</td>
                <td>nguyenvu@gmail.com</td>
                <td>0901234567</td>
                <td><img width="50px" height="50px" src="/admin/image/singer/unnamed.jpg" alt=""></td>
                <td>Gia Lai</td>
                <td>
                    <a href="{{route('update-publishers')}}" > <i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="" class="p-2"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="form-group">
        <div class="col-sm-12">
            <a href="{{route('add-publishers')}}" class="btn btn-success">Thêm nhà xuất bản</a>
        </div>
    </div>
</div>

@endsection
