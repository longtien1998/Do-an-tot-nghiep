@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách Quốc gia đã xóa</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Thể loại Quốc gia</li>

                        <li class="breadcrumb-item active" aria-current="page">Danh sách Quốc gia đã xóa</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('list_trash_country')}}" class="btn btn-outline-success"> Tất cả Quốc gia đã xóa</a>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{route('search-song-trash')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên Quốc gia..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <table class="table text-center" id="myTable">
        <div class="form-group row justify-content-between m-0 p-0">
            <div class="col-sm-3 my-3">
                <div>Đã chọn <strong id="total-songs">0</strong> mục</div>
            </div>
            <div class="col-sm-6 text-center my-3">
                <form action="{{route('list-restore-countries')}}" class="d-inline" method="post" id="form-restore">
                    @csrf
                    <input type="text" value="" name="restore_list" id="songs-restore" hidden>
                    <button type="submit" class="btn btn-success" onclick="return confirm('Xác nhận khôi phục Quốc gia đã chọn?')">Khôi phục Quốc gia</button>
                </form>
                <form action="{{route('list-destroy-countries')}}" class="d-inline" method="post" id="form-delete">
                    @csrf
                    <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Xác nhận xóa Quốc gia đã chọn?')">Xóa Quốc gia</button>
                </form>
                <a href="{{route('restore-all-countries')}}" class="btn btn-primary" onclick="return confirm('Xác nhận khôi phục tất cả?')">Khôi phục tất cả Quốc gia</a>
                <!-- <a href="{{route('delete-all-songs')}}" class="btn btn-danger" onclick="return confirm('Xác nhận xóa tất cả?')">Xóa tất cả Quốc gia</a> -->
            </div>

        </div>
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_songs" class="check_all_songs"></th>
                <th scope="col">STT</th>
                <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(3)">Tên Quốc gia <span class="sort-icon">⬍</span></th>
                <th scope="col">Mô tả</th>
                <th scope="col" onclick="sortTable(5)">Ngày xóa <span class="sort-icon">⬍</span></th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php $stt = 1; @endphp
            @foreach($Countries as $index => $Country)
            <tr>
                <td><input type="checkbox" class="check_song" value="{{$Country->id}}"></td>
                <th scope="row">{{$Countries->firstItem() + $index}}</th>
                <td>{{$Country->id}}</td>
                <td>{{$Country->name_country}}</td>
                <td></td>
                <td>{{$Country->deleted_at}}</td>

                <td>
                    <a href="{{route('restore_country',$Country->id)}}" class="btn btn-link btn-outline-success" onclick="return confirm('Xác nhận khôi phục Quốc gia?')">
                        <i class="fa-solid fa-rotate"></i>
                    </a>

                    <a href="{{route('destroy-trash-country',$Country->id)}}" data-bs-toggle="tooltip" title="" class="btn btn-link btn-outline-danger" data-original-title="Remove" onclick="return confirm('Xác nhận xóa Quốc gia?')">
                        <i class="fa-solid fa-trash"></i>
                    </a>

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
    document.querySelector('#check_all_songs').addEventListener('click', function() {
        var checkboxes = document.getElementsByClassName('check_song');

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }

        getCheckedValues()

    });
    // Gán sự kiện 'submit' cho form
    document.getElementById('form-restore').addEventListener('submit', function(e) {
        return submitForm(e, 'check_song_trash'); // Gọi hàm submitForm khi gửi
    });

    document.getElementById('form-delete').addEventListener('submit', function(e) {
        return submitForm(e, 'check_song_trash'); // Gọi hàm submitForm khi gửi
    });

    const checkboxes = document.getElementsByClassName('check_song');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('click', getCheckedValues);

    }
</script>
@endsection
