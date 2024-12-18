@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách hổ trợ</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Hổ trợ</li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách hổ trợ</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('contacts.index')}}" class="btn btn-outline-success"> Tất cả hổ trợ </a>
        </div>
        <div class="col-sm-6 my-3">
            <form class="search-form float-end" action="{{route('contacts.search')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tìm kiếm..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between align-content-center m-0 p-0">
        <div class="form-group col-12 my-auto">
            <h5>Bộ Lọc</h5>
            <form action="{{route('contacts.index')}}" class="row align-middle" method="post" id="itemsPerPageForm">

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
                    <label for="">Trạng thái hổ trợ</label>
                    <select name="filterStatus" id="filterStatus" class="form-select" onchange="submitForm()">
                        <option value="" {{ request()->input('filterStatus') ? '' : 'selected'}}>Chọn trạng thái</option>
                        <option value="waiting" {{ request()->input('filterStatus') == "waiting" ? 'selected' : ''}} >Đang hổ trợ</option>
                        <option value="success" {{ request()->input('filterStatus') == "success" ? 'selected' : ''}} >Thành công</option>
                        <option value="fail" {{ request()->input('filterStatus') == "fail" ? 'selected' : ''}} >Thất bại</option>
                    </select>
                </div>
                <div class="col-6 col-sm-2">
                    <label for="">Từ ngày</label>
                    <input type="date" name="filterCreateStart" class="form-control" value="{{request()->input('filterCreateStart') ? request()->input('filterCreateStart') : ''}}" onchange="submitForm()">
                </div>
                <div class="col-6 col-sm-2">
                    <label for="">Đến ngày</label>
                    <input type="date" name="filterCreateEnd" class="form-control" value="{{request()->input('filterCreateEnd') ? request()->input('filterCreateEnd') : ''}}" onchange="submitForm()">
                </div>
            </form>
        </div>
    </div>
    <table class="table text-center mt-3" id="myTable">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Mã hổ trợ</th>
                <th scope="col">Tên tài khoản</th>
                <th scope="col">Email</th>
                <th scope="col">Ngày gửi</th>
                <th scope="col">Vấn đề</th>
                <th scope="col">Nội dung</th>
                <th scope="col">Trạng thái</th>
                <th scope="col-1">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @if (count($contacts))
            @foreach($contacts as $index => $contact)
            <tr>
                <td>{{$contacts->firstItem()+$index }}</td>
                <td>{{$contact->id}}</td>
                <td>{{$contact->username}}</td>
                <td>{{$contact->email}}</td>
                <td>{{$contact->created_at}}</td>
                <td>{{$contact->topic}}</td>
                <td>{{$contact->message}}</td>
                <td>
                    <form action="{{ route('contacts.update', $contact->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="contact_status" class="form-select {{ $contact->status == 'waiting' ? 'bg-warning' : ($contact->status == 'success' ? 'bg-success' : 'bg-danger') }} text-white" onchange="this.form.submit()">
                            <option class="bg-warning" value="waiting" {{ $contact->status == 'waiting' ? 'selected' : '' }}>Đang hổ trợ</option>
                            <option class="bg-success" value="success" {{ $contact->status == 'success' ? 'selected' : '' }}>Thành công</option>
                            <option class="bg-danger" value="fail" {{ $contact->status == 'fail' ? 'selected' : '' }}>Thất bại</option>
                        </select>
                    </form>
                </td>
                <td>
                    <a class="btn btn-link btn-outline-success" data-bs-toggle="modal" data-bs-target="#showBanner" onclick="showBanner('{{$contact->id}}','{{$contact->username}}','{{$contact->email}}','{{$contact->created_at}}','{{$contact->topic}}','{{$contact->message}}','{{$contact->status}}')">
                        <i class="fa-solid fa-eye"></i>
                    </a>
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

</div>
<div class="pagination-area" style="display: flex; justify-content: center; align-items: center;">
    <ul class="pagination">
        {{$contacts->links('pagination::bootstrap-5')}}
    </ul>
</div>
<!-- Modal show-->
<div class="modal fade" id="showBanner" tabindex="-1" aria-labelledby="showBannerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-2" id="">Chi tiết hổ trợ</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Id contact : <span id="idContact"></span></h5>
                <h5>Tên tài khoản : <strong id="tentk"></strong></h5>
                <h5>Email : <span id="emailtk"></span></h5>
                <h5>Ngày gửi : <span id="ngaygui"></span></h5>
                <h5>Vấn đề : <strong id="vande"></strong></h5>
                <h5>Nội dung : <span id="noidung"></span></h5>
                <h5>Trạng thái : <strong id="status"></strong></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>

        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    function submitForm() {
        document.getElementById('itemsPerPageForm').submit();
    }

    function showBanner() {
        let id = arguments[0];
        let name = arguments[1];
        let email = arguments[2];
        let created_at = arguments[3];
        let topic = arguments[4];
        let message = arguments[5];
        let status = arguments[6];

        $('#idContact').text(id);
        $('#tentk').text(name);
        $('#emailtk').text(email);
        $('#ngaygui').text(created_at);
        $('#vande').text(topic);
        $('#noidung').text(message);
        $('#status').text(status == 'waiting' ? 'Đang hổ trợ' : status == 'success' ? 'Thành công' : 'Thất bại');

    }
</script>
@endsection
