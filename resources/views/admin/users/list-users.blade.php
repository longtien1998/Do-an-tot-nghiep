@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách tài khoản</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách tài khoản</li>
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
                <th scope="col">Tên</th>
                <th scope="col">Họ</th>
                <th scope="col">Email</th>
                <th scope="col">Điện thoại</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Giới tính</th>
                <th scope="col">Ngày sinh</th>
                <th scope="col">Quyền</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <th scope="row">{{$user->id}}</th>
                <td>{{$user->firstname}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->phone}}</td>
                <td><img width="50px" height="50px" src="{{asset('upload/image/users/'. $user->image)}}" alt=""></td>
                <td>{{$user->gerder}}</td>
                <td>{{$user->birthday}}</td>
                <td>
                    @if ($user->roles == 1)
                    Admin
                    @else
                    Người dùng
                    @endif
                </td>
                <td >
                    <a href="{{route('update-users', $user->id)}}"> <i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="{{route('delete-users', $user->id)}}" onclick="return confirmDelete()" class="p-2"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4><i class="icon fa fa-check"></i> Thông báo !</h4>
        {{session('success')}}
    </div>
    @endif
</div>

@endsection
@section("js-listUsers")
<script>
    function confirmDelete() {
        if (confirm('Bạn có chắc chắn muốn xóa?')) {
            return true;
        } else {
            return false;
        }
    }
</script>
@endsection
