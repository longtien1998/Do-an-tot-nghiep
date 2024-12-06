    function getTime(input) {
        const file = input.files[0];
        if (!file) return;

        const audio = new Audio(URL.createObjectURL(file)); // Tạo đối tượng Audio
        $(audio).on('loadedmetadata', function () {
            const duration = audio.duration; // Thời lượng tính bằng giây
            $('#time_song').val(duration);
        });
    }

    //  // Hàm định dạng thời gian (mm:ss)
    //  function formatTime(seconds) {
    //     const minutes = Math.floor(seconds / 60).toString().padStart(2, '0'); // Luôn có 2 chữ số
    //     const remainingSeconds = Math.floor(seconds % 60).toString().padStart(2, '0'); // Luôn có 2 chữ số
    //     return `${minutes}:${remainingSeconds}`;
    // }
    function previewImage(input,pre) {
        const file = input.files[0]; // Lấy file đầu tiên từ input
        const preview = $('#'+pre); // Sử dụng jQuery để lấy <img>

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.attr('src', e.target.result); // Đặt src bằng kết quả đọc file
            };

            reader.readAsDataURL(file);
            preview.removeClass('d-none'); // Hiển thị ảnh preview
        } else {
            preview.attr('src', '').addClass('d-none'); // Xóa ảnh nếu không có file
        }
    }
