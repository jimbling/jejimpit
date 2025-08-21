@extends('layouts.tabler')

@section('title', 'Kehadiran Petugas Jimpitan')
@section('page-title', 'Kehadiran Petugas Jimpitan')

@section('content')
    <div class="container-xl">
        <div class="row row-deck row-cards">
            @forelse($kehadiran as $data)
                <div class="col-sm-6 col-lg-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">{{ $data['petugas']->name }}</h3>
                            <span class="badge bg-success">Total Transaksi: {{ $data['total_transaksi'] }}</span>
                        </div>
                        <div class="card-body">
                            @if (count($data['checkins']) > 0)
                                <ul class="list-group list-group-flush">
                                    @foreach ($data['checkins'] as $checkin)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>{{ $checkin['tanggal'] }}</span>
                                            <span class="badge bg-primary">{{ $checkin['jumlah_transaksi'] }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted mb-0">Belum ada check-in.</p>
                            @endif
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
    </div>
@endsection
