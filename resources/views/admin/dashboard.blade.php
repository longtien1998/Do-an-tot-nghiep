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
            <div class="dashboard-card" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
                <i class="fas fa-dollar-sign"></i>
                <span>Thu nhập</span>
                <p class="card-value">58,300 VND</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card" style="background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%);">
                <i class="fa-solid fa-comment"></i>
                <span>Bình luận</span>
                <p class="card-value">{{$total_comment}}</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card" style="background: linear-gradient(135deg, #ff9a8b 0%, #ff6a88 100%);">
                <i class='bx bxs-album'></i>
                <span>Album</span>
                <p class="card-value">510</p>
            </div>
        </div>
        <div class="col">
            <div class="dashboard-card" style="background: linear-gradient(135deg, #b2fefa 0%, #0ed2f7 100%);">
                <i class='bx bx-building-house'></i>
                <span>Nhà xuất bản</span>
                <p class="card-value">{{$total_publishers}}</p>
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

@section('js')
<!-- <script src="path/to/chartjs/dist/chart.umd.js"></script> -->
<script>
    let mixedChart;
    let userChart;
    let payChart;
    const token = $('meta[name="csrf-token"]').attr('content');
    chart(10);
    chartUser(10);
    chartPay(10);
    $(document).ready(function() {
        // Gọi chung cho các select
        const selectors = ['#selectDate', '#selectDateUser', '#selectDatePay'];

        selectors.forEach(selector => {
            $(selector).on('change', function() {
                const date = $(this).val(); // Lấy giá trị của select

                // Gọi hàm tương ứng
                switch (this.id) {
                    case 'selectDate':
                        chart(date);
                        break;
                    case 'selectDateUser':
                        chartUser(date);
                        break;
                    case 'selectDatePay':
                        chartPay(date);
                        break;
                }
            });
        });
    });


    function chart(date) {

        let labels = null;
        let playsData = null;
        let likesData = [];
        let downloadsData = [];
        console.log(date);
        $.ajax({
            url: urlAjax + 'getData/' + date,
            method: "get",
            headers: {
                'Content-Type': 'application/json',
                Authorization: `Bearer ${token}`,
                
            },


            success: function(data) {
                // console.log(data);
                labels = data.labels;
                playsData = data.listen_count.map(Number);
                likesData = data.download_count.map(Number);
                downloadsData = data.like_count.map(Number);

                if (mixedChart) {
                    mixedChart.destroy();
                }
                // console.log(playsData);
                const ctx = document.getElementById('mixedChart').getContext('2d');
                mixedChart = new Chart(ctx, {
                    type: 'bar', // Loại biểu đồ chính
                    data: {
                        labels: labels, // Ngày
                        datasets: [{
                                label: 'Lượt nghe',
                                type: 'bar',
                                data: playsData,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)', // Màu cột
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Lượt thích',
                                data: likesData,
                                backgroundColor: 'rgba(255, 99, 132, 0.5)', // Màu cột
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Lượt tải xuống',
                                data: downloadsData,
                                backgroundColor: 'rgba(75, 192, 192, 0.5)', // Màu cột
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top', // Vị trí chú thích
                            },
                            title: {
                                display: true,
                                text: 'Thống kê lượt nghe, lượt thích và lượt tải',
                                font: {
                                    size: 20
                                }
                            }
                        },
                        scales: {
                            x: {
                                stacked: false // Hiển thị các cột chồng nhau
                            },
                            y: {
                                beginAtZero: true // Bắt đầu từ 0
                            }
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }



    function chartUser(date) {

        let labels = null;
        let createData = [];
        console.log(date);
        $.ajax({
            url: urlAjax + 'getUser/' + date,
            method: "get",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },


            success: function(data) {
                // console.log(data);
                labels = data.labels;
                createData = data.create_count.map(Number);

                if (userChart) {
                    userChart.destroy();
                }
                // console.log(playsData);
                const ctx = document.getElementById('userChart').getContext('2d');
                userChart = new Chart(ctx, {
                    type: 'bar', // Loại biểu đồ chính
                    data: {
                        labels: labels, // Ngày
                        datasets: [{
                            label: 'Lượt tạo tài khoản',
                            type: 'bar',
                            data: createData,
                            backgroundColor: 'rgba(153, 102, 255, 0.5)', // Màu cột
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        }, ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top', // Vị trí chú thích
                            },
                            title: {
                                display: true,
                                text: 'Thống kê tạo tài khoản',
                                font: {
                                    size: 20
                                }
                            }
                        },
                        scales: {
                            x: {
                                stacked: false // Hiển thị các cột chồng nhau
                            },
                            y: {
                                beginAtZero: true // Bắt đầu từ 0
                            }
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }

    function chartPay(date) {

        let labels = null;
        let amount = [];
        console.log(date);
        $.ajax({
            url: urlAjax + 'getPay/' + date,
            method: "get",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },


            success: function(data) {
                // console.log(data);
                labels = data.labels;
                amount = data.amount.map(Number);

                if (payChart) {
                    payChart.destroy();
                }
                // console.log(playsData);
                const ctx = document.getElementById('payChart').getContext('2d');
                payChart = new Chart(ctx, {
                    type: 'bar', // Loại biểu đồ chính
                    data: {
                        labels: labels, // Ngày
                        datasets: [{
                            label: 'Tổng tiền thanh toán',
                            type: 'bar',
                            data: amount,
                            backgroundColor: 'rgba(255, 206, 86, 0.5)', // Màu cột
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        }, ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top', // Vị trí chú thích
                            },
                            title: {
                                display: true,
                                text: 'Thống kê thanh toán',
                                font: {
                                    size: 20
                                }
                            }
                        },
                        scales: {
                            x: {
                                stacked: false // Hiển thị các cột chồng nhau
                            },
                            y: {
                                beginAtZero: true // Bắt đầu từ 0
                            }
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
</script>
@endsection

