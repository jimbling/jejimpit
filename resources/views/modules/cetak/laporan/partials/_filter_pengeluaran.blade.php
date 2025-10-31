{{-- resources/views/admin/laporan/_filter_pengeluaran.blade.php --}}
<form id="filterPengeluaran" class="row g-2">
    <div class="col-md-4">
        <label class="form-label">Kategori</label>
        <select name="kategori_id" class="form-select" id="kategori_pengeluaran">
            <option value="">-- Semua Kategori --</option>
            @foreach ($kategori as $kat)
                <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Bulan</label>
        <select name="bulan" class="form-select" id="bulan_pengeluaran">
            <option value="">-- Semua Bulan --</option>
            @foreach (range(1, 12) as $bln)
                <option value="{{ $bln }}">{{ \Carbon\Carbon::create()->month($bln)->translatedFormat('F') }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Tahun</label>
        <select name="tahun" class="form-select" id="tahun_pengeluaran">
            @foreach (range(now()->year - 1, now()->year + 1) as $thn)
                <option value="{{ $thn }}">{{ $thn }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 d-flex align-items-end">
        <a id="btnCetakPengeluaran" href="#" target="_blank" class="btn btn-success w-100">
            <i class="ti ti-printer"></i> Cetak
        </a>
    </div>
</form>

{{-- Preview hasil filter --}}
<div id="previewPengeluaran" class="mt-4">
    <div class="alert alert-info">Silakan pilih filter untuk melihat data pengeluaran.</div>

    <div id="preview-wrapper" class="d-none mt-3">
        <div id="preview-table"></div>
    </div>
</div>
