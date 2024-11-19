<!-- Header -->
<div id="header">
    <div id="toggle-btn">
        <i class="fas fa-bars"></i>
    </div>
    <form class="search-form">
        <input type="text" placeholder="Search..." />
        <button type="submit"><i class="fas fa-search"></i></button>
    </form>
    <div class="row row-cols-3 align-items-center">
        <div class="align-content-center m-0 p-0" style="width: 30px;">
            <i class="fa-solid fa-cloud-sun text-warning"></i>
        </div>
        <!-- .slideThree -->
        <div class="slideThree col-1">

            <input type="checkbox" value="None" id="slideThree" name="check" checked />
            <label for="slideThree"></label>
        </div>
        <!-- end .slideThree -->

        <!--notification  -->

        <div class="notification dropdown mx-3" style="width: 40px; height: 35px;">
            <button type="button" class="btn btn-primary position-relative " style="width: 40px; height: 35px;" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-bell"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notifi-span" >
                    <span id="notifi-count">99+</span>
                    <span class="visually-hidden">Thông báo</span>
                </span>
            </button>
            <ul class="dropdown-menu">
                <li class="row justify-content-between align-items-center mx-2" >
                    <p class="col-8 px-2 m-0">
                        <i class="fa-solid fa-bell"></i>
                        Thông báo mới nhất
                    </p>
                    <p class="col-4 btn btn-info m-0">
                        Đánh dấu đã đọc
                    </p>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li class="li"><a class="notification-item" href="#">Action</a></li>
            </ul>
        </div>

        <div class="user-info align-content-center mx-2">
            <!-- Example single danger button -->
            <div class="btn-group">
                <a type="button" class="text-decoration-none text-black dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <span>Welcome {{Auth::user() ? Auth::user()->name : 'Admin'}}</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Thông tin cá nhân</a></li>
                    <li><a class="dropdown-item" href="#">Cài đặt</a></li>
                    <li><a class="dropdown-item" href="#">Thông báo</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a href="route('logout')" class="dropdown-item" onclick="event.preventDefault(); $('#logout').submit();">
                            Đăng xuất
                            <i class="fas fa-sign-out-alt align-middle ms-md-4"></i>
                        </a>
                        <form method="POST" class=" m-0" id="logout" action="{{ route('logout') }}">
                            @csrf

                        </form>
                    </li>
                </ul>
            </div>

        </div>
    </div>


</div>
