@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb mb-5">
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
    <div class="form-group row justify-content-between align-content-center m-0 p-0">
        <div class="form-group col-12 my-auto">
            <h5>Bộ Lọc</h5>
            <form action="{{route('list-music')}}" class="row align-middle" method="post" id="itemsPerPageForm">
                @csrf
                <div class="col-6 col-sm">
                    <label for="">Hiển thị</label>
                    <select name="indexPage" id="indexPage" class="form-select" onchange="submitForm()">
                        <option value="10" {{request()->input('indexPage') == 10 ? 'selected' : ''}}>10</option>
                        <option value="20" {{request()->input('indexPage') == 20 ? 'selected' : ''}}>20</option>
                        <option value="50" {{request()->input('indexPage') == 50 ? 'selected' : ''}}>50</option>
                        <option value="100" {{request()->input('indexPage') == 100 ? 'selected' : ''}}>100</option>
                        <option value="200" {{request()->input('indexPage') == 200 ? 'selected' : ''}}>200</option>
                        <option value="500" {{request()->input('indexPage') == 500 ? 'selected' : ''}}>500</option>
                        <option value="1000" {{request()->input('indexPage') == 1000 ? 'selected' : ''}}>1000</option>
                    </select>
                </div>
                <div class="col-6 col-sm">
                    <label for="">Theo thể loại</label>
                    <select name="filterTheloai" id="indexPage" class="form-select" onchange="submitForm()">
                        <option value=""></option>
                        <option value="{{request()->input('filterTheloai') ? request()->input('filterTheloai') : ''}}" selected>
                        {{request()->input('filterTheloai') ? \App\Models\Categories::find(request()->input('filterTheloai'))->categorie_name : 'Chọn Thể loại'}}
                        </option>
                        @foreach ( \App\Models\Categories::all() as $categori)
                            <option value="{{$categori->id}}">{{$categori->categorie_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-sm">
                    <label for="">Theo Ca sỹ</label>
                    <select name="filterSinger" id="indexPage" class="form-select" onchange="submitForm()">
                        <option value="" selected></option>
                        <option value="{{request()->input('filterSinger') ? request()->input('filterSinger') : ''}}" selected>
                        {{request()->input('filterSinger') ? \App\Models\Singer::find(request()->input('filterSinger'))->singer_name : 'Chọn Ca sỹ'}}
                        </option>
                        @foreach ( \App\Models\Singer::all() as $singer)
                            <option value="{{$singer->id}}">{{$singer->singer_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-sm">
                    <label for="">Ngày Phát hành</label>
                    <input type="date" name="filterRelease" class="form-control" value="{{request()->input('filterRelease') ? request()->input('filterRelease') : ''}}" onchange="submitForm()">
                </div>
                <div class="col-6 col-sm">
                    <label for="">Ngày tạo</label>
                    <input type="date" name="filterCreate" class="form-control" value="{{request()->input('filterCreate') ? request()->input('filterCreate') : ''}}" onchange="submitForm()">
                </div>
            </form>
        </div>
        <div class="col-sm-5 my-auto">
            <div class="align-middle">Đã chọn <strong id="total-songs">0</strong> bài hát</div>
        </div>
        <div class="col-sm-6 my-auto">
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
            @foreach($songs as $index => $song)
            <tr>
                <td><input type="checkbox" class="check_song" value="{{$song->id}}"></td>
                <th scope="row">{{$songs->firstItem() + $index}}</th>
                <td>{{$song->id}}</td>
                <td>{{$song->song_name}}</td>
                <td>{{Str::limit($song->description, 20, '...') }}</td>
                <td><img src="{{$song->song_image}}" alt="image {{$song->song_name}}" width="50"></td>
                <td>{{$song->category_name}}</td>
                <td>{{$song->singer_name}}</td>
                <td>{{$song->release_day}}</td>
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
            @endforeach
        </tbody>

    </table>

    <div class=" mb-5">
        {!! $songs->links('pagination::bootstrap-5') !!}
    </div>

</div>

@endsection

@section('js')
<script>
    document.querySelector('#check_all_songs').addEventListener('click', function() {
        var checkboxes = document.getElementsByClassName('check_song');

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }

        getCheckedValues()

    });
    // Gán sự kiện 'submit' cho form
    document.getElementById('form-delete').addEventListener('submit', function(e) {
        return submitForm(e, 'check_song'); // Gọi hàm submitForm khi gửi
    });

    const checkboxes = document.getElementsByClassName('check_song');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('click', getCheckedValues);

    }
    // form show list page
    function submitForm() {
        document.getElementById('itemsPerPageForm').submit();
    }
</script>

@endsection
