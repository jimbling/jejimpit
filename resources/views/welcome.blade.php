<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Jimpitan 63 - Kedungtangkil')</title>
    <!-- Tabler Core CSS -->
    @vite('resources/css/app.css')
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #206bc4 0%, #8256d0 100%);
        }

        .jimpitan-pattern {
            background-color: #206bc4;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        .stat-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .leader-item {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 8px;
            background: #f8f9fa;
            transition: background 0.2s ease;
        }

        .leader-item:hover {
            background: #e9ecef;
        }

        .rank-badge {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            margin-right: 12px;
        }

        .rank-1 {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            color: #000;
        }

        .rank-2 {
            background: linear-gradient(135deg, #C0C0C0 0%, #A9A9A9 100%);
            color: #000;
        }

        .rank-3 {
            background: linear-gradient(135deg, #CD7F32 0%, #A55B28 100%);
            color: #fff;
        }

        .rank-other {
            background: #f0f0f0;
            color: #495057;
        }

        .progress-thin {
            height: 8px;
            border-radius: 4px;
        }

        .dark .hero-gradient {
            background: linear-gradient(135deg, #1c3f6e 0%, #4d2a7a 100%);
        }

        .dark .jimpitan-pattern {
            background-color: #1c3f6e;
        }

        .dark .leader-item {
            background: #2a2c31;
        }

        .dark .leader-item:hover {
            background: #34363d;
        }

        .dark .rank-other {
            background: #3a3d44;
            color: #e9ecef;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let theme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', theme);
        });
    </script>
    @php $favicon = system_setting('favicon'); @endphp

    @if ($favicon)
        <link rel="icon" href="{{ asset('storage/' . $favicon) }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ asset('storage/' . $favicon) }}" type="image/x-icon">
    @else
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    @endif
</head>

<body class="d-flex flex-column">

    <!-- Header -->
    <header class="navbar navbar-expand-md navbar-light d-print-none sticky-top">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                <a href="/">
                    <span class="text-primary">Jimpitan63</span>
                </a>
            </h1>

            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#stats">
                                <span class="nav-link-title">Statistik</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#leaders">
                                <span class="nav-link-title">Peringkat</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">
                                <span class="nav-link-title">Tentang</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">
                                <span class="nav-link-title">Kontak</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="ms-md-3 pe-3 pe-md-0">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            Masuk
                        </a>

                    @endauth
                @endif
            </div>
        </div>
    </header>


    <!-- Hero Section -->
    <section class="hero-gradient text-white py-6 py-lg-8">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Sistem Kelola <span class="text-warning">Jimpitan 63</span>
                    </h1>
                    <p class="lead mb-4">Membangun kebersamaan dan kemandirian warga melalui sistem jimpitan digital di
                        Kedungtangkil RT 63.</p>
                    <div class="d-flex gap-3">

                        <a href="#stats" class="btn btn-lg btn-outline-light">Lihat Statistik</a>
                    </div>
                </div>
                <div class="col-lg-6 ">
                    <img src="https://jimpitan.sinaucms.web.id/illustrasi/jimpitan.png" alt="Hero illustration"
                        class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="py-6 py-lg-8 bg-body">
        <div class="container">
            <div class="text-center mb-6">
                <span class="badge bg-primary-lt text-primary mb-3">Statistik Jimpitan</span>
                <h2 class="display-5 fw-bold mb-3">Kinerja Jimpitan RT 63</h2>
                <p class="text-muted lead">Pantau perkembangan kegiatan jimpitan warga kami</p>
            </div>

            <div class="row g-4">
                <!-- Total Jimpitan -->
                <div class="col-md-4">
                    <div class="card stat-card h-100">
                        <div class="card-body p-4 text-center">

                            <h3 class="h4 mb-3">Total Jimpitan Tahun Ini</h3>
                            <div class="display-4 fw-bold text-primary mb-2">
                                Rp {{ number_format($totalDana, 0, ',', '.') }}
                            </div>
                            <p class="text-muted">
                                Terkumpul dari {{ $jumlahTransaksi }} transaksi jimpitan
                            </p>
                            <div class="progress progress-thin mt-3">
                                <div class="progress-bar bg-primary" style="width: {{ $persenTarget }}%"></div>
                            </div>
                            <small class="text-muted">
                                {{ $persenTarget }}% dari target Rp {{ number_format($targetDana, 0, ',', '.') }}
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Rata-rata Per Hari -->
                <div class="col-md-4">
                    <div class="card stat-card h-100">
                        <div class="card-body p-4 text-center">

                            <h3 class="h4 mb-3">Rata-rata Harian</h3>
                            <div class="display-4 fw-bold text-green mb-2">
                                Rp {{ number_format($rataBulanIni, 0, ',', '.') }}
                            </div>
                            <p class="text-muted">Rata-rata terkumpul per hari</p>
                            <div class="mt-4 pt-2">
                                <span class="badge bg-green-lt text-green">
                                    @if ($selisih >= 0)
                                        <svg class="icon icon-tabler icon-tabler-arrow-up" ...></svg>
                                        {{ number_format($persenKenaikan, 1) }}% dari bulan lalu
                                    @else
                                        <svg class="icon icon-tabler icon-tabler-arrow-down" ...></svg>
                                        {{ number_format(abs($persenKenaikan), 1) }}% turun dari bulan lalu
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Partisipasi Warga -->
                <div class="col-md-4">
                    <div class="card stat-card h-100">
                        <div class="card-body p-4 text-center">

                            <h3 class="h4 mb-3">Tingkat Partisipasi</h3>
                            <div class="display-4 fw-bold text-purple mb-2">
                                {{ $persenPartisipasi }}%
                            </div>
                            <p class="text-muted">Warga berpartisipasi aktif</p>
                            <div class="progress progress-thin mt-3">
                                <div class="progress-bar bg-purple" style="width: {{ $persenPartisipasi }}%"></div>
                            </div>
                            <small class="text-muted">
                                {{ $jumlahPartisipan }} dari {{ $totalWarga }} KK berpartisipasi
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Leaders Section -->
    <section id="leaders" class="py-6 py-lg-8 jimpitan-pattern">
        <div class="container">
            <div class="text-center mb-6">
                <span class="badge bg-white text-primary mb-3">Peringkat Warga</span>
                <h2 class="display-5 fw-bold mb-3 text-white">Top Performers Jimpitan</h2>
                <p class="text-white-50 lead">Apresiasi untuk warga yang paling aktif berpartisipasi</p>
            </div>

            <div class="row g-4">
                <!-- Top Penyetor -->
                <div class="col-md-6">
                    <div class="card stat-card h-100">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title mb-0">Top 10 Partisipan Jimpitan</h3>
                        </div>
                        <div class="card-body p-3">
                            <div class="list-group list-group-flush">
                                @foreach ($topWarga as $index => $warga)
                                    <div class="leader-item d-flex align-items-center">
                                        <div
                                            class="rank-badge {{ $index < 3 ? 'rank-' . ($index + 1) : 'rank-other' }}">
                                            {{ $index + 1 }}</div>
                                        <div class="flex-fill">
                                            <div class="fw-bold">{{ $warga->warga->nama_kk ?? 'Tanpa Nama' }}</div>
                                            <div class="text-muted small">Rp
                                                {{ number_format($warga->warga->transaksiJimpitan->where('tanggal', '>=', now()->startOfYear())->sum('jumlah'), 0, ',', '.') }}


                                            </div>
                                        </div>
                                        <div class="badge bg-primary-lt text-primary">{{ $warga->total_transaksi }}
                                            setoran</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Petugas & Tidak Aktif -->
                <div class="col-md-6">
                    <!-- Petugas Teraktif -->
                    <div class="card stat-card mb-4">
                        <div class="card-header bg-success text-white">
                            <h3 class="card-title mb-0">Petugas Jimpitan Teraktif</h3>
                        </div>
                        <div class="card-body p-3">
                            <div class="list-group list-group-flush">
                                @foreach ($topPetugas as $index => $petugas)
                                    <div class="leader-item d-flex align-items-center">
                                        <div class="rank-badge rank-{{ $index + 1 }}">{{ $index + 1 }}</div>
                                        <div class="flex-fill">
                                            <div class="fw-bold">
                                                {{ $petugas->user->name ?? 'Petugas #' . $petugas->user_id }}</div>
                                            <div class="text-muted small">{{ $petugas->total_transaksi }} hari
                                                bertugas</div>
                                        </div>
                                        <div class="badge bg-success-lt text-success">
                                            {{ $index == 0 ? 'Top Collector' : 'Aktif' }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Warga Tidak Aktif -->
                    <div class="card stat-card">
                        <div class="card-header bg-orange text-white">
                            <h3 class="card-title mb-0">Perlu Perhatian Khusus</h3>
                        </div>
                        <div class="card-body p-3">
                            <div class="list-group list-group-flush">
                                @foreach ($wargaRendah as $index => $warga)
                                    <div class="leader-item d-flex align-items-center">
                                        <div class="rank-badge rank-other">{{ $index + 1 }}</div>
                                        <div class="flex-fill">
                                            <div class="fw-bold">{{ $warga->nama }}</div>
                                            <div class="text-muted small">{{ $warga->total_transaksi }} partisipasi
                                                (tahun
                                                ini)
                                            </div>
                                        </div>
                                        <div class="badge bg-orange-lt text-orange">
                                            @if ($warga->total_transaksi == 0)
                                                Tidak aktif
                                            @elseif($warga->total_transaksi <= 2)
                                                Sangat jarang
                                            @else
                                                Jarang
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- About Section -->
    <section id="about" class="py-6 py-lg-8 bg-body">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <span class="badge bg-primary-lt text-primary mb-3">Tentang Kami</span>
                    <h2 class="display-5 fw-bold mb-4">Jimpitan: Tradisi Gotong Royong Warga</h2>
                    <p class="text-muted lead mb-4">Jimpitan adalah tradisi gotong royong warga RT 63 Kedungtangkil
                        dalam bentuk iuran sukarela yang dikumpulkan secara berkala untuk membiayai kegiatan
                        kemasyarakatan.</p>

                </div>
                <div class="col-lg-6 ">
                    <img src="https://jimpitan.sinaucms.web.id/illustrasi/royong.png" alt="Community illustration"
                        class="img-fluid">
                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="footer footer-transparent py-6">
        <div class="container">
            <div class="row text-center align-items-center flex-row-reverse">
                <div class="col-lg-auto ms-lg-auto">
                    <ul class="list-inline list-inline-dots mb-0">
                        <li class="list-inline-item"><a href="#stats" class="link-secondary">Statistik</a></li>
                        <li class="list-inline-item"><a href="#leaders" class="link-secondary">Peringkat</a></li>
                        <li class="list-inline-item"><a href="#about" class="link-secondary">Tentang</a></li>
                        <li class="list-inline-item"><a href="#contact" class="link-secondary">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                    <p class="text-muted mb-0">Copyright © 2023 Jimpitan63. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Tabler Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
</body>

</html>
