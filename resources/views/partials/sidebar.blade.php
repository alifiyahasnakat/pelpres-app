<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="/" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset ('assets/img/logo-cendana.png') }}" alt="" height="30">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/img/logo-sipelpres.png') }}" alt="" height="28">
            </span>
        </a>

        <a href="/" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset ('assets/img/logo-cendana.png') }}" alt="" height="30">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/img/logo-sipelpres.png') }}" alt="" height="28">
            </span>
        </a>
    </div>
    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>
    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="/dashboard">
                        <i class="uil-home-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @can('superAdmin')
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-database"></i>
                        <span>Data</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/admin" class=" {{ Request::is('admin*') ? 'active' : '' }}">Admin</a></li>
                        <li><a href="/guru" class=" {{ Request::is('guru*') ? 'active' : '' }}">Guru</a></li>
                        <li><a href="/siswa" class=" {{ Request::is('siswa*') ? 'active' : '' }}">Siswa</a></li>
                        <li><a href="/kelas" class=" {{ Request::is('kelas*') ? 'active' : '' }}">Kelas</a></li>
                        <li><a href="/pindah-naik-kelas" class=" {{ Request::is('pindah-naik-kelas*') ? 'active' : '' }}">Pindah/Naik Kelas</a></li>
                        <li><a href="/alumni" class=" {{ Request::is('alumni*') ? 'active' : '' }}">Alumni</a></li>
                        <li><a href="/guru-pensiun" class=" {{ Request::is('guru-pensiun*') ? 'active' : '' }}">Guru Pensiun</a></li>
                    </ul>
                </li>
                @endcan
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-balance-scale"></i>
                        <span>Tata Tertib</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/prestasi" class=" {{ Request::is('prestasi*') ? 'active' : '' }}">Prestasi</a></li>
                        <li><a href="/pelanggaran" class=" {{ Request::is('pelanggaran*') ? 'active' : '' }}">Pelanggaran</a></li>
                    </ul>
                </li>
                @unless(auth()->user()->can('siswa') || auth()->user()->can('superAdmin'))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-medal"></i>
                        <span>Prestasi</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                    @can('guru')
                        <li><a href="/siprestasi"  class=" {{ Request::is('siprestasi*') ? 'active' : '' }}">Input Prestasi</a></li>
                        <li><a href="/riwayat-prestasi"  class=" {{ Request::is('/riwayat-prestasi') ? 'active' : '' }}">Riwayat Prestasi</a></li>
                    @endcan
                    @can('admin')
                        <li><a href="/siprestasi"  class=" {{ Request::is('siprestasi*') ? 'active' : '' }}">Input Prestasi</a></li>
                        <li><a href="/riwayat-prestasi"  class=" {{ Request::is('/riwayat-prestasi') ? 'active' : '' }}">Riwayat Prestasi</a></li>
                    @endcan
                    @can('admin')
                        <li><a href="/prestasi-siswa" class=" {{ Request::is('/prestasi-siswa') ? 'active' : '' }}">Prestasi Siswa</a></li>
                    @endcan
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-exclamation-octagon"></i>
                        <span>Pelanggaran</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                    @can('guru')
                        <li><a href="/sipelanggaran"  class=" {{ Request::is('sipelanggaran*') ? 'active' : '' }}">Input Pelanggaran</a></li>
                        <li><a href="/riwayat-pelanggaran"  class=" {{ Request::is('/riwayat-pelanggaran') ? 'active' : '' }}">Riwayat Pelanggaran</a></li>
                    @endcan
                    @can('admin')
                        <li><a href="/sipelanggaran"  class=" {{ Request::is('sipelanggaran*') ? 'active' : '' }}">Input Pelanggaran</a></li>
                        <li><a href="/riwayat-pelanggaran"  class=" {{ Request::is('/riwayat-pelanggaran') ? 'active' : '' }}">Riwayat Pelanggaran</a></li>
                    @endcan
                    @can('admin')
                        <li><a href="/pelanggaran-siswa"  class=" {{ Request::is('/pelanggaran-siswa') ? 'active' : '' }}">Pelanggaran Siswa</a></li>
                    @endcan

                    </ul>
                </li>
                @endunless

                @can('siswa')
                <li>
                    <a href="/riwayat-prestasi-siswa"  class=" {{ Request::is('/riwayat-prestasi-siswa') ? 'active' : '' }}">
                        <i class="uil-medal"></i>
                        <span>Riwayat Prestasi</span>
                    </a>
                </li>
                <li>
                    <a href="/riwayat-pelanggaran-siswa"  class=" {{ Request::is('/riwayat-pelanggaran-siswa') ? 'active' : '' }}">
                        <i class="uil-exclamation-octagon"></i>
                        <span>Riwayat Pelanggaran</span>
                    </a>
                </li>
                @endcan
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>