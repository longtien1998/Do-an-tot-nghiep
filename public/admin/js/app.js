/// check list

window.onload = function () {
    document.querySelector('#check_all_songs').addEventListener('click', function () {
        var checkboxes = document.getElementsByClassName('check_song');

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }

        getCheckedValues()

    });
};
// Hàm lấy giá trị của tất cả các checkbox đã được chọn
function getCheckedValues() {
    var checkboxes = document.getElementsByClassName('check_song');
    var checkedValues = [];
    let total = 0;
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checkedValues.push(checkboxes[i].value); // Thêm value của checkbox đã được chọn
            total += 1;
        }
    }

    document.getElementById('songs-restore') ? document.getElementById('songs-restore').value = JSON.stringify(checkedValues) : undefined;
    document.getElementById('songs-delete') ? document.getElementById('songs-delete').value = JSON.stringify(checkedValues) : undefined;
    document.getElementById('total-songs').innerText = total;
    // console.log(document.getElementById('songs-delete').value);
    return checkedValues; // Trả về mảng nếu cần sử dụng sau này
}

// Gán sự kiện 'click' cho từng checkbox






function checkcheckbox(className) {
    const checkboxes = document.getElementsByClassName(className);
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


function submitForm(e, className) {
    console.log(document.getElementById('delete_list').value);
    // Kiểm tra xem có ít nhất 1 checkbox đã được chọn chưa
    if (!checkcheckbox(className)) {
        e.preventDefault();
        alert('Vui lòng chọn ít nhất 1 bài hát!');
        return false;
    } else {
        return true;
    }

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
