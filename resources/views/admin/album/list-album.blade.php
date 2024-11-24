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
                            <li class="breadcrumb-item active" aria-current="page">Danh sách album</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="form-group row justify-content-between m-0 p-0">
            <div class="col-sm-6 my-3">
                <a href="{{ route('albums.add') }}" class="btn btn-success">Thêm album</a>
            </div>
            <div class="col-sm-3 my-3">
                <form class="search-form" action="{{ route('albums.search') }}" method="post">
                    @csrf
                    <input type="text" name="search" placeholder="Tên bình luận..." required />
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
        <div class="form-group row justify-content-between m-0 p-0">
            <div class="col-sm-6 my-3">
                <div>Đã chọn <strong id="total-songs">0</strong> mục</div>
            </div>
            <div class="col-sm-6 my-3">
                <form action="{{ route('albums.delete-list') }}" class="d-inline float-end" method="post" id="form-delete">
                    @csrf
                    <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Xác nhận xóa album đã chọn?')">Xóa album</button>
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
                    <th scope="col">Ca sĩ</th>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col" onclick="sortTable(5)">Ngày tạo <span class="sort-icon">⬍</span></th>
                    <th scope="col">Lượt nghe</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($albums as $index => $album)
                    <tr>
                        <td><input type="checkbox" class="check_list" value="{{ $album->id }}"></td>
                        <td>{{ $albums->firstItem() + $index }}</td>
                        <td>{{ $album->id }}</td>
                        <td>{{ $album->album_name }}</td>
                        <td>{{ $album->singer ? $album->singer->singer_name : 'N/A' }}</td>

                        <td>
                            @if ($album->image)
                                <img width="50" height="50" src="{{ $album->image }}" alt="">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ $album->creation_date }}</td>
                        <td>{{ $album->listen_count }}</td>
                        <td>
                            <a href="{{ route('albums.edit', $album->id) }}" class="btn btn-link btn-outline-warning">
                                <i class="fa-solid fa-pen-to-square"></i>
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
            </tbody>
        </table>
        <div class="mb-5">
            {!! $albums->links('pagination::bootstrap-5') !!}
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
    </script>
@endsection
