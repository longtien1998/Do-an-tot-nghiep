@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách quảng cáo</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Quảng cáo</li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách quảng cáo</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('advertisements.list')}}" class="btn btn-outline-success"> Tất cả quảng cáo</a>
            <a href="{{route('advertisements.create')}}" class="btn btn-success">Thêm quảng cáo</a>
        </div>
        <div class="col-sm-6 my-3">
            <form class="search-form float-end" action="{{route('advertisements.search')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên quảng cáo..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <div>Đã chọn <strong id="total-songs">0</strong> quảng cáo</div>
        </div>
        <div class="col-sm-6 my-3">
            <form action="{{route('advertisements.delete-list')}}" class="d-inline float-end" method="post" id="form-delete">
                @csrf
                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận xóa quảng cáo đã chọn?')">Xóa quảng cáo</button>
            </form>
        </div>
    </div>
    <table class="table text-center" id="myTable">
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_list" class=""></th>
                <th scope="col" onclick="sortTable(1)">ID <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(2)">Tên quảng cáo <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(3)">Mô tả <span class="sort-icon">⬍</span></th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Đường dẫn </th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @if (count($advertisements))
            @php $stt = 1; @endphp
            @foreach($advertisements as $ads)
            <tr>
                <td><input type="checkbox" class="check_list" value="{{$ads->id}}"></td>
                <th scope="row">{{$ads->id}}</th>
                <td>{{$ads->ads_name}}</td>
                <td>{{$ads->ads_description}}</td>
                <td>
                    @if($ads->image_path)
                    <img width="50" height="50" src="{{$ads->image_path}}" alt="">
                    @else
                    <img width="50" height="50" src="{{asset('logo.png')}}">
                    @endif
                </td>
                <td><a href="{{$ads->file_path}}" target="_blank">{{$ads->file_path}}</a></td>
                <td>
                    <a href="{{route('advertisements.edit',$ads->id)}}"> <i class="fa-solid fa-pen-to-square"></i></a>

                    <form action="{{ route('advertisements.delete', $ads->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link btn-outline-danger" onclick="return confirm('Xác nhận xóa quảng cáo?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @php $stt++; @endphp
            @endforeach
            @else
            <tr class="text-center">
                <td colspan="10">Không có dữ liệu</td>
            </tr>
            @endif
        </tbody>
    </table>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
        {{session('success')}}
    </div>
    @endif

</div>
<div class="pagination-area" style="display: flex; justify-content: center; align-items: center;">
    <ul class="pagination">
        {{$advertisements->links('pagination::bootstrap-5')}}
    </ul>
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
</script>

@endsection
