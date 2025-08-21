@extends('layouts.tabler')

@section('title', 'Kehadiran Petugas Jimpitan')
@section('page-title', 'Kehadiran Petugas Jimpitan')

@section('content')
    <div class="mb-3 d-flex align-items-center">
        <form method="GET" class="d-flex gap-2">
            <select name="bulan" class="form-select">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $selected_bulan == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                    </option>
                @endfor
            </select>
            <select name="tahun" class="form-select">
                @for ($y = now()->year; $y >= now()->year - 5; $y--)
                    <option value="{{ $y }}" {{ $selected_tahun == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>
            <button class="btn btn-primary">Filter</button>
        </form>
    </div>

    <div class="row row-deck row-cards">
        @forelse($kehadiran as $data)
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">{{ $data['petugas']->name }}</h3>
                        <span class="badge bg-success text-white">Total Transaksi: {{ $data['total_transaksi'] }}</span>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-sm btn-outline-primary mb-2" type="button" data-bs-toggle="collapse"
                            data-bs-target="#checkin-{{ $data['petugas']->id }}">
                            Lihat Detail Check-in
                        </button>
                        <div class="collapse" id="checkin-{{ $data['petugas']->id }}">
                            @if (count($data['checkins']) > 0)
                                <ul class="list-group list-group-flush">
                                    @foreach ($data['checkins'] as $checkin)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                <i class="fas fa-calendar-alt text-muted me-2"></i>
                                                {{ $checkin['tanggal'] }}
                                            </span>
                                            <span class="badge bg-primary text-white rounded-pill px-3 py-1">
                                                {{ $checkin['jumlah_transaksi'] }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted mb-0 text-center py-2">Belum ada check-in di bulan ini.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Belum ada data kehadiran petugas.
                </div>
            </div>
        @endforelse
    </div>
@endsection
