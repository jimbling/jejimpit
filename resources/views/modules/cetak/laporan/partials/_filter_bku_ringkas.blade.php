{{-- resources/views/admin/laporan/_filter_partisipasi.blade.php --}}
<form id="filterPartisipasi" class="row g-2 mb-3">
    <div class="col-md-6">
        <label class="form-label">Bulan</label>
        <select id="bulan_partisipasi" class="form-select">
            @foreach (range(1, 12) as $bln)
                <option value="{{ $bln }}">{{ \Carbon\Carbon::create()->month($bln)->translatedFormat('F') }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Tahun</label>
        <select id="tahun_partisipasi" class="form-select">
            @foreach (range(now()->year - 1, now()->year + 1) as $thn)
                <option value="{{ $thn }}">{{ $thn }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 mt-2 d-flex">
        <a id="btnCetakPartisipasi" href="#" target="_blank" class="btn btn-success w-100">
            <i class="ti ti-printer"></i> Cetak
        </a>
    </div>
</form>

{{-- Tabel hasil --}}
<div class="table-responsive">
    <table class="table table-bordered table-striped" id="tablePartisipasi">
        <thead>
            <tr>
                <th>Minggu</th>
                <th>Penerimaan</th>
                <th>Pengeluaran</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="4" class="text-center">Pilih filter untuk menampilkan data</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>Total Bulan</th>
                <th id="totalPenerimaan">-</th>
                <th id="totalPengeluaran">-</th>
                <th id="totalSaldo">-</th>
            </tr>
        </tfoot>
    </table>
</div>

@push('scripts')
    <script>
        function fetchBkuRingkas() {
            const bulan = document.getElementById('bulan_partisipasi').value;
            const tahun = document.getElementById('tahun_partisipasi').value;

            fetch(`/laporan/bku/ringkas?bulan=${bulan}&tahun=${tahun}`)
                .then(res => res.json())
                .then(res => {
                    const tbody = document.querySelector("#tablePartisipasi tbody");
                    tbody.innerHTML = '';

                    if (res.data && res.data.length) {
                        res.data.forEach(row => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                            <td>${row.minggu}</td>
                            <td>Rp ${row.penerimaan.toLocaleString()}</td>
                            <td>Rp ${row.pengeluaran.toLocaleString()}</td>
                            <td>Rp ${row.saldo.toLocaleString()}</td>
                        `;
                            tbody.appendChild(tr);
                        });

                        // Update footer
                        document.getElementById('totalPenerimaan').innerText = 'Rp ' + res.data.reduce((a, b) => a + b
                            .penerimaan, 0).toLocaleString();
                        document.getElementById('totalPengeluaran').innerText = 'Rp ' + res.data.reduce((a, b) => a + b
                            .pengeluaran, 0).toLocaleString();
                        document.getElementById('totalSaldo').innerText = 'Rp ' + res.data[res.data.length - 1].saldo
                            .toLocaleString();
                    } else {
                        tbody.innerHTML = `<tr><td colspan="4" class="text-center">Tidak ada data</td></tr>`;
                    }
                });
        }

        document.getElementById('bulan_partisipasi').addEventListener('change', fetchBkuRingkas);
        document.getElementById('tahun_partisipasi').addEventListener('change', fetchBkuRingkas);
        document.addEventListener('DOMContentLoaded', fetchBkuRingkas);

        document.getElementById('btnCetakPartisipasi').addEventListener('click', function(e) {
            e.preventDefault();
            const bulan = document.getElementById('bulan_partisipasi').value;
            const tahun = document.getElementById('tahun_partisipasi').value;
            const url = `/laporan/bku-ringkas/cetak?bulan=${bulan}&tahun=${tahun}`;
            window.open(url, '_blank');
        });
    </script>
@endpush
