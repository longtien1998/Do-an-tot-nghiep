@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách thể loại đã xóa</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Thể loại</li>

                        <li class="breadcrumb-item active" aria-current="page">Danh sách thể loại đã xóa</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('categories.trash.list')}}" class="btn btn-outline-success"> Tất cả thể loại đã xóa</a>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{route('categories.trash.search')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên thể loại đã xóa..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <table class="table text-center" id="myTable">
        <div class="form-group row justify-content-between m-0 p-0">
            <div class="col-sm-6 my-3">
                <div>Đã chọn <strong id="total-songs">0</strong> mục</div>
            </div>
            <div class="col-sm-6 my-3">
                <div class="float-end">
                    <form action="{{route('categories.trash.restore-list')}}" class="d-inline" method="post" id="form-restore">
                        @csrf
                        <input type="text" value="" name="restore_list" id="songs-restore" hidden>
                        <button type="submit" class="btn btn-success" onclick="return confirm('Xác nhận khôi phục Quốc gia đã chọn?')">Khôi phục thể loại</button>
                    </form>
                    <form action="{{route('categories.trash.destroy-list')}}" class="d-inline" method="post" id="form-delete">
                        @csrf
                        <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                        <button type="submit" class="btn btn-warning" onclick="return confirm('Xác nhận xóa Quốc gia đã chọn?')">Xóa thể loại</button>
                    </form>
                    <a href="{{route('categories.trash.restore-all')}}" class="btn btn-primary" onclick="return confirm('Xác nhận khôi phục tất cả?')">Khôi phục tất cả thể loại</a>
                    <!-- <a href="{{route('delete-all-songs')}}" class="btn btn-danger" onclick="return confirm('Xác nhận xóa tất cả?')">Xóa tất cả Quốc gia</a> -->
                </div>

            </div>

        </div>
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_list" class="check_all_songs"></th>
                <th scope="col">STT</th>
                <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(3)">Tên Quốc gia <span class="sort-icon">⬍</span></th>
                <th scope="col">Mô tả</th>
                <th scope="col" onclick="sortTable(5)">Ngày xóa <span class="sort-icon">⬍</span></th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $index => $category)
            <tr>
                <td><input type="checkbox" class="check_list" value="{{$category->id}}"></td>
                <th scope="row">{{$categories->firstItem() + $index}}</th>
                <td>{{$category->id}}</td>
                <td>{{$category->categorie_name}}</td>
                <td>{{$category->description}}</td>
                <td>{{$category->deleted_at}}</td>

                <td>
                    <a href="{{route('categories.trash.restore',$category->id)}}" class="btn btn-link btn-outline-success" onclick="return confirm('Xác nhận khôi phục thể loại?')">
                        <i class="fa-solid fa-rotate"></i>
                    </a>

                    <a href="{{route('categories.trash.destroy',$category->id)}}" data-bs-toggle="tooltip" title="" class="btn btn-link btn-outline-danger" data-original-title="Remove" onclick="return confirm('Xác nhận xóa thể loại?')">
                        <i class="fa-solid fa-trash"></i>
                    </a>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

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
</script>
@endsection
