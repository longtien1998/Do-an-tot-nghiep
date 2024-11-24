    function getTime(input) {
        const file = input.files[0];
        if (!file) return;

        const audio = new Audio(URL.createObjectURL(file)); // Tạo đối tượng Audio
        $(audio).on('loadedmetadata', function () {
            const duration = audio.duration; // Thời lượng tính bằng giây
            $('#time_song').val(formatTime(duration));
        });
    }

     // Hàm định dạng thời gian (mm:ss)
     function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60).toString().padStart(2, '0'); // Luôn có 2 chữ số
        const remainingSeconds = Math.floor(seconds % 60).toString().padStart(2, '0'); // Luôn có 2 chữ số
        return `${minutes}:${remainingSeconds}`;
    }

