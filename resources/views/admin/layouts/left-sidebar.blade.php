<!-- Sidebar -->
<div id="sidebar">
    <div class="name-sidebar">
        <a class="nav-item row text-center m-0 p-0" href="{{route('dashboard')}}">
            <i style="padding: 0px; margin: 0px;"><img src="{{asset('logo.png')}}" alt="" width="50"></i>
            <span style="font-size: 25px;">SoundWave</span>
        </a>
    </div>
    <nav class="nav flex-column " id="accordionFlushExample">
        <a class="nav-item" href="https://soundwave.io.vn" target="_blank">
            <i class="fas fa-home"></i>
            <span>Trang chủ</span>
        </a>
        <a class="nav-item" href="{{route('dashboard')}}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a class="nav-item collapsed" data-bs-toggle="collapse" data-bs-target="#ql-lu" aria-controls="ql-lu">
            <i class='bx bxs-layout'></i>
            <span>Layout<i class="fa fa-caret-down float-end "></i></span>

        </a>
        <div class="accordion-collapse collapse" id="ql-lu" data-bs-parent="#accordionFlushExample">
            <ol class="nav-collapse">
                <li>
                    <a href="" class="nav-item">
                        <i class="fa-solid fa-image"></i>
                        <span class="">Banner</span>
                    </a>
                </li>
            </ol>
        </div>
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
                    <a href="{{route('url.index')}}" class="nav-item">
                        <i class="fa-solid fa-link"></i>
                        <span class="">List URL</span>
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
            <i class="fa-solid fa-globe"></i>
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
        <a class="nav-item collapsed" data-bs-toggle="collapse" data-bs-target="#ql-cs" aria-controls="ql-cs">
            <i class="fa-solid fa-microphone"></i>
            <span>Ca sĩ<i class="fa fa-caret-down float-end "></i></span>
        </a>
        <div class="accordion-collapse collapse" id="ql-cs" data-bs-parent="#accordionFlushExample">
            <ol class="nav-collapse">
                <li>
                    <a href="{{route('singer.create')}}" class="nav-item">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span class="">Thêm Ca sĩ</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('singer.index')}}" class="nav-item">
                        <i class="fa-solid fa-list"></i>
                        <span class="">Danh sách Ca sĩ</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('singer.trash.index')}}" class="nav-item">
                        <i class="fa-solid fa-trash"></i>
                        <span class="">Ca sĩ đã xóa</span>
                    </a>
                </li>
                <!-- <li>
                    <a href="" class="nav-item">
                        <i class="fa-solid fa-file"></i>
                        <span class="">Hình Ca sĩ</span>
                    </a>
                </li> -->
            </ol>
        </div>
        <a class="nav-item collapsed" data-bs-toggle="collapse" data-bs-target="#ql-album" aria-controls="ql-album">
            <i class="fa-solid fa-compact-disc"></i>
            <span>Album <i class="fa fa-caret-down float-end "></i></span>
        </a>
        <div class="accordion-collapse collapse" id="ql-album" data-bs-parent="#accordionFlushExample">
            <ol class="nav-collapse">
               
                <li>
                    <a href="{{ route('albums.add') }}" class="nav-item">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span>Thêm album</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('albums.list') }}" class="nav-item">
                        <i class="fa-solid fa-list"></i>
                        <span>Danh sách album</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('albums.trash.list')}}" class="nav-item">
                        <i class="fa-solid fa-trash"></i>
                        <span class="">Album đã xóa</span>
                    </a>
                </li>
              
            </ol>
        </div>
        

        <a class="nav-item collapsed" data-bs-toggle="collapse" data-bs-target="#ql-bq" aria-controls="ql-qb">
            <i class="fa-solid fa-copyright"></i>
            <span>Bản quyền <i class="fa fa-caret-down float-end "></i></span>
        </a>
        <div class="accordion-collapse collapse" id="ql-bq" data-bs-parent="#accordionFlushExample">
            <ol class="nav-collapse">
                <li>
                    <a href="{{route('copyrights.create')}}" class="nav-item">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span class="">Thêm Bản quyền</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('copyrights.index')}}" class="nav-item">
                        <i class="fa-solid fa-list"></i>
                        <span class="">Danh sách Bản quyền</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('copyrights.trash.index')}}" class="nav-item">
                        <i class="fa-solid fa-trash"></i>
                        <span class="">Bản quyền đã xóa</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('copyrights.file')}}" class="nav-item">
                        <i class="fa-solid fa-file"></i>
                        <span class="">File Bản quyền</span>
                    </a>
                </li>
            </ol>
        </div>
        <a class="nav-item collapsed" data-bs-toggle="collapse" data-bs-target="#ql-nxb" aria-controls="ql-nxb">
            <i class="fa-sharp-duotone fa-solid fa-layer-group"></i>
            <span>Nhà xuất bản <i class="fa fa-caret-down float-end "></i></span>
        </a>
        <div class="accordion-collapse collapse" id="ql-nxb" data-bs-parent="#accordionFlushExample">
            <ol class="nav-collapse">
                <li>
                    <a href="{{route('publishers.create')}}" class="nav-item">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span class="">Thêm Nhà xuất bản</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('publishers.index')}}" class="nav-item">
                        <i class="fa-solid fa-list"></i>
                        <span class="">Danh sách Nhà xuất bản</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('publishers.trash.index')}}" class="nav-item">
                        <i class="fa-solid fa-trash"></i>
                        <span class="">Nhà xuất bản đã xóa</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('publishers.file')}}" class="nav-item">
                        <i class="fa-solid fa-file"></i>
                        <span class="">File logo Nhà xuất bản</span>
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
        <a class="nav-item collapsed" data-bs-toggle="collapse" data-bs-target="#ql-ads" aria-controls="ql-ads">
            <i class="fa-solid fa-rectangle-ad"></i>
            <span>Quảng cáo <i class="fa fa-caret-down float-end "></i></span>
        </a>
        <div class="accordion-collapse collapse" id="ql-ads" data-bs-parent="#accordionFlushExample">
            <ol class="nav-collapse">
                <li>
                    <a href="{{route('advertisements.create')}}" class="nav-item">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span class="">Thêm quảng cáo</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('advertisements.list')}}" class="nav-item">
                        <i class="fa-solid fa-list"></i>
                        <span class="">Danh sách quảng cáo</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('advertisements.trash.list')}}" class="nav-item">
                        <i class="fa-solid fa-trash"></i>
                        <span class="">Quảng cáo đã xóa</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('advertisements.s3ads.index')}}" class="nav-item">
                        <i class="fa-solid fa-file"></i>
                        <span class="">File quảng cáo</span>
                    </a>
                </li>
            </ol>
        </div>
        <a class="nav-item collapsed" data-bs-toggle="collapse" data-bs-target="#ql-user" aria-controls="ql-user">
            <i class="fa-solid fa-users"></i>
            <span>Tài khoản <i class="fa fa-caret-down float-end "></i></span>
        </a>
        <div class="accordion-collapse collapse" id="ql-user" data-bs-parent="#accordionFlushExample">
            <ol class="nav-collapse">
                <li>
                    <a href="{{route('users.create')}}" class="nav-item">
                        <i class="fa-solid fa-circle-plus"></i>
                        <span class="">Thêm tài khoản</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('users.list')}}" class="nav-item">
                        <i class="fa-solid fa-list"></i>
                        <span class="">Danh sách tài khoản</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('users.trash.list')}}" class="nav-item">
                        <i class="fa-solid fa-trash"></i>
                        <span class="">Tài khoản đã xóa</span>
                    </a>
                </li>

            </ol>
        </div>
        <a class="nav-item collapsed" data-bs-toggle="collapse" data-bs-target="#ql-quyen" aria-controls="ql-quyen">
            <i class="fa-solid fa-shield"></i>
            <span>Phân quyền <i class="fa fa-caret-down float-end "></i></span>
        </a>
        <div class="accordion-collapse collapse" id="ql-quyen" data-bs-parent="#accordionFlushExample">
            <ol class="nav-collapse">
                <li>
                    <a href="{{route('modules.index')}}" class="nav-item">
                        <i class="fa-solid fa-list"></i>
                        <span class="">Danh sách Module</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('permissions.index')}}" class="nav-item">
                        <i class="fa-solid fa-list"></i>
                        <span class="">Danh sách quyền</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('roles.index')}}" class="nav-item">
                        <i class="fa-solid fa-list"></i>
                        <span class="">Danh sách vai trò</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('authorization.index')}}" class="nav-item">
                        <i class="fa-solid fa-shield"></i>
                        <span class="">Phân quyền tài khoản</span>
                    </a>
                </li>
            </ol>
        </div>
        <a class="nav-item collapsed" data-bs-toggle="collapse" data-bs-target="#ql-cmt" aria-controls="ql-cmt">
            <i class="fa-solid fa-comment"></i>
            <span>Bình luận <i class="fa fa-caret-down float-end "></i></span>
        </a>
        <div class="accordion-collapse collapse" id="ql-cmt" data-bs-parent="#accordionFlushExample">
            <ol class="nav-collapse">
                <li>
                    <a href="{{route('comments.list')}}" class="nav-item">
                        <i class="fa-solid fa-list"></i>
                        <span class="">Danh sách bình luận</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('comments.trash.list')}}" class="nav-item">
                        <i class="fa-solid fa-trash"></i>
                        <span class="">Bình luận đã xóa</span>
                    </a>
                </li>

            </ol>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="nav-item dropdown-item" type="submit">
                <i class="fas fa-sign-out-alt"></i>
                <span class="float-start">Đăng xuất</span>
            </button>
        </form>
    </nav>
</div>
