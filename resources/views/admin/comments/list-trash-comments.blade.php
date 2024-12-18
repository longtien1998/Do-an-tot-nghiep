@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh bình luận đã xóa</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Bình luận</li>

                        <li class="breadcrumb-item active" aria-current="page">Danh sách bình luận đã xóa</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('comments.trash.list')}}" class="btn btn-outline-success"> Tất cả bình luận đã xóa</a>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{route('comments.trash.search')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên bình luận..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <table class="table text-center" id="myTable">
        <div class="form-group row justify-content-between m-0 p-0">
            <div class="col-sm-3 my-3">
                <div>Đã chọn <strong id="total-songs">0</strong> bình luận</div>
            </div>
            <div class="col-sm-6 my-3">
                <div class="float-end">
                    <form action="{{route('comments.trash.restore')}}" class="d-inline" method="post" id="form-restore">
                        @csrf
                        <input type="text" value="" name="restore_list" id="songs-restore" hidden>
                        <button type="submit" class="btn btn-success" onclick="return confirm('Xác nhận khôi phục bình luận đã chọn?')">Khôi phục bình luận</button>
                    </form>
                    <form action="{{route('comments.trash.delete')}}" class="d-inline" method="post" id="form-delete">
                        @csrf
                        <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                        <button type="submit" class="btn btn-warning" onclick="return confirm('Xác nhận xóa bình luận đã chọn?')">Xóa bình luận</button>
                    </form>
                    <a href="{{route('comments.trash.restore-all')}}" class="btn btn-primary" onclick="return confirm('Xác nhận khôi phục tất cả?')">Khôi phục tất cả bình luận</a>
                </div>

            </div>

        </div>
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_list" class="check_all_list"></th>
                <th scope="col" onclick="sortTable(1)">STT</th>
                <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(3)">Bình luận <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(4)">Đánh giá <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(5)">Người dùng <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(6)">Bài hát <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(7)">Ngày đánh giá <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(8)">Ngày xóa <span class="sort-icon">⬍</span></th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @if(count($comments))
            @php $stt = 1; @endphp
            @foreach($comments as $cmt)
            <tr>
                <td><input type="checkbox" class="check_list" value="{{$cmt->id}}"></td>
                <th scope="row">{{$stt}}</th>
                <td>{{$cmt->id}}</td>
                <td>{{$cmt->comment}}</td>
                <td>{{$cmt->rating}}</td>
                <td>{{$cmt->user_id}}</td>
                <td>{{$cmt->song_id}}</td>
                <td>{{$cmt->rating_date}}</td>
                <td>{{$cmt->deleted_at}}</td>

                <td>
                    <a href="{{route('comments.trash.destroy',$cmt->id)}}" data-bs-toggle="tooltip" title="" class="btn btn-link btn-outline-danger" data-original-title="Remove" onclick="return confirm('Xác nhận xóa bình luận?')">
                        <i class="fa-solid fa-trash"></i>
                    </a>

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
    <div class="mb-5">
        {!! $comments->links('pagination::bootstrap-5') !!}
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
    document.getElementById('form-restore').addEventListener('submit', function(e) {
        return submitForm(e, 'check_song_list'); // Gọi hàm submitForm khi gửi
    });

    document.getElementById('form-delete').addEventListener('submit', function(e) {
        return submitForm(e, 'check_song_list'); // Gọi hàm submitForm khi gửi
    });

    const checkboxes = document.getElementsByClassName('check_list');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('click', getCheckedValues);

    }
</script>
@endsection
