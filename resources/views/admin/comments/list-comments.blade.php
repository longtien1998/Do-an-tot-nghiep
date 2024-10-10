@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách bình luận</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách bình luận</li>
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
                <th scope="col">Bình luận</th>
                <th scope="col">Đánh giá</th>
                <th scope="col">Mã người dùng</th>
                <th scope="col">Mã bài hát</th>
                <th scope="col">Ngày đánh giá</th>
                <th scope="col">Hành dộng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comments as $comment)
            <tr>
                <th scope="row">{{$comment->id}}</th>
                <td>{{$comment->comment}}</td>
                <td>{{$comment->rating}}</td>
                <td>{{$comment->user_id}}</td>
                <td>{{$comment->song_id}}</td>
                <td>{{$comment->rating_date}}</td>
                <td>
                    <a href="{{route('update_comments', $comment->id)}}"> <i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="{{route('delete-comments', $comment->id)}}" onclick="return confirmDelete()" class="p-2"><i class="fa-solid fa-trash"></i></a>
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
@section("js-listCmt")
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
