<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>

</head>

<body>

    <form action="api/playlist-user/1/add-song" method="post">
        @csrf
        <label for="">tên playlist</label>
        <input type="text" name="song_id" id="text">

        <!-- <input type="text" name="new-password" id="text"> -->
        <button id="" type="submit" >lưu</button>
    </form>

</body>

</html>
