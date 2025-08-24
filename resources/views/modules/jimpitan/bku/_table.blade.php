<div class="alert alert-light border-start border-primary shadow-sm d-flex justify-content-between align-items-center">
    <div>
        <span class="fw-bold text-primary">Buku Kas Umum</span><br>
        <small class="text-muted">
            Bulan:
            <strong>{{ $bulan ? \Carbon\Carbon::create()->month((int) $bulan)->translatedFormat('F') : 'Semua' }}</strong>
            | Tahun: <strong>{{ $tahun ?? '-' }}</strong>
        </small>
    </div>
</div>




<div class="card table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Uraian</th>
                <th class="text-end">Dana Masuk</th>
                <th class="text-end">Dana Keluar</th>
                <th class="text-end">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bku ?? [] as $row)
                <tr @class([
                    'fw-bold bg-light' => $row->is_saldo_awal,
                    'fw-bold bg-secondary text-white' => $row->is_saldo_akhir,
                ])>
                    <td>{{ $row->no }}</td>
                    <td>{{ $row->tanggal?->format('d/m/Y') }}</td>
                    <td>{{ $row->uraian }}</td>
                    <td class="text-end">{{ number_format($row->dana_masuk, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($row->dana_keluar, 0, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($row->saldo, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
