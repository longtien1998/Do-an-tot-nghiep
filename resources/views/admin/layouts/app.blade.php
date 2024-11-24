<!DOCTYPE html5>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="icon" href="{{asset('favicon.ico')}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin SoundWave - Sidebar Dark</title>
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
        // Xử lý khi quay lại trang từ trình duyệt
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) { // Kiểm tra nếu trang được tải lại từ cache
                document.getElementById('preloader').style.display = 'none';
            }
        });
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{asset('admin/css/font-awesome.css')}}"> -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{asset('admin/css/style.css')}}">

    <link rel="stylesheet" href="{{asset('vendor/flasher/flasher.min.css')}}">
    <script type="text/javascript" src="{{ asset('vendor/flasher/flasher.min.js') }}"></script>


    <!-- Thêm Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">



</head>

<body>

    <div id="preloader">
        <div class="spinner"></div>
    </div>
    @include('admin.layouts.header')
    @include('admin.layouts.left-sidebar')
    <div id="main-content" class="mb-5">
        @yield('content')
    </div>

    <!-- Footer -->
    <div id="footer">
        &copy; 2024 SoundWave Admin Dashboard
    </div>
    <script>
        function confirmDelete() {
            if (confirm('Bạn có chắc chắn muốn xóa?')) {
                return true;
            } else {
                return false;
            }
        }
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/flasher/flasher.min.js') }}"></script>
    <!-- Thêm Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{asset('admin/js/app.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/js/notifi.js')}}"></script>

    @yield('js')

</body>

</html>
