<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Penerimaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #000;
        }

        .kop-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }

        .kop {
            text-align: left;
            flex: 1;
        }

        .kop img {
            max-height: 70px;
            display: block;
            margin-bottom: 4px;
        }

        .alamat {
            font-size: 12px;
            margin-top: 4px;
        }

        h4 {
            text-align: center;
            margin: 0;
            margin-top: 8px;
        }

        p.subjudul {
            text-align: center;
            margin: 4px 0 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        tfoot th {
            background: #f0f0f0;
        }

        .ttd {
            margin-top: 40px;
            width: 100%;
        }

        .ttd td {
            width: 50%;
            vertical-align: top;
            text-align: center;
        }

        .nama {
            margin-top: 70px;
            font-weight: bold;
            text-decoration: underline;
        }

        .footer {
            margin-top: 50px;
            font-size: 11px;
            text-align: center;
            color: #555;
            border-top: 1px solid #ccc;
            padding-top: 6px;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="kop-wrapper">
        <div class="kop">
            @if (system_setting('kop_sekolah'))
                <img src="{{ Storage::url(system_setting('kop_sekolah')) }}" alt="Logo">
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
    </div>

    <h4>Laporan Penerimaan Jimpitan</h4>
    <p class="subjudul">Bulan {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Minggu</th>
                <th>Total Penerimaan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $row)
                <tr>
                    <td>{{ $row['label'] }}</td>
                    <td>Rp {{ number_format($row['total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Total Bulan</th>
                <th>Rp {{ number_format($total_bulan, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <table class="ttd">
        <tr>
            <td>
                Mengetahui,<br>
                Ketua RT 63
                <div class="nama">{{ system_setting('nama_rt') }}</div>
            </td>
            <td>
                Koordinator,<br>
                Kegiatan Jimpitan 63
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

</body>

</html>
