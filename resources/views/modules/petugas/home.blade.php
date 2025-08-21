@extends('layouts.petugas')

@section('content')
    <div class="p-4 space-y-4">
        {{-- Modern alert sukses entri jimpitan --}}
        @if (session('jimpitan_success'))
            @php
                $data = session('jimpitan_success');
            @endphp
            <div id="alert-jimpitan"
                class="fixed top-4 left-1/2 transform -translate-x-1/2 bg-white border-l-4 border-green-500 shadow-lg rounded-lg px-5 py-4 flex items-start space-x-3 w-[calc(100%-2rem)] max-w-md animate-slide-down z-50">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="flex-1 text-sm text-gray-700">
                    <strong class="font-semibold">Berhasil!</strong>
                    <p class="mt-1">
                        Jimpitan dari Bapak/Ibu <strong>{{ $data['warga'] }}</strong> telah dientri sebesar
                        <strong>Rp {{ number_format($data['jumlah'], 0, ',', '.') }}</strong> pada tanggal
                        <strong>{{ \Carbon\Carbon::parse($data['tanggal'])->translatedFormat('d M Y') }}</strong>.
                    </p>
                </div>
                <button onclick="document.getElementById('alert-jimpitan').remove()"
                    class="ml-3 text-gray-400 hover:text-gray-600 flex-shrink-0">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Header sapaan -->
        <div>
            <h1 class="text-xl font-bold">Halo... Mas {{ auth()->user()->name }} 👋</h1>
            <p class="text-gray-500 text-sm">Selamat bertugas malam ini!</p>
        </div>

        <div x-data="{ openModal: false, sudahCheckin: {{ $sudahCheckin ? 'true' : 'false' }} }" class="grid grid-cols-2 gap-3">

            <!-- Form Check-in -->
            <form x-ref="checkinForm" id="checkinForm" action="{{ route('kehadiran.checkin') }}" method="POST"
                class="flex flex-col items-center">
                @csrf
                <button type="button" @click="if(!sudahCheckin) openModal = true"
                    :class="sudahCheckin ? 'bg-gray-300 cursor-not-allowed' : 'bg-white hover:bg-gray-50'"
                    :disabled="sudahCheckin" class="flex flex-col items-center p-3 rounded-xl shadow w-full">
                    <i class="fas fa-tasks text-indigo-500 text-2xl mb-1"></i>
                    <span class="text-xs font-medium" x-text="sudahCheckin ? 'Sudah Check-in' : 'Check-in'"></span>
                </button>
            </form>



            <a href="{{ route('petugas.jimpitan.riwayat') }}"
                class="flex flex-col items-center bg-white p-3 rounded-xl shadow hover:bg-gray-50">
                <i class="fas fa-history text-blue-500 text-2xl mb-1"></i>
                <span class="text-xs font-medium">Riwayat</span>
            </a>

            <!-- Modal -->
            <div x-show="openModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
                <div class="bg-white rounded-lg shadow-lg p-6 w-80">
                    <h2 class="text-lg font-bold mb-4">Konfirmasi Check-in</h2>
                    <p class="mb-6">Apakah Anda yakin ingin melakukan check-in hari ini?</p>
                    <div class="flex justify-end gap-3">
                        <button @click="openModal = false"
                            class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Batal</button>
                        <button @click="$refs.checkinForm.submit()"
                            class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600">Konfirmasi</button>
                    </div>
                </div>
            </div>

        </div>




        <!-- Info section -->
        <div class="bg-white p-4 rounded-xl shadow">
            <h2 class="font-semibold mb-2">Informasi</h2>
            <ul class="text-sm text-gray-600 space-y-1">
                <li>📌 Jadwal Jimpitan Setiap Malam Minggu</li>
                <li>💰 Setiap warga diwajibkan Rp. 2.000</li>
                <li>🔔 Pastikan muncul Notifikasi Berhasil saat entri data Jimpitan</li>
            </ul>
        </div>



        <!-- Card Check-in -->
        <div id="alert-checkin" class="p-4 rounded-xl shadow mb-4 max-w-md mx-auto">
            <h2 class="font-semibold mb-2"></h2>
            <p class="text-sm mb-3"></p>
            <a id="checkin-btn" href="#" class="inline-block font-semibold py-2 px-4 rounded-md text-center"></a>
        </div>




    </div>
@endsection
