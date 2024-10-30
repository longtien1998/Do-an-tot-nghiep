@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Tất cả file nhạc</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tất cả file nhạc</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h1 class="text-center mb-4">Quản lý File Bài Hát</h1>
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-3 my-3">
            <div>Đã chọn <strong id="total-songs">0</strong> mục</div>
        </div>
        <div class="col-sm-6 text-center my-3">
            <form action="{{route('s3list-destroy-songs')}}" class="d-inline float-end" method="post" id="form-delete">
                @csrf
                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận xóa Quốc gia đã chọn?')">Xóa file bài hát</button>
            </form>
        </div>

    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_songs" class="check_all_songs"></th>
                <th scope="col">STT</th>
                <th scope="col">File Path</th>
                <th scope="col">URL</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php $stt = 1; @endphp
            @foreach($songs as $song)
            <tr>
                <td><input type="checkbox" class="check_song" value="{{$song['path']}}"></td>
                <td>{{ $stt++ }}</td>
                <td>{{ $song['path'] }}</td>
                <td><a href="{{ $song['url'] }}" target="_blank">Xem file</a></td>
                <td>
                    @if($song['in_use'])
                    <span class="badge bg-success">Đang sử dụng</span>
                    @else
                    <span class="badge bg-secondary">Không sử dụng</span>
                    @endif
                </td>
                <td>
                    @if(!$song['in_use'])
                    <form action="{{ route('s3songs.destroy', ) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="text" name="path" value="{{$song['path']}}" hidden>
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa file này?')">
                            Xóa
                        </button>
                    </form>
                    @else
                    <button class="btn btn-secondary btn-sm" disabled>Đang sử dụng</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
