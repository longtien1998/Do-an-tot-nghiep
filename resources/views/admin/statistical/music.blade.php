@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Thống kê bài hát</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Thống kê</li>
                        <li class="breadcrumb-item active" aria-current="page">Thống kê bài hát</li>
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
                                <th scope="col">Tên bài hát</th>
                                <th scope="col">Ngày</th>
                                <th scope="col">Lượt nghe</th>
                                <th scope="col">Lượt thích</th>
                                <th scope="col">Lượt tải xuống</th>
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
                <select name="selectDate" id="selectDate" class="form-select mt-2">
                    <option value="10">10 ngày trước</option>
                    <option value="20">20 ngày trước</option>
                    <option value="30">30 ngày trước</option>
                    <option value="60">2 tháng trước</option>
                    <option value="90">3 tháng trước</option>
                    <option value="180">6 tháng trước</option>
                    <option value="365">1 năm trước</option>
                </select>
            </div>
            <div class="col-6 col-sm-2" style="margin-top: 35;">
                <a href="{{route('exportExcelMusic')}}" class="btn btn-success"><i class="fa-regular fa-file"></i> Xuất file</a>
            </div>
        </div>
        <canvas id="mixedChart" style="max-height: 500px;"></canvas>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        let mixedChart;
        $(document).ready(function() {
            $('.btn-success').on('click', function(event) {
                event.preventDefault();
                let url = $(this).attr('href');
                window.location.href = url;
                setTimeout(function() {
                    window.location.href = "{{ route('statisticalmusic.index') }}";
                }, 1000);
                alert("Xuất file thành công!");
            });
        });

        function chart(date) {
            let labels = null;
            let playsData = null;
            let likesData = [];
            let downloadsData = [];

            let urlAjax = "{{ route('statisticalmusic.getData', ['date' => 'DATE']) }}";
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
                    playsData = data.listen_count.map(Number).filter(value => value > 0);
                    likesData = data.like_count.map(Number).filter(value => value > 0);
                    downloadsData = data.download_count.map(Number).filter(value => value > 0);

                    if (mixedChart) {
                        mixedChart.destroy();
                    }

                    const ctx = document.getElementById('mixedChart').getContext('2d');
                    mixedChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'Lượt nghe',
                                    data: playsData,
                                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Lượt thích',
                                    data: likesData,
                                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Lượt tải xuống',
                                    data: downloadsData,
                                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top'
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
                                    stacked: false
                                },
                                y: {
                                    beginAtZero: true
                                }
                            },
                            onClick: (event, elements) => {
                                if (elements.length > 0) {
                                    const elementIndex = elements[0].index;
                                    const label = labels[elementIndex]; // Lấy ngày được chọn

                                    // Lấy tên cột được chọn
                                    const clickedDatasetIndex = elements[0].datasetIndex;
                                    let datasetLabel = '';
                                    let tableColumns = [];

                                    // xác định cột được click
                                    switch (clickedDatasetIndex) {
                                        case 0:
                                            datasetLabel = 'Lượt nghe';
                                            tableColumns = ['Lượt nghe'];
                                            break;
                                        case 1:
                                            datasetLabel = 'Lượt thích';
                                            tableColumns = ['Lượt thích'];
                                            break;
                                        case 2:
                                            datasetLabel = 'Lượt tải xuống';
                                            tableColumns = ['Lượt tải xuống'];
                                            break;
                                        default:
                                            datasetLabel = 'Lỗi';
                                            tableColumns = [];
                                    }

                                    const url = "{{ route('statisticalmusic.getSongsByDate') }}";

                                    $.ajax({
                                        url: url,
                                        method: "POST",
                                        data: {
                                            date: label,
                                            dataset: datasetLabel,
                                            _token: $('meta[name="csrf-token"]').attr('content')
                                        },
                                        success: function(response) {
                                            const songs = response.songs;
                                            const tbody = $('#myTableBody');

                                            // bỏ dữ liệu cũ trong modal
                                            tbody.empty();

                                            if (songs.length === 0) {
                                                tbody.append(`<tr><td colspan="6">Không có dữ liệu</td></tr>`);
                                            } else {
                                                // thêm dữ liệu vô modal
                                                songs.forEach((song, index) => {
                                                    let value = 0;

                                                    // Lấy giá trị với cột đã chọn
                                                    switch (datasetLabel) {
                                                        case 'Lượt nghe':
                                                            value = song.listen_count;
                                                            break;
                                                        case 'Lượt thích':
                                                            value = song.like_count;
                                                            break;
                                                        case 'Lượt tải xuống':
                                                            value = song.download_count;
                                                            break;
                                                    }

                                                    // dữ liệu
                                                    if (value > 0) {
                                                        let rowHtml = `<tr>
                                                            <td>${index + 1}</td>
                                                            <td>${song.song_name}</td>
                                                            <td>${song.date}</td>
                                                            <td>${value}</td>
                                                        </tr>`;
                                                        tbody.append(rowHtml);
                                                    }
                                                });
                                            }

                                            // cập nhật tiêu đề cột
                                            $('#myTable thead th').each((i, th) => {
                                                if (i === 3) {
                                                    if (tableColumns.includes('Lượt nghe')) {
                                                        $(th).show();
                                                    } else {
                                                        $(th).hide();
                                                    }
                                                }
                                                if (i === 4) {
                                                    if (tableColumns.includes('Lượt thích')) {
                                                        $(th).show();
                                                    } else {
                                                        $(th).hide();
                                                    }
                                                }
                                                if (i === 5) {
                                                    if (tableColumns.includes('Lượt tải xuống')) {
                                                        $(th).show();
                                                    } else {
                                                        $(th).hide();
                                                    }
                                                }
                                            });

                                            $('#chartModal').modal('show');
                                        },
                                        error: function(xhr) {
                                            console.error(xhr.responseText);
                                        }
                                    });
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

        // chọn ngày
        chart(10);
        $('#selectDate').on('change', function() {
            const date = $(this).val();
            chart(date); //gọi hmaf vẽ lại biểu đồ khi thay đổi ngày
        });
    });
</script>
@endsection
