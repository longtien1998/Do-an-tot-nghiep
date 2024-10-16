@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách thể loại</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách thể loại</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="form-group">
        <div class="col-sm-12 my-3">
            <a href="{{route('add-categories')}}" class="btn btn-success">Thêm thể loại</a>
        </div>
    </div>
    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên thể loại</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Rap</td>
                <td>mô tả</td>
                <td>
                    <a href="{{route('update-categories')}}"> <i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="" class="p-2"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
        </tbody>
    </table>

</div>

@endsection
