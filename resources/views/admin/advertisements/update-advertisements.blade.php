@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Cập nhật quảng cáo</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Cập nhật quảng cáo</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="card" style="border: none; border-radius: 0px;">
        <div class="card-body">
            <form class="form-horizontal form-material" action="{{route('update-advertisements')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="col-md-12">Tên quảng cáo <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="ads_name" value="{{old('ads_name', $ads->ads_name)}}" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Mô tả</label>
                    <div class="col-md-12">
                        <input type="text" name="ads_description" value="{{old('ads_description', $ads->ads_description)}}" class="form-control form-control-line">
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label class="col-md-12">Đường dẫn</label>
                    <div class="col-md-12">
                    @if($ads->file_path)
                        <input type="text" name="file_path" id="file" value="{{asset('admin/upload/ads/'. $ads->file_path)}}" class="form-control form-control-line" >
                    @endif
                    </div>
                </div>
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
                <div class="form-group mt-3">
                    <div class="col-sm-12">
                        <button class="btn btn-success" type="submit">Cập nhật</button>
                        <button type="button" id="uploadFile" class="btn btn-primary"> Upload file</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    document.getElementById('uploadFile').addEventListener('click',function(){
        if(document.getElementById('file').getAttribute('type') == 'text'){
            document.getElementById('file').setAttribute('type','file');
        } else {
            document.getElementById('file').setAttribute('type','text');
        }

    });
</script>

@endsection
