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
    <div class="row row-cols-xxl-6 row-cols-xl-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-4">
        <div class="col">
            <div class="dashboard-card">
                <i class="fas fa-users"></i>
                <h5>Người dùng</h5>
                <p class="card-value">{{$total_user}}</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card">
                <i class="fas fa-music"></i>
                <h5>Bài hát</h5>
                <p class="card-value">{{$total_song}}</p>
            </div>
        </div>
        <div class="col col">
            <div class="dashboard-card">
                <!-- <i class="fas fa-microphone-stand"></i> -->
                <i class='bx bxs-microphone-alt'></i>
                <h5>Ca sĩ</h5>
                <p class="card-value">{{$total_singer}}</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card">
                <i class="fa-solid fa-list"></i>
                <h5>Thể loại</h5>
                <p class="card-value">{{$total_category}}</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card">
                <i class="fas fa-box"></i>
                <h5>Đơn hàng</h5>
                <p class="card-value">100</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card">
                <i class="fas fa-dollar-sign"></i>
                <h5>Thu nhập</h5>
                <p class="card-value">$58,300</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card">
                <i class="fa-solid fa-comment"></i>
                <h5>Bình luận</h5>
                <p class="card-value">{{$total_comment}}</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card">
                <i class='bx bxs-album'></i>
                <h5>Album</h5>
                <p class="card-value">510</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card" >
                <i class='bx bx-building-house'></i>
                <h5>Nhà xuất bản</h5>
                <p class="card-value">{{$total_publishers}}</p>
            </div>
        </div>
    </div>

    <!-- More Dashboard Content -->
    <div class="row mt-4">
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
