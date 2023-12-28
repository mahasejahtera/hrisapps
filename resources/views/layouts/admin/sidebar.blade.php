<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand ">
            <a href=".">
                <img src="{{ asset('assets/img/logo-maha-akbar.png') }}" width="110" height="32" alt="Tabler"
                    class="navbar-brand-image">
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item d-none d-lg-flex me-3">
                <div class="btn-list">
                    <a href="https://github.com/tabler/tabler" class="btn" target="_blank" rel="noreferrer">
                        <!-- Download SVG icon from http://tabler-icons.io/i/brand-github -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M9 19c-4.3 1.4 -4.3 -2.5 -6 -3m12 5v-3.5c0 -1 .1 -1.4 -.5 -2c2.8 -.3 5.5 -1.4 5.5 -6a4.6 4.6 0 0 0 -1.3 -3.2a4.2 4.2 0 0 0 -.1 -3.2s-1.1 -.3 -3.5 1.3a12.3 12.3 0 0 0 -6.2 0c-2.4 -1.6 -3.5 -1.3 -3.5 -1.3a4.2 4.2 0 0 0 -.1 3.2a4.6 4.6 0 0 0 -1.3 3.2c0 4.6 2.7 5.7 5.5 6c-.6 .6 -.6 1.2 -.5 2v3.5" />
                        </svg>
                        Source code
                    </a>
                    <a href="https://github.com/sponsors/codecalm" class="btn" target="_blank" rel="noreferrer">
                        <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-pink" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                        </svg>
                        Sponsor
                    </a>
                </div>
            </div>
            <div class="d-none d-lg-flex">
                <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode"
                    data-bs-toggle="tooltip" data-bs-placement="bottom">
                    <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                    </svg>
                </a>
                <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode"
                    data-bs-toggle="tooltip" data-bs-placement="bottom">
                    <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path
                            d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                    </svg>
                </a>
                <div class="nav-item dropdown d-none d-md-flex me-3">
                    <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1"
                        aria-label="Show notifications">
                        <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                            <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                        </svg>
                        <span class="badge bg-red"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Last updates</h3>
                            </div>
                            <div class="list-group list-group-flush list-group-hoverable">
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto"><span
                                                class="status-dot status-dot-animated bg-red d-block"></span></div>
                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block">Example 1</a>
                                            <div class="d-block text-muted text-truncate mt-n1">
                                                Change deprecated html tags to text decoration classes (#29604)
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="list-group-item-actions">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted"
                                                    width="24" height="24" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto"><span class="status-dot d-block"></span></div>
                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block">Example 2</a>
                                            <div class="d-block text-muted text-truncate mt-n1">
                                                justify-content:between ⇒ justify-content:space-between (#29734)
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="list-group-item-actions show">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-yellow"
                                                    width="24" height="24" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto"><span class="status-dot d-block"></span></div>
                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block">Example 3</a>
                                            <div class="d-block text-muted text-truncate mt-n1">
                                                Update change-version.js (#29736)
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="list-group-item-actions">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted"
                                                    width="24" height="24" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto"><span
                                                class="status-dot status-dot-animated bg-green d-block"></span></div>
                                        <div class="col text-truncate">
                                            <a href="#" class="text-body d-block">Example 4</a>
                                            <div class="d-block text-muted text-truncate mt-n1">
                                                Regenerate package-lock.json (#29730)
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#" class="list-group-item-actions">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted"
                                                    width="24" height="24" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" fill="none"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>Paweł Kuna</div>
                        <div class="mt-1 small text-muted">UI Designer</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="#" class="dropdown-item">Status</a>
                    <a href="./profile.html" class="dropdown-item">Profile</a>
                    <a href="#" class="dropdown-item">Feedback</a>
                    <div class="dropdown-divider"></div>
                    <a href="./settings.html" class="dropdown-item">Settings</a>
                    <a href="/proseslogoutadmin" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item">
                    <a class="nav-link" href="/panel/dashboardadmin">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff"
                                viewBox="0 0 256 256">
                                <path
                                    d="M218.83,103.77l-80-75.48a1.14,1.14,0,0,1-.11-.11,16,16,0,0,0-21.53,0l-.11.11L37.17,103.77A16,16,0,0,0,32,115.55V208a16,16,0,0,0,16,16H96a16,16,0,0,0,16-16V160h32v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V115.55A16,16,0,0,0,218.83,103.77ZM208,208H160V160a16,16,0,0,0-16-16H112a16,16,0,0,0-16,16v48H48V115.55l.11-.1L128,40l79.9,75.43.11.1Z">
                                </path>
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Home
                        </span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is(['karyawan', 'departemen', 'cabang']) ? 'show' : '' }}"
                        href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button"
                        aria-expanded="{{ request()->is(['karyawan', 'departemen', 'cabang']) ? 'true' : '' }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff"
                                viewBox="0 0 256 256">
                                <path
                                    d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z">
                                </path>
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Data Karyawan
                        </span>
                    </a>
                    <div
                        class="dropdown-menu {{ request()->is(['karyawan*', 'departemen*', 'cabang*', 'jabatan*']) ? 'show' : '' }}">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item {{ request()->is(['karyawan*']) ? 'active' : '' }}"
                                    href="/karyawan">
                                    Karyawan
                                </a>
                                <a class="dropdown-item {{ request()->is(['departemen']) ? 'active' : '' }}"
                                    href="/departemen">
                                    Departemen
                                </a>
                                <a class="dropdown-item {{ request()->is(['jabatan']) ? 'active' : '' }}"
                                    href="/jabatan">
                                    Jabatan
                                </a>
                                <a class="dropdown-item {{ request()->is(['cabang']) ? 'active' : '' }}"
                                    href="/cabang">
                                    Kantor Cabang
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('presensi/monitoring') ? 'active' : '' }}"
                        href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button"
                        aria-expanded="{{ request()->is(['izinsakit', 'monitoring', 'laporan', 'rekap', 'jamkerja', 'jamkerjadept']) ? 'true' : '' }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff"
                                viewBox="0 0 256 256">
                                <path
                                    d="M72,128a134.63,134.63,0,0,1-14.16,60.47,8,8,0,1,1-14.32-7.12A118.8,118.8,0,0,0,56,128,71.73,71.73,0,0,1,83,71.8,8,8,0,1,1,93,84.29,55.76,55.76,0,0,0,72,128Zm56-8a8,8,0,0,0-8,8,184.12,184.12,0,0,1-23,89.1,8,8,0,0,0,14,7.76A200.19,200.19,0,0,0,136,128,8,8,0,0,0,128,120Zm0-32a40,40,0,0,0-40,40,8,8,0,0,0,16,0,24,24,0,0,1,48,0,214.09,214.09,0,0,1-20.51,92A8,8,0,1,0,146,226.83,230,230,0,0,0,168,128,40,40,0,0,0,128,88Zm0-64A104.11,104.11,0,0,0,24,128a87.76,87.76,0,0,1-5,29.33,8,8,0,0,0,15.09,5.33A103.9,103.9,0,0,0,40,128a88,88,0,0,1,176,0,282.24,282.24,0,0,1-5.29,54.45,8,8,0,0,0,6.3,9.4,8.22,8.22,0,0,0,1.55.15,8,8,0,0,0,7.84-6.45A298.37,298.37,0,0,0,232,128,104.12,104.12,0,0,0,128,24ZM94.4,152.17A8,8,0,0,0,85,158.42a151,151,0,0,1-17.21,45.44,8,8,0,0,0,13.86,8,166.67,166.67,0,0,0,19-50.25A8,8,0,0,0,94.4,152.17ZM128,56a72.85,72.85,0,0,0-9,.56,8,8,0,0,0,2,15.87A56.08,56.08,0,0,1,184,128a252.12,252.12,0,0,1-1.92,31A8,8,0,0,0,189,168a8.39,8.39,0,0,0,1,.06,8,8,0,0,0,7.92-7,266.48,266.48,0,0,0,2-33A72.08,72.08,0,0,0,128,56Zm57.93,128.25a8,8,0,0,0-9.75,5.75c-1.46,5.69-3.15,11.4-5,17a8,8,0,0,0,5,10.13,7.88,7.88,0,0,0,2.55.42,8,8,0,0,0,7.58-5.46c2-5.92,3.79-12,5.35-18.05A8,8,0,0,0,185.94,184.26Z">
                                </path>
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Data Absensi
                        </span>
                    </a>
                    <div
                        class="dropdown-menu {{ request()->is(['presensi/izinsakit', 'presensi/monitoring', 'presensi/laporan', 'presensi/rekap', 'konfigurasi/jamkerja', 'konfigurasi/jamkerjadept', 'presensi/izin/karyawan', 'presensi/hari/libur', 'presensi/detailabsenpresensi', 'getpresensi', 'presensi/persetujuan', 'presensi/persetujuan/search', 'presensi/penolakan', 'presensi/penolakan/search']) ? 'show' : '' }}">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item  {{ request()->is('presensi/hari/libur') ? 'active' : '' }}"
                                    href="/presensi/hari/libur">
                                    Hari Libur
                                </a>
                                <a class="dropdown-item  {{ request()->is('presensi/izin/karyawan') ? 'active' : '' }}"
                                    href="/presensi/izin/karyawan">
                                    Data Ijin & Sakit
                                </a>
                                <a class="dropdown-item {{ request()->is('presensi/monitoring') ? 'active' : '' }}"
                                    href="/presensi/monitoring">
                                    Monitoring Absensi
                                </a>
                                <a class="dropdown-item  {{ request()->is(['presensi/rekap']) ? 'active' : '' }}"
                                    href="/presensi/rekap">
                                    Rekap Absensi
                                </a>
                                <a class="dropdown-item {{ request()->is(['konfigurasi/jamkerja']) ? 'active' : '' }}"
                                    href="/konfigurasi/jamkerja">
                                    Jam Kerja
                                </a>
                                <a class="dropdown-item {{ request()->is(['konfigurasi/jamkerjadept']) ? 'active' : '' }}"
                                    href="/konfigurasi/jamkerjadept">
                                    Jam Kerja Departemen
                                </a>
                            </div>
                        </div>
                    </div>

                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs(['payroll', 'payroll.*']) ? 'active' : '' }}"
                        href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button"
                        aria-expanded="{{ request()->routeIs(['payroll']) ? 'true' : '' }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/package -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff"
                                viewBox="0 0 256 256">
                                <path
                                    d="M224,48H32A16,16,0,0,0,16,64V192a16,16,0,0,0,16,16H224a16,16,0,0,0,16-16V64A16,16,0,0,0,224,48Zm0,16V88H32V64Zm0,128H32V104H224v88Zm-16-24a8,8,0,0,1-8,8H168a8,8,0,0,1,0-16h32A8,8,0,0,1,208,168Zm-64,0a8,8,0,0,1-8,8H120a8,8,0,0,1,0-16h16A8,8,0,0,1,144,168Z">
                                </path>
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Data Payroll
                        </span>
                    </a>
                    <div class="dropdown-menu {{ request()->routeIs(['payroll.', 'payroll.*']) ? 'show' : '' }}">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item {{ request()->routeIs(['payroll.']) ? 'active' : '' }}"
                                    href="{{ route('payroll.') }}">
                                    Laporan Payroll
                                </a>
                                <a class="dropdown-item {{ request()->routeIs(['payroll.deductions']) ? 'active' : '' }}"
                                    href="{{ route('payroll.deductions') }}">
                                    Potongan
                                </a>
                                <a class="dropdown-item {{ request()->routeIs(['payroll.loan.index']) ? 'active' : '' }}"
                                    href="{{ route('payroll.loan.index') }}">
                                    Pinjaman
                                </a>
                                <a class="dropdown-item {{ request()->routeIs(['payroll.bonus.index']) ? 'active' : '' }}"
                                    href="{{ route('payroll.bonus.index') }}">
                                    Bonus
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#navbar-base" data-bs-toggle="dropdown"
                        data-bs-auto-close="false" role="button"
                        aria-expanded="{{ request()->is(['izinsakit', 'monitoring', 'laporan', 'rekap', 'jamkerja', 'jamkerjadept']) ? 'true' : '' }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff"
                                viewBox="0 0 256 256">
                                <path
                                    d="M168,112h48a16,16,0,0,0,16-16V48a16,16,0,0,0-16-16H168a16,16,0,0,0-16,16V64h-8a32,32,0,0,0-32,32v24H80v-8A16,16,0,0,0,64,96H32a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H64a16,16,0,0,0,16-16v-8h32v24a32,32,0,0,0,32,32h8v16a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V160a16,16,0,0,0-16-16H168a16,16,0,0,0-16,16v16h-8a16,16,0,0,1-16-16V96a16,16,0,0,1,16-16h8V96A16,16,0,0,0,168,112ZM64,144H32V112H64v32Zm104,16h48v48H168Zm0-112h48V96H168Z">
                                </path>
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Pengajuan
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a href="{{route('panelpengajuan.list','HR')}}" class="dropdown-item  ">
                                    Pengajuan Dept HRD
                                </a>
                                <a href="{{route('panelpengajuan.list','KU')}}" class="dropdown-item ">
                                    Pengajuan Dept Keuangan
                                </a>
                                <a href="{{route('panelpengajuan.list','SC')}}" class="dropdown-item ">
                                    Pengajuan Dept SCM
                                </a>
                                <a href="{{route('panelpengajuan.list','PN')}}" class="dropdown-item  ">
                                    Pengajuan Dept Pemasaran
                                </a>
                                <a href="{{route('panelpengajuan.list','PR')}}" class="dropdown-item ">
                                    Pengajuan Dept Produksi
                                </a>
                                <a href="{{route('panelpengajuan.list','TK')}}" class="dropdown-item ">
                                    Pengajuan Dept Teknik
                                </a>
                            </div>
                        </div>
                    </div>

                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#navbar-base" data-bs-toggle="dropdown"
                        data-bs-auto-close="false" role="button"
                        aria-expanded="{{ request()->is(['izinsakit', 'monitoring', 'laporan', 'rekap', 'jamkerja', 'jamkerjadept']) ? 'true' : '' }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff"
                                viewBox="0 0 256 256">
                                <path
                                    d="M216,56H176V48a24,24,0,0,0-24-24H104A24,24,0,0,0,80,48v8H40A16,16,0,0,0,24,72V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V72A16,16,0,0,0,216,56ZM40,112H216v48H40ZM96,48a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96ZM216,72V96H40V72Zm0,128H40V176H216v24Z">
                                </path>
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Rencana Kerja
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item  ">
                                    Rencana Kerja Karyawan
                                </a>
                                <a class="dropdown-item  ">
                                    Tugas Karyawan
                                </a>
                            </div>
                        </div>
                    </div>

                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="#navbar-base" data-bs-toggle="dropdown"
                        data-bs-auto-close="false" role="button"
                        aria-expanded="{{ request()->is(['izinsakit', 'monitoring', 'laporan', 'rekap', 'jamkerja', 'jamkerjadept']) ? 'true' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff"
                            viewBox="0 0 256 256">
                            <path
                                d="M223.16,68.42l-16-32A8,8,0,0,0,200,32H56a8,8,0,0,0-7.16,4.42l-16,32A8.08,8.08,0,0,0,32,72V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V72A8.08,8.08,0,0,0,223.16,68.42ZM60.94,48H195.06l8,16H52.94ZM208,208H48V80H208V208Zm-42.34-61.66a8,8,0,0,1,0,11.32l-32,32a8,8,0,0,1-11.32,0l-32-32a8,8,0,0,1,11.32-11.32L120,164.69V104a8,8,0,0,1,16,0v60.69l18.34-18.35A8,8,0,0,1,165.66,146.34Z">
                            </path>
                        </svg>
                        </span>
                        <span class="nav-link-title">
                            Arsip
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item  ">
                                    Arsip Absensi
                                </a>
                                <a class="dropdown-item  ">
                                    Arsip Pengajuan
                                </a>
                                <a class="dropdown-item  ">
                                    Arsip Permintaan
                                </a>
                                <a class="dropdown-item  ">
                                    Arsip Rencana Kerja
                                </a>
                                <a class="dropdown-item  ">
                                    Arsip Tugas
                                </a>
                            </div>
                        </div>
                    </div>

                </li>
            </ul>
        </div>
    </div>
</aside>
