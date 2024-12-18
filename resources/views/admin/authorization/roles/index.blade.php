@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách Vai trò</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Phân quyền tài khoản</li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách Vai trò</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid border">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('roles.index')}}" class="btn btn-outline-success"> Tất cả Vai trò</a>
            <a href="{{route('roles.create')}}" class="btn btn-success">Thêm Vai trò</a>
        </div>
        <div class="col-sm-6 my-3">
            <form class="search-form float-end" action="{{route('roles.search')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên ..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between align-content-center m-0 p-0">
        <div class="form-group col-12 my-auto">
            <h5>Bộ Lọc</h5>
            <form action="{{route('roles.index')}}" class="row align-middle" method="post" id="itemsPerPageForm">
                @csrf
                <div class="col-1 col-sm-1">
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
                <div class="col-6 col-sm-2">
                    <label for="">Từ: Ngày tạo</label>
                    <input type="date" name="filterCreateStart" class="form-control" value="{{request()->input('filterCreateStart') ? request()->input('filterCreateStart') : ''}}" onchange="submitForm()">
                </div>
                <div class="col-6 col-sm-2">
                    <label for="">Đến: Ngày tạo</label>
                    <input type="date" name="filterCreateEnd" class="form-control" value="{{request()->input('filterCreateEnd') ? request()->input('filterCreateEnd') : ''}}" onchange="submitForm()">
                </div>
            </form>
        </div>
        <div class="col-sm-5 my-auto">
            <div class="align-middle">Đã chọn <strong id="total-songs">0</strong> mục</div>
        </div>
        <div class="col-sm-6 my-auto">
            <form action="{{route('roles.delete-list')}}" class="d-inline float-end" method="post" id="form-delete">
                @csrf
                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận xóa Vai trò đã chọn?')">Xóa Vai trò</button>
            </form>
        </div>

    </div>
    <div class="table-responsive-xl mb-3">
        <table class="table text-center table-hover border" id="myTable">
            <thead>
                <tr>
                    <th><input type="checkbox" name="" id="check_all_list" class=""></th>
                    <th scope="col">STT</th>
                    <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col" onclick="sortTable(3)">Tên Vai trò <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col" onclick="sortTable(4)">Loại vai trò <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col" onclick="sortTable(5)">Màu <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col" onclick="sortTable(6)">Quyền hạn <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col-2" onclick="sortTable(5)">Ngày tạo <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col-2">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @if(count($roles))
                @foreach($roles as $index => $role)
                <tr>
                    <td><input type="checkbox" class="check_list" value="{{$role->id}}"></td>

                    <th scope="row">{{$roles->firstItem() + $index}}</th>
                    <td>{{$role->id}} </td>
                    <td>{{$role->name}} </td>
                    <td>{{$role->role_type}} </td>
                    <td><span class="btn" @if ($role->color) style="background-color:{{$role->color}};" @endif ></span></td>
                    <td style="max-width: 700px;" >{{$role->permissions->pluck('alias')->join(', ')}} </td>
                    <td>{{$role->created_at->format('d-m-Y')}}</td>
                    <td scope="row-3">
                        <a href="{{route('roles.edit',$role->id)}}" class="btn btn-link btn-outline-warning"> <i class="fa-solid fa-edit"></i></a>
                        <form action="{{route('roles.delete',$role->id)}}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" data-bs-toggle="tooltip" title="" class="btn btn-link btn-outline-danger" data-original-title="Remove" onclick="return confirm('Xác nhận xóa Vai trò?')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="20">Không có dữ liệu</td>
                </tr>
                @endif
            </tbody>
        </table>
        <div class=" mb-5">
            {!! $roles->links('pagination::bootstrap-5') !!}
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
</script>

@endsection
