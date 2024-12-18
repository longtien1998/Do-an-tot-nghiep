@extends('admin.layouts.app')

@section('content')
<!-- Main Content -->


<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Dashboard</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row row-cols-xxl-6 row-cols-xl-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-4 ">
        <div class="col ">
            <div class="dashboard-card h-100" style="background: linear-gradient(98deg, rgba(249,246,181,1) 39%, rgba(153,255,161,1) 87%);">
                <a href="{{route('users.list')}}" class="text-decoration-none text-black">
                    <i class="fas fa-users"></i>
                    <span>Người dùng</span>
                    <p class="card-value">{{$total_user}}</p>
                </a>
            </div>
        </div>
        <div class="col ">
            <div class="dashboard-card h-100" style="background: linear-gradient(98deg, rgba(186,249,181,1) 39%, rgba(153,225,255,1) 87%);">
                <a href="{{route('users.list')}}" class="text-decoration-none text-black">
                    <i class="fas fa-music"></i>
                    <span>Bài hát</span>
                    <p class="card-value">{{$total_song}}</p>
                </a>
            </div>
        </div>
        <div class="col ">
            <div class="dashboard-card h-100" style="background: linear-gradient(138deg, rgba(181,246,249,1) 32%, rgba(153,164,255,1) 87%);">
                <a href="{{route('singer.index')}}" class="text-decoration-none text-black">
                    <i class='bx bxs-microphone-alt'></i>
                    <span>Ca sĩ</span>
                    <p class="card-value">{{$total_singer}}</p>
                </a>
            </div>
        </div>
        <div class="col ">
            <div class="dashboard-card h-100" style="background: linear-gradient(138deg, rgba(181,202,249,1) 32%, rgba(209,153,255,1) 87%);">
                <a href="{{route('categories.list')}}" class="text-decoration-none text-black">
                    <i class="fa-solid fa-list"></i>
                    <span>Thể loại</span>
                    <p class="card-value">{{$total_category}}</p>
                </a>
            </div>
        </div>
        <div class="col ">
            <div class="dashboard-card h-100" style="background: linear-gradient(169deg, rgba(218,181,249,1) 0%, rgba(255,153,155,1) 100%);">
                <a href="{{route('users.list')}}" class="text-decoration-none text-black">
                    <i class="fas fa-box"></i>
                    <span>Đơn hàng</span>
                    <p class="card-value">{{$total_order}}</p>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card h-100" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
                <a href="{{route('users.list')}}" class="text-decoration-none text-black">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Thu nhập</span>
                    <p class="card-value">{{number_format($total_amount)}} VND</p>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card h-100" style="background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%);">
                <a href="{{route('comments.list')}}" class="text-decoration-none text-black">
                    <i class="fa-solid fa-comment"></i>
                    <span>Bình luận</span>
                    <p class="card-value">{{$total_comment}}</p>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card h-100" style="background: linear-gradient(135deg, #ff9a8b 0%, #ff6a88 100%);">
                <a href="{{route('albums.list')}}" class="text-decoration-none text-black">
                    <i class='bx bxs-album'></i>
                    <span>Album</span>
                    <p class="card-value">{{$total_albums}}</p>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card h-100" style="background: linear-gradient(135deg, #b2fefa 0%, #0ed2f7 100%);">
                <a href="{{route('publishers.index')}}" class="text-decoration-none text-black">
                    <i class='bx bx-building-house'></i>
                    <span>Nhà xuất bản</span>
                    <p class="card-value">{{$total_publishers}}</p>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card h-100" style="background: linear-gradient(135deg, #fffcab 0%, #ff9e9e 100%);">
                <a href="{{route('copyrights.index')}}" class="text-decoration-none text-black">
                    <i class='fa-solid fa-copyright'></i>
                    <span>Bản quyền</span>
                    <p class="card-value">{{$total_copyright}}</p>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card h-100" style="background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);">
                <a href="{{route('advertisements.list')}}" class="text-decoration-none text-black">
                    <i class='fa-solid fa-rectangle-ad'></i>
                    <span>Quảng cáo</span>
                    <p class="card-value">{{$total_ads}}</p>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card h-100" style="background: linear-gradient(135deg, #c1f0fc 0%, #f7d6e0 100%);">
                <a href="{{route('list-country')}}" class="text-decoration-none text-black">
                    <i class='fa-solid fa-globe'></i>
                    <span>Quốc gia</span>
                    <p class="card-value">{{$total_country}}</p>
                </a>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card h-100" style="background: linear-gradient(135deg, #c1f0fc 0%, #f7d6e0 100%);">
                <a href="{{route('list-country')}}" class="text-decoration-none text-black">
                <i class="fa-solid fa-handshake-angle"></i>
                    <span>Hỗ trợ</span>
                    <p class="card-value">{{$total_contact}}</p>
                </a>
            </div>
        </div>

    </div>
    <!-- More Dashboard Content -->
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="dashboard-card">
                <i class="fas fa-chart-pie"></i>
                <h5>Recent Activity</h5>
                <p>Show the latest user activities here...</p>
            </div>
        </div>
    </div>
</div>
@endsection
