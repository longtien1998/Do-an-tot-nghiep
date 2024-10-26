@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách bài hát</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Bài hát</li>

                        <li class="breadcrumb-item active" aria-current="page">Danh sách quốc gia</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5>Thông báo !</h5>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <div class="col-sm-6 my-3">
            <a href="{{route('list-country')}}" class="btn btn-outline-success"> Tất cả quốc gia</a>
            <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#createCoutry">Thêm quốc gia</button>

            <div class="modal fade" id="createCoutry" tabindex="-1" aria-labelledby="createCoutryLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="row g-3 needs-validation" novalidate method="post" action="{{route('store-country')}}">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="createCoutryLabel">Thêm mới quốc gia</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12 position-relative">
                                    <label for="validationTooltip01" class="form-label">Tên quốc gia</label>
                                    <input type="text" class="form-control" name="name_country" id="validationTooltip01" required>
                                    <div class="valid-tooltip">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button class="btn btn-primary" type="submit">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{route('search-song')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên quốc gia..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <div>Đã chọn <strong id="total-songs">0</strong> mục</div>
        </div>
        <div class="col-sm-6 my-3">
            <form action="{{route('delete-list-music')}}" class="d-inline float-end" method="post" id="form-delete">
                @csrf
                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận xóa bài hát đã chọn?')">Xóa quốc gia</button>
            </form>
        </div>

    </div>
    <table class="table text-center" id="myTable">

        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_songs" class=""></th>
                <th scope="col">STT</th>
                <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(3)">Tên Quốc gia <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(4)">Ngày tạo <span class="sort-icon"> ⬍ </span></th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php $stt = 1; @endphp
            @foreach($countries as $country)
            <tr>
                <td><input type="checkbox" class="check_song" value="{{$country->id}}"></td>
                <th scope="row">{{$stt}}</th>
                <td>{{$country->id}}</td>
                <td>{{$country->name_country}}</td>
                <td>{{$country->created_at}}</td>

                <td>
                    <a href="" class="btn btn-link btn-outline-success"> <i class="fa-solid fa-eye"></i></a>
                    <a href="" class="btn btn-link btn-outline-warning"> <i class="fa-solid fa-edit"></i></a>
                    <form action="{{route('delete-music',$country->id)}}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" data-bs-toggle="tooltip" title="" class="btn btn-link btn-outline-danger" data-original-title="Remove" onclick="return confirm('Xác nhận xóa thể loại?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @php $stt++; @endphp
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $songs->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection

@section('js')
<script>
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
