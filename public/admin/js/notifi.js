// thông báo
// thông báo
$(document).ready(function () {
    function getNotifications() {
        $.ajax({
            url: urlAjax + 'notification-count',
            method: "GET",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {

                if (response.count > 0) {
                    $('#notifi-count').text(response.count);
                } else {
                    $('#notifi-span').hide();
                }
                console.log(response.notifications);
                // Duyệt qua mảng thông báo và tạo các <li> mới
                var notificationsList = response.notifications;
                var dropdownMenu = $("#notification .dropdown-menu");

                // Xóa các phần tử <li> cũ trước khi thêm thông báo mới
                dropdownMenu.find(".notification-item").remove();

                // Duyệt qua mỗi phần tử trong mảng notifications và thêm vào dropdown
                notificationsList.forEach(function (notification) {
                    var notificationItem = `
                <li class="li p-0">
                    <a class="notification-item py-4" href="#">${notification.icon} ${notification.message}</a>
                </li>
            `;
                    dropdownMenu.append(notificationItem);
                });
            },
            error: function (xhr, status, error) {
                console.error("Error: " + error); // Thêm xử lý lỗi nếu cần
            }
        });
    }
    // getNotifications();
    setInterval(getNotifications, 100000);
});
