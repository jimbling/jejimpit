@extends('layouts.tabler')

@section('title', 'Laporan Penerimaan Jimpitan')
@section('page-title', 'Laporan Penerimaan Jimpitan')

@section('content')
    <div class="container-fluid">
        <div class="card mt-3">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="laporanTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#mingguan" role="tab">Mingguan Penerimaan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#bku" role="tab">Bulanan (BKU)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#bku_ringkas" role="tab">BKU Ringkas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#pengeluaran" role="tab">Pengeluaran per
                            Kategori</a>
                    </li>

                </ul>
            </div>
            <div class="card-body tab-content">
                {{-- Mingguan --}}
                <div class="tab-pane fade show active" id="mingguan">
                    @include('modules.cetak.laporan.partials._filter_mingguan')
                </div>
                {{-- BKU --}}
                <div class="tab-pane fade" id="bku">
                    @include('modules.cetak.laporan.partials._filter_bulanan')
                </div>
                {{-- Pengeluaran --}}
                <div class="tab-pane fade" id="pengeluaran">
                    @include('modules.cetak.laporan.partials._filter_pengeluaran')
                </div>
                {{-- BKU RIngkas --}}
                <div class="tab-pane fade" id="bku_ringkas">
                    @include('modules.cetak.laporan.partials._filter_bku_ringkas')
                </div>
            </div>
        </div>



    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('filterMingguanForm').addEventListener('submit', function(e) {
            e.preventDefault();
            loadMingguanData();
        });

        function loadMingguanData() {
            let bulan = document.getElementById('mingguan_bulan').value;
            let tahun = document.getElementById('mingguan_tahun').value;

            fetch(`/laporan/penerimaan-mingguan/json?bulan=${bulan}&tahun=${tahun}`)
                .then(res => res.json())
                .then(data => {
                    let body = document.getElementById('laporanMingguanBody');
                    let rows = '';
                    data.items.forEach(item => {
                        rows += `
                    <tr>
                        <td>${item.label}</td>
                        <td>Rp ${new Intl.NumberFormat('id-ID').format(item.total)}</td>
                    </tr>
                `;
                    });
                    body.innerHTML = rows;
                    document.getElementById('laporanMingguanTotal').innerText =
                        "Rp " + new Intl.NumberFormat('id-ID').format(data.total_bulan);
                    document.getElementById('laporanMingguanCard').classList.remove('d-none');

                    // update link cetak
                    document.getElementById('btnCetakMingguan').href =
                        `/laporan/penerimaan-mingguan/cetak?bulan=${bulan}&tahun=${tahun}`;
                })
                .catch(err => {
                    console.error(err);
                    alert("Gagal memuat data");
                });
        }

        // load pertama kali
        loadMingguanData();
    </script>

    <script>
        document.getElementById('btnCetakBku').addEventListener('click', function(e) {
            e.preventDefault();
            let bulan = document.getElementById('bulan_bku').value;
            let tahun = document.getElementById('tahun_bku').value;
            let url = "{{ route('laporan.bku_bulanan.cetak') }}?bulan=" + bulan + "&tahun=" + tahun;
            window.open(url, '_blank');
        });
    </script>

    <script>
        document.getElementById('filterBulananForm').addEventListener('submit', function(e) {
            e.preventDefault();
            loadBulananData();
        });

        function loadBulananData() {
            let bulan = document.getElementById('bulan_bku').value;
            let tahun = document.getElementById('tahun_bku').value;

            fetch(`/laporan/bku-bulanan/json?bulan=${bulan}&tahun=${tahun}`)
                .then(res => res.json())
                .then(data => {
                    let body = document.getElementById('laporanBulananBody');
                    let rows = '';
                    data.items.forEach(item => {
                        rows += `
                    <tr>
                        <td>${new Date(item.tanggal).toLocaleDateString('id-ID')}</td>
                        <td>${item.uraian}</td>
                        <td>${item.dana_masuk > 0 ? 'Rp ' + new Intl.NumberFormat('id-ID').format(item.dana_masuk) : '-'}</td>
                        <td>${item.dana_keluar > 0 ? 'Rp ' + new Intl.NumberFormat('id-ID').format(item.dana_keluar) : '-'}</td>
                        <td>Rp ${new Intl.NumberFormat('id-ID').format(item.saldo)}</td>
                    </tr>
                `;
                    });
                    body.innerHTML = rows;

                    // gunakan key yang sesuai JSON
                    document.getElementById('laporanBulananPenerimaan').innerText =
                        "Rp " + new Intl.NumberFormat('id-ID').format(data.total_masuk);
                    document.getElementById('laporanBulananPengeluaran').innerText =
                        "Rp " + new Intl.NumberFormat('id-ID').format(data.total_keluar);
                    document.getElementById('laporanBulananSaldo').innerText =
                        "Rp " + new Intl.NumberFormat('id-ID').format(data.saldo_akhir);

                    document.getElementById('laporanBulananCard').classList.remove('d-none');

                    // update link cetak
                    document.getElementById('btnCetakBku').href =
                        `/laporan/bku-bulanan/cetak?bulan=${bulan}&tahun=${tahun}`;
                })
                .catch(err => {
                    console.error(err);
                    alert("Gagal memuat data");
                });
        }


        // auto-load pertama kali
        loadBulananData();
    </script>

    <script>
        function loadPengeluaranData() {
            let query = $("#filterPengeluaran").serialize();

            $.get("{{ route('laporan.pengeluaran.json') }}?" + query, function(res) {
                if (res.items.length === 0) {
                    $("#preview-table").html('<div class="alert alert-warning">Tidak ada data pengeluaran.</div>');
                    $("#preview-wrapper").removeClass("d-none");
                    return;
                }

                let html = `
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Uraian</th>
                        <th class="text-end">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
        `;

                res.items.forEach(item => {
                    html += `
                <tr>
                    <td>${new Date(item.tanggal).toLocaleDateString('id-ID')}</td>
                    <td>${item.kategori ? item.kategori.nama : '-'}</td>
                    <td>${item.uraian ?? ''}</td>
                    <td class="text-end">${parseInt(item.jumlah).toLocaleString('id-ID')}</td>
                </tr>
            `;
                });

                html += `
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total</th>
                        <th class="text-end">${parseInt(res.total).toLocaleString('id-ID')}</th>
                    </tr>
                </tfoot>
            </table>
        `;

                $("#preview-table").html(html);
                $("#preview-wrapper").removeClass("d-none");

                // update tombol cetak
                $("#btnCetakPengeluaran").attr("href", "{{ route('laporan.pengeluaran.cetak') }}?" + query);
            });
        }

        // trigger otomatis saat filter berubah
        $('#filterPengeluaran select').on('change', loadPengeluaranData);
    </script>
@endpush
