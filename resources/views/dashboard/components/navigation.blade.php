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
                    <span><i class="bi bi-stack"></i> Layanan</span>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('counters*') ? 'active' : '' }} ">
                <a href="{{ route('counters.index') }}" class='menu-link'>
                    <span><i class="bi bi-display-fill"></i> Loket</span>
                </a>
            </li>
            <li class="menu-item ">
                <a href="#" class='menu-link'>
                    <span><i class="bi bi-sliders"></i> Pengaturan 1</span>
                </a>
            </li>
            <li class="menu-item ">
                <a href="#" class='menu-link'>
                    <span><i class="bi bi-gear-fill"></i> Pengaturan 2</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
