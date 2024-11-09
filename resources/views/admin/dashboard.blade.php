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
            <div class="dashboard-card" style="background: linear-gradient(98deg, rgba(249,246,181,1) 39%, rgba(153,255,161,1) 87%);">
                <i class="fas fa-users"></i>
                <span>Người dùng</span>
                <p class="card-value">{{$total_user}}</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card" style="background: linear-gradient(98deg, rgba(186,249,181,1) 39%, rgba(153,225,255,1) 87%);">
                <i class="fas fa-music"></i>
                <span>Bài hát</span>
                <p class="card-value">{{$total_song}}</p>
            </div>
        </div>
        <div class="col col">
            <div class="dashboard-card" style="background: linear-gradient(138deg, rgba(181,246,249,1) 32%, rgba(153,164,255,1) 87%);">
                <!-- <i class="fas fa-microphone-stand"></i> -->
                <i class='bx bxs-microphone-alt'></i>
                <span>Ca sĩ</span>
                <p class="card-value">{{$total_singer}}</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card" style="background: linear-gradient(138deg, rgba(181,202,249,1) 32%, rgba(209,153,255,1) 87%);">
                <i class="fa-solid fa-list"></i>
                <span>Thể loại</span>
                <p class="card-value">{{$total_category}}</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card" style="background: linear-gradient(169deg, rgba(218,181,249,1) 0%, rgba(255,153,155,1) 100%);">
                <i class="fas fa-box"></i>
                <span>Đơn hàng</span>
                <p class="card-value">100</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card">
                <i class="fas fa-dollar-sign"></i>
                <span>Thu nhập</span>
                <p class="card-value">58,300 VND</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card">
                <i class="fa-solid fa-comment"></i>
                <span>Bình luận</span>
                <p class="card-value">{{$total_comment}}</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card">
                <i class='bx bxs-album'></i>
                <span>Album</span>
                <p class="card-value">510</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card" >
                <i class='bx bx-building-house'></i>
                <span>Nhà xuất bản</span>
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
