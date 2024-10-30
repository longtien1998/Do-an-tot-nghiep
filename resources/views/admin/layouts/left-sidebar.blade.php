<!-- Sidebar -->
<div id="sidebar">
    <div class="name-sidebar">
        <a class="nav-link row text-center m-0 p-0" href="{{route('dashboard')}}">
            <i style="padding: 0px; margin: 0px;"><img src="{{asset('logo.png')}}" alt="" width="50"></i>
            <span style="font-size: 25px;">SoundWave</span>
        </a>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link" href="{{route('dashboard')}}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a class="nav-link " href="#ql-songs" data-bs-toggle="collapse" data-bs-target="#ql-songs">
            <i class="fa-solid fa-music"></i>
            <span>Bài hát <i class="fa fa-caret-down float-end "></i></span>

        </a>
        <div class="collapse" id="ql-songs">
            <ol class="nav-collapse">
                <li>
                    <a href="{{route('list-music')}}" class="nav-link">
                        <span class="">Danh sách bài hát</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('list-country')}}" class="nav-link">
                        <span class="">Danh sách quốc gia</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('list-trash-music')}}" class="nav-link">
                        <span class="">Bài hát đã xóa</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('s3songs.index')}}" class="nav-link">
                        <span class="">File bài hát</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('s3images.index')}}" class="nav-link">
                        <span class="">Hình bài hát</span>
                    </a>
                </li>
            </ol>
        </div>
        <a class="nav-link" href="{{route('list-categories')}}">
            <i class="fa-sharp-duotone fa-solid fa-layer-group"></i>
            <span>Thể loại</span>
        </a>
        <a class="nav-link" href="{{route('list-singer')}}">
            <i class="fa-solid fa-microphone"></i>
            <span>Ca sĩ</span>
        </a>
        <a class="nav-link" href="{{route('list-album')}}">
            <i class="fa-solid fa-compact-disc"></i>
            <span>Album</span>
        </a>
        <a class="nav-link" href="{{route('list-copyright')}}">
            <i class="fa-solid fa-copyright"></i>
            <span>Bản quyền</span>
        </a>
        <a class="nav-link" href="{{route('list-publishers')}}">
            <i class="fa-solid fa-industry"></i>
            <span>Nhà xuất bản</span>
        </a>
        <a class="nav-link dropdown-toggle" href="#ql-ads" data-bs-toggle="collapse">
            <i class="fa-solid fa-rectangle-ad"></i>
            <span>Quảng cáo</span>
        </a>
        <div class="collapse" id="ql-ads">
            <ol class="nav-collapse">
                <li>
                    <a href="{{route('list-advertisements')}}" class="nav-link">
                        <span class="">Danh sách quảng cáo</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('list_trash_ads')}}" class="nav-link">
                        <span class="">Quảng cáo đã xóa</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('s3ads.index')}}" class="nav-link">
                        <span class="">File quảng cáo</span>
                    </a>
                </li>
            </ol>
        </div>
        <a class="nav-link dropdown-toggle" href="#ql-user" data-bs-toggle="collapse">
            <i class="fa-solid fa-users"></i>
            <span>Người dùng</span>
        </a>
        <div class="collapse" id="ql-user">
            <ol class="nav-collapse">
                <li>
                    <a href="{{route('list-users')}}" class="nav-link">
                        <span class="">Danh sách người dùng</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('list_trash_users')}}" class="nav-link">
                        <span class="">Người dùng đã xóa</span>
                    </a>
                </li>

            </ol>
        </div>
        <a class="nav-link dropdown-toggle" href="#ql-cmt" data-bs-toggle="collapse">
            <i class="fa-solid fa-comment"></i>
            <span>Bình luận</span>
        </a>
        <div class="collapse" id="ql-cmt">
            <ol class="nav-collapse">
                <li>
                    <a href="{{route('list-comments')}}" class="nav-link">
                        <span class="">Danh sách bình luận</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('list_trash_comments')}}" class="nav-link">
                        <span class="">Bình luận đã xóa</span>
                    </a>
                </li>

            </ol>
        </div>
        <a class="nav-link dropdown-toggle" href="#ql-image" data-bs-toggle="collapse" onclick="closed('ql-image')">
            <i class="fa-solid fa-image"></i>
            <span>Hình ảnh</span>
        </a>
        <div class="collapse" id="ql-image">
            <ol class="nav-collapse">

                <li>
                    <a href="" class="nav-link">
                        <span class="">Hình Tài khoản</span>
                    </a>
                </li>
                <li>
                    <a href="" class="nav-link">
                        <span class="">Hình ca sĩ</span>
                    </a>
                </li>
            </ol>
        </div>
        <a class="nav-link dropdown-toggle" href="#ql-file-songs" data-bs-toggle="collapse">
            <i class="fa-solid fa-file"></i>
            <span>File nhạc</span>
        </a>
        <div class="collapse" id="ql-file-songs">
            <ol class="nav-collapse">

                <li>
                    <a href="" class="nav-link">
                        <span class="">File quảng cáo</span>
                    </a>
                </li>
                <li>
                    <a href="" class="nav-link">
                        <span class="">file demo</span>
                    </a>
                </li>
            </ol>
        </div>

        <a class="nav-link" href="#">
            <i class="fas fa-sign-out-alt"></i>
            <span>Đăng xuất</span>
        </a>
    </nav>
</div>
