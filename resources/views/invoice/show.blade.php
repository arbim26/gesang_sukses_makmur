@extends('layouts.app')
@section('title', 'Invoice ' . $invoice->No_Invoice)
@section('page-title', 'Detail Invoice')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('invoice.index') }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar
    </a>
    <div class="d-flex gap-2">
        <a href="{{ route('invoice.edit', $invoice->No_Invoice) }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
        <a href="{{ route('invoice.print', $invoice->No_Invoice) }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-printer me-1"></i> Cetak
        </a>
    </div>
</div>

<div class="row g-3">
    {{-- Invoice utama --}}
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <span>Invoice <code>{{ $invoice->No_Invoice }}</code></span>
                <span style="font-size:.8rem;color:var(--text-muted);">
                    {{ \Carbon\Carbon::parse($invoice->tanggal_terbit)->format('d F Y') }}
                </span>
            </div>
            <div class="card-body">
                <div class="row g-2 mb-4" style="font-size:.875rem;">
                    <div class="col-sm-3 text-muted">No. PO</div>
                    <div class="col-sm-9">
                        <a href="{{ route('purchase-order.show', $invoice->No_PO) }}"
                           style="color:var(--accent);text-decoration:none;">
                            {{ $invoice->No_PO }}
                        </a>
                    </div>
                    <div class="col-sm-3 text-muted">Customer</div>
                    <div class="col-sm-9">
                        <strong>{{ $invoice->purchaseOrder->customer->Nama ?? '-' }}</strong>
                        <span style="color:var(--text-muted);font-size:.8rem;"> — {{ $invoice->purchaseOrder->customer->PIC ?? '' }}</span>
                    </div>
                    <div class="col-sm-3 text-muted">Rekening</div>
                    <div class="col-sm-9">
                        {{ $invoice->rekening ? $invoice->rekening->Bank . ' ' . $invoice->Acc_No . ' a/n ' . $invoice->rekening->Nama : '—' }}
                    </div>
                </div>

                {{-- Tabel detail barang dari PO --}}
                <table class="table table-sm" style="font-size:.85rem;">
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
                        @foreach($invoice->purchaseOrder->details as $d)
                        <tr>
                            <td>{{ $d->barang->Nama_Barang ?? $d->No_Barang }}</td>
                            <td class="text-center">{{ $d->Qty }}</td>
                            <td class="text-end">Rp {{ number_format($d->Unit_Price, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($d->Amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge-pill" style="background:#f3f4f6;color:#374151;font-size:.7rem;">{{ $d->Metode }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end text-muted" style="font-size:.8rem;">Sub Total</td>
                            <td class="text-end">Rp {{ number_format($subTotal, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                        @if($diskon > 0)
                        <tr>
                            <td colspan="3" class="text-end text-muted" style="font-size:.8rem;">Diskon ({{ $diskon }}%)</td>
                            <td class="text-end" style="color:#dc2626;">
                                - Rp {{ number_format($subTotal - $afterDisc, 0, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="3" class="text-end text-muted" style="font-size:.8rem;">PPN ({{ $ppn }}%)</td>
                            <td class="text-end">Rp {{ number_format($grandTotal - $afterDisc, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                        <tr style="border-top:2px solid var(--border);">
                            <td colspan="3" class="text-end" style="font-weight:600;">Grand Total</td>
                            <td class="text-end" style="font-weight:700;font-size:1rem;color:var(--accent);">
                                Rp {{ number_format($grandTotal, 0, ',', '.') }}
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Sidebar info --}}
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header"><span>Pegawai Terkait</span></div>
            <div class="card-body p-3" style="font-size:.875rem;">
                <div class="mb-3">
                    <p class="text-muted mb-1" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">CEO</p>
                    <p class="mb-0" style="font-weight:500;">{{ $invoice->ceo->Nama_Pegawai ?? '—' }}</p>
                    @if($invoice->ceo)
                    <code style="font-size:.7rem;">{{ $invoice->Id_CEO }}</code>
                    @endif
                </div>
                <div>
                    <p class="text-muted mb-1" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Sekretaris</p>
                    <p class="mb-0" style="font-weight:500;">{{ $invoice->sekretaris->Nama_Pegawai ?? '—' }}</p>
                    @if($invoice->sekretaris)
                    <code style="font-size:.7rem;">{{ $invoice->Id_Sekretaris }}</code>
                    @endif
                </div>
            </div>
        </div>

        {{-- Surat Jalan terkait --}}
        <div class="card">
            <div class="card-header">
                <span><i class="bi bi-truck me-1"></i>Surat Jalan</span>
                @if(!$invoice->purchaseOrder->suratJalan)
                <a href="{{ route('surat-jalan.create') }}" class="btn btn-sm btn-accent" style="font-size:.7rem;padding:.25rem .6rem;">
                    <i class="bi bi-plus-lg"></i> Buat SJ
                </a>
                @endif
            </div>
            <div class="card-body p-3" style="font-size:.875rem;">
                @if($invoice->purchaseOrder->suratJalan)
                @php $sj = $invoice->purchaseOrder->suratJalan @endphp
                <div class="d-flex justify-content-between">
                    <a href="{{ route('surat-jalan.show', $sj->No_SJ) }}"
                       style="color:var(--accent);text-decoration:none;font-weight:500;">
                        {{ $sj->No_SJ }}
                    </a>
                    <span style="color:var(--text-muted);font-size:.8rem;">
                        {{ \Carbon\Carbon::parse($sj->Tanggal)->format('d M Y') }}
                    </span>
                </div>
                <p class="mb-0 mt-1" style="font-size:.8rem;color:var(--text-muted);">
                    Supir: {{ $sj->supir->Nama_Pegawai ?? '—' }}
                </p>
                @else
                <p class="text-muted mb-0 text-center py-2" style="font-size:.85rem;">
                    Belum ada surat jalan.
                </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
