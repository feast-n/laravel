        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Menu Utama
            </div>

            <!-- Nav Item - Student -->
            <li class="nav-item {{ request()->is('admin/student*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('student') }}">
                    <i class="fas fa-fw fa-user-graduate"></i>
                    <span>Student Data</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('admin/contact*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('contact.index') }}">
                    <i class="fas fa-fw fa-address-book"></i>
                    <span>Data Contact</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('admin/blog*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('blog.index') }}">
                    <i class="fas fa-fw fa-blog"></i>
                    <span>Blog</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
