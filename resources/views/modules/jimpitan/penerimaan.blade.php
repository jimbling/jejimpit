@extends('layouts.tabler')

@section('title', ' Penerimaan Jimpitan')
@section('page-title', ' Penerimaan Jimpitan')

@section('content')
    <div class="container-xl">

        <!-- Filter Bulan & Tahun -->
        <form method="GET" class="row g-2 mb-4">
            <div class="col-auto">
                <select name="bulan" class="form-select">
                    @foreach (range(1, 12) as $b)
                        <option value="{{ $b }}" {{ $b == $bulan ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($b)->format('F') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <input type="number" name="tahun" class="form-control" value="{{ $tahun }}">
            </div>
            <div class="col-auto">
                <button class="btn btn-primary"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-filter">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z" />
                    </svg>Filter</button>
            </div>
        </form>

        <!-- penerimaan Mingguan -->
        <div class="card mb-4">
            <div class="card-header">
                penerimaan Mingguan
                <form action="{{ route('penerimaan.generate-mingguan') }}" method="POST" class="d-inline float-end">
                    @csrf
                    <input type="hidden" name="bulan" value="{{ $bulan }}">
                    <input type="hidden" name="tahun" value="{{ $tahun }}">
                    <button class="btn btn-sm btn-success">Generate Mingguan</button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Minggu</th>
                            <th>Total Penerimaan</th>
                            <th>Locked</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penerimaanMingguan as $minggu)
                            <tr>
                                <td>{{ $minggu->minggu }}</td>
                                <td>Rp {{ number_format($minggu->total, 0, ',', '.') }}</td>
                                <td>{{ $minggu->locked ? 'Ya' : 'Tidak' }}</td>
                                <td>
                                    @if (!$minggu->locked)
                                        <form action="{{ route('penerimaan.hapus-mingguan', $minggu->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                        <form action="{{ route('penerimaan.lock-mingguan', $minggu->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-warning">Lock</button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada penerimaan Mingguan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- penerimaan Bulanan -->
        <div class="card mb-4">
            <div class="card-header">
                penerimaan Bulanan
                <form action="{{ route('penerimaan.generate-bulanan') }}" method="POST" class="d-inline float-end">
                    @csrf
                    <input type="hidden" name="bulan" value="{{ $bulan }}">
                    <input type="hidden" name="tahun" value="{{ $tahun }}">
                    <button class="btn btn-sm btn-success">Generate Bulanan</button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Saldo Awal</th>
                            <th>Total Penerimaan</th>
                            <th>Saldo Akhir</th>
                            <th>Locked</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($penerimaanBulanan)
                            <tr>
                                <td>{{ \Carbon\Carbon::create()->month($penerimaanBulanan->bulan)->format('F') }}
                                    {{ $penerimaanBulanan->tahun }}</td>
                                <td>Rp {{ number_format($penerimaanBulanan->saldo_awal, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($penerimaanBulanan->total_penerimaan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($penerimaanBulanan->saldo_akhir, 0, ',', '.') }}</td>
                                <td>{{ $penerimaanBulanan->locked ? 'Ya' : 'Tidak' }}</td>
                                <td>
                                    @if (!$penerimaanBulanan->locked)
                                        <form action="{{ route('penerimaan.hapus-bulanan', $penerimaanBulanan->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                        <form action="{{ route('penerimaan.lock-bulanan', $penerimaanBulanan->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button class="btn btn-sm btn-warning">Lock</button>
                                        </form>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="6" class="text-center">Belum ada penerimaan Bulanan</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
