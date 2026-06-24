<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Surat Jalan {{ $suratJalan->No_SJ }}</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }

  :root {
    --navy: #0D1F4E;
    --navy-mid: #1a3a8f;
    --navy-light: #e8edf8;
    --gold: #C8960C;
    --gold-light: #fdf6e3;
    --ink: #1a1a2a;
    --muted: #6b7280;
    --border: #d1d9ee;
    --surface: #f7f8fc;
  }

  body {
    font-family: 'DM Sans', sans-serif;
    background: #f0f2f8;
    color: var(--ink);
    -webkit-print-color-adjust: exact;
    print-color-adjust: exact;
  }

  /* ── TOOLBAR ── */
  .toolbar {
    background: var(--navy);
    color: #fff;
    padding: 10px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    font-size: 13px;
    position: sticky;
    top: 0;
    z-index: 100;
  }
  .toolbar span { flex: 1; font-weight: 500; opacity: 0.85; }
  .btn-back {
    background: transparent;
    color: rgba(255,255,255,0.6);
    border: 1px solid rgba(255,255,255,0.25);
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 13px;
    cursor: pointer;
    text-decoration: none;
    font-family: 'DM Sans', sans-serif;
  }
  .btn-print {
    background: var(--navy);
    color: #fff;
    border: none;
    padding: 7px 20px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    letter-spacing: 0.3px;
  }
  .btn-print:hover { background: #b5830a; }

  /* ── PAGE ── */
  .page {
    width: 210mm;
    min-height: 297mm;
    margin: 24px auto;
    background: #fff;
    padding: 14mm 16mm 14mm 16mm;
    box-shadow: 0 2px 32px rgba(13,31,78,0.10);
  }

  /* ── HEADER BAND ── */
  .header-band {
    background: var(--navy);
    margin: -14mm -16mm 0 -16mm;
    padding: 10mm 16mm 9mm;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .logo-area {
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .logo-badge {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: rgba(255,255,255,0.12);
    border: 2px solid rgba(255,255,255,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .logo-badge span {
    font-family: 'DM Serif Display', serif;
    font-size: 18px;
    color: #fff;
    letter-spacing: -0.5px;
  }
  .company-name {
    font-family: 'DM Serif Display', serif;
    font-size: 20px;
    color: #fff;
    letter-spacing: 1.5px;
    line-height: 1;
    margin-bottom: 4px;
  }
  .company-tagline {
    font-size: 9px;
    color: rgba(255,255,255,0.65);
    font-style: italic;
    letter-spacing: 0.5px;
    margin-bottom: 3px;
  }
  .company-address {
    font-size: 8px;
    color: rgba(255,255,255,0.45);
    line-height: 1.6;
  }

  .sj-badge-wrap { text-align: right; }
  .sj-badge {
    display: inline-block;
    border: 1.5px solid rgba(255,255,255,0.45);
    color: #fff;
    padding: 6px 20px;
    font-size: 13px;
    font-family: 'DM Sans', sans-serif;
    font-weight: 600;
    letter-spacing: 5px;
    border-radius: 4px;
    background: rgba(255,255,255,0.08);
  }

  /* ── GOLD LINE ── */
  .gold-line {
    height: 3px;
    background: var(--navy);
    margin: 0 -16mm 16px -16mm;
  }

  /* ── META ── */
  .meta-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 18px;
  }

  .kepada-block { flex: 1; }
  .kepada-block .to-label {
    font-size: 9px;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--navy);
    font-weight: 600;
    margin-bottom: 5px;
  }
  .kepada-block .cust-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--navy);
    margin-bottom: 2px;
  }
  .kepada-block .cust-sub {
    font-size: 11px;
    color: var(--muted);
    border-bottom: 1px solid var(--border);
    padding-bottom: 4px;
    min-width: 200px;
    display: inline-block;
  }

  .meta-table-wrap {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    overflow: hidden;
    min-width: 220px;
  }
  .meta-table-wrap table {
    width: 100%;
    border-collapse: collapse;
    font-size: 11px;
  }
  .meta-table-wrap tr:not(:last-child) td { border-bottom: 1px solid var(--border); }
  .meta-table-wrap td { padding: 7px 12px; }
  .meta-table-wrap td:first-child {
    color: var(--muted);
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    white-space: nowrap;
    background: rgba(0,0,0,0.02);
    width: 90px;
  }
  .meta-table-wrap td:last-child { font-weight: 500; color: var(--navy); }

  /* ── ITEMS TABLE ── */
  .items-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    border: 1px solid var(--border);
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 22px;
  }

  .items-table thead tr th {
    background: var(--navy);
    color: rgba(255,255,255,0.88);
    font-size: 10px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 9px 12px;
    border: none;
    text-align: left;
  }
  .items-table thead tr th.center { text-align: center; }

  .items-table tbody tr td {
    padding: 9px 12px;
    font-size: 11px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
  }
  .items-table tbody tr:last-child td { border-bottom: none; }
  .items-table tbody tr:hover td { background: #f7f8fc; }

  .no-col { width: 32px; text-align: center; color: var(--muted); font-size: 11px; }
  .kode-col { width: 95px; font-family: monospace; font-size: 11px; color: var(--muted); }
  .nama-col { font-weight: 500; color: var(--ink); }
  .qty-col { width: 60px; text-align: center; font-weight: 600; }
  .ket-col { width: 110px; font-size: 10.5px; color: var(--muted); }

  .empty-row td { height: 26px; }

  /* ── FOOTER SIGNATURE ── */
  .footer-sig {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-top: 10px;
  }

  .sig-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 12px 20px;
    text-align: center;
    min-width: 175px;
  }
  .sig-card .sig-role {
    font-size: 10px;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 2px;
  }
  .sig-card .sig-from {
    font-size: 11px;
    font-weight: 500;
    color: var(--navy);
    margin-bottom: 38px;
  }
  .sig-card .sig-line {
    border-top: 1px solid var(--border);
    margin: 0 auto 6px;
    width: 100%;
  }
  .sig-card .sig-name {
    font-size: 10.5px;
    color: var(--muted);
    font-style: italic;
  }

  /* ── PRINT ── */
  @media print {
    body { background: #fff; }
    .toolbar { display: none; }
    .page {
      margin: 0;
      box-shadow: none;
      padding: 10mm 14mm;
    }
    .header-band { margin: -10mm -14mm 0 -14mm; padding: 8mm 14mm 7mm; }
    .gold-line { margin: 0 -14mm 14px; }
  }

  @media screen {
    .page { margin-top: 56px; }
  }
</style>
</head>
<body>

<div class="toolbar no-print">
  <a href="{{ route('surat-jalan.show', $suratJalan->No_SJ) }}" class="btn-back">← Kembali</a>
  <span>Surat Jalan {{ $suratJalan->No_SJ }}</span>
  <button class="btn-print" onclick="window.print()">🖨 Cetak</button>
</div>

<div class="page">

  <!-- HEADER -->
  <div class="header-band">
    <div class="logo-area">
      <div class="logo-badge"><span>GS</span></div>
      <div>
        <div class="company-name">PT. GESANG SUKSES MAKMUR</div>
        <div class="company-tagline">Machining · Jig · Mold · Dies · Precision Part · Fabrication</div>
        <div class="company-address">
          Jl. Bernang Raya Blok G3 No. 212 RT.003 RW.010 Jayamukti, Cikarang Pusat &nbsp;·&nbsp; Telp. 021-89329258 &nbsp;·&nbsp; gs.makmur08@gmail.com<br>
          Workshop : Jl. Pasir Gombong RT.04 RW.06 Belakang Ruko Hario Irigasi
        </div>
      </div>
    </div>
    <div class="sj-badge-wrap">
      <div class="sj-badge">SURAT JALAN</div>
    </div>
  </div>

  <div class="gold-line"></div>

  <!-- META -->
  <div class="meta-row">
    <div class="kepada-block">
      <div class="to-label">Kepada Yth.</div>
      <div class="cust-name">{{ $suratJalan->purchaseOrder->customer->Nama ?? '-' }}</div>
      <div class="cust-sub">&nbsp;</div>
    </div>
    <div class="meta-table-wrap">
      <table>
        <tr>
          <td>No. Surat Jalan</td>
          <td>{{ $suratJalan->No_SJ }}</td>
        </tr>
        <tr>
          <td>Tanggal</td>
          <td>{{ \Carbon\Carbon::parse($suratJalan->Tanggal)->format('d F Y') }}</td>
        </tr>
        <tr>
          <td>No. PO</td>
          <td>{{ $suratJalan->No_PO }}</td>
        </tr>
      </table>
    </div>
  </div>

  <!-- ITEMS TABLE -->
  <table class="items-table">
    <thead>
      <tr>
        <th class="no-col center">No</th>
        <th class="kode-col">Kode Barang</th>
        <th class="nama-col">Nama Barang</th>
        <th class="qty-col center">Qty</th>
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

      @for($r = 0; $r < max(0, 6 - $suratJalan->purchaseOrder->details->count()); $r++)
      <tr class="empty-row">
        <td></td><td></td><td></td><td></td><td></td>
      </tr>
      @endfor
    </tbody>
  </table>

  <!-- SIGNATURE FOOTER -->
  <div class="footer-sig">
    <div class="sig-card">
      <div class="sig-role">Penerima</div>
      <div class="sig-from">Cap / Tanda Tangan &amp; Tanggal</div>
      <div class="sig-line"></div>
      <div class="sig-name">( ............................................. )</div>
    </div>

    <div class="sig-card">
      <div class="sig-role">Pengirim</div>
      <div class="sig-from">PT. Gesang Sukses Makmur</div>
      <div class="sig-line"></div>
      <div class="sig-name">( {{ $suratJalan->supir->Nama_Pegawai ?? '.............................................' }} )</div>
    </div>
  </div>

</div>
</body>
</html>