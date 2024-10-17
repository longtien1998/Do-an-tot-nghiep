@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Tất cả ảnh</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tất cả ảnh</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<style>
    .image-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .image-item {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    img {
        max-width: 200px;
        height: auto;
        border: 1px solid #ccc;
    }

    .in-use {
        color: green;
        font-weight: bold;
    }
</style>
<div class="image-container">
    @foreach ($images as $image)
    <div class="image-item">
        <img src="{{ $image['url'] }}" alt="Image">
        @if ($image['in_use'])
        <p class="in-use">Đang được sử dụng</p>
        @else
        <form action="{{ route('s3images.destroy') }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa ảnh này?');">
            @csrf
            <input type="hidden" name="path" value="{{$image['path']}}" hidden>
            <button type="submit">Xóa</button>
        </form>
        @endif
    </div>
    @endforeach
</div>
@endsection
