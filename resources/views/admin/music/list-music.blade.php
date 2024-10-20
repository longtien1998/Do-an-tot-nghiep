@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách bài hát</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Bài hát</li>

                        <li class="breadcrumb-item active" aria-current="page">Danh sách bài hát</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<style>
    th, td {
        vertical-align: middle;
    }
</style>
<div class="container-fluid">
    <div class="form-group">
        <div class="col-sm-12 my-3">
            <a href="{{route('add-music')}}" class="btn btn-success">Thêm bài hát</a>
        </div>
    </div>
    <table class="table text-center">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">ID</th>
                <th scope="col">Tên bài hát</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Thể loại</th>
                <th scope="col">Ca sỹ</th>
                <th scope="col">Ngày phát hành</th>
                <th scope="col">Lượt nghe</th>
                <th scope="col">Lượt tải</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php $stt = 1; @endphp
            @foreach($songs as $song)
            <tr>
                <th scope="row">{{$stt}}</th>
                <td>{{$song->id}}</td>
                <td>{{$song->song_name}}</td>
                <td>{{$song->description}}</td>
                <td><img src="{{$song->song_image}}" alt="image {{$song->song_name}}" width="50"></td>
                <td>{{$song->category_name}}</td>
                <td></td>
                <td>{{$song->release_date}}</td>
                <td>{{$song->listen_count}}</td>
                <td>{{$song->download_count}}</td>
                <td>{{$song->created_at}}</td>

                <td >
                    <a href="{{route('show-music',$song->id)}}" class="btn btn-link btn-outline-success"> <i class="fa-solid fa-eye"></i></a>
                    <a href="{{route('show-music',$song->id)}}" class="btn btn-link btn-outline-warning"> <i class="fa-solid fa-upload"></i></a>
                    <form action="{{route('delete-music',$song->id)}}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" data-bs-toggle="tooltip" title="" class="btn btn-link btn-outline-danger" data-original-title="Remove" onclick="return confirm('Xác nhận xóa thể loại?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @php $stt++; @endphp
            @endforeach
        </tbody>
    </table>

</div>

@endsection
