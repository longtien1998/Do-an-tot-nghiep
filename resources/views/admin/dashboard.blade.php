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
        <div class="row g-4">
            <div class="col-md-4">
                <div class="dashboard-card">
                    <i class="fas fa-users"></i>
                    <h5>Total Users</h5>
                    <p class="card-value">1,245</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-card">
                    <i class="fas fa-dollar-sign"></i>
                    <h5>Total Sales</h5>
                    <p class="card-value">$58,300</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-card">
                    <i class="fas fa-box"></i>
                    <h5>Active Subscriptions</h5>
                    <p class="card-value">320</p>
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
