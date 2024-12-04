@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách album</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách bài hát trong album</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('albums.list')}}" class="btn btn-outline-success"> Tất cả bài hát trong album</a>
            <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#createAlbumSong">Thêm bài hát trong album</button>
            <!-- modal thêm bài hát trong album -->
            <div class="modal fade" id="createAlbumSong" tabindex="-1" aria-labelledby="createAlbumSongLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="row g-3 needs-validation" novalidate method="post" action="" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="createAlbumSongLabel">Thêm mới quốc gia</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12 position-relative">
                                    <label for="validationTooltip01" class="form-label">Album</label>
                                    <select name="album_id" id="album_id" class="form-control">
                                        <option selected value="">Chọn Album</option>
                                        @foreach ($albums as $album)
                                        <option value="{{$album->id}}">{{ $album->album_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 my-3 position-relative">
                                    <label for="validationTooltip01" class="form-label">Bài hát</label>
                                    <select name="song_id" id="song_id" class="form-control">
                                        <option selected value="">Chọn Bài Hát</option>
                                        @foreach ($songs as $song)
                                        <option value="{{$song->id}}">{{ $song->song_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button class="btn btn-primary" type="submit">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{ route('albums.search') }}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên album..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="form-group col-12 my-4">
            <h5>Bộ Lọc</h5>
            <form action="{{route('albums.albumsongs.list')}}" class="row align-middle" method="post" id="itemsPerPageForm">
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
                    <label for="">Theo Album</label>
                    <select name="filterAlbum" id="indexPage" class="form-select" onchange="submitForm()">
                        <option value="{{request()->input('filterAlbum') ? request()->input('filterAlbum') : ''}}" selected>
                            {{request()->input('filterAlbum') ? \App\Models\Album::find(request()->input('filterAlbum'))->album_name : 'Chọn Album'}}
                        </option>
                        @foreach ( $albums as $album)
                        <option value="{{$album->id}}" >{{$album->album_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-sm">
                    <label for="">Theo Bài Hát</label>
                    <select name="filterSong" id="indexPage" class="form-select" onchange="submitForm()">
                        <option value="{{request()->input('filterSong') ? request()->input('filterSong') : ''}}" selected>
                            {{request()->input('filterSong') ? \App\Models\Music::find(request()->input('filterSong'))->song_name : 'Chọn Bài Hát'}}
                        </option>
                        @foreach ( \App\Models\Music::all() as $song)
                        <option value="{{$song->id}}">{{$song->song_name}}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="col-sm-6 my-3">
            <div>Đã chọn <strong id="total-songs">0</strong> mục</div>
        </div>
        <div class="col-sm-6 my-3">
            <form action="{{ route('albums.delete-list') }}" class="d-inline float-end" method="post" id="form-delete">
                @csrf
                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Xác nhận xóa album đã chọn?')">Xóa bài hát trong album</button>
            </form>
        </div>
    </div>
    <table class="table text-center" id="myTable">
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_list" class=""></th>
                <th scope="col">STT</th>
                <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(3)">Tên album <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(3)">Bài hát <span class="sort-icon">⬍</span></th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @if(count($albumsong))
            @foreach ($albumsong as $index => $album)
            <tr>
                <td><input type="checkbox" class="check_list" value="{{ $album->id }}"></td>
                <td>{{ $album->id }}</td>
                <td>{{ $album->album_id }}</td>
                <td>{{ $album->song_id }}</td>
                <td>
                    <a class="btn btn-link btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editAlbumSong" onclick="editAlbumSong('{{$album->id}}','{{$album->album_id}}','{{$album->song_id}}')">
                        <i class="fa-solid fa-edit"></i>
                    </a>

                    <form action="{{ route('albums.delete', $album->id) }}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" data-bs-toggle="tooltip" title=""
                            class="btn btn-link btn-danger" data-original-title="Remove"
                            onclick="return confirm('Xác nhận xóa album?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
            @else
            <tr class="text-center">
                <td colspan="10">Không có dữ liệu</td>
            </tr>
            @endif
        </tbody>
    </table>
    <div class="mb-5">
        {!! $albumsong->links('pagination::bootstrap-5') !!}
    </div>


    <!-- Modal edit-->
    <div class="modal fade" id="editCountry" tabindex="-1" aria-labelledby="editCountryLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="row g-3 needs-validation" novalidate method="post" action="" id="formEditCountry" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="createCoutryLabel">Chỉnh sửa bài hát trong album/h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 position-relative">
                            <label for="validationTooltip01" class="form-label">Album</label>
                            <select name="album_id" id="album_id" class="form-control">
                                <option selected value="">Chọn Album</option>
                                @foreach ($albums as $album)
                                <option value="{{$album->id}}">{{ $album->album_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 my-3 position-relative">
                            <label for="validationTooltip01" class="form-label">Bài hát</label>
                            <select name="song_id" id="song_id" class="form-control">
                                <option selected value="">Chọn Bài Hát</option>
                                @foreach ($songs as $song)
                                <option value="{{$song->id}}">{{ $song->song_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button class="btn btn-primary" type="submit">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.querySelector('#check_all_list').addEventListener('click', function() {
        var checkboxes = document.getElementsByClassName('check_list');

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }

        getCheckedValues()

    });
    // Gán sự kiện 'submit' cho form
    document.getElementById('form-delete').addEventListener('submit', function(e) {
        return submitForm(e, 'check_list'); // Gọi hàm submitForm khi gửi
    });

    const checkboxes = document.getElementsByClassName('check_list');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('click', getCheckedValues);

    }
    // form show list page
    function submitForm() {
        document.getElementById('itemsPerPageForm').submit();
    }

    const updateRoute = "{{ route('update-country', ['id' => '__ID__']) }}";

    function editAlbumSong() {
        let id = arguments[0];
        let album_id = arguments[1];
        let song_id = arguments[2];

        const finalAction = updateRoute.replace('__ID__', id);
        $('#album_id').val(album_id);
        $('#song_id').val(song_id);
        $('#formEditCountry').attr('action', finalAction);
    }
</script>
@endsection
