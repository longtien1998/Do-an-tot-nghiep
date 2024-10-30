@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh tài khoản đã xóa</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tài khoản</li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách tài khoản đã xóa</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('list_trash_users')}}" class="btn btn-outline-success"> Tất cả tài khoản đã xóa</a>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên tài khoản..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <table class="table text-center" id="myTable">
        <div class="form-group row justify-content-between m-0 p-0">
            <div class="col-sm-3 my-3">
                <div>Đã chọn <strong id="total-songs">0</strong> tài khoản</div>
            </div>
            <div class="col-sm-6 text-center my-3">
                <form action="{{route('restore_trash_users')}}" class="d-inline" method="post" id="form-restore">
                    @csrf
                    <input type="text" value="" name="restore_list" id="songs-restore" hidden>
                    <button type="submit" class="btn btn-success" onclick="return confirm('Xác nhận khôi phục tài khoản đã chọn?')">Khôi phục tài khoản</button>
                </form>
                <form action="{{route('delete_trash_users')}}" class="d-inline" method="post" id="form-delete">
                    @csrf
                    <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Xác nhận xóa tài khoản đã chọn?')">Xóa tài khoản</button>
                </form>
                <a href="{{route('restore_all_users')}}" class="btn btn-primary" onclick="return confirm('Xác nhận khôi phục tất cả?')">Khôi phục tất cả tài khoản</a>
            </div>

        </div>
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_ads" class="check_all_songs" ></th>
                <th scope="col">STT</th>
                <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(3)">Tên <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(3)">Email <span class="sort-icon">⬍</span></th>
                <th scope="col">Hình ảnh</th>
                <th scope="col" onclick="sortTable(3)">Ngày tạo <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(3)">Quyền <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(11)">Ngày xóa <span class="sort-icon">⬍</span></th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php $stt = 1; @endphp
            @foreach($users as $user)
            <tr>
                <td><input type="checkbox" class="check_song" value="{{$user->id}}"></td>
                <th scope="row">{{$stt}}</th>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td><img width="50px" height="50px" src="{{$user->image}}" alt=""></td>
                <td>{{$user->created_at}}</td>
                <td>
                    Người dùng
                </td>
                <td>{{$user->deleted_at}}</td>

                <td>
                    <a href="{{route('show-music',$user->id)}}" class="btn btn-link btn-outline-success"> <i class="fa-solid fa-eye"></i></a>

                    <a href="{{route('destroy_trash_users',$user->id)}}" data-bs-toggle="tooltip" title="" class="btn btn-link btn-outline-danger" data-original-title="Remove" onclick="return confirm('Xác nhận xóa tài khoản?')">
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
    document.querySelector('#check_all_ads').addEventListener('click', function() {
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
