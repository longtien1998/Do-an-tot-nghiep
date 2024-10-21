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

<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('list-music')}}" class="btn btn-outline-success"> Tất cả bài hát</a>
            <a href="{{route('add-music')}}" class="btn btn-success">Thêm bài hát</a>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{route('search-song')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên bài hát..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <div>Đã chọn <strong id="total-songs">0</strong> bài hát</div>
        </div>
        <div class="col-sm-6 my-3">
            <form action="{{route('delete-list-music')}}" class="d-inline float-end" method="post" id="form-delete">
                @csrf
                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận xóa bài hát đã chọn?')">Xóa bài hát</button>
            </form>
        </div>

    </div>
    <table class="table text-center" id="myTable">

        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_songs" class=""></th>
                <th scope="col">STT</th>
                <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(3)">Tên bài hát <span class="sort-icon"> ⬍ </span></th>
                <th scope="col">Mô tả</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col" onclick="sortTable(6)">Thể loại <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(7)">Ca sỹ <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(8)">Ngày phát hành <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(9)">Lượt nghe <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(10)">Lượt tải <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(11)">Ngày tạo <span class="sort-icon"> ⬍ </span></th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php $stt = 1; @endphp
            @foreach($songs as $song)
            <tr>
                <td><input type="checkbox" class="check_song" value="{{$song->id}}"></td>
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

                <td>
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

@section('js')
<script>
    // Gán sự kiện 'submit' cho form
    document.getElementById('form-delete').addEventListener('submit', function(e) {
        return submitForm(e, 'check_song'); // Gọi hàm submitForm khi gửi
    });

    const checkboxes = document.getElementsByClassName('check_song');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('click', getCheckedValues);

    }
</script>

@endsection
