@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Thêm bài hát</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Bài hát</li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm bài hát</li>
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
            <form class="form-horizontal form-material" method="POST" enctype="multipart/form-data" action="{{route('store-music')}}">
                @csrf
                <div class="form-group mt-3">
                    <label class="col-md-12 mb-2">Tên bài hát <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="song_name" value="{{old('song_name')}}" class="form-control form-control-line border-3">
                    </div>
                    <div class="text-danger m-3 d-none" id="error-song-name">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12 mb-2">Mô tả <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="description" id="description" value="{{old('description')}}" class="form-control form-control-line border-3" disabled>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12 mb-2">Lời bài hát</label>
                    <div class="col-md-12">
                        <textarea name="lyrics" class="form-control form-control-line border-3 lyrics" id="editor" disabled>{{old('lyrics')}}</textarea>
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12 mb-2">Ca sĩ <span class="text-danger">(*)</span></label>
                        <select class="form-select border-3" name="singer_id" id="singer_id" aria-label="Default select example" value="{{old('singer_id')}}" disabled>
                            <option selected value="">Chọn Ca Sĩ</option>
                            @foreach ( $Singers as $Singer)
                            <option value="{{$Singer->id}}">{{$Singer->singer_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12 mb-2">Thể loại <span class="text-danger">(*)</span></label>
                        <select class="form-select border-3" name="category_id" id="category_id" aria-label="Default select example" value="{{old('category_id')}}" disabled>
                            <option selected value="">Chọn thể loại</option>
                            @foreach ( $Categories as $category)
                            <option value="{{$category->id}}">{{$category->categorie_name}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12 mb-2">Ngày phát hành <span class="text-danger">(*)</span></label>
                        <input type="date" name="release_day" id="release_day" value="{{old('release_day')}}" class="form-control form-control-line border-3" disabled>

                    </div>
                </div>
                <div class="form-group row mt-3">
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12 mb-2">Quốc gia <span class="text-danger">(*)</span></label>
                        <select class="form-select border-3" name="country_id" id="country_id" aria-label="Default select example" value="{{old('country_id')}}" disabled>
                            <option selected value="">Chọn quốc gia</option>

                            @foreach ( $Countries as $country)
                            <option value="{{$country->id}}">{{$country->name_country}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12 mb-2">Nhà cung cấp <span class="text-danger">(*)</span></label>
                        <input type="text" name="provider" id="provider" class="form-control form-control-line border-3" value="{{old('provider')}}" disabled>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12 mb-2">Tác giả <span class="text-danger">(*)</span></label>
                        <input type="text" name="composer" id="composer" class="form-control form-control-line border-3" value="{{old('composer')}}" disabled>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12 mb-2">Hình ảnh <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="file" class="form-control form-control-line border-3" name="song_image" id="songImage" accept="image/*" disabled>
                    </div>
                    <img id="previewImage" src="" alt="Image Preview" style="max-width: 300px; margin-top: 10px;" class="d-none">
                </div>
                <div class="form-group row mt-3">
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12 mb-2">File nhạc Basic <span class="text-danger">(*)</span></label>
                        <div class="form-check form-switch mb-3">
                            <label class="form-check-label" for="file_basic_text">Nhập text</label>
                            <input class="form-check-input" type="checkbox" role="switch" id="file_basic_text" disabled>
                        </div>
                        <input type="file" name="file_basic" id="file_basic" onchange="getTime(this)" accept="audio/mp3" class="form-control form-control-line border-3" disabled>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12 mb-2">File nhạc Plus</label>
                        <div class="form-check form-switch mb-3">
                            <label class="form-check-label" for="file_plus_text">Nhập text</label>
                            <input class="form-check-input" type="checkbox" role="switch" id="file_plus_text" disabled>
                        </div>
                        <input type="file" name="file_plus" id="file_plus" onchange="getTime(this)" accept="audio/mp3" class="form-control form-control-line border-3" disabled>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label class="col-md-12 mb-2">File nhạc Premium</label>
                        <div class="form-check form-switch mb-3">
                            <label class="form-check-label" for="file_premium_text">Nhập text</label>
                            <input class="form-check-input" type="checkbox" role="switch" id="file_premium_text" disabled>
                        </div>
                        <input type="file" name="file_premium" id="file_premium" onchange="getTime(this)" accept="audio/mp3" class="form-control form-control-line border-3" disabled>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12 mb-2">Thời lượng <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" class="form-control form-control-line border-3" name="time" id="time_song" required>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <div class="col-sm-12">
                        <button class="btn btn-success" id="addButton" type="submit" disabled>Thêm mới</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
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
<!-- <script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script> -->
<script>
    $(document).ready(function() {
        let editorInstance;

        // Khởi tạo CKEditor và đặt ở chế độ chỉ đọc
        ClassicEditor.create(document.querySelector('#editor'))
            .then(editor => {
                editor.enableReadOnlyMode('initial'); // Thiết lập chế độ chỉ đọc
                editorInstance = editor; // Lưu editor vào biến để có thể truy cập sau

                // Lắng nghe sự kiện change trong CKEditor để mở khóa trường tiếp theo
                editor.model.document.on('change:data', () => {
                    if (editor.getData()) {
                        enableNext(elements.indexOf('#editor'));
                        checkAllFieldsFilled(); // Kiểm tra nếu tất cả trường đã điền
                    }
                });
            })
            .catch(error => {
                console.error(error);
            });

        // Danh sách các trường cần điền theo thứ tự
        const elements = [
            '#song_name',
            '#description',
            '#editor',
            '#singer_id',
            '#category_id',
            '#release_day',
            '#country_id',
            '#provider',
            '#composer',
            '#songImage',
            '#file_basic',
            '#file_plus',
            '#file_premium'
        ];

        // Hàm mở khóa trường tiếp theo
        function enableNext(currentIndex) {
            if (currentIndex < elements.length - 1) {
                $(elements[currentIndex + 1]).removeAttr('disabled');
                if (elements[currentIndex + 1] === '#editor' && editorInstance) {
                    editorInstance.disableReadOnlyMode('initial');
                }
                if (elements[currentIndex + 1] === '#file_basic' || elements[currentIndex + 1] === '#file_plus' || elements[currentIndex + 1] === '#file_premium') {
                    $(elements[currentIndex + 1] + '_text').removeAttr('disabled');
                }
            }
        }

        // Hàm kiểm tra nếu tất cả trường cần thiết đã được điền (bỏ qua 3 phần tử cuối cùng)
        function checkAllFieldsFilled() {
            // Chỉ lấy các trường từ đầu đến trước 3 trường cuối
            const requiredElements = elements.slice(0, elements.length - 2);

            const allFilled = requiredElements.every(selector => {
                if (selector === '#editor') {
                    return editorInstance && editorInstance.getData().trim() !== "";
                } else {
                    return $(selector).val().trim() !== "";
                }
            });

            // Nếu tất cả các trường cần thiết đã có giá trị, kích hoạt nút Thêm mới
            $('#addButton').prop('disabled', !allFilled);
        }

        // Lặp qua từng trường và thiết lập sự kiện
        elements.forEach((selector, index) => {
            if (selector !== '#editor') { // Thiết lập sự kiện cho các trường khác CKEditor
                $(selector).on('input change', function() {
                    if ($(this).val() !== "") {
                        $(this).addClass('is-valid');
                        $(this).removeClass('is-invalid');
                        enableNext(index);
                        checkAllFieldsFilled(); // Kiểm tra nếu tất cả trường đã điền
                    } else {
                        $(this).removeClass('is-valid');
                        $(this).addClass('is-invalid');
                    }
                });
            }
        });

        // validate tên bài hát
        $('#song_name').keyup(function() {
            let song_name = $(this).val();
            if (song_name !== "") {
                $.ajax({
                    url: 'validate/name',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        song_name: song_name
                    },
                    success: function(response) {
                        if (response.success == true) {

                            $('#error-song-name').text(response.message);
                            $('#error-song-name').removeClass('d-none');
                            $('#song_name').addClass('is-invalid');
                            $('#song_name').removeClass('is-valid');
                        } else {
                            $('#error-song-name').addClass('d-none');
                            $('#song_name').addClass('is-valid');
                            $('#song_name').removeClass('is-invalid');
                            console.log(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            } else {
                $('#error-song-name').removeClass('d-none');
                $('#error-song-name').text('Nhập tên bài hát');
                $('#song_name').addClass('is-invalid');
                $('#song_name').removeClass('is-valid');
            }
        });

        // validate ngày
        const dateInput = $('#release_day');

        // Lấy ngày hôm nay ở định dạng YYYY-MM-DD
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0-11, cần +1
        const dd = String(today.getDate()).padStart(2, '0'); // Ngày trong tháng

        // Thiết lập giá trị tối đa cho thẻ input là hôm nay
        const maxDate = `${yyyy}-${mm}-${dd}`;
        dateInput.attr('max', maxDate);

        // Xử lý sự kiện thay đổi trên input để kiểm tra tính hợp lệ (nếu cần)
        dateInput.on('change', function() {
            if (new Date(dateInput.val()) > new Date(maxDate)) {
                dateInput.addClass('is-invalid');
                dateInput.val(''); // Xóa giá trị nếu chọn không hợp lệ
            } else {
                dateInput.addClass('is-valid');
            }
        });


        // file or text
        $('#file_basic_text').on('change', function() {
            // Thay đổi type của #file_basic dựa vào trạng thái checked
            $('#file_basic').prop('type', $(this).is(':checked') ? 'text' : 'file');
        });
        $('#file_plus_text').on('change', function() {
            // Thay đổi type của #file_plus dựa vào trạng thái checked
            $('#file_plus').prop('type', $(this).is(':checked') ? 'text' : 'file');
        });
        $('#file_premium_text').on('change', function() {
            // Thay đổi type của #file_premium dựa vào trạng thái checked
            $('#file_premium').prop('type', $(this).is(':checked') ? 'text' : 'file');
        });

    });
</script>
@endsection
