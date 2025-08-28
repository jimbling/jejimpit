<!DOCTYPE html>
<html lang="id">

<head>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 6px;
            font-size: 12px;
        }

        th {
            background: #f2f2f2;
        }

        .summary {
            margin-top: 20px;
        }

        .ttd {
            width: 100%;
            margin-top: 40px;
            text-align: center;
        }

        .ttd td {
            width: 50%;
            vertical-align: top;
            border: none;
        }

        .ttd .nama {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }

        .footer {
            margin-top: 30px;
            font-size: 11px;
            text-align: center;
            color: #444;
        }
    </style>
</head>

<body>

    <h3>
        Buku Kas Umum — Bulan
        {{ \Carbon\Carbon::createFromDate(null, (int) $bulan, 1)->translatedFormat('F') }} {{ $tahun }}
    </h3>

    @php
        $items = $items ?? collect();
        $total_masuk = $total_masuk ?? $items->sum('dana_masuk');
        $total_keluar = $total_keluar ?? $items->sum('dana_keluar');
        $saldo_awal =
            $saldo_awal ??
            (optional($items->firstWhere('is_saldo_awal', true))->saldo ?? ($items->first()->saldo ?? 0));
        $saldo_akhir =
            $saldo_akhir ??
            (optional($items->firstWhere('is_saldo_akhir', true))->saldo ?? ($items->last()->saldo ?? 0));
    @endphp

    <table>
        <thead>
            <tr>
                <th style="width:40px">No</th>
                <th style="width:90px">Tanggal</th>
                <th>Uraian</th>
                <th style="width:120px">Dana Masuk</th>
                <th style="width:120px">Dana Keluar</th>
                <th style="width:120px">Saldo</th>
                <th style="width:150px">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $i => $row)
                <tr>
                    <td class="text-center">{{ $row->no ?? $i + 1 }}</td>
                    <td class="text-center">{{ optional($row->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $row->uraian }}</td>
                    <td class="text-right">Rp {{ number_format($row->dana_masuk ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($row->dana_keluar ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($row->saldo ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $row->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Ringkasan --}}
    <table class="summary">
        <tr>
            <th style="text-align:left; width:200px">Saldo Awal</th>
            <td style="text-align:right">Rp {{ number_format($saldo_awal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th style="text-align:left">Total Dana Masuk</th>
            <td style="text-align:right">Rp {{ number_format($total_masuk, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th style="text-align:left">Total Dana Keluar</th>
            <td style="text-align:right">Rp {{ number_format($total_keluar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th style="text-align:left">Saldo Akhir</th>
            <td style="text-align:right"><strong>Rp {{ number_format($saldo_akhir, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    {{-- Tanda Tangan --}}
    <table class="ttd">
        <tr>
            <td>
                Mengetahui,<br>
                Ketua RT 63
                <div class="nama">{{ system_setting('nama_rt') }}</div>
            </td>
            <td>
                {{ system_setting('nama_dusun') }}, {{ $tanggal_akhir->translatedFormat('d F Y') }} <br>
                Koordinator Kegiatan Jimpitan 63
                <div class="nama">{{ system_setting('nama_koordinator') }}</div>
            </td>
        </tr>
    </table>


    {{-- Footer --}}
    <div class="footer">
        <em>
            Semua laporan kegiatan Jimpitan baik penerimaan, pengeluaran, keaktifan warga dan petugas
            dapat diakses pada <strong>www.jimpitan.remaked.web.id</strong>
        </em>
    </div>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>

</html>
