<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice INV-N-GSM/11/25/020 — PT. Gesang Sukses Makmur</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --navy:   #0d2344;
            --navy2:  #163461;
            --gold:   #c8992a;
            --gold-lt:#e8b84b;
            --ink:    #1a1a2e;
            --muted:  #5a6278;
            --rule:   #d4d8e2;
            --bg:     #f4f5f8;
            --white:  #ffffff;
        }

        @media screen {
            body {
                background: var(--bg);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 40px 20px;
                font-family: 'DM Sans', sans-serif;
            }
            .toolbar {
                width: 210mm;
                max-width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 18px;
            }
            .toolbar span {
                font-size: 13px;
                color: var(--muted);
                font-family: 'DM Sans', sans-serif;
            }
            .btn-print {
                background: var(--navy);
                color: #fff;
                border: none;
                padding: 9px 22px;
                border-radius: 6px;
                font-family: 'DM Sans', sans-serif;
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                letter-spacing: .4px;
                transition: background .2s;
            }
            .btn-print:hover { background: var(--navy2); }
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            max-width: 100%;
            background: var(--white);
            font-family: 'DM Sans', sans-serif;
            color: var(--ink);
            position: relative;
            overflow: hidden;
        }

        /* ── decorative top bar ── */
        .top-bar {
            height: 6px;
            background: linear-gradient(90deg, var(--navy) 0%, var(--navy2) 60%, var(--gold) 100%);
        }

        .inner {
            padding: 28px 32px 36px;
        }

        /* ── HEADER ── */
        .header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding-bottom: 20px;
            border-bottom: 1.5px solid var(--rule);
            margin-bottom: 22px;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .logo-mark {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            border: 2.5px solid var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: var(--white);
        }

        .logo-mark span {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--navy);
            letter-spacing: -1px;
        }

        .company-name {
            font-family: 'Playfair Display', serif;
            font-size: 21px;
            font-weight: 700;
            color: var(--navy);
            letter-spacing: 1.5px;
            line-height: 1.2;
        }

        .company-tagline {
            font-size: 9.5px;
            color: var(--gold);
            font-weight: 600;
            letter-spacing: .8px;
            text-transform: uppercase;
            margin-top: 3px;
        }

        .company-address {
            font-size: 9px;
            color: var(--muted);
            margin-top: 4px;
            line-height: 1.5;
        }

        .invoice-badge {
            background: var(--navy);
            color: #fff;
            font-family: 'Playfair Display', serif;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 5px;
            padding: 8px 22px;
            border-radius: 4px;
            align-self: center;
        }

        /* ── META SECTION ── */
        .meta {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
            gap: 20px;
        }

        .customer-block .label {
            font-size: 9.5px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 5px;
        }

        .customer-block .name {
            font-size: 14px;
            font-weight: 600;
            color: var(--navy);
        }

        .customer-block .city {
            font-size: 11px;
            color: var(--muted);
            margin-top: 2px;
        }

        .meta-table {
            border-collapse: collapse;
            font-size: 11px;
        }

        .meta-table td {
            padding: 3px 6px;
        }

        .meta-table td:first-child {
            color: var(--muted);
            white-space: nowrap;
            padding-right: 4px;
        }

        .meta-table td:nth-child(2) {
            color: var(--muted);
            padding: 3px 2px;
        }

        .meta-table td:last-child {
            font-weight: 500;
            color: var(--ink);
        }

        /* ── ITEMS TABLE ── */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            font-size: 11.5px;
        }

        .items-table thead tr {
            background: var(--navy);
            color: #fff;
        }

        .items-table thead th {
            padding: 9px 12px;
            font-weight: 600;
            font-size: 10.5px;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .items-table thead th.c { text-align: center; }
        .items-table thead th.r { text-align: right; }
        .items-table thead th.l { text-align: left; }

        .items-table tbody tr:nth-child(even) {
            background: #f7f8fb;
        }

        .items-table tbody tr:nth-child(odd) {
            background: var(--white);
        }

        .group-row td {
            background: #eef0f5 !important;
            font-weight: 600;
            font-size: 10.5px;
            letter-spacing: .4px;
            color: var(--navy2);
            padding: 6px 12px !important;
            border-bottom: 1px solid var(--rule) !important;
            text-transform: uppercase;
        }

        .items-table tbody td {
            padding: 8px 12px;
            border-bottom: 1px solid var(--rule);
            color: var(--ink);
        }

        .items-table tbody td.c { text-align: center; }
        .items-table tbody td.r { text-align: right; }

        .items-table tfoot tr td {
            padding: 7px 12px;
            font-size: 11.5px;
        }

        .summary-row td {
            border-top: 1px solid var(--rule);
        }

        .summary-row td.label-cell {
            text-align: right;
            color: var(--muted);
            font-weight: 500;
        }

        .summary-row td.val-cell {
            text-align: right;
            font-weight: 500;
        }

        .grand-row td {
            background: var(--navy);
            color: #fff !important;
            font-weight: 700;
            font-size: 12.5px;
        }

        .grand-row td.label-cell {
            color: rgba(255,255,255,.85) !important;
        }

        .grand-row td.val-cell {
            color: var(--gold-lt) !important;
        }

        /* ── FOOTER ── */
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1.5px solid var(--rule);
            gap: 20px;
        }

        .note-label {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 8px;
        }

        .bank-table {
            border-collapse: collapse;
            font-size: 11px;
        }

        .bank-table td {
            padding: 2px 0;
        }

        .bank-table td:first-child {
            color: var(--muted);
            width: 56px;
        }

        .bank-table td:nth-child(2) {
            color: var(--muted);
            padding: 2px 4px;
        }

        .bank-table td:last-child {
            font-weight: 600;
            color: var(--ink);
        }

        .bank-note {
            font-size: 10px;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .signature-block {
            text-align: center;
            min-width: 160px;
        }

        .regards {
            font-size: 11px;
            color: var(--muted);
            margin-bottom: 10px;
        }

        .sig-circle {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            border: 2px solid var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
        }

        .sig-circle span {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--navy);
        }

        .signer {
            font-size: 11px;
            font-weight: 600;
            color: var(--ink);
        }

        /* ── bottom bar ── */
        .bottom-bar {
            height: 4px;
            background: linear-gradient(90deg, var(--gold) 0%, var(--navy) 100%);
        }

        @media print {
            body { background: #fff; padding: 0; }
            .toolbar { display: none !important; }
            .page { box-shadow: none; width: 100%; }
            .top-bar, .bottom-bar { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .items-table thead tr,
            .grand-row td,
            .group-row td { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>

<div class="toolbar no-print">
    <span>PT. Gesang Sukses Makmur — Invoice INV-N-GSM/11/25/020</span>
    <button class="btn-print" onclick="window.print()">🖨 Cetak</button>
</div>

<div class="page">
    <div class="top-bar"></div>
    <div class="inner">

        <!-- HEADER -->
        <div class="header">
            <div class="logo-area">
                <div class="logo-mark"><span>GS</span></div>
                <div>
                    <div class="company-name">PT. GESANG SUKSES MAKMUR</div>
                    <div class="company-tagline">Machining · Jig · Mold · Dies · Precision Part · Fabrication</div>
                    <div class="company-address">
                        Jl. Bernang Raya Blok 6-3 No.212 RT.003 RW.010 Jayamukti, Cikarang Pusat<br>
                        Telp. 021-89329258 &nbsp;·&nbsp; Email: gs.makmur08@gmail.com
                    </div>
                </div>
            </div>
            <div class="invoice-badge">INVOICE</div>
        </div>

        <!-- META -->
        <div class="meta">
            <div class="customer-block">
                <div class="label">Customer</div>
                <div class="name">PT. NAURA TECHNOLOGI</div>
                <div class="city">Bekasi</div>
            </div>
            <table class="meta-table">
                <tr>
                    <td>Nomor</td><td>:</td>
                    <td><strong>INV-N-GSM/11/25/020</strong></td>
                </tr>
                <tr>
                    <td>Tanggal</td><td>:</td>
                    <td>28 November 2025</td>
                </tr>
                <tr>
                    <td>PO No</td><td>:</td>
                    <td>—</td>
                </tr>
            </table>
        </div>

        <!-- ITEMS TABLE -->
        <table class="items-table">
            <thead>
                <tr>
                    <th class="c" style="width:42px;">No</th>
                    <th class="l">Description</th>
                    <th class="c" style="width:80px;">Qty</th>
                    <th class="r" style="width:140px;">Unit Price</th>
                    <th class="r" style="width:148px;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <!-- Group -->
                <tr class="group-row">
                    <td></td>
                    <td colspan="4">Proses Machining</td>
                </tr>
                <!-- Items -->
                <tr>
                    <td class="c">1</td>
                    <td>PLATE BESAR</td>
                    <td class="c">6 Pcs</td>
                    <td class="r">Rp &nbsp;3.000.000</td>
                    <td class="r">Rp &nbsp;18.000.000</td>
                </tr>
                <tr>
                    <td class="c">2</td>
                    <td>PLATE KECIL</td>
                    <td class="c">9 Pcs</td>
                    <td class="r">Rp &nbsp;1.800.000</td>
                    <td class="r">Rp &nbsp;16.200.000</td>
                </tr>
                <!-- padding rows -->
                <tr style="height:30px;"><td colspan="5"></td></tr>
                <tr style="height:30px;"><td colspan="5"></td></tr>
                <tr style="height:30px;"><td colspan="5"></td></tr>
            </tbody>
            <tfoot>
                <tr class="summary-row">
                    <td colspan="3" style="border:none;"></td>
                    <td class="label-cell">Total</td>
                    <td class="val-cell">Rp &nbsp;34.200.000</td>
                </tr>
                <tr class="summary-row">
                    <td colspan="3" style="border:none;"></td>
                    <td class="label-cell">Discount</td>
                    <td class="val-cell">Rp &nbsp;—</td>
                </tr>
                <tr class="grand-row">
                    <td colspan="3" style="border:none; background:var(--navy);"></td>
                    <td class="label-cell" style="text-align:right; padding-right:12px;">Grand Total</td>
                    <td class="val-cell">Rp &nbsp;34.200.000</td>
                </tr>
            </tfoot>
        </table>

        <!-- FOOTER -->
        <div class="footer">
            <div class="note-block">
                <div class="note-label">Note</div>
                <p class="bank-note">Please transfer payment to:</p>
                <table class="bank-table">
                    <tr><td>Name</td><td>:</td><td>SYAMSUL BAHRI FITRIYANTO</td></tr>
                    <tr><td>Bank</td><td>:</td><td>PERMATA</td></tr>
                    <tr><td>Acc No</td><td>:</td><td>4205563240</td></tr>
                </table>
            </div>

            <div class="signature-block">
                <div class="regards">Best Regards,</div>
                <div class="sig-circle"><span>GS</span></div>
                <div class="signer">( Syamsul Bahri Fitriyanto )</div>
            </div>
        </div>

    </div><!-- /inner -->
    <div class="bottom-bar"></div>
</div>

</body>
</html>