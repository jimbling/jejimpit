@extends('layouts.petugas')

@section('content')
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white flex flex-col">

        <!-- Header dengan tombol kembali -->
        <div class="p-5 bg-white border-b border-gray-200 flex items-center shadow-sm">
            <a href="{{ route('petugas.jimpitan.index') }}" class="text-blue-600 mr-4">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <h1 class="text-xl font-bold text-gray-800">Tambah Transaksi Jimpitan</h1>
        </div>

        <!-- Form Container -->
        <div class="flex-1 p-5 overflow-y-auto">
            <form action="{{ route('petugas.jimpitan.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Pilih Warga -->
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <label for="warga_id" class="block text-sm font-medium text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-user text-blue-500 mr-2"></i>
                        Pilih Warga
                    </label>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Dropdown Warga -->
                        <div class="relative">
                            <select id="warga_id" name="warga_id"
                                class="w-full py-3 px-4 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors appearance-none bg-white"
                                required>
                                <option value="" selected disabled>-- Pilih Warga --</option>
                                @foreach ($wargas as $warga)
                                    <option value="{{ $warga->id }}" data-kode="{{ $warga->kode_unik }}">
                                        {{ $warga->nama_kk }} ({{ $warga->kode_unik }})
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>

                        <!-- Input Kode Unik + Tombol Scan -->
                        <div class="relative">
                            <input type="text" id="kode_unik" placeholder="Masukkan Kode Unik / Scan QR"
                                class="w-full py-3 pl-4 pr-12 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors" />

                            <!-- Tombol scan QR -->
                            <button type="button" id="scan-qr-btn"
                                class="absolute inset-y-0 right-0 px-3 flex items-center text-blue-600 hover:text-blue-800">
                                <i class="fas fa-qrcode text-lg"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Modal QR Scanner -->
                    <!-- Modal QR Scanner -->
                    <div id="qr-scanner-modal" class="fixed inset-0 z-50 hidden">
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

                        <!-- Modal Box -->
                        <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
                            <div class="bg-white rounded-2xl shadow-lg w-full max-w-md overflow-hidden">

                                <!-- Header -->
                                <div class="flex items-center justify-between px-4 py-3 border-b">
                                    <h3 class="text-lg font-semibold text-gray-800">📷 Scan QR Code</h3>
                                    <button type="button" id="close-qr-scanner"
                                        class="p-1 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full transition">
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>

                                <!-- QR Reader -->
                                <div class="p-4">
                                    <div id="qr-reader"
                                        class="w-full bg-gray-100 rounded-xl overflow-hidden border-2 border-blue-400">
                                    </div>
                                    <p class="text-sm text-gray-600 text-center mt-3">
                                        Arahkan kamera ke QR Code untuk memindai
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <!-- Tanggal -->
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-calendar text-blue-500 mr-2"></i>
                        Tanggal Transaksi
                    </label>
                    <div class="relative">
                        <input type="date" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}"
                            class="w-full py-3 px-4 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors">
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                </div>

                <!-- Jumlah -->
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-money-bill-wave text-blue-500 mr-2"></i>
                        Jumlah Jimpitan
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">Rp</span>
                        </div>
                        <input type="text" id="jumlah" name="jumlah" placeholder="0"
                            class="w-full py-3 pl-10 pr-4 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors"
                            required>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Masukkan jumlah, contoh: 5.000</p>
                </div>

                <!-- Keterangan -->
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-sticky-note text-blue-500 mr-2"></i>
                        Keterangan (Opsional)
                    </label>
                    <textarea id="keterangan" name="keterangan" rows="3" placeholder="Contoh: Jimpitan bulan September 2023"
                        class="w-full py-3 px-4 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-colors resize-none"></textarea>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-between space-x-3 mt-8 sticky bottom-5 bg-white p-3 rounded-xl shadow-lg">
                    <a href="{{ route('petugas.jimpitan.index') }}"
                        class="flex-1 py-3 px-4 border border-gray-300 text-gray-700 rounded-lg text-center font-medium flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i> Batal
                    </a>
                    <button type="submit"
                        class="flex-1 py-3 px-4 bg-blue-600 text-white rounded-lg font-medium shadow-md hover:bg-blue-700 transition-colors flex items-center justify-center">
                        <i class="fas fa-check-circle mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-5 right-5 flex flex-col gap-3 z-50"></div>

    <style>
        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0;
            position: absolute;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        select {
            background-image: none;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
        }

        @keyframes slide-in {
            0% {
                opacity: 0;
                transform: translateX(100%);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-slide-in {
            animation: slide-in 0.3s ease-out forwards;
        }
    </style>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // === Default tanggal hari ini ===
            const tanggalInput = document.getElementById('tanggal');
            if (tanggalInput && !tanggalInput.value) {
                tanggalInput.value = new Date().toISOString().split('T')[0];
            }

            // === Format ribuan untuk jumlah ===
            const jumlahInput = document.getElementById('jumlah');
            if (jumlahInput) {
                jumlahInput.addEventListener('input', function() {
                    let value = this.value.replace(/\D/g, '');
                    this.value = value ? new Intl.NumberFormat('id-ID').format(value) : '';
                });

                if (jumlahInput.form) {
                    jumlahInput.form.addEventListener('submit', function() {
                        jumlahInput.value = jumlahInput.value.replace(/\./g, '').replace(/,/g, '');
                    });
                }
            }

            // === Tom Select Init ===
            const wargaSelect = new TomSelect("#warga_id", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "-- Pilih Warga --",
            });

            const kodeInput = document.getElementById("kode_unik");
            const scanBtn = document.getElementById("scan-qr-btn");
            const qrModal = document.getElementById("qr-scanner-modal");
            const closeQrScanner = document.getElementById("close-qr-scanner");
            let html5QrCode = null;

            // === Toast Function ===
            function showToast(message, type = "error") {
                const container = document.getElementById("toast-container");
                if (!container) return;

                const colors = {
                    error: "bg-red-500",
                    success: "bg-green-500",
                    info: "bg-blue-500"
                };

                const toast = document.createElement("div");
                toast.className =
                    `${colors[type]} text-white px-4 py-3 rounded-lg shadow-lg flex items-center justify-between transition-transform duration-300 transform translate-x-full`;
                toast.innerHTML = `
                <span class="flex-1">${message}</span>
                <button class="ml-4 text-white font-bold" onclick="this.parentElement.remove()">×</button>
            `;

                container.appendChild(toast);

                // Trigger animation
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                    toast.classList.add('translate-x-0');
                }, 10);

                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }

            // === Update input kode unik saat select berubah ===
            wargaSelect.on("change", function(value) {
                const opt = document.querySelector(`#warga_id option[value="${value}"]`);
                if (opt && kodeInput) {
                    kodeInput.value = opt.dataset.kode || "";
                }
            });

            // === Blur-only check kode unik ===
            if (kodeInput) {
                kodeInput.addEventListener("blur", function() {
                    const kode = this.value.trim().toUpperCase();
                    const opt = document.querySelector(`#warga_id option[data-kode="${kode}"]`);

                    if (opt) {
                        wargaSelect.setValue(opt.value, true);
                    } else if (kode.length > 0) {
                        showToast("Kode unik tidak ditemukan!", "error");
                        wargaSelect.setValue("", true);
                    }
                });
            }

            // === QR Scan Functionality ===
            if (scanBtn && qrModal) {
                scanBtn.addEventListener("click", function() {
                    // Tampilkan modal
                    qrModal.classList.remove('hidden');

                    // Inisialisasi scanner
                    setTimeout(() => {
                        const qrRegion = document.getElementById("qr-reader");
                        if (qrRegion) {
                            html5QrCode = new Html5Qrcode("qr-reader");

                            Html5Qrcode.getCameras().then(cameras => {
                                if (cameras && cameras.length) {
                                    // Prioritaskan kamera belakang jika ada
                                    const cameraId = cameras.length > 1 ? cameras[1].id :
                                        cameras[0].id;

                                    html5QrCode.start(
                                        cameraId, {
                                            fps: 10,
                                            qrbox: {
                                                width: 250,
                                                height: 250
                                            }
                                        },
                                        (decodedText, decodedResult) => {
                                            // QR Code berhasil dipindai
                                            if (kodeInput) {
                                                kodeInput.value = decodedText.trim()
                                                    .toUpperCase();

                                                const opt = document.querySelector(
                                                    `#warga_id option[data-kode="${kodeInput.value}"]`
                                                );
                                                if (opt) {
                                                    wargaSelect.setValue(opt.value,
                                                        true);
                                                    showToast(
                                                        "QR Code berhasil dipindai!",
                                                        "success");
                                                } else {
                                                    showToast(
                                                        "Kode unik tidak ditemukan!",
                                                        "error");
                                                }
                                            }

                                            // Stop scanner dan tutup modal
                                            html5QrCode.stop().then(() => {
                                                qrModal.classList.add('hidden');
                                            }).catch((err) => {
                                                console.error(
                                                    "Gagal menghentikan scanner:",
                                                    err);
                                                qrModal.classList.add('hidden');
                                            });
                                        },
                                        (errorMessage) => {
                                            // Error handling opsional
                                        }
                                    ).catch(err => {
                                        console.error("Gagal memulai scanner:",
                                            err);
                                        showToast("Tidak dapat mengakses kamera",
                                            "error");
                                        qrModal.classList.add('hidden');
                                    });
                                }
                            }).catch(err => {
                                console.error("Tidak dapat mendapatkan daftar kamera:",
                                    err);
                                showToast("Tidak dapat mengakses kamera", "error");
                                qrModal.classList.add('hidden');
                            });
                        }
                    }, 100);
                });
            }

            // Tutup modal scanner
            if (closeQrScanner) {
                closeQrScanner.addEventListener("click", function() {
                    if (html5QrCode && html5QrCode.isScanning) {
                        html5QrCode.stop().then(() => {
                            qrModal.classList.add('hidden');
                        }).catch(err => {
                            console.error("Gagal menghentikan scanner:", err);
                            qrModal.classList.add('hidden');
                        });
                    } else {
                        qrModal.classList.add('hidden');
                    }
                });
            }

            // Tutup modal saat klik di luar konten
            qrModal.addEventListener('click', function(e) {
                if (e.target === qrModal) {
                    if (html5QrCode && html5QrCode.isScanning) {
                        html5QrCode.stop().then(() => {
                            qrModal.classList.add('hidden');
                        }).catch(err => {
                            console.error("Gagal menghentikan scanner:", err);
                            qrModal.classList.add('hidden');
                        });
                    } else {
                        qrModal.classList.add('hidden');
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action="{{ route('petugas.jimpitan.store') }}"]');

            form.addEventListener('submit', function(e) {
                // Tampilkan Swal loading
                Swal.fire({
                    title: 'Mengirim data...',
                    html: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
            });
        });
    </script>

    <style>
        /* Animasi untuk toast */
        #toast-container div {
            transition: transform 0.3s ease-in-out;
        }

        /* Styling untuk QR scanner container */
        #qr-reader {
            position: relative;
        }

        #qr-reader video {
            width: 100% !important;
            border-radius: 0.5rem;
        }

        #qr-reader div:first-child {
            border: none !important;
        }
    </style>
@endsection
