@extends('layouts.tabler') <!-- Gunakan layout utama Tabler -->

@section('title', $title ?? 'Dashboard')

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
                                    <h3 class="card-title mb-0">Warga Kedungtangkil</h3>
                                    <p class="text-secondary m-0">Jumlah Warga : {{ $totalWargas }}</p>
                                </div>


                                <div class="col-md-auto col-sm-12">
                                    <div class="ms-auto d-flex flex-wrap btn-list">
                                        <!-- Tombol untuk membuka modal -->
                                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                            data-bs-target="#tambahWargaModal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-users-plus">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4c.96 0 1.84 .338 2.53 .901" />
                                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                                <path d="M16 19h6" />
                                                <path d="M19 16v6" />
                                            </svg>
                                            Tambah Warga
                                        </button>
                                        <a href="{{ route('warga.qr.export') }}" class="btn btn-outline-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-qrcode">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M4 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                <path d="M7 17l0 .01" />
                                                <path
                                                    d="M14 4m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                <path d="M7 7l0 .01" />
                                                <path
                                                    d="M4 14m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" />
                                                <path d="M17 7l0 .01" />
                                                <path d="M14 14l3 0" />
                                                <path d="M20 14l0 .01" />
                                                <path d="M14 14l0 3" />
                                                <path d="M14 20l3 0" />
                                                <path d="M17 17l3 0" />
                                                <path d="M20 17l0 3" />
                                            </svg>
                                            QR Semua Warga
                                        </a>


                                        <div class="input-group input-group-flat w-auto">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-1">
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                    <path d="M21 21l-6 -6" />
                                                </svg>
                                            </span>
                                            <input id="warga-table-search" type="text" class="form-control"
                                                autocomplete="off" />
                                            <span class="input-group-text">
                                                <kbd>ctrl + K</kbd>
                                            </span>
                                        </div>

                                        <form id="form-mass-delete" method="POST"
                                            action="{{ route('induk.warga.massDelete') }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="ids[]" id="selected-students">
                                            <button type="button" class="btn btn-outline-danger"
                                                id="btn-konfirmasi-hapus-warga">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 7l16 0" />
                                                    <path d="M10 11l0 6" />
                                                    <path d="M14 11l0 6" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="warga-table">
                            <div class="table-responsive">
                                <table class="table table-vcenter table-selectable">
                                    <thead>
                                        <tr>
                                            <th class="w-1"></th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-nama">Nama</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-id">ID</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-alamat">Alamat</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-rt">RT</button>
                                            </th>
                                            <th>
                                                <button class="table-sort d-flex justify-content-between"
                                                    data-sort="sort-rw">RW
                                                </button>
                                            </th>
                                            <th>
                                                <button class="table-sort  d-flex justify-content-between">Aksi</button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-tbody">
                                        @forelse ($wargas as $warga)
                                            <tr>
                                                <td>
                                                    <input class="form-check-input m-0 align-middle table-selectable-check"
                                                        type="checkbox" aria-label="Select siswa"
                                                        value="{{ $warga->id }}" />
                                                </td>
                                                <td class="sort-nama">{{ $warga->nama_kk }}</td>
                                                <td class="sort-id">{{ $warga->kode_unik }}</td>
                                                <td class="sort-alamat">{{ $warga->alamat }}</td>
                                                <td class="sort-rt">{{ $warga->rt }}</td>
                                                <td class="sort-rw">{{ $warga->rw }}</td>

                                                <td>
                                                    <div class="btn-list">
                                                        {{-- Cetak QR --}}
                                                        <a href="{{ route('induk.warga.qr', $warga->id) }}"
                                                            target="_blank" class="btn btn-outline-success btn-icon"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Cetak QR">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-qrcode" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <rect x="4" y="4" width="6" height="6"
                                                                    rx="1" />
                                                                <rect x="14" y="4" width="6" height="6"
                                                                    rx="1" />
                                                                <rect x="4" y="14" width="6" height="6"
                                                                    rx="1" />
                                                                <path d="M14 14h2v2h-2z" />
                                                                <path d="M20 14v6h-6v-6h6z" />
                                                            </svg>
                                                        </a>




                                                        {{-- Hapus --}}
                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-icon btn-hapus-warga"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Hapus Warga"
                                                            data-url="{{ route('induk.warga.destroy', $warga->id) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-trash" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
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
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2"
                                                        width="48" height="48" viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <circle cx="12" cy="12" r="9" />
                                                        <line x1="12" y1="8" x2="12"
                                                            y2="12" />
                                                        <line x1="12" y1="16" x2="12.01"
                                                            y2="16" />
                                                    </svg>
                                                    <div><strong>Tidak ada data Warga yang tersedia.</strong></div>
                                                    <div class="small text-muted">Silakan tambahkan data atau periksa
                                                        filter pencarian Anda.</div>
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
    </div>





    {{-- Modal Konfirmasi Hapus --}}
    <x-modal.konfirmasi id="modalKonfirmasiHapus" title="Hapus Data Terpilih?"
        body="Data yang dipilih akan dihapus permanen. Tindakan ini tidak dapat dibatalkan." btnLabel="Ya, Hapus"
        btnColor="danger" :formAction="''" {{-- formAction dikosongkan, nanti diisi JS --}} method="DELETE" />

    {{-- Modal Peringatan Tidak Ada Data --}}
    <x-modal.peringatan id="modalPeringatanTidakAdaData" title="Tidak Ada Data Dipilih"
        message="Silakan pilih setidaknya satu data untuk dihapus." btnLabel="Tutup" btnColor="warning" formAction="#"
        method="GET" />

    @include('components.modal.tambah-warga')


    @push('scripts')
        <script>
            let list;

            document.addEventListener("DOMContentLoaded", function() {
                const advancedTable = {
                    headers: [{
                            "data-sort": "sort-nama",
                            name: "Nama"
                        },
                        {
                            "data-sort": "sort-id",
                            name: "ID"
                        },
                        {
                            "data-sort": "sort-alamat",
                            name: "Alamat"
                        },
                        {
                            "data-sort": "sort-rt",
                            name: "RT"
                        },
                        {
                            "data-sort": "sort-rw",
                            name: "RW"
                        },
                    ],
                };

                list = new List("warga-table", {
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

                const searchInput = document.querySelector("#warga-table-search");
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
            document.querySelectorAll('.btn-hapus-warga').forEach(button => {
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
            document.getElementById('btn-konfirmasi-hapus-warga').addEventListener('click', function() {
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
