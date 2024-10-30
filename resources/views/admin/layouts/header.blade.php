<!-- Header -->
<div id="header">
    <div id="toggle-btn">
        <i class="fas fa-bars"></i>
    </div>
    <form class="search-form">
        <input type="text" placeholder="Search..." />
        <button type="submit"><i class="fas fa-search"></i></button>
    </form>
    <div class="user-info mx-4">
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
                    <form method="POST" class="" action="{{ route('logout') }}">
                        @csrf
                        <a href="route('logout')" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                            <span class="float-start">Đăng xuất</span>
                            <i class="fas fa-sign-out-alt float-end"></i>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
