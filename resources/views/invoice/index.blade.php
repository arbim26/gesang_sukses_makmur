@extends('layouts.app')
@section('title', 'Invoice')
@section('page-title', 'Manajemen Invoice')

@php
    $jabatanAktif = auth('pegawai')->user()->Jabatan;
@endphp


@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0" style="font-size:.85rem;">
        Total <strong>{{ $invoices->total() }}</strong> invoice
    </p>
    <a href="{{ route('invoice.create') }}" class="btn btn-accent">
        <i class="bi bi-plus-lg me-1"></i> Buat Invoice
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Tanggal</th>
                    <th>No. PO</th>
                    <th>Customer</th>
                    <th class="text-end">Grand Total</th>
                    <th>Rekening</th>
                    <th style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $inv)
                @php
                    $sub   = $inv->purchaseOrder->Sub_Total ?? 0;
                    $ppn   = $inv->purchaseOrder->PPN ?? 11;
                    $disc  = $inv->discount ?? 0;
                    $grand = round($sub * (1 - $disc/100) * (1 + $ppn/100), 0);
                @endphp
                <tr>
                    <td><code style="font-size:.8rem;">{{ $inv->No_Invoice }}</code></td>
                    <td style="font-size:.85rem;">{{ \Carbon\Carbon::parse($inv->tanggal_terbit)->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('purchase-order.show', $inv->No_PO) }}"
                           style="font-size:.8rem;color:var(--accent);text-decoration:none;">
                            {{ $inv->No_PO }}
                        </a>
                    </td>
                    <td>
                        <div style="font-size:.875rem;">{{ $inv->purchaseOrder->customer->Nama ?? '-' }}</div>
                        <div style="font-size:.75rem;color:var(--text-muted);">{{ $inv->purchaseOrder->customer->PIC ?? '' }}</div>
                    </td>
                    <td class="text-end" style="font-weight:500;">
                        Rp {{ number_format($grand, 0, ',', '.') }}
                        @if($disc > 0)
                        <div style="font-size:.7rem;color:#059669;">diskon {{ $disc }}%</div>
                        @endif
                    </td>
                    <td style="font-size:.85rem;">
                        {{ $inv->rekening ? $inv->rekening->Bank . ' — ' . $inv->Acc_No : '—' }}
                    </td>
                    <td>
                        <a href="{{ route('invoice.show', $inv->No_Invoice) }}"
                           class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-eye"></i>
                        </a>
                        @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
                        <a href="{{ route('invoice.edit', $inv->No_Invoice) }}"
                           class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('invoice.destroy', $inv->No_Invoice) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus invoice ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-inbox" style="font-size:1.5rem;"></i>
                        <p class="mt-1 mb-0">Belum ada invoice.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
    <div class="text-muted small">
        Menampilkan {{ $invoices->firstItem() ?? 0 }} - {{ $invoices->lastItem() ?? 0 }} dari total {{ $invoices->total() }} barang
    </div>
    <div>
        @if ($invoices->hasPages())
            {{ $invoices->onEachSide(1)->links('pagination::bootstrap-5') }}
        @else
            <nav aria-label="Page navigation">
                <ul class="pagination mb-0">
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    <li class="page-item active"><span class="page-link">1</span></li>
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                </ul>
            </nav>
        @endif
    </div>
</div>
@endsection
