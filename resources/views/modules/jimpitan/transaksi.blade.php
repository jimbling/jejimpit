@extends('layouts.tabler') <!-- Gunakan layout utama Tabler -->

@section('title', 'Dashboard')

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

                        <div id="transaksi-table">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-selectable">
                                    <thead>
                                        <tr>
                                            <th class="w-1"></th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-tanggal">Tanggal</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-warga">Warga</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-jumlah">Jumlah</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-petugas">Petugas</button>
                                            </th>
                                            <th>
                                                <button class="table-sort text-center">Aksi</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-tbody">
                                        @forelse ($transaksi as $t)
                                            <tr>
                                                <td>
                                                    <input class="form-check-input m-0 align-middle table-selectable-check"
                                                        type="checkbox" value="{{ $t->id }}" />
                                                </td>
                                                <td class="sort-tanggal">{{ $t->tanggal->format('d-m-Y') }}</td>
                                                <td class="sort-warga">{{ $t->warga->nama_kk }} ({{ $t->warga->kode_unik }})
                                                </td>
                                                <td class="sort-jumlah">{{ number_format($t->jumlah, 0, ',', '.') }}</td>
                                                <td class="sort-petugas">{{ $t->user->name }}</td>
                                                <td class="text-end">
                                                    <div class="btn-list justify-content-end">
                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-icon btn-hapus-transaksi"
                                                            data-url="{{ route('transaksi.jimpitan.destroy', $t->id) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-trash" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <line x1="4" y1="7" x2="20"
                                                                    y2="7" />
                                                                <line x1="10" y1="11" x2="10"
                                                                    y2="17" />
                                                                <line x1="14" y1="11" x2="14"
                                                                    y2="17" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3h6v3" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    Tidak ada data transaksi.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
                let list;

                document.addEventListener("DOMContentLoaded", function() {
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
                        valueNames: advancedTable.headers.map(header => header["data-sort"]),
                    });

                    const searchInput = document.querySelector("#transaksi-table-search");
                    if (searchInput) {
                        searchInput.addEventListener("input", () => {
                            list.search(searchInput.value);
                        });
                    }

                    document.addEventListener("keydown", function(e) {
                        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                            e.preventDefault();
                            if (searchInput) searchInput.focus();
                        }
                    });
                });

                function setPageListItems(event) {
                    const newPageCount = parseInt(event.target.dataset.value);

                    if (list) {
                        list.page = newPageCount;
                        list.update();
                    }

                    document.getElementById('page-count').textContent = newPageCount;
                }
            </script>
            <script>
                document.getElementById('btn-konfirmasi-hapus-transaksi').addEventListener('click', function() {
                    const selected = document.querySelectorAll('.table-selectable-check:checked');

                    if (selected.length === 0) {

                        const warningModal = new bootstrap.Modal(document.getElementById('modalPeringatanTidakAdaData'));
                        warningModal.show();
                        return;
                    }

                    const ids = Array.from(selected).map(checkbox => checkbox.value);

                    let form = document.getElementById('form-mass-delete');
                    if (!form) {
                        form = document.createElement('form');
                        form.method = 'POST';
                        form.action = "{{ route('induk.warga.massDelete') }}";
                        form.id = 'form-mass-delete';

                        form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                        document.body.appendChild(form);
                    }

                    form.querySelectorAll('input[name="ids[]"]').forEach(e => e.remove());

                    ids.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = id;
                        form.appendChild(input);
                    });

                    const konfirmasiModal = new bootstrap.Modal(document.getElementById('modalKonfirmasiHapus'));
                    konfirmasiModal.show();

                    document.querySelector('#modalKonfirmasiHapus form').onsubmit = function(e) {
                        e.preventDefault();
                        form.submit();
                    };
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
        @endpush



    @endsection
