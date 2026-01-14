<nav class="main-navbar">
    <div class="container">
        <ul>
            <li class="menu-item {{ request()->routeIs('dashboard*') ? 'active' : '' }} ">
                <a href="{{ route('dashboard') }}" class='menu-link'>
                    <span><i class="bi bi-grid-fill"></i> Dashboard</span>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('services*') ? 'active' : '' }} ">
                <a href="{{ route('services.index') }}" class='menu-link'>
                    <span><i class="bi bi-gear-fill"></i> Layanan</span>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('counters*') ? 'active' : '' }} ">
                <a href="{{ route('counters.index') }}" class='menu-link'>
                    <span><i class="bi bi-gear-fill"></i> Loket / Pemanggil</span>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('users*') ? 'active' : '' }} ">
                <a href="{{ route('users.index') }}" class='menu-link'>
                    <span><i class="bi bi-person-fill"></i> Pengguna</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
