<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Quick Count</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">QC</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="/dashboard">Grafik Data</a>
                    </li>
                    <li>
                        <a class="nav-link" href="/detail">Detail Data</a>
                    </li>

                </ul>
            </li>

            @if (Auth::user()->id_level == '1')
                <li class="menu-header">Peserta</li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Peserta</span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="{{ route('peserta') }}">Peserta</a>
                        </li>
                    </ul>
                </li>
            @endif


            <li class="menu-header">User</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Saksi</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="/saksi">Penginputan Saksi</a>
                    </li>

                </ul>
            </li>
            @if (Auth::user()->id_level == '1')
                <li class="menu-header">Akun</li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Akun</span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="/user">Penginputan Akun</a>
                        </li>

                    </ul>
                </li>
            @endif



            {{-- @if (Auth::user()->id_level == '1') --}}
            <li class="menu-header">Verifikasi</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Verifikasi
                    </span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="/verif">Verifikasi Data</a>
                    </li>

                </ul>
            </li>

            @if (Auth::user()->id_level == '1')
                <li class="menu-header">Scan</li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Scan QrCode
                        </span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="/scan">Scan QrCode</a>
                        </li>

                    </ul>
                </li>
            @endif

            {{-- @endif --}}

    </aside>
</div>
