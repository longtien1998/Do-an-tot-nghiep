@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Tất cả file quảng cáo</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Quảng cáo</li>
                        <li class="breadcrumb-item active" aria-current="page">Tất cả file quảng cáo</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h1 class="text-center mb-4">Quản Lý File Quảng Cáo</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">File Path</th>
                <th scope="col">URL</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php $stt = 1; @endphp
            @foreach($advertisements as $ads)
            <tr>
                <td>{{ $stt++ }}</td>
                <td>{{ $ads['path'] }}</td>
                <td><a href="{{ $ads['url'] }}" target="_blank">Xem file</a></td>
                <td>
                    @if($ads['in_use'])
                    <span class="badge bg-success">Đang sử dụng</span>
                    @else
                    <span class="badge bg-secondary">Không sử dụng</span>
                    @endif
                </td>
                <td>
                    @if(!$ads['in_use'])
                    <form action="{{ route('advertisements.s3ads.destroy') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="text" name="path" value="{{$ads['path']}}" hidden>
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa file này?')">
                            Xóa
                        </button>
                    </form>
                    @else
                    <button class="btn btn-secondary btn-sm" disabled>Đang sử dụng</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
