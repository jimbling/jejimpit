@extends('layouts.tabler')

@section('title', 'Laporan Partisipasi Jimpitan')
@section('page-title', 'Laporan Partisipasi - Semua Warga')

@section('content')
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <div class="row w-full">
                    <div class="col">
                        <h3 class="card-title mb-0">Warga Kedungtangkil</h3>
                        <p class="text-secondary m-0">Jumlah Warga : {{ $totalWargas }}</p>
                    </div>


                    <div class="col-md-auto col-sm-12">
                        <div class="ms-auto d-flex flex-wrap btn-list">



                            <div class="input-group input-group-flat w-auto">
                                <span class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="icon icon-1">
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                        <path d="M21 21l-6 -6" />
                                    </svg>
                                </span>
                                <input id="partisipasi-warga-table-search" type="text" class="form-control"
                                    autocomplete="off" />
                                <span class="input-group-text">
                                    <kbd>ctrl + K</kbd>
                                </span>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div id="partisipasi-warga-table">
                <div class="table-responsive">
                    <table class="table table-vcenter table-selectable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>
                                    <button class="table-sort d-flex justify-content-between" data-sort="sort-nama">Nama
                                        KK</button>
                                </th>
                                <th>
                                    <button class="table-sort d-flex justify-content-between" data-sort="sort-telp">No.
                                        Telp</button>
                                </th>
                                <th>
                                    <button class="table-sort d-flex justify-content-between"
                                        data-sort="sort-rt">RT</button>
                                </th>
                                <th>
                                    <button class="table-sort d-flex justify-content-between"
                                        data-sort="sort-rw">RW</button>
                                </th>
                                <th>
                                    <button class="table-sort d-flex justify-content-between" data-sort="sort-total">Total
                                        Setor</button>
                                </th>
                                <th>
                                    <button class="table-sort d-flex justify-content-between">Aksi</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody">
                            @forelse($wargas as $warga)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="sort-nama">{{ $warga->nama_kk }}</td>
                                    <td class="sort-telp">{{ $warga->no_telp ?? '-' }}</td>
                                    <td class="sort-rt">{{ $warga->rt }}</td>
                                    <td class="sort-rw">{{ $warga->rw }}</td>
                                    <td class="sort-total">{{ number_format($warga->total_setor ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="btn-list">
                                            <a href="{{ route('laporan.partisipasi.warga.show', $warga->id) }}"
                                                class="btn btn-outline-primary btn-icon" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Detail Partisipasi">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-list-details" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M13 5h8" />
                                                    <path d="M13 9h5" />
                                                    <path d="M13 15h8" />
                                                    <path d="M13 19h5" />
                                                    <rect x="3" y="4" width="6" height="6" rx="1" />
                                                    <rect x="3" y="14" width="6" height="6" rx="1" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2" width="48"
                                            height="48" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <circle cx="12" cy="12" r="9" />
                                            <line x1="12" y1="8" x2="12" y2="12" />
                                            <line x1="12" y1="16" x2="12.01" y2="16" />
                                        </svg>
                                        <div><strong>Tidak ada data Warga yang tersedia.</strong></div>
                                        <div class="small text-muted">Silakan tambahkan data atau periksa filter pencarian
                                            Anda.</div>
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
                            <a class="dropdown-item" onclick="setPageListItems(event)" data-value="10">10 data</a>
                            <a class="dropdown-item" onclick="setPageListItems(event)" data-value="20">20 data</a>
                            <a class="dropdown-item" onclick="setPageListItems(event)" data-value="50">50 data</a>
                            <a class="dropdown-item" onclick="setPageListItems(event)" data-value="100">100 data</a>
                        </div>
                    </div>
                    <ul class="pagination m-0 ms-auto">
                        <!-- Pagination buttons -->
                    </ul>
                </div>
            </div>
        </div>

    </div>


    @push('scripts')
        <script>
            let list;

            document.addEventListener("DOMContentLoaded", function() {
                const advancedTable = {
                    headers: [{
                            "data-sort": "sort-nama",
                            name: "Nama KK"
                        },
                        {
                            "data-sort": "sort-telp",
                            name: "No. Telp"
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

                        {
                            "data-sort": "sort-total",
                            name: "Total Setor"
                        },
                    ],
                };

                list = new List("partisipasi-warga-table", {
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

                const searchInput = document.querySelector("#partisipasi-warga-table-search");
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
    @endpush
@endsection
