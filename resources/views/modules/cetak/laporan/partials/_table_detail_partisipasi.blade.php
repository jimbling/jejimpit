<div class="card">
    <div class="card-body border-bottom py-3">
        {{-- Optional: filter, search, action bar --}}
    </div>

    <div class="table-responsive">
        <table class="table table-vcenter table-striped">
            <thead>
                <tr>
                    <th>
                        <button class="table-sort d-flex justify-content-between" data-sort="sort-tanggal">
                            Tanggal
                        </button>
                    </th>
                    <th>
                        <button class="table-sort d-flex justify-content-between" data-sort="sort-jumlah">
                            Jumlah
                        </button>
                    </th>
                    <th>
                        <button class="table-sort d-flex justify-content-between" data-sort="sort-keterangan">
                            Keterangan
                        </button>
                    </th>
                    <th>
                        <button class="table-sort d-flex justify-content-between" data-sort="sort-petugas">
                            Petugas
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody class="table-tbody">
                @forelse($transaksis as $trx)
                    <tr>
                        <td class="sort-tanggal">{{ $trx->tanggal->translatedFormat('d F Y') }}</td>
                        <td class="sort-jumlah">{{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                        <td class="sort-keterangan">{{ $trx->keterangan ?? '-' }}</td>
                        <td class="sort-petugas">{{ $trx->user->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2" width="48" height="48"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="12" cy="12" r="9" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            <div><strong>Tidak ada transaksi yang tersedia.</strong></div>
                            <div class="small text-muted">Silakan tambahkan data atau ubah filter pencarian Anda.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex align-items-center">
        <div class="dropdown">
            <a class="btn dropdown-toggle" data-bs-toggle="dropdown">
                <span id="page-count" class="me-1">{{ request('perPage', 10) }}</span>
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
            {{ $transaksis->links('pagination::bootstrap-5') }}
        </ul>
    </div>
</div>
