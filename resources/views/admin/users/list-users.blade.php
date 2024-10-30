@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách tài khoản</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tài khoản</li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách tài khoản</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('list-users')}}" class="btn btn-outline-success"> Tất cả tài khoản</a>
            <a href="{{route('add-users')}}" class="btn btn-success">Thêm tài khoản</a>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{route('searchUser')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên tài khoản..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <div>Đã chọn <strong id="total-songs">0</strong> tài khoản</div>
        </div>
        <div class="col-sm-6 my-3">
            <form action="{{route('delete_list_users')}}" class="d-inline float-end" method="post" id="form-delete">
                @csrf
                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận xóa tài khoản đã chọn?')">Xóa tài khoản</button>
            </form>
        </div>
    </div>
    <table class="table text-center">
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_ads" class=""></th>
                <th scope="col">ID</th>
                <th scope="col">Tên</th>
                <th scope="col">Email</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col">Quyền</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php $stt = 1; @endphp
            @foreach($users as $user)
            <tr>
                <td><input type="checkbox" class="check_song" value="{{$user->id}}"></td>
                <th scope="row">{{$user->id}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td><img width="50px" height="50px" src="{{$user->image}}" alt=""></td>
                <td>{{$user->created_at}}</td>
                <td>
                    Người dùng
                </td>
                <td>
                    <a href="{{route('update-users', $user->id)}}"> <i class="fa-solid fa-pen-to-square"></i></a>
                    <form action="{{ route('delete-users', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link btn-outline-danger" onclick="return confirm('Xác nhận xóa tài khoản?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @php $stt++; @endphp
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
    document.getElementById('form-delete').addEventListener('submit', function(e) {
        return submitForm(e, 'check_song'); // Gọi hàm submitForm khi gửi
    });

    const checkboxes = document.getElementsByClassName('check_song');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('click', getCheckedValues);

    }
</script>

@endsection
