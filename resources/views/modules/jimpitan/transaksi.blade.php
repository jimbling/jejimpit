@extends('layouts.tabler') <!-- Gunakan layout utama Tabler -->

@section('title', 'Transaksi Jimpitan')

@section('page-title', 'Welcome to the Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-0">
                <div class="card">
                    <div class="card-table">
                        <div class="card-header">
                            <div class="row w-full">
                                <div class="col">
                                    <h3 class="card-title mb-0">Transaksi Jimpitan</h3>
                                    <p class="text-secondary m-0">Total Transaksi: {{ $transaksi->count() }}</p>
                                </div>

                                <div class="col-md-auto col-sm-12">
                                    <div class="ms-auto d-flex flex-wrap btn-list">
                                        <!-- Tombol untuk membuka modal tambah -->
                                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                            data-bs-target="#tambahTransaksiModal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icon-tabler-plus">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <line x1="12" y1="5" x2="12" y2="19" />
                                                <line x1="5" y1="12" x2="19" y2="12" />
                                            </svg>
                                            Tambah Transaksi
                                        </button>

                                        <div class="input-group input-group-flat w-auto ms-2">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-1">
                                                    <circle cx="10" cy="10" r="7" />
                                                    <line x1="21" y1="21" x2="15" y2="15" />
                                                </svg>
                                            </span>
                                            <input id="transaksi-table-search" type="text" class="form-control"
                                                placeholder="Cari Transaksi..." autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-header border-bottom pb-3">
                            <form id="filter-form" class="row g-2 align-items-end">
                                <!-- Warga -->
                                <div class="col-md-3">
                                    <label class="form-label">Warga</label>
                                    <select name="warga_id" class="form-select">
                                        <option value="">-- Semua Warga --</option>
                                        @foreach ($wargas as $warga)
                                            <option value="{{ $warga->id }}"
                                                {{ request('warga_id') == $warga->id ? 'selected' : '' }}>
                                                {{ $warga->nama_kk }} ({{ $warga->kode_unik }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Petugas -->
                                <div class="col-md-3">
                                    <label class="form-label">Petugas</label>
                                    <select name="user_id" class="form-select">
                                        <option value="">-- Semua Petugas --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tanggal Mulai -->
                                <div class="col-md-2">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="start_date" class="form-control"
                                        value="{{ request('start_date') }}">
                                </div>

                                <!-- Tanggal Selesai -->
                                <div class="col-md-2">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="date" name="end_date" class="form-control"
                                        value="{{ request('end_date') }}">
                                </div>

                                <!-- Tombol Reset sejajar kanan -->
                                <div class="col-md-2  mt-2">
                                    <a href="{{ route('transaksi.jimpitan.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </form>
                        </div>





                        <div class="table-responsive" id="transaksi-table">

                            @include('modules.jimpitan.transaksi.table', [
                                'transaksi' => $transaksi,
                            ])

                        </div>

                        <div class="card-footer d-flex align-items-center">
                            <div class="dropdown">
                                <a class="btn dropdown-toggle" data-bs-toggle="dropdown">
                                    <span id="page-count" class="me-1">10</span>
                                    <span>data</span>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="setPageListItems(event)" data-value="10">10
                                        data</a>
                                    <a class="dropdown-item" onclick="setPageListItems(event)" data-value="20">20
                                        data</a>
                                    <a class="dropdown-item" onclick="setPageListItems(event)" data-value="50">50
                                        data</a>
                                    <a class="dropdown-item" onclick="setPageListItems(event)" data-value="100">100
                                        data</a>
                                </div>
                            </div>
                            <ul class="pagination m-0 ms-auto">
                                <!-- Pagination buttons -->
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Konfirmasi Hapus --}}
        <x-modal.konfirmasi id="modalKonfirmasiHapus" title="Hapus Data Terpilih?"
            body="Data yang dipilih akan dihapus permanen. Tindakan ini tidak dapat dibatalkan." btnLabel="Ya, Hapus"
            btnColor="danger" :formAction="''" {{-- formAction dikosongkan, nanti diisi JS --}} method="DELETE" />

        {{-- Modal Peringatan Tidak Ada Data --}}
        <x-modal.peringatan id="modalPeringatanTidakAdaData" title="Tidak Ada Data Dipilih"
            message="Silakan pilih setidaknya satu data untuk dihapus." btnLabel="Tutup" btnColor="warning"
            formAction="#" method="GET" />

        @include('components.modal.tambah-transaksi')


        @push('scripts')
            <script>
                let list = null;

                function initListJS() {
                    const advancedTable = {
                        headers: [{
                                "data-sort": "sort-tanggal",
                                name: "Tanggal"
                            },
                            {
                                "data-sort": "sort-warga",
                                name: "Warga"
                            },
                            {
                                "data-sort": "sort-jumlah",
                                name: "Jumlah"
                            },
                            {
                                "data-sort": "sort-petugas",
                                name: "Petugas"
                            },
                        ],
                    };

                    // Hapus instance lama kalau ada
                    if (list) {
                        list.clear();
                        list = null;
                    }

                    const tbodyExists = document.querySelector("#transaksi-table .table-tbody");
                    if (!tbodyExists) return;

                    list = new List("transaksi-table", {
                        sortClass: "table-sort",
                        listClass: "table-tbody",
                        page: 10,
                        pagination: {
                            item: (value) =>
                                `<li class="page-item"><a class="page-link cursor-pointer">${value.page}</a></li>`,
                            innerWindow: 1,
                            outerWindow: 1,
                            left: 0,
                            right: 0,
                        },
                        valueNames: advancedTable.headers.map(h => h["data-sort"]),
                    });

                    const searchInput = document.querySelector("#transaksi-table-search");
                    if (searchInput) {
                        searchInput.addEventListener("input", () => {
                            list.search(searchInput.value);
                        });
                    }
                }

                document.addEventListener("DOMContentLoaded", function() {
                    initListJS();
                });
            </script>


            <script>
                document.querySelectorAll('.btn-hapus-transaksi').forEach(button => {
                    button.addEventListener('click', function() {
                        const url = this.dataset.url;

                        const form = document.querySelector('#modalKonfirmasiHapus form');
                        form.action = url;

                        form.querySelectorAll('input[name="ids[]"]').forEach(e => e.remove());

                        const konfirmasiModal = new bootstrap.Modal(document.getElementById(
                            'modalKonfirmasiHapus'));
                        konfirmasiModal.show();

                        form.onsubmit = function(e) {

                        };
                    });
                });
            </script>


            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Tidak perlu mengubah SVG path, karena CSS menangani rotasi
                    // Inisialisasi untuk semua collapse element
                    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(trigger => {
                        const target = document.querySelector(trigger.getAttribute('href'));

                        // Pastikan aria-expanded sesuai saat load
                        const isExpanded = target.classList.contains('show');
                        trigger.setAttribute('aria-expanded', isExpanded.toString());

                        // Gunakan event Bootstrap untuk sinkronisasi
                        target.addEventListener('shown.bs.collapse', () => {
                            trigger.setAttribute('aria-expanded', 'true');
                        });
                        target.addEventListener('hidden.bs.collapse', () => {
                            trigger.setAttribute('aria-expanded', 'false');
                        });

                        // Tangani saat modal dibuka (opsional, jika collapse dalam modal)
                        const modal = target.closest('.modal');
                        if (modal) {
                            modal.addEventListener('shown.bs.modal', () => {
                                const isExpanded = target.classList.contains('show');
                                trigger.setAttribute('aria-expanded', isExpanded.toString());
                            });
                        }
                    });
                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const formFilter = document.getElementById('filter-form');
                    if (!formFilter) return;

                    function loadTransaksi() {
                        const formData = new FormData(formFilter);
                        const params = new URLSearchParams(formData).toString();

                        fetch("{{ route('transaksi.jimpitan.index') }}?" + params, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(res => res.text())
                            .then(html => {
                                document.getElementById('transaksi-table').innerHTML = html;
                            })
                            .catch(err => console.error(err));
                    }

                    // Tangkap event submit form untuk mencegah reload
                    formFilter.addEventListener('submit', function(e) {
                        e.preventDefault(); // penting agar tidak reload
                        loadTransaksi();
                    });

                    // Optional: juga trigger AJAX saat filter berubah
                    formFilter.querySelectorAll('select, input').forEach(input => {
                        input.addEventListener('change', loadTransaksi);
                    });
                });
            </script>
        @endpush



    @endsection
