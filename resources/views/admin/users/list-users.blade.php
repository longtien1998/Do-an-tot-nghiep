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
            <a href="{{route('users.list')}}" class="btn btn-outline-success"> Tất cả tài khoản</a>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{route('users.search')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên tài khoản..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="form-group col-12 my-3">
            <h5>Bộ Lọc</h5>
            <form action="{{route('users.list')}}" class="row align-middle" method="post" id="itemsPerPageForm">
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
                    <label for="">Theo giới tính</label>
                    <select name="filterGenDer" id="filterGenDer" class="form-select" onchange="submitForm()">
                        <option value="">Chọn giới tính</option>
                        <option value="Nam" {{ request()->input('filterGenDer') == 'Nam' ? 'selected' : '' }}>Nam</option>
                        <option value="Nữ" {{ request()->input('filterGenDer') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                    </select>
                </div>
                <div class="col-6 col-sm">
                    <label for="">Theo quyền</label>
                    <select name="filterRole" id="filterRole" class="form-select" onchange="submitForm()">
                        <option value="">Chọn quyền</option>
                        @foreach ($roles as $role)
                        <option value="{{$role->id}}" @if (request()->input('filterRole') == $role->id ) selected @endif > {{$role->name}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-sm">
                    <label for="">Ngày tạo</label>
                    <input type="date" name="filterCreate" class="form-control" value="{{request()->input('filterCreate') ? request()->input('filterCreate') : ''}}" onchange="submitForm()">
                </div>
            </form>
        </div>
        <div class="col-sm-6 my-3">
            <div>Đã chọn <strong id="total-songs">0</strong> tài khoản</div>
        </div>
        <div class="col-sm-6 my-3">
            <form action="{{route('users.delete-list')}}" class="d-inline float-end" method="post" id="form-delete">
                @csrf
                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận xóa tài khoản đã chọn?')">Xóa tài khoản</button>
            </form>
        </div>
    </div>
    <table class="table text-center" id="myTable">
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_list" class=""></th>
                <th scope="col" onclick="sortTable(1)">ID <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(2)">Tên <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(3)">Email <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(4)">Số điện thoại <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(5)">Giới tính <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(6)">Ngày sinh <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(7)">Hình ảnh <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(8)">Ngày tạo <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(9)">Quyền <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(10)">Loại người dùng <span class="sort-icon">⬍</span></th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @if(count($users))
            @php $stt = 1; @endphp
            @foreach($users as $user)
            <tr>
                <td>
                    @if (Auth::check() && Auth::user()->id !== $user->id)
                    <input type="checkbox" class="check_list" value="{{$user->id}}">
                    @endif
                </td>
                <th scope="row">{{$user->id}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->phone}}</td>
                <td>
                    @if($user->gender == 'nam')
                    <span class="bg-info text-white p-1 rounded-2">Nam</span>
                    @elseif($user->gender == 'nu')
                    <span class="text-white p-1 rounded-2" style="background-color: pink;">Nữ</span>
                    @else
                    <span class="text-white p-1 rounded-2" style="background-color: gray;">Khác</span>
                    @endif
                </td>
                <td>{{$user->birthday}}</td>
                <td><img width="50px" height="50px" src="{{$user->image}}" alt=""></td>
                <td>{{$user->created_at}}</td>
                <td>
                    @foreach ($user->roles as $role)
                    <span class="text-white p-1 rounded-2" @if ($role->color) style="background-color:{{$role->color}};" @endif >
                        {{$role->name}}
                    </span>
                    @endforeach
                </td>
                <td>
                    @if($user->users_type == 'Basic')
                    <span class="bg-secondary text-white p-1 rounded-2">{{$user->users_type}}</span>
                    @elseif($user->users_type == 'Plus')
                    <span class="bg-primary text-white p-1 rounded-2">{{$user->users_type}}</span>
                    @else
                    <span class="bg-warning text-white p-1 rounded-2">{{$user->users_type}}</span>
                    @endif
                </td>
                <td>
                    <a href="{{route('users.show',$user->id)}}" class="btn btn-link btn-outline-warning"> <i class="fa-solid fa-edit"></i></a>
                    @if (Auth::check() && Auth::user()->id !== $user->id)
                    <form action="{{ route('users.delete', $user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link btn-outline-danger" onclick="return confirm('Xác nhận xóa tài khoản?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @php $stt++; @endphp
            @endforeach
            @else
            <tr class="text-center">
                <td colspan="20">Không có dữ liệu</td>
            </tr>
            @endif
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
<div class=" mb-5">
    {!! $users->links('pagination::bootstrap-5') !!}
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

    function submitForm() {
        document.getElementById('itemsPerPageForm').submit();
    }
</script>

@endsection
