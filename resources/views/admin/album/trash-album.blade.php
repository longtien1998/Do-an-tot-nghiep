@extends('admin.layouts.app')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Danh sách album đã xóa</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none">Trang chủ</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">album</li>

                            <li class="breadcrumb-item active" aria-current="page">Danh sách album đã xóa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="form-group row justify-content-between m-0 p-0">
            <div class="col-sm-6 my-3">
                <a href="{{ route('albums.trash.list') }}" class="btn btn-outline-success"> Tất cả album đã xóa</a>
            </div>
            <div class="col-sm-3 my-3">
                <form class="search-form" action="{{ route('albums.trash.search') }}" method="post">
                    @csrf
                    <input type="text" name="search" placeholder="Tên album đã xóa..." required />
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
        <table class="table text-center" id="myTable">
            <div class="form-group row justify-content-between m-0 p-0">
                <div class="col-sm-6 my-3">
                    <div>Đã chọn <strong id="total-songs">0</strong> mục</div>
                </div>
                <div class="col-sm-6 my-3">
                    <div class="float-end">
                        <form action="{{ route('albums.trash.restore') }}" class="d-inline" method="post"
                            id="form-restore">
                            @csrf
                            <input type="text" value="" name="restore_list" id="songs-restore" hidden>
                            <button type="submit" class="btn btn-success mr-2"
                                onclick="return confirm('Xác nhận khôi phục album đã chọn?')">Khôi phục album</button>
                        </form>
                        <form action="{{ route('albums.trash.delete') }}" class="d-inline" method="post" id="form-delete">
                            @csrf
                            <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list"
                                hidden>
                            <button type="submit" class="btn btn-warning"
                                onclick="return confirm('Xác nhận xóa album đã chọn?')">Xóa album</button>
                        </form>
                        <a href="{{ route('albums.trash.restore-all') }}" class="btn btn-primary"
                            onclick="return confirm('Xác nhận khôi phục tất cả?')">Khôi phục tất cả album</a>
                    </div>

                </div>

            </div>
            <thead>
                <tr>
                    <th><input type="checkbox" name="" id="check_all_list" class="check_all_songs"></th>
                    <th scope="col">STT</th>
                    <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon">⬍</span></th>
                    <th scope="col" onclick="sortTable(3)">Tên Album <span class="sort-icon">⬍</span></th>
                    <th scope="col" onclick="sortTable(5)">Ngày xóa <span class="sort-icon">⬍</span></th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @if(count($albums))
                @foreach ($albums as $index => $album)
                    <tr>
                        <td><input type="checkbox" class="check_list" value="{{ $album->id }}"></td>
                        <th scope="row">{{ $albums->firstItem() + $index }}</th>
                        <td>{{ $album->id }}</td>
                        <td>{{ $album->album_name }}</td>
                        <td>{{ $album->deleted_at }}</td>
                        <td>
                            {{-- <form action="{{ route('albums.trash.restore', $album->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-link btn-outline-success"
                                    onclick="return confirm('Xác nhận khôi phục album?')">
                                    <i class="fa-solid fa-rotate"></i>
                                </button>
                            </form> --}}

                            <a href="{{ route('albums.trash.destroy', $album->id) }}"
                                class="btn btn-link btn-outline-danger" onclick="return confirm('Xác nhận xóa album?')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="10">Không có dữ liệu</td>
                </tr>
                @endif
            </tbody>

        </table>
        <div class=" mb-5">
            {!! $albums->links('pagination::bootstrap-5') !!}
        </div>
    </div>
@endsection
@section('js')
    <script>
        // Hàm để lấy các giá trị album được chọn và gán vào input hidden
        function getCheckedValues() {
            var selected = [];
            var checkboxes = document.getElementsByClassName('check_list');

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    selected.push(checkboxes[i].value);
                }
            }

            // Gán giá trị JSON của các album được chọn vào input hidden
            document.getElementById('songs-restore').value = JSON.stringify(selected);
            document.getElementById('songs-delete').value = JSON.stringify(selected);

            // Cập nhật số lượng mục đã chọn
            document.getElementById('total-songs').innerText = selected.length;
        }

        // Gọi hàm getCheckedValues mỗi khi có thay đổi trạng thái checkbox
        const checkboxes = document.getElementsByClassName('check_list');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].addEventListener('click', getCheckedValues);
        }

        // Hàm gửi form chỉ khi có ít nhất một album được chọn
        function submitForm(e, checkClass) {
            var selected = [];
            var checkboxes = document.getElementsByClassName(checkClass);

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    selected.push(checkboxes[i].value);
                }
            }

            if (selected.length === 0) {
                e.preventDefault(); // Ngừng gửi form nếu không có album nào được chọn
                alert("Vui lòng chọn ít nhất một album.");
                return false;
            }

            return true;
        }

        // Gán sự kiện submit cho các form
        document.getElementById('form-restore').addEventListener('submit', function(e) {
            return submitForm(e, 'check_list');
        });

        document.getElementById('form-delete').addEventListener('submit', function(e) {
            return submitForm(e, 'check_list');
        });
    </script>
@endsection
