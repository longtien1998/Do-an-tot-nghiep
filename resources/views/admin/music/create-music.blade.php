<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Music</title>
</head>
<body>
    <h1>Upload MP3</h1>

    <!-- Hiển thị lỗi nếu có -->
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form upload file -->
    <form action="{{ route('store-music') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="music_file" accept="audio/mp3" required>
        <button type="submit">Upload</button>
    </form>

    <!-- Hiển thị nhạc nếu có URL -->
    @if (session('music_url'))
        <h2>Nhạc đã upload:</h2>
        <audio controls>
            <source src="{{ session('music_url') }}" type="audio/mp3">
            Trình duyệt của bạn không hỗ trợ thẻ audio.
        </audio>
    @endif
</body>
</html>
