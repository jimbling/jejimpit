{{-- resources/views/admin/laporan/_filter_partisipasi.blade.php --}}
<form id="filterPartisipasi" class="row g-2">
    <div class="col-md-3">
        <label class="form-label">Jenis</label>
        <select id="jenis_partisipasi" class="form-select">
            <option value="bulanan">Bulanan</option>
            <option value="tahunan">Tahunan</option>
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Bulan</label>
        <select id="bulan_partisipasi" class="form-select">
            @foreach (range(1, 12) as $bln)
                <option value="{{ $bln }}">{{ \Carbon\Carbon::create()->month($bln)->translatedFormat('F') }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Tahun</label>
        <select id="tahun_partisipasi" class="form-select">
            @foreach (range(now()->year - 1, now()->year + 1) as $thn)
                <option value="{{ $thn }}">{{ $thn }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <a id="btnCetakPartisipasi" href="#" target="_blank" class="btn btn-success w-100">
            <i class="ti ti-printer"></i> Cetak
        </a>
    </div>
</form>
