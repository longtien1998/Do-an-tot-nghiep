@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách bản quyền</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách bản quyền</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="form-group row justify-content-between">
        <div class="col-sm-6 my-3">
            <a href="{{route('copyrights.index')}}" class="btn btn-outline-success">Thêm bản quyền</a>
            <a href="{{route('copyrights.create')}}" class="btn btn-success">Thêm bản quyền</a>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{route('copyrights.search')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên bài hát, tền nhà xuất bản" required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between align-content-center m-0 p-0">
        <div class="form-group col-12 my-auto">
            <h5>Bộ Lọc</h5>
            <form action="{{route('copyrights.index')}}" class="row align-middle" method="post" id="itemsPerPageForm">
                @csrf
                <div class="col-6 col-sm-2 col-md-1 ">
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
            <form action="{{route('copyrights.delete-list')}}" class="d-inline float-end" method="post" id="form-delete">
                @csrf
                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận xóa bản quyền đã chọn?')">Xóa bản quyền</button>
            </form>
        </div>

    </div>
    <div class="table-responsive-xl">
        <table class="table text-center table-hover" id="myTable">
            <thead>
                <tr>
                    <th><input type="checkbox" name="" id="check_all_list" class=""></th>
                    <th scope="col">STT</th>
                    <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col" onclick="sortTable(3)">Tên bài hát <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col" onclick="sortTable(4)">Nhà xuất bản <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col" onclick="sortTable(5)">Loại giấy phép <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col" onclick="sortTable(6)">Ngày phát hành <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col" onclick="sortTable(7)">Ngày hết hạn <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col" onclick="sortTable(8)">Quyền sử dụng <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col" onclick="sortTable(9)">Điều khoản <span class="sort-icon"> ⬍ </span></th>
                    <th scope="col">Giấy phép</th>
                    <th scope="col">Hành dộng</th>
                </tr>
            </thead>
            <tbody>
                @foreach($copyrights as $index => $copyright)
                <tr>
                    <td><input type="checkbox" class="check_list" value="{{$copyright->id}}"></td>
                    <th scope="row">{{$copyrights->firstItem() + $index}}</th>
                    <td>{{$copyright->id}}</td>
                    <td>{{$copyright->song->song_name}}</td>
                    <td>{{$copyright->publisher->publisher_name}}</td>
                    <td>{{$copyright->license_type}}</td>
                    <td>{{$copyright->issue_day->format('d-m-Y')}}</td>
                    <td>{{ $copyright->expiry_day ? $copyright->expiry_day->format('d-m-Y') : 'Vĩnh viễn' }}</td>
                    <td>{{$copyright->usage_rights}}</td>
                    <td>{{$copyright->terms}}</td>
                    <td><a href="{{$copyright->license_file}}" target="_blank">File giấy phép</a></td>
                    <td>
                        <a href="{{route('copyrights.edit',$copyright->id)}}" class="btn btn-link btn-outline-success"> <i class="fa-solid fa-edit"></i></a>
                        <form action="{{route('copyrights.delete',$copyright->id)}}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" data-bs-toggle="tooltip" title="" class="btn btn-link btn-outline-danger" data-original-title="Remove" onclick="return confirm('Xác nhận xóa bản quyền?')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class=" mb-5">
            {!! $copyrights->links('pagination::bootstrap-5') !!}
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
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
