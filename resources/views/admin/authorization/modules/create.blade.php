@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Thêm Module</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Phân quyền tài khoản</li>
                        <li class="breadcrumb-item" aria-current="page">Danh sách Module</li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm Module</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
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
            <form class="form-horizontal form-material row" action="{{route('modules.store')}}" method="POST" >
                @csrf
                <div class="form-group">
                    <label class="col-md-12">Tên module <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control form-control-line" required>
                    </div>
                </div>
                <div class="form-group col-md-12 mt-3">
                    <label class="col-md-12">Tên gọi khác <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="slug" value="{{ old('slug') }}"  class="form-control form-control-line" required>
                    </div>
                </div>
                <div class="form-group mt-3" style="margin-bottom: 30px;">
                    <div class="col-sm-12">
                        <button class="btn btn-success" type="submit">Thêm mới</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>

</script>

@endsection