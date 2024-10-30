<!-- Sidebar -->
<div id="sidebar">
    <div class="name-sidebar">
        <a class="nav-item row text-center m-0 p-0" href="{{route('dashboard')}}">
            <i style="padding: 0px; margin: 0px;"><img src="{{asset('logo.png')}}" alt="" width="50"></i>
            <span style="font-size: 25px;">SoundWave</span>
        </a>
    </div>
    <nav class="nav flex-column " id="accordionFlushExample">
        <a class="nav-item" href="{{route('dashboard')}}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a class="nav-item collapsed" data-bs-toggle="collapse" data-bs-target="#ql-songs" aria-controls="ql-songs">
            <i class="fa-solid fa-music"></i>
            <span>Bài hát <i class="fa fa-caret-down float-end "></i></span>
        </a>
        <div class="accordion-collapse collapse" id="ql-songs" data-bs-parent="#accordionFlushExample">
            <ol class="nav-collapse">
                <li>
                    <a href="{{route('add-music')}}" class="nav-item">
                    <i class="fa-solid fa-circle-plus"></i>
                        <span class="">Thêm bài hát</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('list-music')}}" class="nav-item">
                    <i class="fa-solid fa-list"></i>
                        <span class="">Danh sách bài hát</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('list-trash-music')}}" class="nav-item">
                    <i class="fa-solid fa-trash"></i>
                        <span class="">Bài hát đã xóa</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('s3songs.index')}}" class="nav-item">
                    <i class="fa-solid fa-file"></i>
                        <span class="">File bài hát</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('s3images.index')}}" class="nav-item">
                    <i class="fa-solid fa-image"></i>
                        <span class="">Hình bài hát</span>
                    </a>
                </li>
            </ol>
        </div>
        <a class="nav-item collapsed" data-bs-toggle="collapse" data-bs-target="#ql-qg" aria-controls="ql-qg">
            <i class="fa-solid fa-music"></i>
            <span>Thể loại Quốc gia<i class="fa fa-caret-down float-end "></i></span>

        </a>
        <div class="accordion-collapse collapse" id="ql-qg" data-bs-parent="#accordionFlushExample">
            <ol class="nav-collapse">
                <li>
                    <a href="{{route('list-country')}}" class="nav-item">
                    <i class="fa-solid fa-list"></i>
                        <span class="">Danh sách quốc gia</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('list_trash_country')}}" class="nav-item">
                    <i class="fa-solid fa-trash"></i>
                        <span class="">Quốc gia đã xóa</span>
                    </a>
                </li>
            </ol>
        </div>
        <a class="nav-item collapsed" data-bs-toggle="collapse" data-bs-target="#ql-tl" aria-controls="ql-tl">
            <i class="fa-sharp-duotone fa-solid fa-layer-group"></i>
            <span>Thể loại bài hát <i class="fa fa-caret-down float-end "></i></span>
        </a>
        <div class="accordion-collapse collapse" id="ql-tl" data-bs-parent="#accordionFlushExample">
            <ol class="nav-collapse">
                <li>
                    <a href="{{route('categories.add')}}" class="nav-item">
                    <i class="fa-solid fa-circle-plus"></i>
                        <span class="">Thêm Thể loại</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('categories.list')}}" class="nav-item">
                    <i class="fa-solid fa-list"></i>
                        <span class="">Danh sách Thể loại</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('categories.trash.list')}}" class="nav-item">
                    <i class="fa-solid fa-trash"></i>
                        <span class="">Thể loại đã xóa</span>
                    </a>
                </li>
            </ol>
        </div>
        <a class="nav-item" href="{{route('list-singer')}}">
            <i class="fa-solid fa-microphone"></i>
            <span>Ca sĩ</span>
        </a>
        <a class="nav-item" href="{{route('list-album')}}">
            <i class="fa-solid fa-compact-disc"></i>
            <span>Album</span>
        </a>
        <a class="nav-item" href="{{route('list-copyright')}}">
            <i class="fa-solid fa-copyright"></i>
            <span>Bản quyền</span>
        </a>
        <a class="nav-item" href="{{route('list-publishers')}}">
            <i class="fa-solid fa-industry"></i>
            <span>Nhà xuất bản</span>
        </a>
        <a class="nav-item collapsed" data-bs-toggle="collapse" data-bs-target="#ql-ads" aria-controls="ql-ads">
            <i class="fa-solid fa-rectangle-ad"></i>
            <span>Quảng cáo <i class="fa fa-caret-down float-end "></i></span>
        </a>
        <div class="accordion-collapse collapse" id="ql-ads" data-bs-parent="#accordionFlushExample">
            <ol class="nav-collapse">
                <li>
                    <a href="{{route('list-advertisements')}}" class="nav-item">
                    <i class="fa-solid fa-list"></i>
                        <span class="">Danh sách quảng cáo</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('list_trash_ads')}}" class="nav-item">
                        <span class="">Quảng cáo đã xóa</span>
                    </a>
                </li>
            </ol>
        </div>
        <a class="nav-item" href="{{route('list-users')}}">
            <i class="fa-solid fa-users"></i>
            <span>Người dùng</span>
        </a>
        <a class="nav-item" href="{{route('list-comments')}}">
            <i class="fa-solid fa-comment"></i>
            <span>Bình luận</span>
        </a>
        <a class="nav-item dropdown-toggle" href="#ql-image" data-bs-toggle="collapse" onclick="closed('ql-image')">
            <i class="fa-solid fa-image"></i>
            <span>Hình ảnh</span>
        </a>
        <div class="collapse" id="ql-image">
            <ol class="nav-collapse">

                <li>
                    <a href="" class="nav-item">
                        <span class="">Hình Tài khoản</span>
                    </a>
                </li>
                <li>
                    <a href="" class="nav-item">
                        <span class="">Hình ca sĩ</span>
                    </a>
                </li>
            </ol>
        </div>
        <a class="nav-item dropdown-toggle" href="#ql-file-songs" data-bs-toggle="collapse">
            <i class="fa-solid fa-file"></i>
            <span>File nhạc</span>
        </a>
        <div class="collapse" id="ql-file-songs">
            <ol class="nav-collapse">

                <li>
                    <a href="" class="nav-item">
                        <span class="">File quảng cáo</span>
                    </a>
                </li>
                <li>
                    <a href="" class="nav-item">
                        <span class="">file demo</span>
                    </a>
                </li>
            </ol>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="route('logout')" class="nav-item dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span class="float-start">Đăng xuất</span>
            </a>
        </form>
    </nav>
</div>
