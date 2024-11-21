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
                        <li class="breadcrumb-item active" aria-current="page">Phân quyền tài khoản</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('roles.list')}}" class="btn btn-outline-success"> Tất cả tài khoản</a>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên tài khoản..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="form-group col-12 my-auto">
            <h5>Bộ Lọc</h5>
            <form action="{{route('roles.list')}}" class="row align-middle" method="post" id="itemsPerPageForm">
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
                    <label for="">Theo quyền</label>
                    <select name="filterRole" id="filterRole" class="form-select" onchange="submitForm()">
                        <option value="" {{ request()->input('filterRole') == null ? 'selected' : '' }}>Chọn quyền</option>
                        <option value="Admin" {{ request()->input('filterRole') == 'Admin' ? 'selected' : '' }}>Admin</option>
                        <option value="Quản lý" {{ request()->input('filterRole') == 'Quản lý' ? 'selected' : '' }}>Quản lý</option>
                        <option value="Nhân viên" {{ request()->input('filterRole') == 'Nhân viên' ? 'selected' : '' }}>Nhân viên</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <table class="table text-center" id="myTable">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col" onclick="sortTable(1)">ID <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(2)">Tên Tài khoản <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(3)">Quyền <span class="sort-icon">⬍</span></th>
                <th scope="col">phân quyền</th>
                <th scope="col">Layout</th>
                <th scope="col">Bài hát</th>
                <th scope="col">Thể loại quốc gia</th>
                <th scope="col">Thể loại Bài hát</th>
                <th scope="col">Bản quyền</th>
                <th scope="col">Nhà xuất bản</th>
                <th scope="col">Ca sĩ</th>
                <th scope="col">Album</th>
                <th scope="col">Quảng cáo</th>
                <th scope="col">Tài khoản</th>
                <th scope="col">Bình luận</th>


            </tr>
        </thead>
        <tbody>
            @if(count($roles))

            @foreach($roles as $index => $role)
            <tr>
                <td>{{$roles->firstItem() + $index}}</td>
                <th scope="row">{{$role->id}}</th>
                <td scope="row">{{$role->role->users->name}}</td>
                <td scope="row">{{$role->role->role_name}}</td>
                <td scope="row" style="width:90px">
                    <div class="checkbox-wrapper-34 m-auto">
                        <input class="tgl tgl-ios" id="toggle-1-{{$role->id}}" type="checkbox" {{$role->role_1 ? 'Checked' : ''}} data-id="{{$role->id}}" data-name="role_1" {{Auth::user()->role->role_type == 0 ? '' : 'disabled'}}>
                        <label class="tgl-btn" for="toggle-1-{{$role->id}}"></label>
                    </div>
                </td>
                <td scope="row" style="width:90px">
                    <div class="checkbox-wrapper-34 m-auto">
                        <input class="tgl tgl-ios" id="toggle-2-{{$role->id}}" type="checkbox" {{$role->role_2 ? 'Checked' : ''}} data-id="{{$role->id}}" data-name="role_2" {{Auth::user()->id == $role->role->user_id ? 'disabled' : ''}}>
                        <label class="tgl-btn" for="toggle-2-{{$role->id}}"></label>
                    </div>
                </td>
                <td scope="row" style="width:90px">
                    <div class="checkbox-wrapper-34 m-auto">
                        <input class="tgl tgl-ios" id="toggle-3-{{$role->id}}" type="checkbox" {{$role->role_3 ? 'Checked' : ''}} data-id="{{$role->id}}" data-name="role_3">
                        <label class="tgl-btn" for="toggle-3-{{$role->id}}"></label>
                    </div>
                </td>
                <td scope="row" style="width:90px">
                    <div class="checkbox-wrapper-34 m-auto">
                        <input class="tgl tgl-ios" id="toggle-4-{{$role->id}}" type="checkbox" {{$role->role_4 ? 'Checked' : ''}} data-id="{{$role->id}}" data-name="role_4">
                        <label class="tgl-btn" for="toggle-4-{{$role->id}}"></label>
                    </div>
                </td>
                <td scope="row" style="width:90px">
                    <div class="checkbox-wrapper-34 m-auto">
                        <input class="tgl tgl-ios" id="toggle-5-{{$role->id}}" type="checkbox" {{$role->role_5 ? 'Checked' : ''}} data-id="{{$role->id}}" data-name="role_5">
                        <label class="tgl-btn" for="toggle-5-{{$role->id}}"></label>
                    </div>
                </td>
                <td scope="row" style="width:90px">
                    <div class="checkbox-wrapper-34 m-auto">
                        <input class="tgl tgl-ios" id="toggle-6-{{$role->id}}" type="checkbox" {{$role->role_6 ? 'Checked' : ''}} data-id="{{$role->id}}" data-name="role_6">
                        <label class="tgl-btn" for="toggle-6-{{$role->id}}"></label>
                    </div>
                </td>
                <td scope="row" style="width:90px">
                    <div class="checkbox-wrapper-34 m-auto">
                        <input class="tgl tgl-ios" id="toggle-7-{{$role->id}}" type="checkbox" {{$role->role_7 ? 'Checked' : ''}} data-id="{{$role->id}}" data-name="role_7">
                        <label class="tgl-btn" for="toggle-7-{{$role->id}}"></label>
                    </div>
                </td>
                <td scope="row" style="width:90px">
                    <div class="checkbox-wrapper-34 m-auto">
                        <input class="tgl tgl-ios" id="toggle-8-{{$role->id}}" type="checkbox" {{$role->role_8 ? 'Checked' : ''}} data-id="{{$role->id}}" data-name="role_8">
                        <label class="tgl-btn" for="toggle-8-{{$role->id}}"></label>
                    </div>
                </td>
                <td scope="row" style="width:90px">
                    <div class="checkbox-wrapper-34 m-auto">
                        <input class="tgl tgl-ios" id="toggle-9-{{$role->id}}" type="checkbox" {{$role->role_9 ? 'Checked' : ''}} data-id="{{$role->id}}" data-name="role_9">
                        <label class="tgl-btn" for="toggle-9-{{$role->id}}"></label>
                    </div>
                </td>
                <td scope="row" style="width:90px">
                    <div class="checkbox-wrapper-34 m-auto">
                        <input class="tgl tgl-ios" id="toggle-10-{{$role->id}}" type="checkbox" {{$role->role_10 ? 'Checked' : ''}} data-id="{{$role->id}}" data-name="role_10">
                        <label class="tgl-btn" for="toggle-10-{{$role->id}}"></label>
                    </div>
                </td>
                <td scope="row" style="width:90px">
                    <div class="checkbox-wrapper-34 m-auto">
                        <input class="tgl tgl-ios" id="toggle-11-{{$role->id}}" type="checkbox" {{$role->role_11 ? 'Checked' : ''}} data-id="{{$role->id}}" data-name="role_11">
                        <label class="tgl-btn" for="toggle-11-{{$role->id}}"></label>
                    </div>
                </td>
                <td scope="row" style="width:90px">
                    <div class="checkbox-wrapper-34 m-auto">
                        <input class="tgl tgl-ios" id="toggle-12-{{$role->id}}" type="checkbox" {{$role->role_12 ? 'Checked' : ''}} data-id="{{$role->id}}" data-name="role_12">
                        <label class="tgl-btn" for="toggle-12-{{$role->id}}"></label>
                    </div>
                </td>
                <td scope="row" style="width:90px">
                    <div class="checkbox-wrapper-34 m-auto">
                        <input class="tgl tgl-ios" id="toggle-13-{{$role->id}}" type="checkbox" {{$role->role_13 ? 'Checked' : ''}} data-id="{{$role->id}}" data-name="role_13">
                        <label class="tgl-btn" for="toggle-13-{{$role->id}}"></label>
                    </div>
                </td>
                <!-- <td scope="row" style="width:90px">
                    <div class="checkbox-wrapper-34 m-auto">
                        <input class="tgl tgl-ios" id="toggle-14-{{$role->id}}" type="checkbox" {{$role->role_14 ? 'Checked' : ''}} data-id="{{$role->id}}" data-name="role_14">
                        <label class="tgl-btn" for="toggle-14-{{$role->id}}"></label>
                    </div>
                </td>
                <td scope="row" style="width:90px">
                    <div class="checkbox-wrapper-34 m-auto">
                        <input class="tgl tgl-ios" id="toggle-15-{{$role->id}}" type="checkbox" {{$role->role_15 ? 'Checked' : ''}} data-id="{{$role->id}}" data-name="role_15">
                        <label class="tgl-btn" for="toggle-15-{{$role->id}}"></label>
                    </div>
                </td>
                <td scope="row" style="width:90px">
                    <div class="checkbox-wrapper-34 m-auto">
                        <input class="tgl tgl-ios" id="toggle-16-{{$role->id}}" type="checkbox" {{$role->role_16 ? 'Checked' : ''}} data-id="{{$role->id}}" data-name="role_16">
                        <label class="tgl-btn" for="toggle-16-{{$role->id}}"></label>
                    </div>
                </td> -->
            </tr>
            @endforeach
            @else
            <tr class="text-center">
                <td colspan="10">Không có dữ liệu</td>
            </tr>
            @endif
        </tbody>
    </table>
    <div class=" mb-5">
        {!! $roles->links('pagination::bootstrap-5') !!}
    </div>

    <!-- @if(session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4><i class="icon fa fa-check"></i> Thông báo !</h4>
        {{session('success')}}
    </div>
    @endif -->
</div>

@endsection
@section('js')
<script>
    $(document).ready(function() {
        const checkBox = $('.tgl-ios').get();
        checkBox.forEach(ele => {
            $(ele).on('change', function(e) {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const checked = $(this).is(':checked');

                $.ajax({
                    url: '/roles/' + id + '/update',
                    type: 'POST',
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',

                        // 'Authorization': 'Bearer'+ token,

                    },
                    data: JSON.stringify({ // Chuyển đổi thành JSON string
                        role_column: name,
                        checked: checked,
                    }),
                    success: function(response) {
                        if (response.success) {
                            console.log(response.data);

                            flasher.success(response.message);
                        } else {
                            console.log('Update failed');
                            flasher.success(response.message);
                        }
                    },
                    error: function(error) {
                        console.log('Error:', error);
                        flasher.success('Error:', error);
                    }
                });
            });
        });

    });

    function submitForm() {
        document.getElementById('itemsPerPageForm').submit();
    }
</script>

@endsection
