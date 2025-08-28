{{-- resources/views/modules/cetak/laporan/partisipasi.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Partisipasi Jimpitan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @page {
            size: A4 portrait;
            margin: 20mm;
        }

        body {
            font-size: 13px;
        }

        .table th,
        .table td {
            vertical-align: middle !important;
        }

        .table thead th {
            background-color: #f8f9fa;
        }

        h4,
        h5 {
            margin: 0;
            padding: 0;
        }

        .judul {
            text-align: center;
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        @php
            use Carbon\Carbon;

            $startFormatted = $start ? Carbon::parse($start)->translatedFormat('d F Y') : '-';
            $endFormatted = $end ? Carbon::parse($end)->translatedFormat('d F Y') : '-';
        @endphp

        {{-- Judul --}}
        <div class="judul">
            <h4>Rekap Partisipasi Jimpitan oleh Warga {{ system_setting('nama_dusun') }}</h4>
            <h5>Nama Warga: {{ $warga->nama_kk }}</h5>
            <h6>Tanggal Mulai: {{ $startFormatted ?? '-' }} &nbsp;&nbsp; | &nbsp;&nbsp; Tanggal Selesai:
                {{ $endFormatted ?? '-' }}</h6>
        </div>

        {{-- Tabel --}}
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">No</th>
                    <th>Tanggal</th>
                    <th>Nama Petugas</th>
                    <th class="text-end">Jumlah Setor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $trx)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($trx->tanggal)->translatedFormat('d/m/Y') }}</td>
                        <td>{{ $trx->user->name ?? '-' }}</td>
                        <td class="text-end">{{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada transaksi</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total</th>
                    <th class="text-end">{{ number_format($total, 0, ',', '.') }}</th>
                </tr>
            </tfoot>

        </table>

    </div>
    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>

</body>

</html>
