@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh quảng cáo đã xóa</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Quảng cáo</li>

                        <li class="breadcrumb-item active" aria-current="page">Danh sách quảng cáo đã xóa</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('advertisements.trash.list')}}" class="btn btn-outline-success"> Tất cả quảng cáo đã xóa</a>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{route('advertisements.trash.search')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên quảng cáo..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <table class="table text-center" id="myTable">
        <div class="form-group row justify-content-between m-0 p-0">
            <div class="col-sm-3 my-3">
                <div>Đã chọn <strong id="total-songs">0</strong> Quảng cáo</div>
            </div>
            <div class="col-sm-6 text-center my-3">
                <form action="{{route('advertisements.trash.restore')}}" class="d-inline" method="post" id="form-restore">
                    @csrf
                    <input type="text" value="" name="restore_list" id="songs-restore" hidden>
                    <button type="submit" class="btn btn-success" onclick="return confirm('Xác nhận khôi phục quảng cáo đã chọn?')">Khôi phục quảng cáo</button>
                </form>
                <form action="{{route('advertisements.trash.delete')}}" class="d-inline" method="post" id="form-delete">
                    @csrf
                    <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Xác nhận xóa quảng cáo đã chọn?')">Xóa quảng cáo</button>
                </form>
                <a href="{{route('advertisements.trash.restore-all')}}" class="btn btn-primary" onclick="return confirm('Xác nhận khôi phục tất cả?')">Khôi phục tất cả quảng cáo</a>
            </div>

        </div>
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_list" class="check_all_list" ></th>
                <th scope="col" onclick="sortTable(1)">STT <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(3)">Tên quảng cáo <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(4)">Mô tả <span class="sort-icon">⬍</span></th>
                <th scope="col">Đường dẫn</th>
                <th scope="col" onclick="sortTable(6)">Ngày xóa <span class="sort-icon">⬍</span></th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php $stt = 1; @endphp
            @foreach($advertisements as $ads)
            <tr>
                <td><input type="checkbox" class="check_list" value="{{$ads->id}}"></td>
                <th scope="row">{{$stt}}</th>
                <td>{{$ads->id}}</td>
                <td>{{$ads->ads_name}}</td>
                <td>{{$ads->ads_description}}</td>
                <td><a href="{{asset('admin/upload/ads/'. $ads->file_path)}}">{{$ads->file_path}}</a></td>
                <td>{{$ads->deleted_at}}</td>

                <td>
                    <a href="{{route('advertisements.trash.destroy',$ads->id)}}" data-bs-toggle="tooltip" title="" class="btn btn-link btn-outline-danger" data-original-title="Remove" onclick="return confirm('Xác nhận xóa quảng cáo?')">
                        <i class="fa-solid fa-trash"></i>
                    </a>

                </td>
            </tr>
            @php $stt++; @endphp
            @endforeach
        </tbody>
    </table>

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
    document.getElementById('form-restore').addEventListener('submit', function(e) {
       return submitForm(e, 'check_song_trash'); // Gọi hàm submitForm khi gửi
    });

    document.getElementById('form-delete').addEventListener('submit', function(e) {
       return submitForm(e, 'check_song_trash'); // Gọi hàm submitForm khi gửi
    });

    const checkboxes = document.getElementsByClassName('check_list');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('click', getCheckedValues);

    }
</script>
@endsection
