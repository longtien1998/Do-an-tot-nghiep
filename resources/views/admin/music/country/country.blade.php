@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách Quốc gia</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Quốc gia</li>

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
            <!-- modal thêm quốc gia -->
            <div class="modal fade" id="createCoutry" tabindex="-1" aria-labelledby="createCoutryLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="row g-3 needs-validation" novalidate method="post" action="{{route('store-country')}}" enctype="multipart/form-data">
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
                                <div class="col-md-12 my-3 position-relative">
                                    <label for="validationTooltip01" class="form-label">Ảnh nền</label>
                                    <input type="file" class="form-control" name="background" id="backgroundAdd" accept="image/*" required>
                                    <img id="previewImageAdd" src="" alt="Image Preview" style="max-width: 300px; margin-top: 10px;" class="d-none">
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
            <form class="search-form" action="{{route('search-country')}}" method="post">
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
            <form action="{{route('delete-list')}}" class="d-inline float-end" method="post" id="form-delete">
                @csrf
                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận xóa bài hát đã chọn?')">Xóa quốc gia</button>
            </form>
        </div>

    </div>
    <table class="table text-center" id="myTable">

        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_list" class=""></th>
                <th scope="col">STT</th>
                <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(3)">Tên Quốc gia <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(4)">Hình nền <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(5)">Ngày tạo <span class="sort-icon"> ⬍ </span></th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @if(count($countries))
            @foreach($countries as $index => $country)
            <tr>
                <td><input type="checkbox" class="check_list" value="{{$country->id}}"></td>
                <th scope="row">{{$countries->firstItem() + $index}}</th>
                <td>{{$country->id}}</td>
                <td>{{$country->name_country}}</td>
                <td><img src="{{$country->background}}" alt="" width="100px"></td>
                <td>{{$country->created_at}}</td>

                <td>
                    <a class="btn btn-link btn-outline-success" data-bs-toggle="modal" data-bs-target="#showCountry" onclick="showCountry('{{$country->id}}','{{$country->name_country}}','{{$country->background}}','{{$country->created_at}}','{{$country->updated_at}}')">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a class="btn btn-link btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editCountry" onclick="editCountry('{{$country->id}}','{{$country->name_country}}','{{$country->background}}')">
                        <i class="fa-solid fa-edit"></i>
                    </a>
                    <form action="{{route('delete-country',$country->id)}}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" data-bs-toggle="tooltip" title="delete" class="btn btn-link btn-outline-danger" data-original-title="Remove" onclick="return confirm('Xác nhận xóa thể loại?')">
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
    <div class>
        {{ $countries->links('pagination::bootstrap-5') }}
    </div>
    <!-- Modal show-->
    <div class="modal fade" id="showCountry" tabindex="-1" aria-labelledby="showCountryLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-2" id="">Chi tiết thể loại Quốc gia</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Id Quốc gia : <strong id="idQuocGia"></strong></h5>
                    <h5>Tên thể loại Quốc gia : <strong id="tenQuocGia"></strong></h5>
                    <h5>Ảnh nền : <img id="moTaQuocGia" src="" width="150px"></img></h5>
                    <h5>Ngày tạo Quốc gia : <strong id="ngayTao"></strong></h5>
                    <h5>Ngày sửa Quốc gia : <strong id="ngaysSua"></strong></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal edit-->
    <div class="modal fade" id="editCountry" tabindex="-1" aria-labelledby="editCountryLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="row g-3 needs-validation" novalidate method="post" action="" id="formEditCountry" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="createCoutryLabel">Chỉnh sửa quốc gia</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 position-relative my-3">
                            <label for="validationTooltip01" class="form-label">Tên quốc gia</label>
                            <input type="text" class="form-control" name="name_country" id="name_country" required>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-12 position-relative my-3">
                            <label for="validationTooltip01" class="form-label">Ảnh nền</label>
                            <input type="file" class="form-control" name="background" id="backgroundUp" accept="image/*" required>
                            <img id="previewImageUp" src="" alt="Image Preview" style="max-width: 300px; margin-top: 10px;" class="d-none">
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


    document.getElementById('backgroundAdd').addEventListener('change', function(event) {
        const file = event.target.files[0]; // Lấy file đầu tiên từ input
        const preview = document.getElementById('previewImageAdd'); // Thẻ <img> để hiển thị ảnh

        if (file) {
            const reader = new FileReader(); // Tạo FileReader để đọc file

            reader.onload = function(e) {
                preview.src = e.target.result; // Đặt src của <img> bằng kết quả đọc file
            };

            reader.readAsDataURL(file); // Đọc file dưới dạng URL
            preview.classList.remove('d-none'); // Hiển thị ảnh preview
        } else {
            preview.src = ''; // Nếu không có file, bỏ ảnh preview
        }
    });
    document.getElementById('backgroundUp').addEventListener('change', function(event) {
        const file = event.target.files[0]; // Lấy file đầu tiên từ input
        const preview = document.getElementById('previewImageUp'); // Thẻ <img> để hiển thị ảnh

        if (file) {
            const reader = new FileReader(); // Tạo FileReader để đọc file

            reader.onload = function(e) {
                preview.src = e.target.result; // Đặt src của <img> bằng kết quả đọc file
            };

            reader.readAsDataURL(file); // Đọc file dưới dạng URL
            preview.classList.remove('d-none'); // Hiển thị ảnh preview
        } else {
            preview.src = ''; // Nếu không có file, bỏ ảnh preview
        }
    });



    function showCountry() {
        let id = arguments[0];
        let name = arguments[1];
        let background = arguments[2];
        let created_at = arguments[3];
        let updated_at = arguments[4];

        $('#idQuocGia').text(id);
        $('#tenQuocGia').text(name);
        $('#moTaQuocGia').attr('src', background);
        $('#ngayTao').text(created_at);
        $('#ngaysSua').text(updated_at);
    }


    const updateRoute = "{{ route('update-country', ['id' => '__ID__']) }}";
    function editCountry() {
        let id = arguments[0];
        let name = arguments[1];
        let background = arguments[2];

        const finalAction = updateRoute.replace('__ID__', id);
        $('#name_country').val(name);
        $('#previewImageUp').attr('src',background);
        $('#previewImageUp').removeClass('d-none');
        $('#formEditCountry').attr('action', finalAction);
    }
</script>

@endsection
