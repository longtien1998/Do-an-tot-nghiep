@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Cập nhật ca sĩ</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" aria-current="page">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">ca sĩ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Cập nhật ca sĩ</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card" style="border: none; border-radius: 0px;">
        <div class="card-body">
            <form class="form-horizontal form-material row" id="formedit" action="{{route('singer.update',$singer->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="form-group">
                    <label class="col-md-12">Tên ca sĩ <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="singer_name" value="{{$singer->singer_name}}" class="form-control form-control-line update" disabled>
                    </div>
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label class="col-md-12">Hình ảnh </label>
                    <div class="col-md-12">
                        <input type="file" name="singer_image" value="{{$singer->singer_image}}" id="Image" accept="image/*" class="form-control form-control-line update" disabled>
                    </div>
                    <img id="previewImage" src="{{$singer->singer_image}}" alt="Image Preview" style="max-width: 300px; margin-top: 10px;" class="d-none">
                </div>
                <div class="form-group col-md-6 mt-3">
                    <label class="col-md-12">Hình nền </label>
                    <div class="col-md-12">
                        <input type="file" name="singer_background" value="{{$singer->singer_background}}" id="Image2" accept="image/*" class="form-control form-control-line update" disabled>
                    </div>
                    <img id="previewImage2" src="{{$singer->singer_background}}" alt="Image Preview" style="max-width: 300px; margin-top: 10px;" class="d-none">
                </div>
                <div class="form-group col-md-12 mt-3">
                    <label class="col-md-12">Quốc gia</label>
                    <div class="col-md-12">
                        <input type="text" name="singer_country" value="{{$singer->singer_country}}" class="form-control form-control-line update" disabled>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="col-md-12">Ngày sinh</label>
                    <div class="col-md-12">
                        <input type="date" name="singer_birth_date" value="{{$singer->singer_birth_date}}" class="form-control form-control-line update" disabled>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Giới tính</label>
                    <div class="col-md-12">
                        <select class="form-select update" name="singer_gender" aria-label="Default select example " disabled>
                            <option value="Nam" @if ($singer->singer_gender == 'Nam') selected @endif >Nam</option>
                            <option value="Nữ" @if ($singer->singer_gender == 'Nữ') selected @endif >Nữ</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Tiểu sử</label>
                    <div class="col-md-12">
                        <textarea name="singer_biography" class="form-control form-control-line update" id="editor1" disabled>{{$singer->singer_biography}}</textarea>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Ngày tạo: {{$singer->created_at}}</label>
                    <label class="col-md-12">Ngày update: {{$singer->updated_at}}</label>
                </div>
                <div class="form-group mt-3" style="margin-bottom: 30px;">
                    <div class="col-sm-12">
                        <button class="btn btn-warning" id="editBtn">Chỉnh sửa</button>
                        <button class="btn btn-success" id="submit" type="submit" disabled>Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>

    const button = document.getElementById('editBtn');
    button.addEventListener('click', function(e) {
        const inputs = document.querySelectorAll('#formedit .update, #formedit #submit');
        e.preventDefault();
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


    $(document).ready(function() {
        $('#image').on('change', function() {
            previewImage(this, 'previewImage')
        });
        $('#image2').on('change', function() {
            previewImage(this, 'previewImage2')
        });
        const previewImage = $('#previewImage');
        if (previewImage.attr('src') !== undefined && previewImage.attr('src') !== null) {
            previewImage.removeClass('d-none');
        }
        const previewImage2 = $('#previewImage2');
        if (previewImage2.attr('src') !== undefined && previewImage2.attr('src') !== null) {
            previewImage2.removeClass('d-none');
        }
    });
</script>

@endsection
