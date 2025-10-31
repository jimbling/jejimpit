<header class="navbar navbar-expand-md d-print-none top-nav">
    <div class="container-fluid">
        <!-- BEGIN NAVBAR TOGGLER -->
        <!-- Toggler Button for Mobile -->
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu"
            aria-controls="offcanvasMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <img src="https://jimpitan.sinaucms.web.id/illustrasi/sregep2.png" alt="Hero illustration" class="img-fluid">

        <div class="navbar-nav flex-row order-md-last">


            <div class="d-flex">
                <div class="nav-item">
                    <a href="#" class="nav-link px-0 hide-theme-dark" data-theme="dark">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-1">
                            <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                        </svg>
                    </a>

                    <a href="#" class="nav-link px-0 hide-theme-light" data-theme="light">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-1">
                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                            <path
                                d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                        </svg>
                    </a>
                </div>


            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <span class="avatar avatar-sm"
                        style="background-image: url({{ asset('storage/avatars/' . ($user->avatar ?? 'default-avatar.png')) }})"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ $user->name ?? 'Guest' }}</div>
                        <div class="mt-1 small text-secondary">{{ $userRole ?? '-' }}</div>
                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="/profile" class="dropdown-item">Profile</a>
                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-scrollable">
                        Tentang Jimpitan 63 </a>
                    <a href="{{ route('pengaturan.lisensi') }}" class="dropdown-item">Lisensi</a>

                    <div class="dropdown-divider"></div>



                    <!-- Tombol Logout yang membuka modal konfirmasi -->
                    <a href="#" class="dropdown-item text-pink" data-bs-toggle="modal"
                        data-bs-target="#logoutModal">
                        {{ __('Keluar') }}
                    </a>
                </div>

                <!-- Modal Tentang Jimpitan 63 -->
                <div class="modal modal-blur fade" id="modal-scrollable" tabindex="-1" role="dialog"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-2 modal-dialog-centered modal-dialog-scrollable"
                        role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tentang Jimpitan 63</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>
                                    <strong>Jimpitan 63</strong> adalah aplikasi untuk mendukung program kemandirian dan
                                    gotong royong warga <strong>Kedungtangkil RT 63</strong>.
                                    Jimpitan ini berupa iuran rutin sebesar <strong>Rp2.000 setiap malam Minggu</strong>
                                    yang dikelola oleh remaja RT 63.
                                </p>
                                <p>
                                    Seluruh kegiatan mulai dari pencatatan transaksi hingga laporan keuangan dilakukan
                                    secara <strong>online</strong>, sehingga memudahkan pengelolaan serta menjaga
                                    <strong>transparansi</strong> keuangan yang dapat diakses publik.
                                </p>
                                <p>
                                    <strong>Teknologi yang digunakan:</strong>
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="https://laravel.com" target="_blank" title="Visit Laravel">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                                viewBox="0 0 24 24" fill="none" stroke="#FF2D20" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-brand-laravel">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M3 17l8 5l7 -4v-8l-4 -2.5l4 -2.5l4 2.5v4l-11 6.5l-4 -2.5v-7.5l-4 -2.5z" />
                                                <path d="M11 18v4" />
                                                <path d="M7 15.5l7 -4" />
                                                <path d="M14 7.5v4" />
                                                <path d="M14 11.5l4 2.5" />
                                                <path d="M11 13v-7.5l-4 -2.5l-4 2.5" />
                                                <path d="M7 8l4 -2.5" />
                                                <path d="M18 10l4 -2.5" />
                                            </svg>
                                            Laravel
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://tabler.io" target="_blank" title="Visit Tabler">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                                viewBox="0 0 24 24" fill="currentColor"
                                                class="icon icon-tabler icons-tabler-filled icon-tabler-brand-tabler">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M17 2a5 5 0 0 1 5 5v10a5 5 0 0 1 -5 5h-10a5 5 0 0 1 -5 -5v-10a5 5 0 0 1 5 -5zm-1 12h-3a1 1 0 0 0 0 2h3a1 1 0 0 0 0 -2m-7.293 -5.707a1 1 0 0 0 -1.414 0l-.083 .094a1 1 0 0 0 .083 1.32l2.292 2.293l-2.292 2.293a1 1 0 0 0 1.414 1.414l3 -3a1 1 0 0 0 0 -1.414z" />
                                            </svg>
                                            Tabler
                                        </a>
                                    </li>
                                </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Modal Logout -->
                <div class="modal modal-blur fade" id="logoutModal" tabindex="-1"
                    aria-labelledby="logoutModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            <div class="modal-status bg-danger"></div>
                            <div class="modal-body text-center py-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 9v2m0 4v.01" />
                                    <path
                                        d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
                                </svg>
                                <h3>Apakah Anda yakin?</h3>
                                <div class="text-secondary">
                                    Apakah Anda benar-benar ingin keluar? Proses ini tidak dapat dibatalkan.
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="w-100">
                                    <div class="row">
                                        <div class="col">
                                            <button type="button" class="btn w-100"
                                                data-bs-dismiss="modal">Batal</button>
                                        </div>
                                        <div class="col">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="btn btn-danger w-100">Keluar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</header>
<!-- Navbar Menu Items for Mobile (Offcanvas) -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasMenuLabel">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="nav flex-column">
            <!-- Home -->
            <div class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="/dashboard">
                    <span class="nav-link-icon me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                        </svg>
                    </span>
                    <span class="nav-link-title">Home</span>
                </a>
            </div>

            <!-- Buku Induk -->
            <!-- Jimpitan (Mobile Menu) -->
            <div
                class="nav-item {{ Request::is('induk/*') || Request::is('kehadiran*') || Request::is('transaksi/jimpitan*') || Request::is('penerimaan*') || Request::is('pengeluaran*') || Request::is('bku/kelengkap*') || Request::is('laporan*') ? 'active' : '' }}">
                <a class="nav-link" href="#jimpitan-collapse" data-bs-toggle="collapse" role="button"
                    aria-expanded="{{ Request::is('induk/*') || Request::is('kehadiran*') || Request::is('transaksi/jimpitan*') || Request::is('penerimaan*') || Request::is('pengeluaran*') || Request::is('bku/kelengkap*') || Request::is('laporan*') ? 'true' : 'false' }}"
                    aria-controls="jimpitan-collapse">
                    <span class="nav-link-icon me-2">
                        <!-- Icon Buku Induk -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-address-book">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2z" />
                            <path d="M10 16h6" />
                            <path d="M13 11m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M4 8h3" />
                            <path d="M4 12h3" />
                            <path d="M4 16h3" />
                        </svg>
                    </span>
                    <span class="nav-link-title">Jimpitan</span>
                    <span class="nav-link-chevron">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9 6l6 6l-6 6"></path>
                        </svg>
                    </span>
                </a>

                <div class="collapse {{ Request::is('induk/*') || Request::is('kehadiran*') || Request::is('transaksi/jimpitan*') || Request::is('penerimaan*') || Request::is('pengeluaran*') || Request::is('bku/kelengkap*') || Request::is('laporan*') ? 'show' : '' }}"
                    id="jimpitan-collapse">
                    <div class="nav flex-column ps-4">

                        <a class="nav-link {{ request()->routeIs('induk.warga') ? 'active' : '' }}"
                            href="{{ route('induk.warga') }}">
                            Data Warga
                        </a>

                        <!-- Submenu Petugas -->
                        <a class="nav-link d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" href="#petugas-collapse" role="button"
                            aria-expanded="{{ Request::is('kehadiran*') || Request::is('transaksi/jimpitan*') ? 'true' : 'false' }}"
                            aria-controls="petugas-collapse">
                            <span>Petugas</span>
                            <span class="nav-link-chevron">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="20" height="20"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 6l6 6l-6 6"></path>
                                </svg>
                            </span>
                        </a>
                        <div class="collapse {{ Request::is('kehadiran*') || Request::is('transaksi/jimpitan*') ? 'show' : '' }}"
                            id="petugas-collapse">
                            <div class="nav flex-column ps-4">
                                <a href="{{ route('transaksi.jimpitan.index') }}"
                                    class="nav-link {{ isActiveRoute('transaksi.jimpitan.index') }}">
                                    Transaksi
                                </a>
                                <a href="{{ route('kehadiran.index') }}"
                                    class="nav-link {{ isActiveRoute('kehadiran.index') }}">
                                    Kehadiran
                                </a>
                            </div>
                        </div>

                        <!-- Submenu Penatausahaan -->
                        <a class="nav-link d-flex justify-content-between align-items-center"
                            data-bs-toggle="collapse" href="#penatausahaan-collapse" role="button"
                            aria-expanded="{{ Request::is('penerimaan*') || Request::is('pengeluaran*') || Request::is('bku/kelengkap*') ? 'true' : 'false' }}"
                            aria-controls="penatausahaan-collapse">
                            <span>Penatausahaan</span>
                            <span class="nav-link-chevron">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="20" height="20"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 6l6 6l-6 6"></path>
                                </svg>
                            </span>
                        </a>
                        <div class="collapse {{ Request::is('penerimaan*') || Request::is('pengeluaran*') || Request::is('bku/kelengkap*') ? 'show' : '' }}"
                            id="penatausahaan-collapse">
                            <div class="nav flex-column ps-4">
                                <a href="{{ route('penerimaan.index') }}"
                                    class="nav-link {{ isActiveRoute('penerimaan.index') }}">
                                    Penerimaan
                                </a>
                                <a href="{{ route('pengeluaran.index') }}"
                                    class="nav-link {{ isActiveRoute('pengeluaran.index') }}">
                                    Pengeluaran
                                </a>
                                <a href="{{ route('bku.lengkap.index') }}"
                                    class="nav-link {{ isActiveRoute('bku.lengkap.index') }}">
                                    Buku Kas Umum
                                </a>
                            </div>
                        </div>


                        <a class="nav-link {{ isActiveRoute('laporan.index') }}"
                            href="{{ route('laporan.index') }}">
                            Laporan
                        </a>
                        <a class="nav-link {{ isActiveRoute('laporan.partisipasi.index') }}"
                            href="{{ route('laporan.partisipasi.index') }}">
                            Partisipasi Warga
                        </a>
                    </div>
                </div>
            </div>


            <!-- Administrator -->
            <div class="nav-item {{ Request::is('pengaturan/*') ? 'active' : '' }}">
                <a class="nav-link" href="#admin-collapse" data-bs-toggle="collapse" role="button"
                    aria-expanded="{{ Request::is('pengaturan/*') ? 'true' : 'false' }}"
                    aria-controls="admin-collapse">
                    <span class="nav-link-icon me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M12 21a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3a12 12 0 0 0 8.5 3c.568 1.933 .635 3.957 .223 5.89" />
                            <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M19.001 15.5v1.5" />
                            <path d="M19.001 21v1.5" />
                            <path d="M22.032 17.25l-1.299 .75" />
                            <path d="M17.27 20l-1.3 .75" />
                            <path d="M15.97 17.25l1.3 .75" />
                            <path d="M20.733 20l1.3 .75" />
                        </svg>
                    </span>
                    <span class="nav-link-title">Administrator</span>
                    <span class="nav-link-chevron">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M9 6l6 6l-6 6"></path>
                        </svg>
                    </span>
                </a>
                <div class="collapse {{ Request::is('pengaturan/*') ? 'show' : '' }}" id="admin-collapse">
                    <div class="nav flex-column ps-4">
                        <a class="nav-link {{ request()->routeIs('pengaturan.sistem') ? 'active' : '' }}"
                            href="{{ route('pengaturan.sistem') }}">
                            Pengaturan Sistem
                        </a>
                        <a class="nav-link {{ request()->routeIs('pengaturan.akses') ? 'active' : '' }}"
                            href="{{ route('pengaturan.akses') }}">
                            Pengaturan Akses
                        </a>
                        <a class="nav-link {{ request()->routeIs('pengaturan.pembaruan') ? 'active' : '' }}"
                            href="{{ route('pengaturan.pembaruan') }}">
                            Pembaruan Aplikasi
                        </a>
                        <a class="nav-link {{ request()->routeIs('pengaturan.pemeliharaan.index') ? 'active' : '' }}"
                            href="{{ route('pengaturan.pemeliharaan.index') }}">
                            Pemeliharaan
                        </a>
                        <a class="nav-link {{ request()->routeIs('google.drive.index') ? 'active' : '' }}"
                            href="{{ route('google.drive.index') }}">
                            Pengaturan GDrive
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
