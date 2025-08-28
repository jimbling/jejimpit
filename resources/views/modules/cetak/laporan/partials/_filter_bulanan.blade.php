<form id="filterBulananForm" class="row g-3 mb-3">
    <div class="col-md-3">
        <label for="bulan_bku" class="form-label">Bulan</label>
        <select id="bulan_bku" class="form-select">
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                </option>
            @endfor
        </select>
    </div>
    <div class="col-md-2">
        <label for="tahun_bku" class="form-label">Tahun</label>
        <input type="number" id="tahun_bku" class="form-control" value="{{ now()->year }}">
    </div>
    <div class="col-md-2 align-self-end">
        <button type="submit" class="btn btn-primary">Tampilkan</button>
    </div>
</form>

<div id="laporanBulananCard" class="card d-none">
    <div class="card-body">
        <h5 class="card-title">Laporan BKU Bulanan</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Uraian</th>
                        <th>Penerimaan</th>
                        <th>Pengeluaran</th>
                        <th>Saldo</th>
                    </tr>
                </thead>
                <tbody id="laporanBulananBody"></tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">Total Bulan</th>
                        <th id="laporanBulananPenerimaan"></th>
                        <th id="laporanBulananPengeluaran"></th>
                        <th id="laporanBulananSaldo"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <a href="#" target="_blank" id="btnCetakBku" class="btn btn-success mt-3">Cetak</a>
    </div>
</div>
