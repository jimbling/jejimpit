<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Warga - Jimpitan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            max-width: 21cm;
            margin: 0 auto;
            padding: 15px;
        }

        .card-warga {
            background: linear-gradient(135deg, #ffffff 0%, #f5f7fa 100%);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 12px;
            position: relative;
            overflow: hidden;
            height: 8.5cm;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-header {
            text-align: center;
            border-bottom: 1px dashed #e0e6ed;
            padding-bottom: 8px;
            margin-bottom: 8px;
            position: relative;
        }

        .card-title {
            font-size: 12px;
            font-weight: 700;
            color: #2e51bb;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .card-subtitle {
            font-size: 8px;
            color: #8392a5;
            margin: 0;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-grow: 1;
        }

        .qr-container {
            background: white;
            padding: 6px;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin: 5px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-details {
            text-align: center;
            margin-top: 8px;
        }

        .warga-name {
            font-size: 11px;
            font-weight: 700;
            color: #1b2e4b;
            margin: 0;
            line-height: 1.2;
        }

        .warga-code {
            font-size: 10px;
            color: #2e51bb;
            font-weight: 600;
            margin-top: 3px;
        }

        .card-footer {
            text-align: center;
            border-top: 1px dashed #e0e6ed;
            padding-top: 6px;
            margin-top: 8px;
            font-size: 7px;
            color: #8392a5;
        }

        .website {
            color: #2e51bb;
            font-weight: 600;
        }

        /* Ornament dan efek desain */
        .ornament-top {
            position: absolute;
            top: 0;
            right: 0;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #2e51bb 0%, #1b2e4b 100%);
            border-radius: 0 12px 0 40px;
            opacity: 0.1;
        }

        .ornament-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #2e51bb 0%, #1b2e4b 100%);
            border-radius: 0 0 0 12px;
            opacity: 0.1;
        }

        .pattern-dots {
            position: absolute;
            top: 15px;
            left: 15px;
            opacity: 0.05;
        }

        .pattern-dots::before {
            content: "";
            position: absolute;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: #2e51bb;
            box-shadow:
                8px 0 0 #2e51bb,
                0 8px 0 #2e51bb,
                8px 8px 0 #2e51bb;
        }

        /* Tombol cetak */
        .print-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 100;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Media query untuk cetak */
        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white;
            }

            .print-button {
                display: none;
            }

            .card-container {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                /* 3 kolom */
                gap: 0.5cm;
                /* jarak antar kartu */
                padding: 0.5cm;
                width: 21cm;
                max-width: 21cm;
                margin: 0 auto;
            }

            .card-warga {
                width: 6cm;
                /* lebar kartu */
                height: 9cm;
                /* tinggi kartu */
                box-shadow: none;
                border: 1px solid #e0e6ed;
                page-break-inside: avoid;
                box-sizing: border-box;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            @page {
                size: A4 portrait;
                margin: 0;
            }
        }

        .info-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #ffffff 100%);
            border-radius: 6px;
            padding: 6px 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            width: 100%;
            text-align: left;
            font-size: 9pt;
            color: #1b2e4b;
        }

        .info-card p {
            margin: 2px 0;
            line-height: 1.2;
        }
    </style>
</head>

<body>
    <button onclick="window.print()" class="btn btn-primary print-button">
        🖨️ Cetak Semua Kartu
    </button>

    <div class="card-container">
        @foreach ($wargas as $warga)
            <div class="card-warga">
                <div class="ornament-top"></div>
                <div class="ornament-bottom"></div>
                <div class="pattern-dots"></div>

                <div class="card-header">
                    <h5 class="card-title">QR-CODE WARGA</h5>
                    <p class="card-subtitle">Untuk Scan Petugas Jimpitan</p>
                </div>

                <div class="card-body">
                    <div class="qr-container">
                        <img src="data:image/png;base64,{{ $warga->qr_base64 }}" width="90" height="90"
                            alt="QR">
                    </div>

                    <div class="card-details">
                        <h6 class="warga-name">{{ $warga->nama_kk }}</h6>
                        <p class="warga-code">{{ $warga->kode_unik }}</p>
                    </div>

                    <!-- Section informasi tambahan -->
                    <div class="info-card mt-2">
                        <p><strong>Alamat:</strong> {{ $warga->alamat ?? '-' }}</p>
                        <p><strong>Nomor Rumah:</strong> {{ $warga->no_rumah ?? '-' }}</p>
                        <p><strong>Status:</strong> {{ $warga->status ?? '-' }}</p>
                    </div>
                </div>

                <div class="card-footer">
                    Laporan kegiatan jimpitan:<br>
                    <span class="website">jimpitan.remaked.web.id</span>
                </div>
            </div>
        @endforeach
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
