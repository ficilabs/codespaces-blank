<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">

        <a href="{{ route('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                {{-- Logo Here --}}
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">Sneat</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="align-middle bx bx-chevron-left bx-sm"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="py-1 menu-inner">

        {{-- Admin --}}
        <li class="menu-item {{ request()->is('home') ? 'active' : '' }}">
            <a href="{{ route('home.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Beranda">Beranda</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('attendance.todayReport') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-clipboard"></i>
                <div>Laporan Hari Ini</div>
            </a>
        </li>


        <li class="menu-item {{ request()->is('attendance/scanner') ? 'active' : '' }}">
            <a href="{{ route('attendance.scanner') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-qr-scan"></i>
                <div data-i18n="Scanner">Scanner</div>
            </a>
        </li>

        @role('Administrator')

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Class Management</span>
            </li>

            <li class="menu-item {{ request()->is('classes') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Kelola Kelas">Kelola Kelas</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item {{ request()->is('class-groups') ? 'active' : '' }}">
                        <a href="{{ route('class-students.index') }}" class="menu-link">
                            <div data-i18n="Kelas Per Jenjang">Kelas Siswa</div>
                        </a>
                    </li>
                </ul>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->is('classes') ? 'active' : '' }}">
                        <a href="{{ route('grades.index') }}" class="menu-link">
                            <div data-i18n="Kelas">Kelas</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Users Management</span>
            </li>

            <li class="menu-item {{ request()->is('users') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Kelola Pengguna">Kelola Pengguna</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item {{ request()->is('users') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class="menu-link">
                            <div data-i18n="Pengguna">Pengguna</div>
                        </a>
                    </li>
                </ul>

            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">System Management</span>
            </li>

            <li class="menu-item {{ request()->is('users') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Pengaturan Sistem">Pengaturan Sistem</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="" class="menu-link">
                            <div data-i18n="Pengaturan">Pengaturan</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endrole
    </ul>
</aside>
