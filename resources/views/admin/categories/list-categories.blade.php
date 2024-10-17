@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách thể loại</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Danh sách thể loại</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="form-group">
        <div class="col-sm-12 my-3">
            <a href="{{route('add-categories')}}" class="btn btn-success">Thêm thể loại</a>
        </div>
    </div>
    <table class="table text-center">
        <thead>
            <tr>
                <th scope="1">STT</th>
                <th scope="col">ID</th>
                <th scope="col">Tên thể loại</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php $stt = 1; @endphp
            @foreach ($categories as $category)
            <tr>
                <td>{{$stt}}</td>
                <th scope="row">{{$category->id}}</th>
                <td>{{$category->categorie_name}}</td>
                <td>{{$category->description}}</td>
                <td>{{$category->created_at}}</td>
                <td>
                    <a href="{{route('edit-categories',$category->id)}}"> <i class="fa-solid fa-pen-to-square"></i></a>
                    <form action="{{route('delete-categories',$category->id)}}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove" onclick="return confirm('Xác nhận xóa thể loại?')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>


                </td>
            </tr>
            @php $stt++; @endphp
            @endforeach
        </tbody>
    </table>

</div>

@endsection
