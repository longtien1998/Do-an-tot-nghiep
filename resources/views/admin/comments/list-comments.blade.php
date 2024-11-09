@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách bình luận</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Bình luận</li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách bình luận</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
<div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('comments.list')}}" class="btn btn-outline-success"> Tất cả bình luận</a>
            <!-- <a href="#" class="btn btn-success">Thêm bình luận</a> -->
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{route('comments.search')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên bình luận..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <div>Đã chọn <strong id="total-songs">0</strong> bình luận</div>
        </div>
        <div class="col-sm-6 my-3">
            <form action="{{route('comments.delete-list')}}" class="d-inline float-end" method="post" id="form-delete">
                @csrf
                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận xóa bình luận đã chọn?')">Xóa bình luận</button>
            </form>
        </div>
    </div>
    <table class="table text-center" id="myTable">
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_list" class=""></th>
                <th scope="col" onclick="sortTable(1)">ID <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(2)">Bình luận <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(3)">Đánh giá <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(4)">Người dùng <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(5)">Bài hát <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(6)">Ngày đánh giá <span class="sort-icon">⬍</span></th>
                <th scope="col">Hành dộng</th>
            </tr>
        </thead>
        <tbody>
            @php $stt = 1; @endphp
            @foreach($comments as $comment)
            <tr>
                <td><input type="checkbox" class="check_list" value="{{$comment->id}}"></td>
                <th scope="row">{{$comment->id}}</th>
                <td>{{$comment->comment}}</td>
                <td>{{$comment->rating}}</td>
                <td>{{$comment->user->name}}</td>
                <td>{{$comment->song->song_name}}</td>
                <td>{{$comment->rating_date}}</td>
                <td>
                    <a href="{{route('comments.edit', $comment->id)}}"> <i class="fa-solid fa-pen-to-square"></i></a>
                    <form action="{{ route('comments.delete', $comment->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link btn-outline-danger" onclick="return confirm('Xác nhận xóa bình luận?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @php $stt++; @endphp
            @endforeach
        </tbody>
    </table>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <h4><i class="icon fa fa-check"></i> Thông báo !</h4>
        {{session('success')}}
    </div>
    @endif
</div>
<div class="pagination-area" style="display: flex; justify-content: center; align-items: center;">
    <ul class="pagination">
        {{$comments->links('pagination::bootstrap-5')}}
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
