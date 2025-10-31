<div class="card">
    <div class="card-body">
        <form id="filterMingguanForm" class="row g-2">
            {{-- Pilih Bulan --}}
            <div class="col-md-4">
                <label for="mingguan_bulan" class="form-label">Bulan</label>
                <select name="bulan" id="mingguan_bulan" class="form-select">
                    @foreach (range(1, 12) as $bln)
                        <option value="{{ $bln }}" {{ request('bulan', $bulan) == $bln ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($bln)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Pilih Tahun --}}
            <div class="col-md-4">
                <label for="mingguan_tahun" class="form-label">Tahun</label>
                <select name="tahun" id="mingguan_tahun" class="form-select">
                    @foreach (range(now()->year - 1, now()->year + 1) as $thn)
                        <option value="{{ $thn }}" {{ request('tahun', $tahun) == $thn ? 'selected' : '' }}>
                            {{ $thn }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="ti ti-filter"></i> Tampilkan
                </button>
                <a id="btnCetakMingguan" href="#" target="_blank" class="btn btn-success">
                    <i class="ti ti-printer"></i> Cetak PDF
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Data --}}
<div class="card mt-3 d-none" id="laporanMingguanCard">
    <div class="card-body">
        <h4 class="mb-3">Laporan Penerimaan Mingguan</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Minggu</th>
                    <th>Total Penerimaan</th>
                </tr>
            </thead>
            <tbody id="laporanMingguanBody">
                <tr>
                    <td colspan="2" class="text-center">Belum ada data</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>Total Bulan</th>
                    <th id="laporanMingguanTotal">Rp 0</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
