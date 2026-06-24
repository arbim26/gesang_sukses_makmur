@extends('layouts.app')
@section('title', 'Purchase Order')
@section('page-title', 'Manajemen Purchase Order')

@php
    $jabatanAktif = auth('pegawai')->user()->Jabatan;
@endphp


@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0" style="font-size:.85rem;">
        Total <strong>{{ $purchaseOrders->total() }}</strong> purchase order
    </p>
    <a href="{{ route('purchase-order.create') }}" class="btn btn-accent">
        <i class="bi bi-plus-lg me-1"></i> Buat PO
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>No. PO</th>
                    <th>Tanggal PO</th>
                    <th>Customer</th>
                    <th>Delivery Date</th>
                    <th class="text-end">Grand Total</th>
                    <th>Status</th>
                    <th style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchaseOrders as $po)
                <tr>
                    <td><code style="font-size:.8rem;">{{ $po->No_PO }}</code></td>
                    <td style="font-size:.85rem;">{{ \Carbon\Carbon::parse($po->PO_Date)->format('d M Y') }}</td>
                    <td>
                        <div style="font-weight:500;font-size:.875rem;">{{ $po->customer->Nama ?? '-' }}</div>
                        <div style="font-size:.75rem;color:var(--text-muted);">{{ $po->customer->PIC ?? '' }}</div>
                    </td>
                    <td style="font-size:.85rem;">
                        {{ $po->Delivery_date ? \Carbon\Carbon::parse($po->Delivery_date)->format('d M Y') : '—' }}
                    </td>
                    <td class="text-end" style="font-weight:500;">
                        Rp {{ number_format($po->Grand_Total, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($po->suratJalan)
                            <span class="badge-pill" style="background:#ecfdf5;color:#059669;">Selesai</span>
                        @elseif($po->invoices->count() > 0)
                            <span class="badge-pill" style="background:#fef3c7;color:#d97706;">Diinvoice</span>
                        @else
                            <span class="badge-pill" style="background:#f3f4f6;color:#6b7280;">Baru</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('purchase-order.show', $po->No_PO) }}"
                           class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-eye"></i>
                        </a>
<<<<<<< HEAD
=======

                        @if($po->attachment)
                            @php
                                $ext = strtolower(pathinfo($po->attachment, PATHINFO_EXTENSION));
                                $fileUrl = asset('storage/' . $po->attachment);
                                $safeNoPo = str_replace(['/', '\\'], '-', $po->No_PO ?? 'Dokumen');
                                $fileName = $safeNoPo . '.' . $ext; 
                            @endphp
                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary me-1 mb-1"
                                    title="Preview Dokumen"
                                    onclick="openCustomPreview('{{ $fileUrl }}', '{{ $fileName }}')">
                                <i class="bi bi-file-earmark-text"></i>
                            </button>
                        @endif

                        @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
>>>>>>> f51e716 (add JWT and Multi Role)
                        @if(!$po->invoices->count())
                        <a href="{{ route('purchase-order.edit', $po->No_PO) }}"
                           class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('purchase-order.destroy', $po->No_PO) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus PO ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                        @endif
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-inbox" style="font-size:1.5rem;"></i>
                        <p class="mt-1 mb-0">Belum ada purchase order.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $purchaseOrders->links() }}</div>
@endsection
