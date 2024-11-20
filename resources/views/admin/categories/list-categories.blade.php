@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách thể loại</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách thể loại</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('categories.add')}}" class="btn btn-success">Thêm thể loại</a>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{route('categories.search')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên thể loại..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <div>Đã chọn <strong id="total-songs">0</strong> mục</div>
        </div>
        <div class="col-sm-6 my-3">
            <form action="{{route('categories.delete-list')}}" class="d-inline float-end" method="post" id="form-delete">
                @csrf
                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận xóa thể loại đã chọn?')">Xóa thể loại</button>
            </form>
        </div>

    </div>
    <table class="table text-center" id="myTable">
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_list" class=""></th>
                <th scope="1">STT</th>
                <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(3)"> Tên thể loại <span class="sort-icon"> ⬍ </span></th>
                <th scope="col">Mô tả</th>
                <th scope="col">Ảnh nền</th>
                <th scope="col" onclick="sortTable(5)">Ngày tạo <span class="sort-icon"> ⬍ </span></th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @if(count($categories))
            @foreach ($categories as $index => $category)
            <tr>
                <td><input type="checkbox" class="check_list" value="{{$category->id}}"></td>
                <td>{{$categories->firstItem() + $index}}</td>
                <th scope="row">{{$category->id}}</th>
                <td>{{$category->categorie_name}}</td>
                <td>{{$category->description}}</td>
                <td><img src="{{$category->background}}" alt="{{$category->categorie_name}}"></td>
                <td>{{$category->created_at}}</td>
                <td>
                    <a href="{{route('categories.edit',$category->id)}}" class="btn btn-link btn-outline-warning"> <i class="fa-solid fa-pen-to-square"></i></a>
                    <form action="{{route('categories.delete',$category->id)}}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove" onclick="return confirm('Xác nhận xóa thể loại?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
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
            {!! $categories->links('pagination::bootstrap-5') !!}
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
</script>
@endsection
