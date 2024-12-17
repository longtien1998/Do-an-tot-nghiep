@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Thống kê thu nhập</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Thống kê</li>
                        <li class="breadcrumb-item active" aria-current="page">Thống kê thu nhập</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="modal fade" id="chartModal" tabindex="-1" aria-labelledby="chartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chartModalLabel">Thông tin chi tiết</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped text-center w-100" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Mã thanh toán</th>
                                <th scope="col">Mô tả</th>
                                <th scope="col">Ngày thanh toán</th>
                                <th scope="col">Phương thức thanh toán</th>
                                <th scope="col">Số tiền thanh toán</th>
                                <th scope="col">Tài khoản thanh toán</th>
                            </tr>
                        </thead>
                        <tbody id="myTableBody">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <div style="width: 100%; margin: auto;" class="border p-3 mt-3">
        <div class="row">
            <div class="col-6 col-sm-2">
                <label for="">Chọn Ngày</label>
                <select name="selectDate" id="selectDatePay" class="form-select mt-2" ">
                    <option value=" 10">10 ngày trước</option>
                    <option value="20">20 ngày trước</option>
                    <option value="30">30 ngày trước</option>
                    <option value="60">2 tháng trước</option>
                    <option value="90">3 tháng trước</option>
                    <option value="180">6 tháng trước</option>
                    <option value="365">1 năm trước</option>
                </select>

            </div>
            <div class="col-6 col-sm-2" style="margin-top: 35;">
                <a href="{{route('exportExcel')}}" class="btn btn-success"><i class="fa-regular fa-file"></i> Xuất file</a>
            </div>

        </div>
        <canvas id="payChart" style="max-height: 500px;"></canvas>
    </div>
</div>
@endsection

@section('js')
<script>
    let payChart;

    chartPay(10);
    $(document).ready(function() {
        $('.btn-success').on('click', function(event) {
            event.preventDefault();
            let url = $(this).attr('href');
            window.location.href = url;
            setTimeout(function() {
                window.location.href = "{{ route('statisticalpay.index') }}";
            }, 1000);
            alert("Xuất file thành công!");
        });
    });


    function chartPay(date) {
        let labels = null;
        let amount = [];
        let urlAjax = "{{ route('statisticalpay.getPay', ['date' => 'DATE']) }}";
        urlAjax = urlAjax.replace('DATE', date);

        $.ajax({
            url: urlAjax,
            method: "get",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                labels = data.labels;
                amount = data.amount.map(Number);

                if (payChart) {
                    payChart.destroy();
                }

                const ctx = document.getElementById('payChart').getContext('2d');
                payChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Tổng tiền thanh toán (VNĐ)',
                            type: 'bar',
                            data: amount,
                            backgroundColor: 'rgba(255, 206, 86, 0.5)',
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
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
                                stacked: false
                            },
                            y: {
                                beginAtZero: true
                            }
                        },
                        onClick: function(evt, elements) {
                            if (elements.length > 0) {
                                const index = elements[0].index;
                                const selectedDate = labels[index]; // Ngày được click
                                fetchDataByDate(selectedDate);
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

    function fetchDataByDate(date) {
        const url = "{{ route('statisticalpay.getPayByDate') }}";

        $.ajax({
            url: url,
            method: "POST",
            data: {
                date: date,
                _token: $('meta[name="csrf-token"]').attr('content') // CSRF token để bảo mật
            },
            success: function(data) {
                // Kiểm tra dữ liệu trả về
                if (data.pays.length === 0) {
                    alert("Không có dữ liệu cho ngày được chọn!");
                    return;
                }

                // Xóa dữ liệu cũ
                $('#myTableBody').empty();

                // Thêm dữ liệu mới vào bảng
                data.pays.forEach((pay, index) => {
                    $('#myTableBody').append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${pay.pay_id}</td>
                        <td>${pay.description || ''}</td>
                        <td>${pay.payment_date || ''}</td>
                        <td>${pay.payment_method || ''}</td>
                        <td>${pay.amount ? Math.floor(pay.amount) : ''} VNĐ</td>
                        <td>${pay.name || ''}</td>
                    </tr>
                `);
                });

                // Hiển thị Modal
                $('#chartModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>
@endsection
