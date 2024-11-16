@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Tất cả logo</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('copyrights.index')}}" class="text-decoration-none">Nhà bản quyền</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tất cả logo</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<style>
    .image-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .image-item {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    img {
        max-width: 200px;
        height: auto;
        border: 1px solid #ccc;
    }

    .in-use {
        color: green;
        font-weight: bold;
    }
</style>
<div class="container mt-5">
    <h1 class="text-center mb-4">Quản lý File bản quyền</h1>
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-3 my-3">
            <div>Đã chọn <strong id="total-songs">0</strong> mục</div>
        </div>
        <div class="col-sm-6 text-center my-3">
            <form action="{{route('copyrights.destroy-list-logo')}}" class="d-inline float-end" method="post" id="form-delete">
                @csrf
                <input type="text" value="" name="delete_list" id="songs-delete" class="delete_list" hidden>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Xác nhận xóa file đã chọn?')">Xóa file</button>
            </form>
        </div>

    </div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_list" class="check_all_songs"></th>
                <th scope="col">STT</th>
                <th scope="col">File</th>
                <th scope="col">URL</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php $stt = 1; @endphp
            @foreach($filescopyright as $file)
            <tr>
                <td><input type="checkbox" class="check_list" value="{{$file['path']}}"></td>
                <td>{{ $stt++ }}</td>
                <td>{{ $file['url'] }}</td>
                <td><a href="{{ $file['url'] }}" target="_blank">Xem file</a></td>
                <td>
                    @if($file['in_use'])
                    <span class="badge bg-success">Đang sử dụng</span>
                    @else
                    <span class="badge bg-secondary">Không sử dụng</span>
                    @endif
                </td>
                <td>
                    @if ($file['in_use'])
                    <p class="in-use">Đang được sử dụng</p>
                    @else
                    <form action="{{ route('publishers.destroy_file') }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa ảnh này?');">
                        @csrf
                        <input type="hidden" name="path" value="{{$file['path']}}" hidden>
                        <button type="submit">Xóa</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
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
</script>

@endsection
