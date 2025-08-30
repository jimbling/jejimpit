@extends('layouts.tabler')

@section('title', 'Detail Partisipasi Warga')
@section('page-title', 'Detail Partisipasi: ' . $warga->nama_kk)

@section('content')
    <div class="container-xl">

        {{-- Informasi Warga --}}
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">Informasi Warga</h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>Nama KK:</strong> {{ $warga->nama_kk }} <br>
                        <strong>No. Telp:</strong> {{ $warga->no_telp ?? '-' }}
                    </div>
                    <div class="col-md-6">
                        <strong>RT/RW:</strong> {{ $warga->rt }}/{{ $warga->rw }} <br>
                        <strong>Total Setoran:</strong>
                        {{ number_format($warga->transaksiJimpitan->sum('jumlah'), 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Menu & Filter --}}
        <div class="card mb-4">
            <div class="card-body border-bottom py-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

                    {{-- Tombol kembali --}}
                    <a href="{{ route('laporan.partisipasi.index') }}" class="btn btn-warning d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="20" height="20"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 12h14" />
                            <path d="M5 12l6 6" />
                            <path d="M5 12l6 -6" />
                        </svg>
                        Kembali
                    </a>

                    {{-- Filter dan Cetak --}}
                    <div class="d-flex gap-2">
                        <input type="text" id="daterange" class="form-control" placeholder="Pilih rentang tanggal"
                            style="width: 220px;" />

                        <button type="button" class="btn btn-success d-flex align-items-center" id="btnPrint">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-printer">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                            </svg>
                            Cetak
                        </button>
                        <button type="button" class="btn btn-success d-flex align-items-center" id="btnSendWa">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-brand-whatsapp">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                                <path
                                    d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                            </svg> Kirim WA
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Riwayat Transaksi --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Riwayat Transaksi</h3>
            </div>
            <div class="card-body p-0" id="transaksi-table-wrapper">
                @include('modules.cetak.laporan.partials._table_detail_partisipasi', [
                    'transaksis' => $transaksis,
                ])
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const picker = new Litepicker({
                element: document.getElementById('daterange'),
                singleMode: false,
                format: 'YYYY-MM-DD',
                numberOfMonths: 2,
                numberOfColumns: 2,
                autoApply: true,
                setup: (picker) => {
                    picker.on('selected', (date1, date2) => {
                        fetchTransaksi(date1.format('YYYY-MM-DD'), date2.format('YYYY-MM-DD'));
                    });
                }
            });

            function fetchTransaksi(start, end, page = 1) {
                const perPage = document.getElementById('page-count').textContent;
                const url =
                    `{{ url('/laporan/partisipasi') }}/${wargaId}/transaksi?start=${start}&end=${end}&page=${page}&perPage=${perPage}`;

                fetch(url)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('transaksi-table-wrapper').innerHTML = html;
                        attachPaginationLinks(start, end); // update pagination link event
                    })
                    .catch(err => console.error(err));
            }

            function attachPaginationLinks(start, end) {
                document.querySelectorAll('#transaksi-table-wrapper .pagination a').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = new URL(this.href).searchParams.get('page');
                        fetchTransaksi(start, end, page);
                    });
                });
            }

            const wargaId = "{{ $warga->id ?? '' }}";
        });


        document.getElementById('btnPrint').addEventListener('click', function() {
            const daterange = document.getElementById('daterange').value;
            let start = '',
                end = '';

            if (daterange.includes(' - ')) {
                [start, end] = daterange.split(' - ').map(s => s.trim());
            }

            const wargaId = "{{ $warga->id ?? '' }}";
            const url = `{{ url('/laporan/partisipasi') }}/${wargaId}/print?start=${start}&end=${end}`;
            window.open(url, '_blank', 'width=900,height=600');
        });

        document.getElementById('btnSendWa').addEventListener('click', function() {
            const daterange = document.getElementById('daterange').value;
            let start = '',
                end = '';

            if (daterange.includes(' - ')) {
                [start, end] = daterange.split(' - ').map(s => s.trim());
            }

            const wargaId = "{{ $warga->id ?? '' }}";
            const url = `{{ url('/laporan/partisipasi') }}/${wargaId}/send-wa?start=${start}&end=${end}`;

            window.open(url, '_blank'); // langsung buka wa.me
        });
    </script>
@endpush
