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
                <input type="text" name="search" placeholder="Tên, tên khác, Quốc gia, Thành ..." required />
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
                    <th scope="col">ID</th>
                    <th scope="col">Tên bài hát</th>
                    <th scope="col">Nhà xuất bản</th>
                    <th scope="col">Loại giấy phép</th>
                    <th scope="col">Ngày phát hành</th>
                    <th scope="col">Ngày hết hạn</th>
                    <th scope="col">Quyền sử dụng</th>
                    <th scope="col">Điều khoản</th>
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
                    <td>{{$copyright->expiry_day->format('d-m-Y')}}</td>
                    <td>{{$copyright->usage_rights}}</td>
                    <td>{{$copyright->terms}}</td>
                    <td>{{$copyright->license_file}}</td>
                    <td>
                        <a href="{{route('copyrights.edit',$copyright->id)}}" class="btn btn-link btn-outline-success"> <i class="fa-solid fa-eye"></i></a>
                        <form action="{{route('copyrights.delete',$copyright->id)}}" method="post" class="d-inline">
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
    </div>
</div>

@endsection
