<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->No_Invoice }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            background: #fff;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 15mm 15mm 15mm 15mm;
        }

        /* ── Header ── */
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
        }

        .logo-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid #1a3a8f;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .logo-circle .gs-text {
            font-size: 18px;
            font-weight: 900;
            color: #1a3a8f;
            letter-spacing: -1px;
        }

        .company-info h1 {
            font-size: 22px;
            font-weight: 900;
            letter-spacing: 2px;
            color: #000;
            font-family: Arial, sans-serif;
        }

        .company-info .tagline {
            font-size: 9px;
            color: #333;
            font-style: italic;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .company-info .address {
            font-size: 8px;
            color: #555;
            margin-top: 2px;
        }

        .invoice-title-box {
            border: 2px solid #000;
            text-align: center;
            padding: 4px 30px;
            font-size: 16px;
            font-weight: 900;
            letter-spacing: 3px;
            margin: 10px 0;
            display: inline-block;
            align-self: center;
        }

        .header-right {
            margin-left: auto;
            text-align: right;
        }

        /* ── Customer & Meta Section ── */
        .meta-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            align-items: flex-start;
        }

        .customer-block {
            flex: 1;
        }

        .customer-block .label {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .customer-block .name {
            font-size: 12px;
            font-weight: bold;
        }

        .customer-block .address-line {
            font-size: 11px;
        }

        .invoice-meta {
            min-width: 220px;
        }

        .invoice-meta table {
            width: 100%;
            font-size: 11px;
            border-collapse: collapse;
        }

        .invoice-meta table td {
            padding: 1px 3px;
        }

        .invoice-meta table td:first-child {
            font-weight: normal;
            white-space: nowrap;
        }

        /* ── Items Table ── */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #000;
            padding: 5px 8px;
        }

        .items-table thead th {
            background: #fff;
            font-weight: bold;
            text-align: center;
            font-size: 11px;
        }

        .items-table tbody td {
            font-size: 11px;
        }

        .items-table .no-col { width: 35px; text-align: center; }
        .items-table .desc-col { min-width: 200px; }
        .items-table .qty-col { width: 70px; text-align: center; }
        .items-table .price-col { width: 130px; text-align: right; }
        .items-table .amount-col { width: 140px; text-align: right; }

        .items-table .group-header td {
            font-weight: bold;
            font-size: 11px;
            border-bottom: none;
        }

        /* Summary rows */
        .summary-row td {
            border-left: none;
            border-right: none;
            border-bottom: none;
            text-align: right;
            padding: 3px 8px;
            font-size: 11px;
        }

        .summary-row td:last-child {
            border: 1px solid #000;
            min-width: 140px;
        }

        .summary-row td:nth-last-child(2) {
            border: none;
        }

        .summary-grand td {
            font-weight: bold;
        }

        /* Footer rows inside table */
        .total-section {
            width: 100%;
            border-collapse: collapse;
        }

        .total-section td {
            border: 1px solid #000;
            padding: 4px 8px;
            font-size: 11px;
        }

        .total-section .label-cell {
            text-align: right;
            font-weight: normal;
            border-left: none;
        }

        .total-section .value-cell {
            text-align: right;
            min-width: 140px;
        }

        /* ── Footer ── */
        .footer-section {
            display: flex;
            justify-content: space-between;
            margin-top: 16px;
            align-items: flex-start;
        }

        .note-block {
            flex: 1;
            max-width: 55%;
        }

        .note-block .note-title {
            font-size: 11px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 4px;
        }

        .note-block .bank-info {
            font-size: 11px;
        }

        .note-block .bank-info p {
            margin: 1px 0;
        }

        .note-block .bank-info .field-row {
            display: flex;
            gap: 4px;
        }

        .note-block .bank-info .field-row .fl {
            min-width: 55px;
            font-weight: normal;
        }

        .signature-block {
            text-align: center;
            min-width: 180px;
        }

        .signature-block .regards {
            font-size: 11px;
            margin-bottom: 8px;
        }

        .signature-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 2px solid #1a3a8f;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px auto;
        }

        .signature-circle .gs-logo {
            font-size: 16px;
            font-weight: 900;
            color: #1a3a8f;
        }

        .signature-block .signer-name {
            font-size: 11px;
        }

        /* ── Print settings ── */
        @media print {
            body { margin: 0; }
            .page { margin: 0; padding: 10mm 12mm; }
            .no-print { display: none !important; }
        }

        /* Screen preview toolbar */
        @media screen {
            body { background: #e5e7eb; }
            .page {
                margin: 20px auto;
                box-shadow: 0 4px 24px rgba(0,0,0,.15);
                background: #fff;
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

        .divider-line {
            border-top: 1.5px solid #000;
            margin: 6px 0;
        }

        .header-wrapper {
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }

        .header-top {
            display: flex;
            align-items: center;
        }

        .invoice-badge {
            border: 2px solid #000;
            padding: 4px 24px;
            font-size: 15px;
            font-weight: 900;
            letter-spacing: 4px;
            margin: 8px auto;
            display: block;
            text-align: center;
            width: fit-content;
        }
    </style>
</head>
<body>

<div class="print-toolbar no-print">
    <a href="{{ route('invoice.show', $invoice->No_Invoice) }}" class="btn-back">← Kembali</a>
    <span style="flex:1; font-weight:bold;">Invoice {{ $invoice->No_Invoice }}</span>
    <button class="btn-print" onclick="window.print()">🖨 Cetak</button>
</div>

<div class="page">

    {{-- ── HEADER ── --}}
    <div class="header-wrapper">
        <div class="header-top">
            {{-- Logo --}}
            <div class="logo-circle">
                <span class="gs-text">GS</span>
            </div>
            {{-- Company name --}}
            <div class="company-info">
                <h1>PT. GESANG SUKSES MAKMUR</h1>
                <div class="tagline">Machining, Jig, Mold, Dies, Precision Part, Fabrication</div>
                <div class="address">
                    Jl. Bernang Raya Blok 6-3 No.212 RT.003 RW.010 Jayamukti, Cikarang Pusat
                    Telp. 021-89329258 &nbsp; Email : gs.makmur08@gmail.com
                </div>
            </div>
        </div>
        <div class="invoice-badge">INVOICE</div>
    </div>

    {{-- ── CUSTOMER & META ── --}}
    <div class="meta-section">
        <div class="customer-block">
            <div class="label">Customer :</div>
            <div class="name">{{ $invoice->purchaseOrder->customer->Nama ?? '-' }}</div>
            @if($invoice->purchaseOrder->customer->PIC ?? null)
                <div class="address-line">{{ $invoice->purchaseOrder->customer->PIC }}</div>
            @endif
        </div>
        <div class="invoice-meta">
            <table>
                <tr>
                    <td>Nomor</td>
                    <td>: {{ $invoice->No_Invoice }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ \Carbon\Carbon::parse($invoice->tanggal_terbit)->format('d F Y') }}</td>
                </tr>
                <tr>
                    <td>PO No</td>
                    <td>: {{ $invoice->No_PO ?? ':-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ── ITEMS TABLE ── --}}
    <table class="items-table">
        <thead>
            <tr>
                <th class="no-col">No</th>
                <th class="desc-col">Description</th>
                <th class="qty-col">Qty</th>
                <th class="price-col">Unit Price</th>
                <th class="amount-col">Amount</th>
            </tr>
        </thead>
        <tbody>
            {{-- Group header based on Metode --}}
            @php
                $grouped = $invoice->purchaseOrder->details->groupBy('Metode');
            @endphp

            @foreach($grouped as $metode => $items)
            <tr class="group-header">
                <td></td>
                <td><strong>{{ $metode }}</strong></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @foreach($items as $i => $d)
            <tr>
                <td class="no-col">{{ $i + 1 }}</td>
                <td>{{ strtoupper($d->barang->Nama_Barang ?? $d->No_Barang) }}</td>
                <td class="qty-col">{{ $d->Qty }} Pcs</td>
                <td class="price-col">Rp &nbsp; {{ number_format($d->Unit_Price, 0, ',', '.') }}</td>
                <td class="amount-col">Rp &nbsp; {{ number_format($d->Amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            @endforeach

            {{-- Empty rows for spacing (like original form) --}}
            @for($r = 0; $r < max(0, 5 - $invoice->purchaseOrder->details->count()); $r++)
            <tr>
                <td style="height:22px;">&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endfor
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="border:none; border-top:1px solid #000;"></td>
                <td style="text-align:right; border:1px solid #000; border-left:none; padding:4px 8px; font-size:11px;">Total</td>
                <td style="text-align:right; border:1px solid #000; padding:4px 8px; font-size:11px;">
                    Rp &nbsp; {{ number_format($subTotal, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border:none;"></td>
                <td style="text-align:right; border:1px solid #000; border-top:none; border-left:none; padding:4px 8px; font-size:11px;">Discount</td>
                <td style="text-align:right; border:1px solid #000; border-top:none; padding:4px 8px; font-size:11px;">
                    @if($diskon > 0)
                        Rp &nbsp; {{ number_format($subTotal - $afterDisc, 0, ',', '.') }}
                    @else
                        Rp &nbsp; -
                    @endif
                </td>
            </tr>
            @if($ppn > 0)
            <tr>
                <td colspan="3" style="border:none;"></td>
                <td style="text-align:right; border:1px solid #000; border-top:none; border-left:none; padding:4px 8px; font-size:11px;">PPN ({{ $ppn }}%)</td>
                <td style="text-align:right; border:1px solid #000; border-top:none; padding:4px 8px; font-size:11px;">
                    Rp &nbsp; {{ number_format($grandTotal - $afterDisc, 0, ',', '.') }}
                </td>
            </tr>
            @endif
            <tr>
                <td colspan="3" style="border:none;"></td>
                <td style="text-align:right; border:1px solid #000; border-top:none; border-left:none; padding:4px 8px; font-size:11px; font-weight:bold;">Grand Total</td>
                <td style="text-align:right; border:1px solid #000; border-top:none; padding:4px 8px; font-size:11px; font-weight:bold;">
                    Rp &nbsp; {{ number_format($grandTotal, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    {{-- ── FOOTER ── --}}
    <div class="footer-section">
        {{-- Note & Bank Info --}}
        <div class="note-block">
            <div class="note-title">NOTE :</div>
            <div class="bank-info" style="margin-top:4px;">
                <p style="margin-bottom:4px;">Please transfer payment to :</p>
                @if($invoice->rekening)
                <div class="field-row"><span class="fl">Name</span><span>: {{ $invoice->rekening->Nama }}</span></div>
                <div class="field-row"><span class="fl">Bank</span><span>: {{ $invoice->rekening->Bank }}</span></div>
                <div class="field-row"><span class="fl">Acc No</span><span>: {{ $invoice->Acc_No }}</span></div>
                @else
                <div class="field-row"><span class="fl">Name</span><span>: —</span></div>
                <div class="field-row"><span class="fl">Bank</span><span>: —</span></div>
                <div class="field-row"><span class="fl">Acc No</span><span>: —</span></div>
                @endif
            </div>
        </div>

        {{-- Signature --}}
        <div class="signature-block">
            <div class="regards">Best Regards,</div>
            <div class="signature-circle">
                <span class="gs-logo">GS</span>
            </div>
            <div class="signer-name">( {{ $invoice->ceo->Nama_Pegawai ?? $invoice->sekretaris->Nama_Pegawai ?? 'Syamsul Bahri Fitriyanto' }} )</div>
        </div>
    </div>

</div>
</body>
</html>
