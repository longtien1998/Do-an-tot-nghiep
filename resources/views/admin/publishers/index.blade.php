@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách nhà xuất bản</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách nhà xuất bản</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('publishers.index')}}" class="btn btn-outline-success"> Tất cả nhà xuất bản</a>
            <a href="{{route('publishers.create')}}" class="btn btn-success">Thêm nhà xuất bản</a>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{route('publishers.search')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên, ..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between align-content-center m-0 p-0">
        <div class="form-group col-12 my-auto">
            <h5>Bộ Lọc</h5>
            <form action="{{route('publishers.index')}}" class="row align-middle" method="post" id="itemsPerPageForm">
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
                    <label for="">Ngày tạo</label>
                    <input type="date" name="filterCreate" class="form-control" value="{{request()->input('filterCreate') ? request()->input('filterCreate') : ''}}" onchange="submitForm()">
                </div>
            </form>
        </div>
        <div class="col-sm-5 my-auto">
            <div class="align-middle">Đã chọn <strong id="total-songs">0</strong> mục</div>
        </div>
        <div class="col-sm-6 my-auto">
            <form action="{{route('delete-list-music')}}" class="d-inline float-end" method="post" id="form-delete">
                @csrf
                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận xóa bài hát đã chọn?')">Xóa nhà xuất bản</button>
            </form>
        </div>

    </div>
    <table class="table text-center" id="myTable">
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_list" class=""></th>
                <th scope="col" >STT</th>
                <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(3)">Tên nhà xuất bản <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(4)">Tên khác <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(5)">Quốc gia <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(6)">Thành phố <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(7)">Địa chỉ <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(8)">Trang web <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(9)">Email <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(10)">SĐT <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(11)">Logo <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(12)">Mô tả <span class="sort-icon"> ⬍ </span></th>
                <th scope="col-2" onclick="sortTable(13)">Ngày tạo <span class="sort-icon"> ⬍ </span></th>
                <th scope="col-2" >Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($publishers as $index => $publisher)
            <tr>
                <td><input type="checkbox" class="check_list" value="{{$publisher->id}}"></td>

                <th scope="row">{{$publishers->firstItem() + $index}}</th>
                <td class="text-start">{{$publisher->id}} </td>
                <td class="text-start">{{$publisher->publisher_name}} </td>
                <td class="text-start">{{$publisher->alias_name}}</td>
                <td class="text-start">{{$publisher->country}}</td>
                <td class="text-start">{{$publisher->city}}</td>
                <td class="text-start">{{$publisher->address}}</td>
                <td class="text-start">{{$publisher->website}}</td>
                <td class="text-start">{{$publisher->email}}</td>
                <td class="text-start">{{$publisher->phone}}</td>

                <td><img width="50px" height="50px" src="{{$publisher->logo}}" alt=""></td>
                <td class="text-start">{{$publisher->description}}</td>
                <td class="text-start">{{$publisher->created_at->format('d-m-Y')}}</td>
                <td scope="row">
                    <a href="{{route('publishers.edit',$publisher->id)}}" class="btn btn-link btn-outline-success"> <i class="fa-solid fa-eye"></i></a>
                    <form action="{{route('publishers.delete',$publisher->id)}}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" data-bs-toggle="tooltip" title="" class="btn btn-link btn-outline-danger" data-original-title="Remove" onclick="return confirm('Xác nhận xóa nhà xuất bản?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class=" mb-5">
        {!! $publishers->links('pagination::bootstrap-5') !!}
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