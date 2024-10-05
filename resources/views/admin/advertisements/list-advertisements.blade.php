@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách quảng cáo</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách quảng cáo</li>
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
                <th scope="col">Tên quảng cáo</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Quảng cáo 1</td>
                <td>Đây là quảng cáo 1</td>
                <td >
                    <a href="{{route('update-advertisements')}}" > <i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="" class="p-2"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="form-group">
        <div class="col-sm-12">
            <a href="{{route('add-advertisements')}}" class="btn btn-success">Thêm quảng cáo</a>
        </div>
    </div>
</div>

@endsection
