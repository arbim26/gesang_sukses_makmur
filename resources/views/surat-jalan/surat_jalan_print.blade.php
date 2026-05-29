<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan {{ $suratJalan->No_SJ }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #000;
            background: #fff;
        }

        .page {
            width: 210mm;
            min-height: 148mm; /* A5 height-ish, like a delivery note booklet */
            margin: 0 auto;
            padding: 10mm 14mm 10mm 14mm;
        }

        /* ── Header ── */
        .header {
            display: flex;
            align-items: flex-start;
            margin-bottom: 6px;
            border-bottom: 2px solid #1a3a8f;
            padding-bottom: 8px;
        }

        .logo-circle {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            border: 3px solid #1a3a8f;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .logo-circle .gs-text {
            font-size: 16px;
            font-weight: 900;
            color: #1a3a8f;
            letter-spacing: -1px;
        }

        .company-info h1 {
            font-size: 18px;
            font-weight: 900;
            letter-spacing: 1.5px;
            color: #1a3a8f;
            font-family: Arial, sans-serif;
        }

        .company-info .tagline {
            font-size: 8.5px;
            color: #333;
            font-style: italic;
            font-weight: bold;
            letter-spacing: 0.3px;
            margin-top: 1px;
        }

        .company-info .address {
            font-size: 7.5px;
            color: #555;
            margin-top: 3px;
            line-height: 1.4;
        }

        /* ── Title ── */
        .sj-title-block {
            margin-bottom: 8px;
        }

        .sj-title {
            font-size: 15px;
            font-weight: 900;
            letter-spacing: 3px;
            text-align: center;
            color: #1a3a8f;
            margin: 6px 0 4px 0;
            text-decoration: underline;
        }

        /* Meta table: Kepada Yth., No. SJ, Tanggal, No. PO */
        .meta-block {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .kepada-block {
            flex: 1;
        }

        .kepada-block .kepada-label {
            font-size: 10px;
            margin-bottom: 2px;
        }

        .kepada-block .kepada-value {
            font-size: 11px;
            font-weight: bold;
            border-bottom: 1px solid #000;
            min-width: 200px;
            padding-bottom: 2px;
        }

        .sj-meta {
            min-width: 230px;
        }

        .sj-meta table {
            width: 100%;
            font-size: 10px;
            border-collapse: collapse;
        }

        .sj-meta table td {
            padding: 1px 3px;
        }

        /* ── Items Table ── */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #1a3a8f;
            padding: 4px 7px;
        }

        .items-table thead th {
            background: #fff;
            font-weight: bold;
            text-align: center;
            font-size: 10px;
            color: #1a3a8f;
        }

        .items-table tbody td {
            font-size: 10px;
            min-height: 18px;
        }

        .items-table .no-col { width: 30px; text-align: center; }
        .items-table .kode-col { width: 90px; }
        .items-table .nama-col { min-width: 160px; }
        .items-table .qty-col { width: 60px; text-align: center; }
        .items-table .ket-col { width: 100px; }

        /* ── Signature Footer ── */
        .footer-sig {
            display: flex;
            justify-content: space-between;
            margin-top: 12px;
        }

        .sig-block {
            text-align: center;
            min-width: 160px;
        }

        .sig-block .sig-title {
            font-size: 10px;
            margin-bottom: 35px; /* space for signature */
        }

        .sig-block .sig-line {
            border-top: 1px solid #000;
            width: 130px;
            margin: 0 auto 3px auto;
        }

        .sig-block .sig-name {
            font-size: 10px;
            font-style: italic;
        }

        /* ── Print settings ── */
        @media print {
            body { margin: 0; }
            .page { margin: 0; padding: 8mm 12mm; }
            .no-print { display: none !important; }
        }

        @media screen {
            body { background: #e5e7eb; }
            .page {
                margin: 20px auto;
                box-shadow: 0 4px 24px rgba(0,0,0,.15);
                background: #fff;
                min-height: 297mm; /* Show as full A4 on screen */
            }
            .print-toolbar {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                background: #1a1a2e;
                color: #fff;
                padding: 10px 20px;
                display: flex;
                align-items: center;
                gap: 12px;
                z-index: 999;
                font-family: Arial, sans-serif;
                font-size: 13px;
            }
            .print-toolbar .btn-print {
                background: #4f46e5;
                color: #fff;
                border: none;
                padding: 6px 18px;
                border-radius: 5px;
                cursor: pointer;
                font-size: 13px;
                font-weight: bold;
            }
            .print-toolbar .btn-back {
                background: transparent;
                color: #aaa;
                border: 1px solid #555;
                padding: 6px 14px;
                border-radius: 5px;
                cursor: pointer;
                font-size: 13px;
                text-decoration: none;
            }
            .page { margin-top: 60px; }
        }
    </style>
</head>
<body>

<div class="print-toolbar no-print">
    <a href="{{ route('surat-jalan.show', $suratJalan->No_SJ) }}" class="btn-back">← Kembali</a>
    <span style="flex:1; font-weight:bold;">Surat Jalan {{ $suratJalan->No_SJ }}</span>
    <button class="btn-print" onclick="window.print()">🖨 Cetak</button>
</div>

<div class="page">

    {{-- ── HEADER ── --}}
    <div class="header">
        <div class="logo-circle">
            <span class="gs-text">GS</span>
        </div>
        <div class="company-info">
            <h1>PT. GESANG SUKSES MAKMUR</h1>
            <div class="tagline">Machining, Jig, Mold, Dies, Precision Part, Fabrication</div>
            <div class="address">
                Jl. Bernang Raya Blok G3 No. 212 RT.003 RW.010 Jayamukti, Cikarang Pusat Telp. 021-89329258 &nbsp; Email : gs.makmur08@gmail.com<br>
                Workshop : Jl. Pasir Gombong RT.04 RW.06 Belakang Ruko Hario Irigasi
            </div>
        </div>
    </div>

    {{-- ── TITLE ── --}}
    <div class="sj-title">SURAT JALAN</div>

    {{-- ── META ── --}}
    <div class="meta-block">
        <div class="kepada-block">
            <div class="kepada-label">Kepada Yth.</div>
            <div class="kepada-value">{{ $suratJalan->purchaseOrder->customer->Nama ?? '-' }}</div>
        </div>
        <div class="sj-meta">
            <table>
                <tr>
                    <td>No. Surat Jalan</td>
                    <td>: {{ $suratJalan->No_SJ }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ \Carbon\Carbon::parse($suratJalan->Tanggal)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td>No. PO</td>
                    <td>: {{ $suratJalan->No_PO }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ── ITEMS TABLE ── --}}
    <table class="items-table">
        <thead>
            <tr>
                <th class="no-col">No</th>
                <th class="kode-col">Kode Barang</th>
                <th class="nama-col">Nama Barang</th>
                <th class="qty-col">Qty</th>
                <th class="ket-col">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suratJalan->purchaseOrder->details as $i => $d)
            <tr>
                <td class="no-col">{{ $i + 1 }}</td>
                <td class="kode-col">{{ $d->No_Barang }}</td>
                <td class="nama-col">{{ $d->barang->Nama_Barang ?? '-' }}</td>
                <td class="qty-col">{{ $d->Qty }}</td>
                <td class="ket-col">
                    @if($i === 0 && $suratJalan->Keterangan)
                        {{ $suratJalan->Keterangan }}
                    @endif
                </td>
            </tr>
            @endforeach

            {{-- Empty rows --}}
            @for($r = 0; $r < max(0, 6 - $suratJalan->purchaseOrder->details->count()); $r++)
            <tr>
                <td style="height:20px;">&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endfor
        </tbody>
    </table>

    {{-- ── SIGNATURE FOOTER ── --}}
    <div class="footer-sig">
        {{-- Penerima --}}
        <div class="sig-block">
            <div class="sig-title">
                Penerima,<br>
                Cap/Tanda tangan &amp; Tanggal
            </div>
            <br><br><br>
            <div class="sig-line"></div>
            <div class="sig-name">( .................................................. )</div>
        </div>

        {{-- Pengirim --}}
        <div class="sig-block">
            <div class="sig-title">
                Pengirim,<br>
                PT. Gesang Sukses Makmur
            </div>
            <br><br><br>
            <div class="sig-line"></div>
            <div class="sig-name">( {{ $suratJalan->supir->Nama_Pegawai ?? '..........................................' }} )</div>
        </div>
    </div>

</div>
</body>
</html>
