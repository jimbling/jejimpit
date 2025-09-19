<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Warga - Jimpitan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            max-width: 21cm;
            margin: 0 auto;
            padding: 20px;
        }

        .card-warga {
            background: linear-gradient(135deg, #af0060 0%, #8a004c 100%);
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            padding: 15px;
            position: relative;
            overflow: hidden;
            height: 9cm;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 2px solid #ffd700;
            transition: transform 0.3s ease;
        }

        .card-warga:hover {
            transform: translateY(-5px);
        }

        .card-header {
            text-align: center;
            border-bottom: 2px dashed rgba(255, 255, 255, 0.4);
            padding-bottom: 10px;
            margin-bottom: 10px;
            position: relative;
        }

        .card-title {
            font-size: 14px;
            font-weight: 800;
            color: #ffffff;
            margin: 0;
            letter-spacing: 1px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .card-subtitle {
            font-size: 9px;
            color: #f8f8f8;
            margin: 3px 0 0;
            font-weight: 500;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-grow: 1;
            position: relative;
            z-index: 2;
        }

        .qr-container {
            background: rgb(255, 255, 255);
            padding: 8px;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            margin: 8px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #e0e0e0;
        }

        .card-details {
            text-align: center;
            margin-top: 2px;
        }

        .warga-name {
            font-size: 22px;
            font-weight: 800;
            color: #ffffff;
            margin: 0;
            line-height: 1.1;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-shadow: 2px 2px 3px rgba(0, 0, 0, 0.2);
        }

        .warga-code {
            font-size: 11px;
            color: #f8f8f8;
            font-weight: 600;
            margin-top: 2px;
            letter-spacing: 0.5px;
            background: rgba(0, 0, 0, 0.2);
            padding: 3px 8px;
            border-radius: 12px;
            display: inline-block;
        }

        .card-footer {
            text-align: center;
            border-top: 2px dashed rgba(255, 255, 255, 0.4);
            padding-top: 2px;
            margin-top: 10px;
            font-size: 11px;
            font-weight: bold;
            color: #fdfdfd;
            position: relative;
            z-index: 2;
        }

        .website {
            color: #ffd700;
            font-weight: 700;
            text-decoration: none;
        }

        /* Ornament dan efek desain baru */
        .ornament-corner {
            position: absolute;
            width: 60px;
            height: 60px;
            opacity: 0.15;
            z-index: 1;
        }

        .ornament-top-right {
            top: 0;
            right: 0;
            background: linear-gradient(135deg, transparent 50%, #ffd700 50%);
            border-radius: 0 16px 0 60px;
        }

        .ornament-bottom-left {
            bottom: 0;
            left: 0;
            background: linear-gradient(315deg, transparent 50%, #ffd700 50%);
            border-radius: 0 0 0 16px;
        }

        .pattern-dots {
            position: absolute;
            top: 20px;
            left: 20px;
            opacity: 0.08;
        }

        .pattern-dots::before {
            content: "";
            position: absolute;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #ffd700;
            box-shadow:
                10px 0 0 #ffd700,
                0 10px 0 #ffd700,
                10px 10px 0 #ffd700,
                20px 0 0 #ffd700,
                20px 10px 0 #ffd700,
                20px 20px 0 #ffd700,
                10px 20px 0 #ffd700,
                0 20px 0 #ffd700;
        }

        .ornament-circle {
            position: absolute;
            width: 80px;
            height: 80px;
            border: 3px solid rgba(255, 215, 0, 0.2);
            border-radius: 50%;
            bottom: -30px;
            right: -30px;
            z-index: 1;
        }

        .ornament-stripe {
            position: absolute;
            height: 20px;
            width: 100%;
            background: rgba(255, 215, 0, 0.1);
            bottom: 40px;
            left: 0;
            transform: skewY(-2deg);
            z-index: 1;
        }

        /* Info card styling */
        .info-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 248, 248, 0.9) 100%);
            border-radius: 8px;
            padding: 6px 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            text-align: left;
            font-size: 9pt;
            color: #1b2e4b;
            margin-top: 1px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(2px);
        }

        .info-card p {
            margin: 3px 0;
            line-height: 0.3;
        }

        .info-card strong {
            color: #af0060;
        }

        /* Icon decorations */
        .icon-house {
            position: absolute;
            top: 15px;
            right: 15px;
            color: rgba(255, 255, 255, 0.2);
            font-size: 24px;
            z-index: 1;
        }

        .icon-community {
            position: absolute;
            bottom: 15px;
            left: 15px;
            color: rgba(255, 255, 255, 0.2);
            font-size: 20px;
            z-index: 1;
        }

        /* Tombol cetak */
        .print-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 100;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            border-radius: 50px;
            padding: 12px 24px;
            font-weight: 600;
            background: linear-gradient(135deg, #af0060 0%, #8a004c 100%);
            border: none;
        }

        /* Garis panduan potong */
        .crop-mark {
            display: none;
            position: absolute;
            background-color: #000;
            z-index: 1000;
        }

        .crop-mark-horizontal {
            width: 20px;
            height: 1px;
        }

        .crop-mark-vertical {
            width: 1px;
            height: 20px;
        }

        .crop-top-left-h {
            top: 0;
            left: 0;
        }

        .crop-top-left-v {
            top: 0;
            left: 0;
        }

        .crop-top-right-h {
            top: 0;
            right: 0;
        }

        .crop-top-right-v {
            top: 0;
            right: 0;
        }

        .crop-bottom-left-h {
            bottom: 0;
            left: 0;
        }

        .crop-bottom-left-v {
            bottom: 0;
            left: 0;
        }

        .crop-bottom-right-h {
            bottom: 0;
            right: 0;
        }

        .crop-bottom-right-v {
            bottom: 0;
            right: 0;
        }

        /* Media query untuk cetak */
        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white;
            }

            .warga-name {
                text-transform: uppercase;
            }

            .print-button {
                display: none;
            }

            .card-container {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 0.5cm;
                padding: 0.5cm;
                width: 21cm;
                max-width: 21cm;
                margin: 0 auto;
            }

            .card-warga {
                width: 6cm;
                height: 9cm;
                box-shadow: none;
                border: 1px solid #e0e6ed;
                page-break-inside: avoid;
                box-sizing: border-box;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                position: relative;
            }

            /* Tampilkan garis panduan potong saat mencetak */
            .crop-mark {
                display: block;
            }

            @page {
                size: A4 portrait;
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <button onclick="window.print()" class="btn btn-primary print-button">
        <i class="fas fa-print me-2"></i> Cetak Semua Kartu
    </button>

    <div class="card-container">
        @foreach ($wargas as $warga)
            <div class="card-warga">
                <!-- Garis panduan potong -->
                <div class="crop-mark crop-mark-horizontal crop-top-left-h"></div>
                <div class="crop-mark crop-mark-vertical crop-top-left-v"></div>
                <div class="crop-mark crop-mark-horizontal crop-top-right-h"></div>
                <div class="crop-mark crop-mark-vertical crop-top-right-v"></div>
                <div class="crop-mark crop-mark-horizontal crop-bottom-left-h"></div>
                <div class="crop-mark crop-mark-vertical crop-bottom-left-v"></div>
                <div class="crop-mark crop-mark-horizontal crop-bottom-right-h"></div>
                <div class="crop-mark crop-mark-vertical crop-bottom-right-v"></div>

                <!-- Ornament dan dekorasi -->
                <div class="ornament-corner ornament-top-right"></div>
                <div class="ornament-corner ornament-bottom-left"></div>
                <div class="pattern-dots"></div>
                <div class="ornament-circle"></div>
                <div class="ornament-stripe"></div>
                <i class="fas fa-home icon-house"></i>
                <i class="fas fa-users icon-community"></i>

                <div class="card-header">
                    <h5 class="card-title">QR JIMPITAN 63</h5>
                </div>

                <div class="card-body">
                    <div class="qr-container">
                        <img src="data:image/png;base64,{{ $warga->qr_base64 }}" width="95" height="95"
                            alt="QR Code Warga">
                    </div>

                    <div class="card-details">
                        <h6 class="warga-name">{{ $warga->nama_kk }}</h6>
                        <p class="warga-code">{{ $warga->kode_unik }}</p>
                    </div>

                    <!-- Section informasi tambahan -->
                    <div class="info-card">
                        <p><strong><i class="fas fa-map-marker-alt me-1"></i> Alamat:</strong>
                            {{ $warga->alamat ?? '-' }}</p>
                        <p><strong><i class="fas fa-house me-1"></i> Nomor Rumah:</strong> {{ $warga->no_rumah ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="card-footer">
                    <span class="website">www.jimpitan.remaked.web.id</span>
                </div>
            </div>
        @endforeach
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
