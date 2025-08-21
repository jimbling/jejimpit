<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard Petugas' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <!-- Tom Select JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <!-- Tambahkan container toast di bawah body atau div utama -->
    <div id="toast-container" class="fixed top-5 right-5 flex flex-col gap-3 z-50"></div>

    <!-- Header -->
    <header class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold">Selamat Datang</h1>
                <p class="text-sm">{{ Auth::user()->name }}</p>
            </div>
            <div class="relative">
                <!-- Icon User -->
                <button id="userMenuBtn"
                    class="h-8 w-8 rounded-full bg-blue-400 flex items-center justify-center focus:outline-none">
                    <i class="fas fa-user"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="userDropdown"
                    class="absolute right-0 mt-2 w-40 bg-white text-gray-800 rounded-lg shadow-lg py-2 hidden z-50">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100 flex items-center space-x-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto p-4 mb-20">
        @yield('content')
    </main>

    <!-- Modern Footer Navigation -->
    <footer class="fixed bottom-0 left-0 right-0 bg-white shadow-2xl border-t border-blue-100 z-40 rounded-t-2xl">
        <div class="container mx-auto relative">
            <div class="flex justify-around items-center p-2 relative">
                <!-- Navigation Indicator -->
                <div class="nav-indicator absolute bottom-1 rounded-full"></div>

                <!-- Beranda -->
                <a href="{{ route('petugas.home') }}"
                    class="nav-item flex flex-col items-center text-gray-500 p-3 {{ request()->routeIs('petugas.home') ? 'active' : '' }}"
                    data-index="0">
                    <div class="nav-icon relative mb-1 transition-transform duration-300">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M3 9L12 2L21 9V20C21 20.53 20.79 21.04 20.41 21.41C20.04 21.79 19.53 22 19 22H5C4.47 22 3.96 21.79 3.58 21.41C3.21 21.04 3 20.53 3 20V9Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 22V12H15V22" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="nav-label text-xs font-medium">Beranda</span>
                </a>

                <!-- Njimpit - Enhanced Design -->
                <a id="menu-njimpit" href="{{ route('petugas.jimpitan.create') }}"
                    class="nav-item njimpit-btn flex flex-col items-center p-3 -mt-8 relative group">
                    <!-- Outer Ring Effect -->
                    <div
                        class="absolute -inset-2 bg-blue-100 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>

                    <!-- Main Button -->
                    <div
                        class="relative z-10 bg-gradient-to-br from-blue-500 to-blue-700 p-4 rounded-2xl shadow-xl transform transition-all duration-300 group-hover:scale-110 group-hover:shadow-2xl group-active:scale-105">
                        <!-- Icon Container -->
                        <div class="relative">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                                class="text-white transform group-hover:rotate-90 transition-transform duration-500">
                                <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                            <!-- Micro Dot Indicator -->
                            <div
                                class="absolute -top-1 -right-1 w-2 h-2 bg-green-400 rounded-full border-2 border-white">
                            </div>
                        </div>

                        <!-- Subtle Shine Effect -->
                        <div class="absolute top-0 left-0 w-full h-full overflow-hidden rounded-2xl">
                            <div
                                class="absolute -inset-10 bg-gradient-to-r from-transparent via-white/20 to-transparent -skew-x-12 group-hover:animate-shine">
                            </div>
                        </div>
                    </div>

                    <!-- Floating Label -->
                    <span
                        class="nav-label text-xs font-semibold text-blue-700 mt-2 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full shadow-sm transform transition-all duration-300 group-hover:translateY(-2px)">
                        Njimpit
                    </span>

                    <!-- Tooltip on Hover -->
                    <div
                        class="absolute -top-12 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs py-2 px-3 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none whitespace-nowrap">
                        Tambah Transaksi Jimpitan
                        <div
                            class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1 w-2 h-2 bg-gray-900 rotate-45">
                        </div>
                    </div>
                </a>

                <!-- Profil -->
                <a href="{{ route('petugas.profile.edit') }}"
                    class="nav-item flex flex-col items-center text-gray-500 p-3 {{ request()->routeIs('petugas.profile.*') ? 'active' : '' }}"
                    data-index="2">
                    <div class="nav-icon relative mb-1 transition-transform duration-300">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M20 21V19C20 17.94 19.58 16.92 18.83 16.17C18.08 15.42 17.06 15 16 15H8C6.94 15 5.92 15.42 5.17 16.17C4.42 16.92 4 17.94 4 19V21"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M12 11C14.21 11 16 9.21 16 7C16 4.79 14.21 3 12 3C9.79 3 8 4.79 8 7C8 9.21 9.79 11 12 11Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <span class="nav-label text-xs font-medium">Profil</span>
                </a>
            </div>
        </div>
    </footer>

    <style>
        .nav-indicator {
            height: 3px;
            border-radius: 9999px;
            background: linear-gradient(to right, #3B82F6, #60A5FA);
            position: absolute;
            bottom: 0.25rem;
            left: 0;
            transition: all 0.35s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .nav-item {
            position: relative;
            transition: transform 0.3s ease;
        }

        .nav-item.active .nav-icon {
            transform: scale(1.2);
            filter: drop-shadow(0 2px 6px rgba(59, 130, 246, 0.4));
        }

        .nav-label {
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(6px);
        }

        .nav-item.active .nav-label {
            opacity: 1;
            transform: translateY(0);
        }

        .nav-item:hover {
            transform: translateY(-2px);
        }

        .nav-item:hover .nav-icon {
            transform: scale(1.1);
        }

        /* Khusus untuk tombol Njimpit */
        .njimpit-btn {
            z-index: 10;
        }

        /* Animasi shine effect */
        @keyframes shine {
            0% {
                transform: translateX(-100%) skewX(-12deg);
            }

            100% {
                transform: translateX(200%) skewX(-12deg);
            }
        }

        .animate-shine {
            animation: shine 1.5s ease-in-out infinite;
        }

        /* Micro pulse untuk dot indicator */
        @keyframes micro-pulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.8;
                transform: scale(1.1);
            }
        }

        .bg-green-400 {
            animation: micro-pulse 2s ease-in-out infinite;
        }

        /* Smooth transitions untuk semua efek */
        .njimpit-btn * {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navItems = document.querySelectorAll('.nav-item[data-index]');
            const navIndicator = document.querySelector('.nav-indicator');

            function updateIndicator() {
                const activeItem = document.querySelector('.nav-item.active[data-index]');
                if (activeItem && navIndicator) {
                    const icon = activeItem.querySelector('svg');
                    if (!icon) return;

                    const iconRect = icon.getBoundingClientRect();
                    const parentRect = activeItem.parentElement.getBoundingClientRect();

                    navIndicator.style.left = `${iconRect.left - parentRect.left}px`;
                    navIndicator.style.width = `${iconRect.width}px`;
                }
            }

            updateIndicator();

            navItems.forEach(item => {
                item.addEventListener('click', () => {
                    navItems.forEach(i => i.classList.remove('active'));
                    item.classList.add('active');
                    updateIndicator();
                });
            });

            window.addEventListener('resize', updateIndicator);

            // Tambahkan efek suara klik (opsional)
            const njimpitBtn = document.getElementById('menu-njimpit');
            if (njimpitBtn) {
                njimpitBtn.addEventListener('click', function(e) {
                    // Haptic feedback simulation
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Hapus alert otomatis setelah 5 detik
            const alertEl = document.getElementById('alert-jimpitan');
            if (alertEl) {
                setTimeout(() => {
                    alertEl.remove();
                }, 10000);
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userBtn = document.getElementById('userMenuBtn');
            const dropdown = document.getElementById('userDropdown');

            userBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
            });

            // Tutup dropdown saat klik di luar
            document.addEventListener('click', function() {
                if (!dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.getElementById('alert-checkin');
            const title = card.querySelector('h2');
            const message = card.querySelector('p');
            const btn = document.getElementById('checkin-btn');

            fetch('/kehadiran-status', {
                    credentials: 'same-origin'
                })
                .then(res => res.json())
                .then(data => {
                    // pastikan card selalu tampil
                    card.className = 'block p-4 rounded-xl shadow max-w-md mx-auto';

                    if (data.sudah_checkin) {
                        card.classList.add('bg-green-50');
                        title.textContent = '✅ Check-in sudah dilakukan';
                        message.textContent =
                            'Terima kasih, Anda sudah melakukan check-in hari ini. Silakan lanjutkan entri data Jimpitan.';
                        btn.style.display = 'none'; // pakai style.display lebih aman
                    } else {
                        card.classList.add('bg-yellow-50');
                        title.textContent = '⚠️ Perhatian!';
                        message.textContent =
                            'Anda belum melakukan check-in untuk hari ini. Harap lakukan check-in sebelum entri data Jimpitan.';
                        btn.style.display = 'inline-block';

                    }
                })
                .catch(err => console.error(err));
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menu = document.getElementById('menu-njimpit');

            fetch('/kehadiran-status', {
                    credentials: 'same-origin'
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.sudah_checkin) {
                        // disable link
                        menu.classList.add('opacity-50', 'pointer-events-none'); // buat seolah disable
                        menu.title = 'Anda harus check-in terlebih dahulu';
                    }
                });
        });
    </script>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-5 right-5 bg-red-500 text-white px-4 py-2 rounded shadow">
            {{ session('error') }}
        </div>
    @endif




</body>

</html>
