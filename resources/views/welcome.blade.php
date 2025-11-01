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
                            <a class="nav-link" href="#laporan-bku">
                                <span class="nav-link-title">Laporan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">
                                <span class="nav-link-title">Tentang</span>
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
                    <img src="https://jimpitan.remaked.web.id/illustrasi/jimpitan.png" alt="Hero illustration"
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

    <!-- Laporan BKU Section -->
    <section id="laporan-bku" class="py-6 py-lg-8 bg-light">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-6">
                    <span class="badge bg-success-lt text-success mb-3">Laporan</span>
                    <h2 class="display-6 fw-bold mb-4">Laporan BKU Bulanan</h2>
                    <p class="text-muted lead mb-4">
                        Data keuangan jimpitan warga RT 63 Kedungtangkil, ditampilkan secara interaktif dan diperbarui
                        secara realtime.
                    </p>

                    <!-- Filter -->
                    <div class="d-flex gap-2 mb-4">
                        <select id="bulan" class="form-select w-auto">
                            @foreach (range(1, 12) as $b)
                                <option value="{{ $b }}" {{ $b == date('n') ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                        <select id="tahun" class="form-select w-auto">
                            @foreach (range(2023, date('Y') + 1) as $t)
                                <option value="{{ $t }}" {{ $t == date('Y') ? 'selected' : '' }}>
                                    {{ $t }}</option>
                            @endforeach
                        </select>
                        <button onclick="loadBku()" class="btn btn-success">Tampilkan</button>
                    </div>

                    <!-- Ringkasan -->
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <div class="text-muted small">Total Masuk</div>
                                    <div id="total-masuk" class="fw-bold fs-5">0</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <div class="text-muted small">Total Keluar</div>
                                    <div id="total-keluar" class="fw-bold fs-5">0</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <div class="text-muted small">Saldo Awal</div>
                                    <div id="saldo-awal" class="fw-bold fs-5">0</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <div class="text-muted small">Saldo Akhir</div>
                                    <div id="saldo-akhir" class="fw-bold fs-5">0</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom kanan tabel -->
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-success text-white">Detail Transaksi</div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Uraian</th>
                                            <th class="text-end">Masuk</th>
                                            <th class="text-end">Keluar</th>
                                            <th class="text-end">Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody id="bku-items">
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Memuat data...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Fungsi format angka ribuan
            function formatNumber(num) {
                return new Intl.NumberFormat('id-ID').format(num);
            }

            // Fungsi load BKU
            async function loadBku() {
                let bulan = document.getElementById("bulan").value;
                let tahun = document.getElementById("tahun").value;

                let url = `/laporan/bku/json?bulan=${bulan}&tahun=${tahun}`;

                try {
                    let res = await fetch(url);
                    if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
                    let data = await res.json();

                    // Update ringkasan
                    document.getElementById("total-masuk").innerText = formatNumber(data.total_masuk ?? 0);
                    document.getElementById("total-keluar").innerText = formatNumber(data.total_keluar ?? 0);
                    document.getElementById("saldo-awal").innerText = formatNumber(data.saldo_awal ?? 0);
                    document.getElementById("saldo-akhir").innerText = formatNumber(data.saldo_akhir ?? 0);

                    // Update tabel
                    let tbody = document.getElementById("bku-items");
                    tbody.innerHTML = "";

                    if (!data.items || data.items.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">Tidak ada data</td></tr>`;
                    } else {
                        data.items.forEach(item => {
                            let tanggal = item.tanggal ? new Date(item.tanggal).toLocaleDateString('id-ID') : '-';
                            tbody.innerHTML += `
                        <tr>
                            <td>${tanggal}</td>
                            <td>${item.uraian ?? '-'}</td>
                            <td class="text-end">${formatNumber(item.dana_masuk ?? 0)}</td>
                            <td class="text-end">${formatNumber(item.dana_keluar ?? 0)}</td>
                            <td class="text-end">${formatNumber(item.saldo ?? 0)}</td>
                        </tr>
                    `;
                        });
                    }

                } catch (err) {
                    console.error("Gagal load data BKU:", err);
                    let tbody = document.getElementById("bku-items");
                    tbody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">Gagal memuat data</td></tr>`;
                }
            }

            // Load pertama kali
            loadBku();

            // Auto refresh tiap 15 detik
            setInterval(loadBku, 15000);
        </script>

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
                    <img src="https://jimpitan.remaked.web.id/illustrasi/royong.png" alt="Community illustration"
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
                        <li class="list-inline-item">
                            <a href="https://sinaucms.web.id" target="_blank" class="link-secondary">
                                Dibuat dengan <span class="text-danger">❤️</span> oleh Mas Boe - Sinau CMS
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                    <p class="text-muted mb-0">
                        Copyright © 2025 - {{ date('Y') }} Jimpitan63. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>


    <!-- Tabler Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
</body>

</html>
