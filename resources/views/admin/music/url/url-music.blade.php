@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb mb-5">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách đường dẫn bài hát</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Bài hát</li>

                        <li class="breadcrumb-item active" aria-current="page">Danh sách đường dẫn bài hát</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('url.index')}}" class="btn btn-outline-success"> Tất cả file</a>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{route('search-song')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên bài hát..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <div class="form-group row justify-content-between align-content-center m-0 p-0">
        <div class="form-group col-12 my-auto">
            <h5>Bộ Lọc</h5>
            <form action="{{route('url.index')}}" class="row align-middle" method="post" id="itemsPerPageForm">
                @csrf
                <div class="col-6 col-sm-6 col-xl-2">
                    <label for="indexPage">Hiển thị</label>
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
            </form>
        </div>
    </div>

    <table class="table text-center mt-3" id="myTable">

        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(3)">Tên bài hát <span class="sort-icon"> ⬍ </span></th>
                <th scope="col" onclick="sortTable(4)">File Path <span class="sort-icon"> ⬍ </span></th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($urls as $index => $url)
            <tr>
                <th scope="row">{{$urls->firstItem() + $index}}</th>
                <td>{{$url->id}}</td>
                <td>{{$url->song_name}}</td>
                <td class="text-start">
                    @foreach ($url->file_paths as $index => $path)
                        <p class="py-2 m-0">{{$index .': '. $path}}</p>
                    @endforeach
                </td>

                <td>
                    <a class="btn btn-link btn-outline-warning" data-bs-toggle="modal" data-bs-target="#upFile" onclick="setModal('{{$url->id}}','{{$url->song_name}}')"> <i class="fa-solid fa-upload"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>

    <div class=" mb-5">
        {!! $urls->links('pagination::bootstrap-5') !!}
    </div>
    <!-- Modal -->
    <div class="modal fade" id="upFile" tabindex="-1" aria-labelledby="upFileLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="upFileLabel">Tải lên file bài hát</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <h4>Tên bài hát : <span id="tenBaiHat"></span></h4>
                        <div class="col-xl-12 mt-3">
                            <label class="col-md-12 mb-2" for="file_basic_up">File nhạc Basic</label>
                            <input type="file" name="file_basic_up" accept="audio/mp3" class="upFile" id="file_basic_up">
                        </div>
                        <div class="col-xl-12 mt-3">
                            <label class="col-md-12 mb-2" for="file_plus_up">File nhạc Plus</label>
                            <input type="file" name="file_plus_up" accept="audio/mp3" class="upFile" id="file_plus_up">
                        </div>
                        <div class="col-xl-12 mt-3">
                            <label class="col-md-12 mb-2" for="file_premium_up">File nhạc Premium</label>
                            <input type="file" name="file_premium_up" accept="audio/mp3" class="upFile" id="file_premium_up">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
    // form show list page
    function submitForm() {
        document.getElementById('itemsPerPageForm').submit();
    }

    const uploadRoute = "{{ route('up-load-file-music', ['id' => '__ID__']) }}";
    function setModal(id, song_name){

        document.getElementById('tenBaiHat').innerText = song_name;
        const finalAction = uploadRoute.replace('__ID__', id);
        document.getElementById('uploadForm').action = finalAction;
    }
</script>

@endsection
