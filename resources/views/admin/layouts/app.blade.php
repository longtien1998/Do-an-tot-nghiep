<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="icon"  href="{{asset('favicon.ico')}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin SoundWave - Sidebar Dark</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{asset('admin/css/style.css')}}">

</head>

<body>


    @include('admin.layouts.header')
    @include('admin.layouts.left-sidebar')
    <div id="main-content">
        @yield('content')
    </div>

    <!-- Footer -->
    <div id="footer">
        &copy; 2024 SoundWave Admin Dashboard
    </div>
    <script>
        document.getElementById('toggle-btn').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('closed');
            document.getElementById('header').classList.toggle('closed');
            document.getElementById('main-content').classList.toggle('closed');
            document.getElementById('footer').classList.toggle('closed');
        });
        window.addEventListener('resize', function() {
            if (window.innerWidth < 986) {
                document.getElementById('sidebar').classList.add('closed');
                document.getElementById('header').classList.add('closed');
                document.getElementById('main-content').classList.add('closed');
                document.getElementById('footer').classList.add('closed');
            } else{
                document.getElementById('sidebar').classList.remove('closed');
                document.getElementById('header').classList.remove('closed');
                document.getElementById('main-content').classList.remove('closed');
                document.getElementById('footer').classList.remove('closed');
            }
        });

    </script>
    <script>
        function confirmDelete() {
            if (confirm('Bạn có chắc chắn muốn xóa?')) {
                return true;
            } else {
                return false;
            }
        }
    </script>
    @yield('js')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-4/53/wFC4owP8e98x4n9el8GriIWk5xynUMybJrVMy1CmMhmcFTFUb+Qh4mj4Kn8" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

</body>

</html>
