    function getTime(input) {
        const file = input.files[0];
        if (!file) return;

        const audio = new Audio(URL.createObjectURL(file));
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
        const file = input.files[0];
        const preview = $('#'+pre);

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.attr('src', e.target.result);
            };

            reader.readAsDataURL(file);
            preview.removeClass('d-none');
        } else {
            preview.attr('src', '').addClass('d-none');
        }
    }

    