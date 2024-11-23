@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách tài khoản với vai trò</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Phân quyền tài khoản</li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách tài khoản với vai trò</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('authorization.index')}}" class="btn btn-outline-success"> Tất cả tài khoản</a>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{route('authorization.search')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên ..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between align-content-center m-0 p-0">
        <div class="form-group col-12 my-3">
            <h5>Bộ Lọc</h5>
            <form action="{{route('authorization.index')}}" class="row align-middle" method="post" id="itemsPerPageForm">
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
            </form>
        </div>
    </div>
    <div class="table-responsive-xl">
        <table class="table text-center table-hover" id="myTable">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col" onclick="sortTable(1)">ID <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col" onclick="sortTable(2)">Tên tài khoản <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col" onclick="sortTable(3)">Email <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col" onclick="sortTable(4)">Vai trò <span class="sort-icon"> ⬍ </span></th>
                </tr>
            </thead>
            <tbody>
                @if(count($users))
                @foreach($users as $index => $user)
                <tr>
                    <th scope="row">{{$users->firstItem() + $index}}</th>
                    <td>{{$user->id}} </td>
                    <td class="text-start">{{$user->name}} </td>
                    <td class="text-start">{{$user->email}} </td>
                    <td>
                        <div class="form-group">
                            <div class="col-md-12">
                                <select name="role" id="role_type_{{ $user->id }}" class="form-select role" data-id="{{$user->id}}">
                                <option value="" {{ $user->roles->isEmpty() ? 'selected' : '' }}>Chọn vai trò</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        @if ($user->roles->pluck('id')->contains($role->id)) selected @endif>
                                        {{ $role->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
            {!! $users->links('pagination::bootstrap-5') !!}
        </div>
    </div>


</div>

@endsection


@section('js')
<script>
   $(document).ready(function() {
        const checkBox = $('.role').get();
        checkBox.forEach(ele => {
            $(ele).on('change', function(e) {
                const userid = $(this).data('id');
                const roleid = +$(this).val();

                console.log(userid, roleid);

                $.ajax({
                    url: '/authorization/'+ userid +'/update',
                    type: 'POST',
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',

                        // 'Authorization': 'Bearer'+ token,

                    },
                    data: JSON.stringify({ // Chuyển đổi thành JSON string
                        role:roleid,

                    }),
                    success: function(response) {
                        if (response.success) {
                            console.log(response.data, response.user);

                            flasher.success(response.message);
                        } else {
                            console.log('Update failed');
                            flasher.error(response.message);
                        }
                    },
                    error: function(error) {
                        console.log('Error:', error);
                        flasher.error('Error:', error);
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
