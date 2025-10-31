<!DOCTYPE html>
<html lang="id">

<head>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        .kop-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }

        .kop {
            text-align: left;
            flex: 1;
        }

        .kop.kanan {
            text-align: right;
            flex: 0 0 auto;
        }

        .kop img {
            max-height: 70px;
            display: block;
            margin-bottom: 4px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 6px;
            font-size: 12px;
            text-align: center;
        }

        th {
            background: #f2f2f2;
        }

        .summary {
            margin-top: 20px;
            width: 50%;
        }

        .summary td {
            border: none;
            text-align: right;
            padding: 4px 6px;
        }

        .summary th {
            border: none;
            text-align: left;
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
    <div class="kop-wrapper">
        <div class="kop">
            @if (system_setting('kop_sekolah'))
                <img src="{{ Storage::url(system_setting('kop_sekolah')) }}" alt="Logo Sekolah">
            @endif
            <div class="alamat">
                {{ system_setting('nama_dusun') }},
                {{ system_setting('desa_kelurahan') }},
                {{ system_setting('kecamatan') }},
                {{ system_setting('kabupaten_kota') }},
                {{ system_setting('provinsi') }},
                Kode Pos {{ system_setting('kode_pos') }}
            </div>
        </div>

        <div class="kop kanan">
            @if (system_setting('logo'))
                <img src="{{ Storage::url(system_setting('logo')) }}" alt="Logo Kanan">
            @endif
        </div>
    </div>

    <h3>Buku Kas Umum Ringkas — Bulan
        {{ \Carbon\Carbon::createFromDate(null, (int) $bulan, 1)->translatedFormat('F') }} {{ $tahun }}
    </h3>

    @php
        $saldo_awal = $saldo_awal ?? ($items->first()->saldo ?? 0);
        $saldo_akhir = $saldo_akhir ?? ($items->last()->saldo ?? 0);
        $total_masuk = $items->sum('penerimaan');
        $total_keluar = $items->sum('pengeluaran');
    @endphp

    <table>
        <thead>
            <tr>
                <th>Minggu</th>
                <th>Penerimaan</th>
                <th>Pengeluaran</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $row)
                <tr>
                    <td>{{ $row['minggu'] }}</td>
                    <td>Rp {{ number_format($row['penerimaan'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($row['pengeluaran'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($row['saldo'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <th>Total Bulan</th>
                <th>Rp {{ number_format($total_masuk, 0, ',', '.') }}</th>
                <th>Rp {{ number_format($total_keluar, 0, ',', '.') }}</th>
                <th>Rp {{ number_format($saldo_akhir, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
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
                {{ system_setting('nama_dusun') }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }} <br>
                Koordinator Kegiatan Jimpitan 63
                <div class="nama">{{ system_setting('nama_koordinator') }}</div>
            </td>
        </tr>
    </table>

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
