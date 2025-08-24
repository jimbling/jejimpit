@extends('layouts.tabler')

@section('title', 'Pengeluaran Jimpitan')
@section('page-title', 'Pengeluaran Jimpitan')

@section('content')
    <div class="container-fluid">
        <div class="row row-cards">
            <div class="col-12">

                {{-- 🔹 Ringkasan & Aksi Utama --}}
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">
                                    <i class="ti ti-wallet me-1"></i> Saldo per Tanggal
                                </label>
                                <input type="text" id="saldoDisplay" class="form-control text-end fw-bold bg-light"
                                    value="Rp 0" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">
                                    <i class="ti ti-calendar me-1"></i> Lihat Saldo per Tanggal
                                </label>
                                <input type="date" id="filterTanggal" class="form-control">
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#tambahPengeluaranModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-cart">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 17h-11v-14h-2" />
                                        <path d="M6 5l14 1l-1 7h-13" />
                                    </svg>
                                    Tambah Pengeluaran
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 🔹 Filter Data --}}
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <form method="GET" action="{{ route('pengeluaran.index') }}" class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Filter Bulan</label>
                                <select name="bulan" class="form-select">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Filter Tahun</label>
                                <select name="tahun" class="form-select">
                                    @for ($y = 2023; $y <= now()->year; $y++)
                                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-filter">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z" />
                                    </svg> Terapkan Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- 🔹 Info Filter Aktif --}}
                <div class="alert alert-info d-flex align-items-center justify-content-between shadow-sm mb-3">
                    <div>
                        <i class="ti ti-info-circle me-2"></i>
                        Menampilkan data untuk
                        <strong>{{ \Carbon\Carbon::create()->month((int) $bulan)->translatedFormat('F') }}</strong>
                        {{ $tahun }}
                    </div>
                    <a href="{{ route('pengeluaran.index') }}" class="btn btn-sm btn-light border">
                        Reset Filter
                    </a>
                </div>

                {{-- 🔹 Tabel Data --}}
                <div class="card shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-vcenter table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Kategori</th>
                                    <th>Uraian</th>
                                    <th class="text-end">Jumlah</th>
                                    <th>Pencatat</th>
                                    <th class="w-1">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengeluaran as $i => $p)
                                    <tr>
                                        <td>{{ $pengeluaran->firstItem() + $i }}</td>
                                        <td>{{ $p->tanggal->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge bg-blue-lt">
                                                {{ $p->kategori->nama ?? '-' }}
                                            </span>
                                        </td>
                                        <td>{{ $p->uraian }}</td>
                                        <td class="text-end fw-semibold">
                                            Rp {{ number_format($p->jumlah, 0, ',', '.') }}
                                        </td>
                                        <td>{{ $p->user->name ?? '-' }}</td>
                                        <td class="text-center">
                                            <button type="button"
                                                class="btn btn-link text-danger p-1 btn-hapus-pengeluaran"
                                                data-url="{{ route('pengeluaran.destroy', $p->id) }}" title="Hapus">
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
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="ti ti-report-off display-5 d-block mb-2"></i>
                                            Belum ada data pengeluaran untuk periode ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        {{ $pengeluaran->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Konfirmasi Hapus --}}
    <x-modal.konfirmasi id="modalKonfirmasiHapus" title="Hapus Data Terpilih?"
        body="Data yang dipilih akan dihapus permanen. Tindakan ini tidak dapat dibatalkan." btnLabel="Ya, Hapus"
        btnColor="danger" :formAction="''" {{-- formAction dikosongkan, nanti diisi JS --}} method="DELETE" />

    @include('components.modal.tambah-pengeluaran')
    <script>
        document.querySelectorAll('.btn-hapus-pengeluaran').forEach(button => {
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
    @push('scripts')
        <script>
            const filterTanggal = document.getElementById('filterTanggal');
            const saldoDisplay = document.getElementById('saldoDisplay');
            const modalTanggal = document.getElementById('modalTanggal');

            filterTanggal.addEventListener('change', function() {
                let tgl = this.value;
                if (!tgl) return;

                // ✅ Set otomatis ke input tanggal di modal
                modalTanggal.value = tgl;

                // ✅ Panggil saldo
                fetch("{{ route('pengeluaran.getSaldo') }}?tanggal=" + tgl)
                    .then(res => res.json())
                    .then(data => {
                        let saldo = data.saldo ?? 0;
                        saldoDisplay.value = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(saldo);
                    })
                    .catch(err => console.error(err));
            });

            // ✅ Jika modal dibuka tanpa pilih tanggal, isi default dengan hari ini
            document.getElementById('tambahPengeluaranModal')
                .addEventListener('show.bs.modal', function() {
                    if (!modalTanggal.value) {
                        let today = new Date().toISOString().split('T')[0];
                        modalTanggal.value = today;
                        filterTanggal.value = today;
                    }
                });
        </script>
    @endpush


@endsection
