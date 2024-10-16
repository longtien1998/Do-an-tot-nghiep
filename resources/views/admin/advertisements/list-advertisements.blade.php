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
                <th scope="col">Đường dẫn</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($advertisements as $ads)
            <tr>
                <th scope="row">{{$ads->id}}</th>
                <td>{{$ads->ads_name}}</td>
                <td>{{$ads->ads_description}}</td>
                <td><a href="{{asset('admin/upload/ads/'. $ads->file_path)}}">{{$ads->file_path}}</a></td>
                <td>
                    <a href="{{route('update-advertisements',$ads->id)}}"> <i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="{{route('delete-advertisements', $ads->id)}}" onclick=" return confirmDelete()" class="p-2"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
        {{session('success')}}
    </div>
    @endif
    <div class="form-group">
        <div class="col-sm-12">
            <a href="{{route('add-advertisements')}}" class="btn btn-success">Thêm quảng cáo</a>
        </div>
    </div>
</div>

@endsection

