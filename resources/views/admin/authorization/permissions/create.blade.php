@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Thêm quyền hạn</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Phân quyền tài khoản</li>
                        <li class="breadcrumb-item" aria-current="page">Danh sách quyền hạn</li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm quyền hạn</li>
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
            <div class="row justify-content-between">
            <form class="form-horizontal form-material row col-md-7" action="{{route('permissions.store')}}" method="POST" >
                @csrf
                <div class="form-group">
                    <label class="col-md-12">Tên quyền hạn <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="alias" value="{{ old('alias') }}" class="form-control form-control-line" required>
                    </div>
                </div>
                <div class="form-group col-md-12 mt-3">
                    <label class="col-md-12">Bí danh <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="name" value="{{ old('name') }}"  class="form-control form-control-line" required>
                    </div>
                </div>
                <div class="form-group col-md-12 mt-3">
                    <label class="col-md-12">Module <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <select name="module" id=""  class="form-select " required>
                            <option value="">Chọn module</option>
                            @foreach ($modules as $module)
                            <option value="{{$module->id}}">{{$module->name}} ({{$module->slug}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group mt-5">
                    <div class="col-sm-12">
                        <button class="btn btn-success" type="submit">Thêm mới</button>
                    </div>
                </div>
            </form>
            <div class="col-md-4 shadow p-3 rounded mt-3 overflow-y-auto" style="max-height: 550px;">
                    <h4>Danh sách quyền hạn</h4>
                    <table class="table">
                        <tr class>
                            <th>Tên</th>
                            <th>Module</th>
                        </tr>
                        @foreach ($permissions as $permission)
                        <tr>
                            <td>{{$permission->alias}} ({{$permission->name}})</td>
                            <td>{{$permission->module->name}} ({{$permission->module->slug}})</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>

</script>

@endsection
