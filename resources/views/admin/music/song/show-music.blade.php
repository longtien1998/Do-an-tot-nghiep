@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Chi tiết bài hát</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('list-music')}}" class="text-decoration-none">Danh sách bài hát</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Chi tiết bài hát</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mb-5">
    <div class="card" style="border: none; border-radius: 0px;">
        <div class="card-body">
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
            <form class="form-horizontal form-material" id="formedit" method="POST" enctype="multipart/form-data" action="{{route('update-music',$song->id)}}">
                @csrf
                @method('put')
                <div class="form-group mt-3">
                    <label class="col-md-12 mb-2">Tên bài hát <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="song_name" value="{{$song->song_name}}" class="form-control form-control-line update" disabled>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12 mb-2">Mô tả <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="description" value="{{$song->description}}" class="form-control form-control-line update" disabled>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12 mb-2">Lời bài hát</label>
                    <div class="col-md-12">
                        <textarea name="lyrics" class="form-control form-control-line update" id="editor" disabled>{{$song->lyrics}}</textarea>
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12 mb-2">Ca sĩ <span class="text-danger">(*)</span></label>
                        <select class="form-select update" name="singer_id" aria-label="Default select example" disabled>
                            <option selected value="{{$song->singer_id}}">{{$song->singer_name}}</option>
                            @foreach ( $Singers as $Singer)
                            <option value="{{$Singer->id}}">{{$Singer->singer_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12 mb-2">Thể loại <span class="text-danger">(*)</span></label>
                        <select class="form-select update" name="category_id" aria-label="Default select example" disabled>
                            <option selected value="{{$song->category_id}}">{{$song->category_name}}</option>

                            @foreach ( $Categories as $category)
                            <option value="{{$category->id}}">{{$category->categorie_name}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12 mb-2">Ngày phát hành <span class="text-danger">(*)</span></label>
                        <input type="date" name="release_day" value="{{\Carbon\Carbon::parse($song->release_day)->format('Y-m-d')}}" class="form-control form-control-line update" disabled>

                    </div>
                </div>
                <div class="form-group row mt-3">
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12 mb-2">Quốc gia <span class="text-danger">(*)</span></label>
                        <select class="form-select update" name="country_id" aria-label="Default select example" value="{{old('country')}}" disabled>
                            <option selected value="{{$song->country_id}}">{{App\Models\Country::find($song->country_id)->name_country}}</option>

                            @foreach ( $Countries as $country)
                            <option value="{{$country->id}}">{{$country->name_country}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12 mb-2">Nhà cung cấp <span class="text-danger">(*)</span></label>
                        <input type="text" name="provider" class="form-control form-control-line update" value="{{$song->provider}}" disabled>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12 mb-2">Nhà soạn nhạc <span class="text-danger">(*)</span></label>
                        <input type="text" name="composer" class="form-control form-control-line update" value="{{$song->composer}}" disabled>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <div class="col-xl-12 mt-3">
                        <label class="col-md-12 mb-2">File nhạc Basic <span class="text-danger">(*)</span></label>
                        @if ($song->file_path_basic)
                        <input type="text" name="file_basic" accept="audio/mp3" value="{{$song->file_path_basic}}" class="form-control form-control-line upFile update" disabled>
                        <audio src="{{$song->file_path_basic}}" controls></audio>
                        @else
                        <input type="file" name="file_basic" accept="audio/mp3"  disabled>
                        @endif
                    </div>
                    <div class="col-xl-12 mt-3">
                        <label class="col-md-12 mb-2">File nhạc Plus</label>
                        @if ($song->file_path_plus)
                        <input type="text" name="file_plus" accept="audio/mp3" value="{{$song->file_path_plus}}" class="form-control form-control-line upFile update" disabled>
                        <audio src="{{$song->file_path_plus}}" controls></audio>
                        @else
                        <input type="file" name="file_plus" accept="audio/mp3"  disabled>
                        @endif
                    </div>
                    <div class="col-xl-12 mt-3">
                        <label class="col-md-12 mb-2">File nhạc Premium</label>
                        @if ($song->file_path_premium)
                        <input type="text" name="file_premium" accept="audio/mp3" value="{{$song->file_path_premium}}" class="form-control form-control-line upFile update" disabled>
                        <audio src="{{$song->file_path_premium}}" controls></audio>
                        @else
                        <input type="file" name="file_premium" accept="audio/mp3"  disabled>
                        @endif
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12 mb-2">Hình ảnh <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="file" name="song_image" id="songImage" class="update" accept="image/*" value="{{$song->song_image}}" disabled>
                    </div>
                    <img id="previewImage" src="{{$song->song_image}}" alt="Image Preview" style="max-width: 300px; margin-top: 10px;" class="d-none">
                </div>
                <div class="form-group mt-3">
                    <p><strong>Lượt Nghe: </strong>{{$song->listen_count}}</p>
                    <p><strong>Lượt tải: </strong>{{$song->download_count}}</p>
                    <p><strong>Ngày tạo: </strong>{{$song->created_at}}</p>
                    <p><strong>Ngày update: </strong>{{$song->updated_at}}</p>
                </div>
                <div class="form-group mt-4">
                    <div class="col-sm-12">
                        <button class="btn btn-primary" type="button" id="editBtn">Chỉnh sửa</button>
                        <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#upFile">Up load file</button>
                        <button class="btn btn-success" type="submit" id="submit" disabled>Lưu</button>
                    </div>
                </div>
            </form>
            <!-- Modal -->
            <div class="modal fade" id="upFile" tabindex="-1" aria-labelledby="upFileLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="upFileLabel">Tải lên file bài hát</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{route('up-load-file-music',$song->id)}}" method="post" enctype="multipart/form-data" id="uploadForm">
                            @csrf
                            @method('put')
                            <div class="modal-body">
                                <h4>Tên bài hát : {{$song->song_name}}</h4>
                                <div class="col-xl-12 mt-3">
                                    <label class="col-md-12 mb-2">File nhạc Basic <span class="text-danger">(*)</span></label>
                                    <input type="file" name="file_basic_up" accept="audio/mp3" class="upFile">
                                </div>
                                <div class="col-xl-12 mt-3">
                                    <label class="col-md-12 mb-2">File nhạc Plus</label>
                                    <input type="file" name="file_plus_up" accept="audio/mp3" class="upFile">
                                </div>
                                <div class="col-xl-12 mt-3">
                                    <label class="col-md-12 mb-2">File nhạc Premium</label>
                                    <input type="file" name="file_premium_up" accept="audio/mp3" class="upFile">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary" >Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    const previewImage = document.getElementById('previewImage');
    if (previewImage.src !== undefined && previewImage.src !== null) {
        previewImage.classList.remove('d-none');
    }

    const button = document.getElementById('editBtn');
    button.addEventListener('click', function() {
        const inputs = document.querySelectorAll('#formedit .update, #formedit #submit');

        inputs.forEach(input => {
            if (input.hasAttribute('disabled')) {
                input.removeAttribute('disabled');
            } else {
                input.setAttribute('disabled', '');
            }
        });

        // Đổi nội dung nút giữa "Chỉnh sửa" và "Khóa lại"
        button.textContent = button.textContent === 'Chỉnh sửa' ? 'Khóa lại' : 'Chỉnh sửa';
    });


    document.getElementById('songImage').addEventListener('change', function(event) {
        const file = event.target.files[0]; // Lấy file đầu tiên từ input
        const preview = document.getElementById('previewImage'); // Thẻ <img> để hiển thị ảnh

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
</script>
<script
    src="https://cdn.ckeditor.com/ckeditor5/36.0.0/classic/ckeditor.js">
</script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
