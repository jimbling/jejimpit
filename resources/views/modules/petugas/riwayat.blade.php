@extends('layouts.petugas')

@section('content')
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <div class="p-4 space-y-4" x-data="riwayatJimpitan()" x-init="init()">

        <!-- Search & Filter -->
        <div class="space-y-2 mb-4">

            <!-- Input Pencarian -->
            <input type="text" placeholder="Cari nama / kode unik" x-model="search"
                class="w-full p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">

            <!-- Row Tanggal, Bulan & Reset -->
            <div class="flex gap-2 min-w-0">
                <!-- Tanggal -->
                <input type="text" x-ref="tanggalInput" placeholder="Pilih tanggal" readonly
                    class="flex-[2] p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition min-w-0">

                <!-- Dropdown Bulan -->
                <select x-model="filterBulan"
                    class="flex-[2] p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition min-w-0">
                    <option value=""> Bulan</option>
                    <template x-for="(namaBulan, index) in bulanList" :key="index">
                        <option :value="index + 1" x-text="namaBulan"></option>
                    </template>
                </select>

                <!-- Reset Filter -->
                <button type="button" @click="resetFilter()"
                    class="flex-[1] flex items-center justify-center p-3 rounded-xl border border-gray-300 bg-gray-50 hover:bg-gray-100 transition">
                    <i class="fas fa-rotate-right text-gray-600"></i>
                </button>
            </div>

        </div>


        <!-- Riwayat Transaksi -->
        <div class="space-y-3">
            <template x-for="item in filteredTransaksi.slice(0, displayedCount)" :key="item.id">
                <div x-transition:enter="transition transform duration-300 ease-out"
                    x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-white rounded-xl shadow p-4 flex justify-between items-center hover:shadow-lg hover:scale-[1.01] transition transform cursor-pointer">
                    <div>
                        <p class="text-sm text-gray-500" x-text="item.tanggal"></p>
                        <p class="text-base font-medium">
                            <span x-text="item.warga_nama"></span>
                            <span class="text-gray-400 text-xs" x-text="'(' + item.warga_kode + ')'"></span>
                        </p>
                        <p class="text-sm text-gray-600" x-text="item.keterangan"></p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-semibold text-green-600"
                            x-text="'Rp ' + item.jumlah.toLocaleString('id-ID')"></p>
                    </div>
                </div>
            </template>

            <!-- Empty State -->
            <div x-show="filteredTransaksi.length === 0"
                class="flex flex-col items-center justify-center mt-6 space-y-2 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-40 h-40 mb-6" fill="none" viewBox="0 0 64 64"
                    stroke="currentColor">
                    <!-- Folder/Base -->
                    <rect x="8" y="20" width="48" height="32" rx="4" ry="4" class="stroke-gray-300"
                        stroke-width="2" fill="none" />
                    <!-- Folder tab -->
                    <rect x="8" y="14" width="16" height="6" rx="1" ry="1" class="stroke-gray-300"
                        stroke-width="2" fill="none" />
                    <!-- Empty line indicator -->
                    <line x1="16" y1="30" x2="48" y2="30" stroke-width="2"
                        stroke-linecap="round" class="stroke-gray-300" />
                    <line x1="16" y1="36" x2="48" y2="36" stroke-width="2"
                        stroke-linecap="round" class="stroke-gray-300" />
                    <line x1="16" y1="42" x2="48" y2="42" stroke-width="2"
                        stroke-linecap="round" class="stroke-gray-300" />
                    <!-- Optional icon/indicator circle -->
                    <circle cx="32" cy="52" r="4" class="fill-gray-200 stroke-gray-300" stroke-width="2" />
                </svg>

                <h3 class="text-xl font-semibold mb-2 text-gray-600">History Kosong</h3>
                <p>Belum ada transaksi untuk ditampilkan</p>
            </div>
        </div>

        <!-- Load More -->
        <div class="flex justify-end mt-3">
            <button x-show="displayedCount < filteredTransaksi.length" @click="displayedCount += 10"
                x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="px-5 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 shadow-lg transition">
                Tampilkan lebih banyak
            </button>
        </div>
    </div>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        function riwayatJimpitan() {
            return {
                search: '',
                filterTanggal: '',
                filterBulan: '',
                displayedCount: 10,
                transaksi: @json($transaksi),
                bulanList: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                    'Oktober', 'November', 'Desember'
                ],



                init() {
                    // Flatpickr untuk tanggal
                    flatpickr(this.$refs.tanggalInput, {
                        dateFormat: "d-m-Y",
                        allowInput: false,
                        disableMobile: true,
                        onChange: (selectedDates, dateStr) => {
                            this.filterTanggal = dateStr;
                        }
                    });
                },

                resetFilter() {
                    this.search = '';
                    this.filterTanggal = '';
                    this.filterBulan = '';
                    if (this.$refs.tanggalInput._flatpickr) {
                        this.$refs.tanggalInput._flatpickr.clear();
                    }
                },

                get filteredTransaksi() {
                    return this.transaksi.filter(item => {
                        const matchSearch = item.warga_nama.toLowerCase().includes(this.search.toLowerCase()) ||
                            item.warga_kode.toLowerCase().includes(this.search.toLowerCase());

                        const matchTanggal = this.filterTanggal ? item.tanggal === this.filterTanggal : true;

                        const matchBulan = this.filterBulan ? (new Date(item.tanggal_raw).getMonth() + 1) ==
                            this.filterBulan : true;

                        return matchSearch && matchTanggal && matchBulan;
                    });
                }
            }
        }
    </script>
@endsection
