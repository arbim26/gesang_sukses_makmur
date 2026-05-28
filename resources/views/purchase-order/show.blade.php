@extends('layouts.app')
@section('title', 'Detail PO ' . $po->No_PO)
@section('page-title', 'Detail Purchase Order')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('purchase-order.index') }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar
    </a>
    <div class="d-flex gap-2">
        @if(!$po->invoices->count())
        <a href="{{ route('purchase-order.edit', $po->No_PO) }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        @endif
        @if($po->invoices->count() && !$po->suratJalan)
        <a href="{{ route('surat-jalan.create') }}" class="btn btn-sm btn-accent">
            <i class="bi bi-truck me-1"></i> Buat Surat Jalan
        </a>
        @endif
        @if(!$po->invoices->count())
        <a href="{{ route('invoice.create') }}" class="btn btn-sm btn-accent">
            <i class="bi bi-receipt me-1"></i> Buat Invoice
        </a>
        @endif
    </div>
</div>

<div class="row g-3">
    {{-- Info PO --}}
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header"><span><i class="bi bi-file-earmark-text me-2"></i>Info Purchase Order</span></div>
            <div class="card-body">
                <dl style="font-size:.875rem;">
                    <dt class="text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">No. PO</dt>
                    <dd><code>{{ $po->No_PO }}</code></dd>

                    <dt class="text-muted mt-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Customer</dt>
                    <dd>
                        <div style="font-weight:500;">{{ $po->customer->Nama ?? '-' }}</div>
                        <div style="color:var(--text-muted);font-size:.8rem;">{{ $po->customer->PIC ?? '' }}</div>
                    </dd>

                    <dt class="text-muted mt-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Tanggal PO</dt>
                    <dd>{{ \Carbon\Carbon::parse($po->PO_Date)->format('d F Y') }}</dd>

                    <dt class="text-muted mt-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Delivery Date</dt>
                    <dd>{{ $po->Delivery_date ? \Carbon\Carbon::parse($po->Delivery_date)->format('d F Y') : '—' }}</dd>

                    @if($po->Note)
                    <dt class="text-muted mt-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Catatan</dt>
                    <dd style="font-size:.85rem;">{{ $po->Note }}</dd>
                    @endif

                    <dt class="text-muted mt-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Status</dt>
                    <dd>
                        @if($po->suratJalan)
                            <span class="badge-pill" style="background:#ecfdf5;color:#059669;"><i class="bi bi-check-circle me-1"></i>Selesai</span>
                        @elseif($po->invoices->count() > 0)
                            <span class="badge-pill" style="background:#fef3c7;color:#d97706;"><i class="bi bi-receipt me-1"></i>Diinvoice</span>
                        @else
                            <span class="badge-pill" style="background:#f3f4f6;color:#6b7280;"><i class="bi bi-clock me-1"></i>Baru</span>
                        @endif
                    </dd>
                </dl>
            </div>
        </div>

        {{-- Totals --}}
        <div class="card">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;">
                    <span class="text-muted">Sub Total</span>
                    <span>Rp {{ number_format($po->Sub_Total, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;">
                    <span class="text-muted">PPN ({{ $po->PPN }}%)</span>
                    <span>Rp {{ number_format($po->Grand_Total - $po->Sub_Total, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between pt-2" style="border-top:1px solid var(--border);font-size:1rem;font-weight:600;">
                    <span>Grand Total</span>
                    <span style="color:var(--accent);">Rp {{ number_format($po->Grand_Total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail & Transaksi --}}
    <div class="col-md-8">
        {{-- Detail Barang --}}
        <div class="card mb-3">
            <div class="card-header"><span><i class="bi bi-list-ul me-2"></i>Detail Barang</span></div>
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
                        @foreach($po->details as $d)
                        <tr>
                            <td style="font-size:.875rem;">{{ $d->barang->Nama_Barang ?? $d->No_Barang }}</td>
                            <td class="text-center">{{ $d->Qty }}</td>
                            <td class="text-end">Rp {{ number_format($d->Unit_Price, 0, ',', '.') }}</td>
                            <td class="text-end" style="font-weight:500;">Rp {{ number_format($d->Amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge-pill" style="background:#f3f4f6;color:#374151;font-size:.7rem;">{{ $d->Metode }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Invoice terkait --}}
        <div class="card mb-3">
            <div class="card-header">
                <span><i class="bi bi-receipt me-2"></i>Invoice</span>
                @if(!$po->invoices->count())
                <a href="{{ route('invoice.create') }}" class="btn btn-sm btn-accent">
                    <i class="bi bi-plus-lg me-1"></i> Buat Invoice
                </a>
                @endif
            </div>
            <div class="card-body p-0">
                @if($po->invoices->isEmpty())
                <p class="text-center text-muted py-3 mb-0" style="font-size:.85rem;">Belum ada invoice untuk PO ini.</p>
                @else
                <table class="table mb-0">
                    <thead><tr><th>No. Invoice</th><th>Tanggal</th><th>CEO</th><th>Rekening</th></tr></thead>
                    <tbody>
                        @foreach($po->invoices as $inv)
                        <tr>
                            <td>
                                <a href="{{ route('invoice.show', $inv->No_Invoice) }}"
                                   style="font-size:.8rem;color:var(--accent);text-decoration:none;">
                                    {{ $inv->No_Invoice }}
                                </a>
                            </td>
                            <td style="font-size:.85rem;">{{ \Carbon\Carbon::parse($inv->tanggal_terbit)->format('d M Y') }}</td>
                            <td style="font-size:.85rem;">{{ $inv->ceo->Nama_Pegawai ?? '—' }}</td>
                            <td style="font-size:.85rem;">{{ $inv->rekening->Bank ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>

        {{-- Surat Jalan --}}
        <div class="card">
            <div class="card-header">
                <span><i class="bi bi-truck me-2"></i>Surat Jalan</span>
                @if($po->invoices->count() && !$po->suratJalan)
                <a href="{{ route('surat-jalan.create') }}" class="btn btn-sm btn-accent">
                    <i class="bi bi-plus-lg me-1"></i> Buat SJ
                </a>
                @endif
            </div>
            <div class="card-body p-0">
                @if(!$po->suratJalan)
                <p class="text-center text-muted py-3 mb-0" style="font-size:.85rem;">Belum ada surat jalan.</p>
                @else
                @php $sj = $po->suratJalan @endphp
                <table class="table mb-0">
                    <thead><tr><th>No. SJ</th><th>Tanggal</th><th>Supir</th><th>Keterangan</th></tr></thead>
                    <tbody>
                        <tr>
                            <td>
                                <a href="{{ route('surat-jalan.show', $sj->No_SJ) }}"
                                   style="font-size:.8rem;color:var(--accent);text-decoration:none;">
                                    {{ $sj->No_SJ }}
                                </a>
                            </td>
                            <td style="font-size:.85rem;">{{ \Carbon\Carbon::parse($sj->Tanggal)->format('d M Y') }}</td>
                            <td style="font-size:.85rem;">{{ $sj->supir->Nama_Pegawai ?? '—' }}</td>
                            <td style="font-size:.85rem;">{{ $sj->Keterangan ?? '—' }}</td>
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
