@extends('layouts.app')
@section('title', 'Surat Jalan ' . $suratJalan->No_SJ)
@section('page-title', 'Detail Surat Jalan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('surat-jalan.index') }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar
    </a>
    <div class="d-flex gap-2">
        <a href="{{ route('surat-jalan.edit', $suratJalan->No_SJ) }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <a href="{{ route('surat-jalan.print', $suratJalan->No_SJ) }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-printer me-1"></i> Cetak
        </a>
    </div>
</div>

<div class="row g-3">
    {{-- Info SJ --}}
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header"><span><i class="bi bi-truck me-2"></i>Info Surat Jalan</span></div>
            <div class="card-body">
                <dl style="font-size:.875rem;">
                    <dt class="text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">No. SJ</dt>
                    <dd><code>{{ $suratJalan->No_SJ }}</code></dd>

                    <dt class="text-muted mt-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Tanggal</dt>
                    <dd>{{ \Carbon\Carbon::parse($suratJalan->Tanggal)->format('d F Y') }}</dd>

                    <dt class="text-muted mt-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">No. PO</dt>
                    <dd>
                        <a href="{{ route('purchase-order.show', $suratJalan->No_PO) }}"
                           style="color:var(--accent);text-decoration:none;">
                            {{ $suratJalan->No_PO }}
                        </a>
                    </dd>

                    <dt class="text-muted mt-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Customer</dt>
                    <dd>
                        <div style="font-weight:500;">{{ $suratJalan->purchaseOrder->customer->Nama ?? '-' }}</div>
                        <div style="font-size:.8rem;color:var(--text-muted);">{{ $suratJalan->purchaseOrder->customer->PIC ?? '' }}</div>
                    </dd>

                    <dt class="text-muted mt-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Supir</dt>
                    <dd>
                        <div style="font-weight:500;">{{ $suratJalan->supir->Nama_Pegawai ?? '—' }}</div>
                        @if($suratJalan->supir)
                        <code style="font-size:.7rem;">{{ $suratJalan->Id_Supir }}</code>
                        @endif
                    </dd>

                    @if($suratJalan->Keterangan)
                    <dt class="text-muted mt-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Keterangan</dt>
                    <dd style="font-size:.85rem;">{{ $suratJalan->Keterangan }}</dd>
                    @endif
                </dl>
            </div>
        </div>

        {{-- Invoice terkait --}}
        <div class="card">
            <div class="card-header"><span><i class="bi bi-receipt me-2"></i>Invoice</span></div>
            <div class="card-body p-3">
                @foreach($suratJalan->purchaseOrder->invoices as $inv)
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('invoice.show', $inv->No_Invoice) }}"
                       style="font-weight:500;color:var(--accent);text-decoration:none;">
                        {{ $inv->No_Invoice }}
                    </a>
                    <span style="font-size:.8rem;color:var(--text-muted);">
                        {{ \Carbon\Carbon::parse($inv->tanggal_terbit)->format('d M Y') }}
                    </span>
                </div>
                @php
                    $sub   = $suratJalan->purchaseOrder->Sub_Total;
                    $ppn   = $suratJalan->purchaseOrder->PPN;
                    $disc  = $inv->discount ?? 0;
                    $grand = round($sub * (1 - $disc/100) * (1 + $ppn/100), 0);
                @endphp
                <p class="mb-0 mt-1" style="font-size:.85rem;font-weight:600;color:var(--accent);">
                    Rp {{ number_format($grand, 0, ',', '.') }}
                </p>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Detail barang --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span><i class="bi bi-list-ul me-2"></i>Daftar Barang yang Dikirim</span>
                <span class="badge-pill" style="background:#ecfdf5;color:#059669;">
                    {{ $suratJalan->purchaseOrder->details->count() }} item
                </span>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Amount</th>
                            <th>Metode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suratJalan->purchaseOrder->details as $d)
                        <tr>
                            <td>
                                <div style="font-weight:500;font-size:.875rem;">{{ $d->barang->Nama_Barang ?? $d->No_Barang }}</div>
                                <code style="font-size:.7rem;color:var(--text-muted);">{{ $d->No_Barang }}</code>
                            </td>
                            <td class="text-center">{{ $d->Qty }}</td>
                            <td class="text-end" style="font-size:.85rem;">Rp {{ number_format($d->Unit_Price, 0, ',', '.') }}</td>
                            <td class="text-end" style="font-weight:500;">Rp {{ number_format($d->Amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge-pill" style="background:#f3f4f6;color:#374151;font-size:.7rem;">{{ $d->Metode }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end text-muted" style="font-size:.8rem;">Grand Total PO</td>
                            <td class="text-end" style="font-weight:600;color:var(--accent);">
                                Rp {{ number_format($suratJalan->purchaseOrder->Grand_Total, 0, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
