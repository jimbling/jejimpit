@extends('layouts.tabler')

@section('title', 'Dashboard Pengelolaan Jimpitan')

@section('page-title', 'Selamat Datang di Sistem Kelola Jimpitan')

@section('content')
    <div class="container-fluid">


        <div class="row row-deck row-cards mb-4">
            <div class="col-sm-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row gy-3 align-items-center">
                            <!-- Kolom Teks -->
                            <div class="col-12 col-md-8 d-flex flex-column">
                                <h3 class="h2 mb-3">SREGEP</h3>
                                <p class="text-muted mb-2">
                                    <strong>SREGEP</strong> adalah jargon dari Warga Kedungtangkil RT 63 yang berarti
                                    <em>"RT 63 Semanak Remaked Guyup ing Padatan"</em> — sebuah semangat
                                    kebersamaan dan keguyuban warga.
                                </p>
                                <p class="text-muted mb-2">
                                    Melalui program <strong>Jimpitan</strong>, warga Kedungtangkil RT 63
                                    menjalankan tradisi iuran rutin setiap minggu sebagai bentuk
                                    kebersamaan dan kemandirian.
                                </p>
                                <p class="text-muted">
                                    Dana jimpitan dikelola secara transparan dan tercatat dalam sistem,
                                    untuk mendukung kegiatan sosial serta kebutuhan bersama warga.
                                </p>
                            </div>

                            <!-- Kolom Logo -->
                            <div class="col-12 col-md-4 d-flex justify-content-center">
                                <div class="d-flex flex-column align-items-center gap-3">
                                    <!-- Logo Kop Sekolah -->
                                    <img src="{{ asset('storage/' . system_setting('kop_sekolah')) }}" alt="Kop Sekolah"
                                        class="img-fluid rounded" style="max-height: 80px;">

                                    <!-- Logo RT -->
                                    <img src="{{ asset('storage/' . system_setting('logo')) }}" alt="Logo RT 63"
                                        class="img-fluid rounded" style="max-height: 120px;">
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>



            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center mb-2">
                            <span class="avatar avatar-sm bg-blue-lt me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-adjustments-cog">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 10a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M6 4v4" />
                                    <path d="M6 12v8" />
                                    <path d="M13.199 14.399a2 2 0 1 0 -1.199 3.601" />
                                    <path d="M12 4v10" />
                                    <path d="M12 18v2" />
                                    <path d="M16 7a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M18 4v1" />
                                    <path d="M18 9v2.5" />
                                    <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    <path d="M19.001 15.5v1.5" />
                                    <path d="M19.001 21v1.5" />
                                    <path d="M22.032 17.25l-1.299 .75" />
                                    <path d="M17.27 20l-1.3 .75" />
                                    <path d="M15.97 17.25l1.3 .75" />
                                    <path d="M20.733 20l1.3 .75" />
                                </svg>
                            </span>
                            <h3 class="card-title m-0">Informasi Sistem</h3>
                        </div>

                        <div class="list-group list-group-flush list-group-condensed">
                            <div class="list-group-item px-0 py-1">
                                <div class="row align-items-center">
                                    <div class="col-auto text-muted">Nama Dusun</div>
                                    <div class="col text-end font-weight-medium text-truncate">
                                        {{ system_setting('nama_dusun') }}</div>
                                </div>
                            </div>
                            <div class="list-group-item px-0 py-1">
                                <div class="row align-items-center">
                                    <div class="col-auto text-muted">Desa</div>
                                    <div class="col text-end font-weight-medium">
                                        {{ system_setting('desa_kelurahan') }}, {{ system_setting('kecamatan') }}</div>
                                </div>
                            </div>
                            <div class="list-group-item px-0 py-1">
                                <div class="row align-items-center">
                                    <div class="col-auto text-muted ">Versi Aplikasi
                                    </div>
                                    <div class="col text-end d-flex justify-content-end align-items-center gap-2">
                                        <span class="font-weight-medium">1.0.0

                                        </span>

                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>


        <!-- Statistik Utama -->
        <div class="row row-deck row-cards mb-4">
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-primary text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    Total Warga
                                </div>
                                <div class="text-muted">
                                    {{ $totalWarga }} KK
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-green text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-user-scan">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 9a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                                        <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                                        <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                                        <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                                        <path d="M8 16a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    Petugas Jimpitan
                                </div>
                                <div class="text-muted">
                                    {{ $totalPetugas }} petugas
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-orange text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-wallet">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
                                        <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    Jimpitan Terkumpul
                                </div>
                                <div class="text-muted">
                                    Rp {{ number_format($totalPenerimaan, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-purple text-white avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-cart">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 17h-11v-14h-2" />
                                        <path d="M6 5l14 1l-1 7h-13" />
                                    </svg>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    Total Pengeluaran
                                </div>
                                <div class="text-muted">
                                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </div>




@endsection
