@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Thêm Vai trò</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Phân quyền tài khoản</li>
                        <li class="breadcrumb-item" aria-current="page">Danh sách Vai trò</li>
                        <li class="breadcrumb-item active" aria-current="page">Thêm Vai trò</li>
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
            <form class="form-horizontal form-material row" action="{{route('roles.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="col-md-12">Tên vai trò <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control form-control-line" placeholder="Thêm tên vai trò" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12">Loại vai trò <span class="text-danger">(*)</span></label>
                    <div class="col-md-12">
                        <select name="role_type" id="role_type" class="form-control">
                            @foreach($allRoleTypes as $roleType)
                            <option value="{{ $roleType }}"
                                @if(in_array($roleType, $existingRoleTypes)) disabled @endif>
                                {{ $roleType }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-12">Màu <span class="text-danger">(*)</span></label>
                    <div class="col-md-1">
                        <input type="color" name="color" value="{{ old('color') }}" class="form-control form-control-line" required>
                    </div>
                </div>
                <div class="form-group border border-1  p-3">
                    <h4 class="my-4">Quyền cho vai trò theo module</h4>
                    <nav>
                        <div class="nav nav-tabs bg-blue" id="nav-tab" role="tablist">
                            @foreach ($modules as $module)
                            <button class="nav-link @if ($loop->first) active @endif"
                                id="{{ $module->module_id }}-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#{{ $module->module_id }}"
                                type="button" role="tab"
                                aria-controls="{{ $module->module_id }}"
                                aria-selected="true">
                                {{ ucfirst($module->module->name) }}
                            </button>
                            @endforeach
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        @foreach ($modules as $module)
                        <div class="tab-pane row row-cols-4 p-4 fade @if ($loop->first) show active @endif" id="{{ $module->module_id }}" role="tabpanel" aria-labelledby="{{ $module->module_id  }}-tab" tabindex="0">
                            @foreach ($permissions->where('module_id', $module->module_id ) as $permission)
                            <div class="checkbox-wrapper-34 row align-items-center">
                                <input class="tgl tgl-ios" id="permission-{{$permission->id}}" type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                                <label class="tgl-btn col-2" for="permission-{{$permission->id}}"></label>
                                <span class="col-10 ps-2">{{$permission->alias }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
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
