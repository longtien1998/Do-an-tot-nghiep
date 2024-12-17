@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách banner đã xóa</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('banner.index')}}">Banner</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách banner đã xóa</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('banner.trash.index')}}" class="btn btn-outline-success"> Tất cả banner đã xóa</a>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{route('banner.trash.search')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên, tên khác, banner, Thành ..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="form-group col-12 my-auto">
            <h5>Bộ Lọc</h5>
            <form action="{{route('banner.trash.index')}}" class="row align-middle" method="post" id="itemsPerPageForm">
                @csrf
                <div class="col-6 col-sm-2">
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
        <div class="col-sm-6 my-3">
            <div>Đã chọn <strong id="total-songs">0</strong> mục</div>
        </div>
        <div class="col-sm-6 my-3">
            <div class="float-end">
                <form action="{{route('banner.trash.restore-list')}}" class="d-inline" method="post" id="form-restore">
                    @csrf
                    <input type="text" value="" name="restore_list" id="songs-restore" hidden>
                    <button type="submit" class="btn btn-success" onclick="return confirm('Xác nhận khôi phục banner đã chọn?')">Khôi phục banner</button>
                </form>
                <form action="{{route('banner.trash.destroy-list')}}" class="d-inline" method="post" id="form-delete">
                    @csrf
                    <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Xác nhận xóa banner đã chọn?')">Xóa banner</button>
                </form>
                <a href="{{route('banner.trash.restore-all')}}" class="btn btn-primary" onclick="return confirm('Xác nhận khôi phục tất cả?')">Khôi phục tất cả banner</a>
                <!-- <a href="{{route('delete-all-songs')}}" class="btn btn-danger" onclick="return confirm('Xác nhận xóa tất cả?')">Xóa tất cả banner</a> -->
            </div>
        </div>

    </div>
    <table class="table text-center" id="myTable">
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_list" class="check_all_songs"></th>
                <th scope="col">STT</th>
                <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(3)">Tên banner <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(4)">Hình nền <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(6)">Ngày xóa<span class="sort-icon"> ⬍ </span></th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @if(count($trashs))
            @foreach($trashs as $index => $banner)
            <tr>
                <td><input type="checkbox" class="check_list" value="{{$banner->id}}"></td>
                <th scope="row">{{$trashs->firstItem() + $index}}</th>
                <td>{{$banner->id}}</td>
                <td class="text-start">{{$banner->banner_name}} </td>
                <td><img src="{{$banner->banner_url}}" alt="" width="100px"></td>
                <td>{{$banner->deleted_at}}</td>

                <td>
                    <a href="{{route('banner.trash.restore',$banner->id)}}" class="btn btn-link btn-outline-success" onclick="return confirm('Xác nhận khôi phục banner?')">
                        <i class="fa-solid fa-rotate"></i>
                    </a>

                    <a href="{{route('banner.trash.destroy',$banner->id)}}" data-bs-toggle="tooltip" title="" class="btn btn-link btn-outline-danger" data-original-title="Remove" onclick="return confirm('Xác nhận xóa banner?')">
                        <i class="fa-solid fa-trash"></i>
                    </a>

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
            {!! $trashs->links('pagination::bootstrap-5') !!}
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
    document.getElementById('form-restore').addEventListener('submit', function(e) {
        return submitForm(e, 'check_list'); // Gọi hàm submitForm khi gửi
    });

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
