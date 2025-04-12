<!-- Profile Dropdown -->
<li class="c-header-nav-item dropdown">
    <a class="c-header-nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user"></i> {{ Auth::user()->name }}
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profileModal">View Profile</a>
        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
            Logout
        </a>
    </div>
</li>
