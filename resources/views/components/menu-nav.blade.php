<aside class="navbar navbar-vertical navbar-expand-lg menu-nav" id="menu-nav">
    <div class="container-fluid">


        <!-- Brand -->
        <div
            class="navbar-brand navbar-brand-autodark d-flex align-items-center justify-content-center position-relative">
            <a href="." class="mx-auto">
                <!-- Logo SVG -->
                <img src="https://jimpitan.sinaucms.web.id/illustrasi/sregep2.png" alt="Hero illustration"
                    class="img-fluid">
            </a>

            <!-- Tombol Collapse -->
            <svg id="toggleSidebarCollapse" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                viewBox="0 0 24 24" fill="currentColor" class="toggle-icon position-absolute end-0 me-2"
                style="cursor: pointer;">
                <path
                    d="M18 3a3 3 0 0 1 2.995 2.824l.005 .176v12a3 3 0 0 1 -2.824 2.995l-.176 .005h-12a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-12a3 3 0 0 1 2.824 -2.995l.176 -.005h12zm0 2h-9v14h9a1 1 0 0 0 .993 -.883l.007 -.117v-12a1 1 0 0 0 -.883 -.993l-.117 -.007zm-2.293 4.293a1 1 0 0 1 .083 1.32l-.083 .094l-1.292 1.293l1.292 1.293a1 1 0 0 1 .083 1.32l-.083 .094a1 1 0 0 1 -1.32 .083l-.094 -.083l-2 -2a1 1 0 0 1 -.083 -1.32l.083 -.094l2 -2a1 1 0 0 1 1.414 0z" />
            </svg>

            <!-- Tombol Expand -->
            <svg id="toggleSidebarExpand" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                viewBox="0 0 24 24" fill="currentColor" class="toggle-icon position-absolute end-0 me-2"
                style="cursor: pointer; display: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="currentColor"
                    class="icon icon-tabler icons-tabler-filled icon-tabler-layout-sidebar-right-collapse">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M18 3a3 3 0 0 1 2.995 2.824l.005 .176v12a3 3 0 0 1 -2.824 2.995l-.176 .005h-12a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-12a3 3 0 0 1 2.824 -2.995l.176 -.005h12zm-3 2h-9a1 1 0 0 0 -.993 .883l-.007 .117v12a1 1 0 0 0 .883 .993l.117 .007h9v-14zm-5.387 4.21l.094 .083l2 2a1 1 0 0 1 .083 1.32l-.083 .094l-2 2a1 1 0 0 1 -1.497 -1.32l.083 -.094l1.292 -1.293l-1.292 -1.293a1 1 0 0 1 -.083 -1.32l.083 -.094a1 1 0 0 1 1.32 -.083z" />
                </svg>
            </svg>
        </div>






        <div class="collapse navbar-collapse" id="sidebar-menu">
            <!-- Sidebar Menu -->
            <ul class="navbar-nav pt-lg-3">


                <!-- Home -->
                <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="/dashboard">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <!-- Home Icon -->
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
                </li>




                @role('super-admin|user')
                    <li
                        class="nav-item dropdown {{ isActiveParent(['induk.*', 'kehadiran.index', 'transaksi.jimpitan.index', 'penerimaan.index', 'pengeluaran.index', 'bku.lengkap.index', 'laporan.index', 'laporan.partisipasi.index']) }}">
                        <a class="nav-link dropdown-toggle {{ isActiveParent(['induk.*', 'kehadiran.index', 'transaksi.jimpitan.index', 'penerimaan.index', 'pengeluaran.index', 'bku.lengkap.index', 'laporan.index', 'laporan.partisipasi.index']) }}"
                            href="#" data-bs-toggle="dropdown" role="button" aria-expanded="false"
                            data-bs-auto-close="outside">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Icon -->
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
                        </a>

                        <div
                            class="dropdown-menu {{ isDropdownOpen(['induk.*', 'kehadiran.index', 'transaksi.jimpitan.index', 'penerimaan.index', 'pengeluaran.index', 'bku.lengkap.index']) }}">
                            <a class="dropdown-item {{ isActiveRoute('induk.warga') }}" href="{{ route('induk.warga') }}">
                                Data Warga
                            </a>


                            <!-- Submenu Petugas -->
                            <div class="dropend">
                                <a class="dropdown-item dropdown-toggle {{ isActiveParent(['kehadiran.index', 'transaksi.jimpitan.index']) }}"
                                    href="#" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button"
                                    aria-expanded="false">
                                    Petugas
                                </a>
                                <div
                                    class="dropdown-menu {{ isDropdownOpen(['kehadiran.index', 'transaksi.jimpitan.index']) }}">
                                    <a href="{{ route('transaksi.jimpitan.index') }}"
                                        class="dropdown-item {{ isActiveRoute('transaksi.jimpitan.index') }}">
                                        Transaksi
                                    </a>
                                    <a href="{{ route('kehadiran.index') }}"
                                        class="dropdown-item {{ isActiveRoute('kehadiran.index') }}">
                                        Kehadiran
                                    </a>
                                </div>
                            </div>

                            <!-- Submenu Penatausahaan -->
                            <div class="dropend">
                                <a class="dropdown-item dropdown-toggle {{ isActiveParent(['penerimaan.index', 'pengeluaran.index', 'bku.lengkap.index']) }}"
                                    href="#" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button"
                                    aria-expanded="false">
                                    Penatausahaan
                                </a>
                                <div
                                    class="dropdown-menu {{ isDropdownOpen(['penerimaan.index', 'pengeluaran.index', 'bku.lengkap.index']) }}">
                                    <a href="{{ route('penerimaan.index') }}"
                                        class="dropdown-item {{ isActiveRoute('penerimaan.index') }}">
                                        Penerimaan
                                    </a>
                                    <a href="{{ route('pengeluaran.index') }}"
                                        class="dropdown-item {{ isActiveRoute('pengeluaran.index') }}">
                                        Pengeluaran
                                    </a>
                                    <a href="{{ route('bku.lengkap.index') }}"
                                        class="dropdown-item {{ isActiveRoute('bku.lengkap.index') }}">
                                        Buku Kas Umum
                                    </a>
                                </div>
                            </div>

                            <a class="dropdown-item {{ isActiveRoute('laporan.index') }}"
                                href="{{ route('laporan.index') }}">
                                Laporan
                            </a>
                            <a class="dropdown-item {{ isActiveRoute('laporan.partisipasi.index') }}"
                                href="{{ route('laporan.partisipasi.index') }}">
                                Partisipasi Warga
                            </a>
                        </div>
                    </li>
                @endrole



                @role('super-admin')
                    <!-- Administrator Dropdown -->
                    <li class="nav-item dropdown {{ Request::is('pengaturan/*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#navbar-admin" data-bs-toggle="dropdown"
                            role="button" aria-expanded="false">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <!-- Settings Icon -->
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
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item {{ request()->routeIs('pengaturan.sistem') ? 'active' : '' }}"
                                href="{{ route('pengaturan.sistem') }}">
                                Pengaturan Sistem
                            </a>
                            <a class="dropdown-item {{ request()->routeIs('pengaturan.akses') ? 'active' : '' }}"
                                href="{{ route('pengaturan.akses') }}">
                                Pengaturan Akses
                            </a>
                            <a class="dropdown-item {{ request()->routeIs('pengaturan.pembaruan') ? 'active' : '' }}"
                                href="{{ route('pengaturan.pembaruan') }}">
                                Pembaruan Aplikasi
                            </a>
                            <a class="dropdown-item {{ request()->routeIs('pengaturan.pemeliharaan') ? 'active' : '' }}"
                                href="{{ route('pengaturan.pemeliharaan') }}">
                                Pemeliharaan
                            </a>
                            <a class="dropdown-item {{ request()->routeIs('google.drive.index') ? 'active' : '' }}"
                                href="{{ route('google.drive.index') }}">
                                Pengaturan GDrive
                            </a>
                        </div>
                    </li>
                @endrole

            </ul>
            <!-- End Sidebar Menu -->
        </div>


    </div>
</aside>
@push('scripts')
    <script>
        $(document).ready(function() {
            // Collapse sidebar
            $('#toggleSidebarCollapse').click(function() {
                $('#menu-nav').addClass('collapsed');
                $('.page-wrapper').addClass('collapsed');

                // Ganti tombol
                $('#toggleSidebarCollapse').hide();
                $('#toggleSidebarExpand').show();
            });

            // Expand sidebar
            $('#toggleSidebarExpand').click(function() {
                $('#menu-nav').removeClass('collapsed');
                $('.page-wrapper').removeClass('collapsed');

                // Ganti tombol
                $('#toggleSidebarExpand').hide();
                $('#toggleSidebarCollapse').show();
            });
        });
    </script>
@endpush
