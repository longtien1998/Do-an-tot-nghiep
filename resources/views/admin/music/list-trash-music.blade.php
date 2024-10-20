@extends('admin.layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Danh sách bài hát đã xóa</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('dashboard')}}" class="text-decoration-none">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Bài hát</li>

                        <li class="breadcrumb-item active" aria-current="page">Danh sách bài hát đã xóa</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<style>
    th,
    td {
        vertical-align: middle;
    }

    .sort-icon {
        font-size: 12px;
        margin-left: 5px;
        cursor: pointer;
    }

    .sorted-asc::after {
        content: ' ▲';
    }

    .sorted-desc::after {
        content: ' ▼';
    }
</style>
<div class="container-fluid">
    <div class="form-group row justify-content-between m-0 p-0">
        <div class="col-sm-6 my-3">
            <a href="{{route('list-music')}}" class="btn btn-outline-success"> Trở về trước</a>
        </div>
        <div class="col-sm-3 my-3">
            <form class="search-form" action="{{route('search-song-trash')}}" method="post">
                @csrf
                <input type="text" name="search" placeholder="Tên bài hát..." required />
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
    </div>
    <table class="table text-center" id="myTable">
        <div class="col-sm-6 my-3">
            <form action="{{route('list-restore-songs')}}" class="d-inline" method="post" id="form-restore">
                @csrf
                <input type="text" value="" name="restore_list" id="valuearray" hidden>
                <button type="submit" class="btn btn-success" onclick="return confirm('Xác nhận khôi phục bài hát đã chọn?')">Khôi phục bài hát</button>
            </form>
            <form action="{{route('list-delete-songs')}}" class="d-inline" method="post" id="form-delete">
                @csrf
                <input type="text" value="" name="delete_list" id="valuearray1" class="delete_list" hidden>
                <button type="submit" class="btn btn-warning" onclick="return confirm('Xác nhận xóa bài hát đã chọn?')">Xóa bài hát</button>
            </form>
            <a href="{{route('restore-all-songs')}}" class="btn btn-primary" onclick="return confirm('Xác nhận khôi phục tất cả?')">Khôi phục tất cả bài hát</a>
            <a href="{{route('delete-all-songs')}}" class="btn btn-danger" onclick="return confirm('Xác nhận xóa tất cả?')">Xóa tất cả bài hát</a>

        </div>
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="check_all_songs" class=""></th>
                <th scope="col">STT</th>
                <th scope="col" onclick="sortTable(2)">ID <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(3)">Tên bài hát <span class="sort-icon">⬍</span></th>
                <th scope="col">Mô tả</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col" onclick="sortTable(6)">Thể loại <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(7)">Ca sỹ <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(8)">Ngày phát hành <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(9)">Lượt nghe <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(10)">Lượt tải <span class="sort-icon">⬍</span></th>
                <th scope="col" onclick="sortTable(11)">Ngày tạo <span class="sort-icon">⬍</span></th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @php $stt = 1; @endphp
            @foreach($songs as $song)
            <tr>
                <td><input type="checkbox" class="check_song" value="{{$song->id}}"></td>
                <th scope="row">{{$stt}}</th>
                <td>{{$song->id}}</td>
                <td>{{$song->song_name}}</td>
                <td>{{$song->description}}</td>
                <td><img src="{{$song->song_image}}" alt="image {{$song->song_name}}" width="50"></td>
                <td>{{$song->category_name}}</td>
                <td></td>
                <td>{{$song->release_date}}</td>
                <td>{{$song->listen_count}}</td>
                <td>{{$song->download_count}}</td>
                <td>{{$song->created_at}}</td>

                <td>
                    <a href="{{route('show-music',$song->id)}}" class="btn btn-link btn-outline-success"> <i class="fa-solid fa-eye"></i></a>

                    <a href="{{route('destroy-trash-songs',$song->id)}}" data-bs-toggle="tooltip" title="" class="btn btn-link btn-outline-danger" data-original-title="Remove" onclick="return confirm('Xác nhận xóa bài hát?')">
                        <i class="fa-solid fa-trash"></i>
                    </a>

                </td>
            </tr>
            @php $stt++; @endphp
            @endforeach
        </tbody>
    </table>

</div>

@endsection
@section('js')
<script>
    // check list
    document.getElementById('check_all_songs').addEventListener('click', function() {
        var checkboxes = document.getElementsByClassName('check_song');

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
        getCheckedValues()

    });

    // Hàm lấy giá trị của tất cả các checkbox đã được chọn
    function getCheckedValues() {
        var checkboxes = document.getElementsByClassName('check_song');
        var checkedValues = [];

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                checkedValues.push(checkboxes[i].value); // Thêm value của checkbox đã được chọn
            }
        }

        document.getElementById('valuearray').value = JSON.stringify(checkedValues);
        document.getElementById('valuearray1').value = JSON.stringify(checkedValues);

        return checkedValues; // Trả về mảng nếu cần sử dụng sau này
    }

    // Gán sự kiện 'click' cho từng checkbox
    var checkboxes = document.getElementsByClassName('check_song');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('click', getCheckedValues);
    }

    // sắp xếp tăng giảm từng column
    let sortOrder = {}; // Lưu trạng thái sắp xếp cho từng cột

    function sortTable(columnIndex) {
        const table = document.getElementById("myTable");
        const tbody = table.querySelector("tbody");
        const rows = Array.from(tbody.rows);

        // Kiểm tra trạng thái sắp xếp và đảo ngược nếu cần
        const isAscending = !sortOrder[columnIndex];
        sortOrder[columnIndex] = isAscending;

        // Sắp xếp các hàng dựa trên giá trị của cột được chọn (bỏ qua STT)
        rows.sort((a, b) => {
            const cellA = a.cells[columnIndex].innerText.toLowerCase();
            const cellB = b.cells[columnIndex].innerText.toLowerCase();

            if (!isNaN(cellA) && !isNaN(cellB)) {
                return isAscending ? cellA - cellB : cellB - cellA; // Sắp xếp số
            } else {
                return isAscending ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA); // Sắp xếp chuỗi
            }
        });

        // Xóa các hàng hiện tại và thêm lại theo thứ tự đã sắp xếp
        tbody.innerHTML = "";
        rows.forEach(row => tbody.appendChild(row));

        // Cập nhật lại STT sau khi sắp xếp
        updateSTT();
        updateIcons(columnIndex, isAscending);
    }

    function updateSTT() {
        const tbody = document.querySelector("#myTable tbody");
        const rows = tbody.rows;

        // Cập nhật STT cho từng hàng
        for (let i = 0; i < rows.length; i++) {
            rows[i].cells[1].innerText = i + 1; // Cột STT (index 1)
        }
    }

    function updateIcons(columnIndex, isAscending) {
        const headers = document.querySelectorAll("th");
        headers.forEach((header, index) => {
            header.classList.remove("sorted-asc", "sorted-desc");
            if (index === columnIndex) {
                header.classList.add(isAscending ? "sorted-asc" : "sorted-desc");
            }
        });
    }


    function checkcheckbox() {
        const checkboxes = document.getElementsByClassName('check_song');
        let hasChecked = false;

        // Kiểm tra xem ít nhất 1 checkbox đã được chọn chưa
        for (let i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                hasChecked = true;
                break;
            }
        }
        return hasChecked;
    }


    document.getElementById('form-delete').addEventListener('submit', function(e) {
        // Nếu không có checkbox nào được chọn, ngăn submit và hiển thị cảnh báo
        if (!checkcheckbox()) {
            e.preventDefault(); // Ngăn submit
            alert('Vui lòng chọn ít nhất 1 bài hát!');
        }
    });
    document.getElementById('form-restore').addEventListener('submit', function(e) {

        // Nếu không có checkbox nào được chọn, ngăn submit và hiển thị cảnh báo
        if (!checkcheckbox()) {
            e.preventDefault(); // Ngăn submit
            alert('Vui lòng chọn ít nhất 1 bài hát!');
        }
    });
</script>
@endsection
