<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Selamat Datang di Siesde')</title>
    <!-- Tabler Core CSS -->
    @vite('resources/css/app.css')
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #206bc4 0%, #8256d0 100%);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        .dark .hero-gradient {
            background: linear-gradient(135deg, #1c3f6e 0%, #4d2a7a 100%);
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
                    <span class="text-primary">Siesde</span>
                </a>
            </h1>

            <div class="collapse navbar-collapse" id="navbar-menu">
                <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#verifikasi">
                                <span class="nav-link-title">Verifikasi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#pricing">
                                <span class="nav-link-title">Pricing</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">
                                <span class="nav-link-title">Contact</span>
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
                        <a href="{{ route('login') }}" class="btn">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary ms-2">
                                Daftar
                            </a>
                        @endif
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
                    <h1 class="display-4 fw-bold mb-4">Sistem Informasi Digital <span class="text-yellow">Siesde</span>
                    </h1>
                    <p class="lead mb-4">Sistem informasi manajemen untuk mengelola Buku Induk Peserta Didik.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('register') }}" class="btn btn-lg btn-yellow">Masuk</a>
                        <a href="#features" class="btn btn-lg btn-outline-white">Verifikasi Data</a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="https://sdnkedungrejo.sch.id/illustrations/undraw.svg" alt="Hero illustration"
                        class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-6 py-lg-8 bg-body">
        <div class="container">
            <div class="text-center mb-6">
                <span class="badge bg-primary-lt text-primary mb-3">Fitur Unggulan</span>
                <h2 class="display-5 fw-bold mb-3">Manajemen Buku Induk Digital</h2>
                <p class="text-muted lead">Kelola data peserta didik secara lengkap, akurat, dan efisien</p>
            </div>

            <div class="row g-4">
                <!-- Feature 1: Complete Student Data -->
                <div class="col-md-4">
                    <div class="card card-hover h-100">
                        <div class="card-body p-4 text-center">
                            <div class="feature-icon bg-primary bg-opacity-10 text-primary mb-4 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-search"
                                    width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h1.5" />
                                    <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                    <path d="M20.2 20.2l1.8 1.8" />
                                </svg>
                            </div>
                            <h3 class="h4 mb-3">Data Peserta Didik Lengkap</h3>
                            <p class="text-muted mb-4">Rekam seluruh data siswa mulai dari identitas pribadi, data
                                orang tua, hingga perkembangan akademik dalam satu sistem terpadu.</p>
                            <ul class="list-unstyled text-start text-muted">
                                <li class="mb-2"><span class="badge bg-primary-lt text-primary me-2">✓</span>
                                    Biodata lengkap</li>
                                <li class="mb-2"><span class="badge bg-primary-lt text-primary me-2">✓</span>
                                    Riwayat pendidikan</li>
                                <li class="mb-0"><span class="badge bg-primary-lt text-primary me-2">✓</span> Data
                                    kesehatan</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Feature 2: Academic Records -->
                <div class="col-md-4">
                    <div class="card card-hover h-100">
                        <div class="card-body p-4 text-center">
                            <div class="feature-icon bg-green bg-opacity-10 text-green mb-4 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-school"
                                    width="32" height="32" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" />
                                    <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" />
                                </svg>
                            </div>
                            <h3 class="h4 mb-3">Rekam Jejak Akademik</h3>
                            <p class="text-muted mb-4">Pantau perkembangan belajar siswa dengan pencatatan nilai,
                                prestasi, dan laporan pendidikan yang komprehensif.</p>
                            <ul class="list-unstyled text-start text-muted">
                                <li class="mb-2"><span class="badge bg-green-lt text-green me-2">✓</span> Raport
                                    digital</li>
                                <li class="mb-2"><span class="badge bg-green-lt text-green me-2">✓</span> Nilai per
                                    semester</li>
                                <li class="mb-0"><span class="badge bg-green-lt text-green me-2">✓</span> Prestasi
                                    non-akademik</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Feature 3: Reporting -->
                <div class="col-md-4">
                    <div class="card card-hover h-100">
                        <div class="card-body p-4 text-center">
                            <div class="feature-icon bg-purple bg-opacity-10 text-purple mb-4 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-report-analytics" width="32"
                                    height="32" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                    <path
                                        d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                    <path d="M9 17v-5" />
                                    <path d="M12 17v-1" />
                                    <path d="M15 17v-3" />
                                </svg>
                            </div>
                            <h3 class="h4 mb-3">Pelaporan Otomatis</h3>
                            <p class="text-muted mb-4">Hasilkan berbagai laporan yang dibutuhkan sekolah berupa Buku
                                Induk.</p>
                            <ul class="list-unstyled text-start text-muted">
                                <li class="mb-2"><span class="badge bg-purple-lt text-purple me-2">✓</span>
                                    Cetak langsung</li>
                                <li class="mb-2"><span class="badge bg-purple-lt text-purple me-2">✓</span>
                                    PDF terenkripsi</li>
                                <li class="mb-0"><span class="badge bg-purple-lt text-purple me-2">✓</span>
                                    Verifikasi PDF</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-6">
                <a href="#" class="btn btn-primary btn-lg">
                    Lihat Semua Fitur
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right"
                        width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l14 0" />
                        <path d="M13 18l6 -6" />
                        <path d="M13 6l6 6" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-6 py-lg-8 bg-blue-lt">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="h1 mb-3">Ready to get started?</h2>
                    <p class="lead text-muted mb-4 mb-lg-0">Join thousands of satisfied users today.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">Sign Up Free</a>
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
                        <li class="list-inline-item"><a href="#" class="link-secondary">Documentation</a></li>
                        <li class="list-inline-item"><a href="#" class="link-secondary">License</a></li>
                        <li class="list-inline-item"><a href="#" class="link-secondary">Changelog</a></li>
                    </ul>
                </div>
                <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                    <p class="text-muted mb-0">Copyright © 2023 YourApp. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Tabler Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
</body>

</html>
