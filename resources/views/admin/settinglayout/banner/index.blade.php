@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách banner</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">banner</li>

                        <li class="breadcrumb-item active" aria-current="page">Danh sách banner</li>
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
            <a href="{{route('banner.index')}}" class="btn btn-outline-success"> Tất cả banner</a>
            <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#createCoutry">Thêm banner</button>
            <!-- modal thêm banner -->
            <div class="modal fade" id="createCoutry" tabindex="-1" aria-labelledby="createCoutryLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="row g-3 needs-validation" novalidate method="post" action="{{route('banner.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="createCoutryLabel">Thêm mới banner</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12 position-relative">
                                    <label for="validationTooltip01" class="form-label">Tên banner</label>
                                    <input type="text" class="form-control" name="banner_name" id="validationTooltip01" value="{{old('banner_name')}}" required>
                                    <div class="valid-tooltip">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12 position-relative my-3 border p-3 rounded-3">
                                    <div class="checkbox-wrapper-34 row align-items-center">
                                        <span class="col-10 ps-2">Hiển thị</span>
                                        <input class="tgl tgl-ios" id="status" type="checkbox" name="status">
                                        <label class="tgl-btn col-2" for="status"></label>
                                    </div>
                                    <div class="valid-tooltip">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-12 my-3 position-relative">
                                    <label for="validationTooltip01" class="form-label">Ảnh nền</label>
                                    <input type="file" class="form-control" name="banner" id="backgroundAdd" value="{{old('banner_name')}}" accept="image/*" required>
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
            <a href="{{route('banner.trash.index')}}" class="btn btn-outline-success">Banner đã xóa</a>
            <a href="{{route('banner.file')}}" class="btn btn-outline-success">File Banner</a>
        </div>
        <div class="col-sm-6 my-3">
            <form class="search-form float-end" action="{{route('banner.search')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên banner..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>


    <div class="form-group row justify-content-between m-0 p-0 ">
        <div class="form-group col-12 my-4">
            <h5>Bộ Lọc</h5>
            <form action="{{route('banner.index')}}" class="row align-middle" method="post" id="itemsPerPageForm">
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
            <form action="{{route('banner.delete-list')}}" class="d-inline float-end" method="post" id="form-delete">
                @csrf
                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận xóa bài hát đã chọn?')">Xóa banner</button>
            </form>
        </div>

    </div>
    <table class="table text-center overflow-x-auto" id="myTable">

        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_list" class=""></th>
                <th scope="col">STT</th>
                <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(3)">Tên banner <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(4)">Hình nền <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(5)">Hiển thị <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(6)">Ngày tạo <span class="sort-icon"> ⬍ </span></th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @if(count($banners))
            @foreach($banners as $index => $banner)
            <tr>
                <td><input type="checkbox" class="check_list" value="{{$banner->id}}"></td>
                <th scope="row">{{$banners->firstItem() + $index}}</th>
                <td>{{$banner->id}}</td>
                <td>{{$banner->banner_name}}</td>
                <td><img src="{{$banner->banner_url}}" alt="" width="100px"></td>
                <td class="">
                    <div class="checkbox-wrapper-34 row align-items-center  justify-content-center">
                        <input class="tgl tgl-ios status_change" id="status_change-{{$banner->id}}" type="checkbox" name="status" data-index={{$banner->id}} {{$banner->status == 1 ? 'checked disabled' : '' }}>
                        <label class="tgl-btn col-2" for="status_change-{{$banner->id}}"></label>
                    </div>
                </td>
                <td>{{$banner->created_at}}</td>

                <td>
                    <a class="btn btn-link btn-outline-success" data-bs-toggle="modal" data-bs-target="#showBanner" onclick="showBanner('{{$banner->id}}','{{$banner->banner_name}}','{{$banner->banner_url}}','{{$banner->created_at}}','{{$banner->updated_at}}','{{$banner->status}}')">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a class="btn btn-link btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editBanner" onclick="editBanner('{{$banner->id}}','{{$banner->banner_name}}','{{$banner->banner_url}}','{{$banner->status}}')">
                        <i class="fa-solid fa-edit"></i>
                    </a>
                    <form action="{{route('banner.delete',$banner->id)}}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" data-bs-toggle="tooltip" title="delete" class="btn btn-link btn-outline-danger" data-original-title="Remove" onclick="return confirm('Xác nhận xóa banner?')">
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
        {{ $banners->links('pagination::bootstrap-5') }}
    </div>
    <!-- Modal show-->
    <div class="modal fade" id="showBanner" tabindex="-1" aria-labelledby="showBannerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-2" id="">Chi tiết thể loại banner</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Id banner : <strong id="idQuocGia"></strong></h5>
                    <h5>Tên thể loại banner : <strong id="tenQuocGia"></strong></h5>
                    <h5>Ảnh nền : <img id="moTaQuocGia" src="" width="460px"></img></h5>
                    <h5>Trạng thái : <strong id="trangThai"></strong></h5>
                    <h5>Ngày tạo banner : <strong id="ngayTao"></strong></h5>
                    <h5>Ngày sửa banner : <strong id="ngaysSua"></strong></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal edit-->
    <div class="modal fade" id="editBanner" tabindex="-1" aria-labelledby="editBannerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="row g-3 needs-validation" novalidate method="post" action="" id="formEditBanner" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="createCoutryLabel">Chỉnh sửa banner</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 position-relative my-3 border p-3 rounded-3">
                            <label for="banner_name" class="form-label">Tên banner</label>
                            <input type="text" class="form-control" name="banner_name" id="banner_name_edit" required>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-12 position-relative my-3 border p-3 rounded-3">
                            <div class="checkbox-wrapper-34 row align-items-center">
                                <span class="col-10 ps-2" for="status_edit">Hiển thị</span>
                                <input class="tgl tgl-ios" id="status_edit" type="checkbox" name="status">
                                <label class="tgl-btn col-2" for="status_edit"></label>
                            </div>
                            <div class="valid-tooltip">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-12 position-relative my-3 border p-3 rounded-3">
                            <label for="backgroundUp" class="backgroundUp">Ảnh nền</label>
                            <input type="file" class="form-control" name="banner" id="backgroundUp" accept="image/*" required>
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
        return submitForm(e, 'check_list');
    });

    const checkboxes = document.getElementsByClassName('check_list');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('click', getCheckedValues);

    }


    document.getElementById('backgroundAdd').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('previewImageAdd');

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(file);
            preview.classList.remove('d-none');
        } else {
            preview.src = '';
        }
    });
    document.getElementById('backgroundUp').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('previewImageUp');

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(file);
            preview.classList.remove('d-none');
        } else {
            preview.src = '';
        }
    });

    // form show list page
    function submitForm() {
        document.getElementById('itemsPerPageForm').submit();
    }

    function showBanner() {
        let id = arguments[0];
        let name = arguments[1];
        let background = arguments[2];
        let created_at = arguments[3];
        let updated_at = arguments[4];
        let status = arguments[5];

        $('#idQuocGia').text(id);
        $('#tenQuocGia').text(name);
        $('#moTaQuocGia').attr('src', background);
        $('#ngayTao').text(created_at);
        $('#ngaysSua').text(updated_at);
        $('#trangThai').text(status == 1 ? 'Hiển thị' : 'ẩn');
    }


    const updateRoute = "{{ route('banner.update', ['id' => '__ID__']) }}";

    function editBanner() {
        let id = arguments[0];
        let name = arguments[1];
        let background = arguments[2];
        let status = arguments[3];


        const finalAction = updateRoute.replace('__ID__', id);
        $('#banner_name_edit').val(name);
        $('#previewImageUp').attr('src', background);
        $('#status_edit').prop('checked', status == 1 ? true : false);
        $('#previewImageUp').removeClass('d-none');
        $('#formEditBanner').attr('action', finalAction);

    }



    $(document).ready(function() {
        $('.status_change').on('change', function() {
            if ($(this).is(':checked')) {
                $(this).prop('disabled', true);
                let bannerId = $(this).data('index');

                $('.status_change').not(this).prop('checked', false).prop('disabled', false);


                updateStatus(bannerId);
            }

        })
    });

    function updateStatus(bannerId) {
        $.ajax({
            url: `/banner/${bannerId}/update/status`,
            type: 'GET',
            success: function(response) {

                flasher.success(response.message);
            },
            error: function(xhr, status, error) {
                flasher.error(xhr.responseText);
            }

        });
    }
</script>

@endsection
