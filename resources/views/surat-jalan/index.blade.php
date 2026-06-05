@extends('layouts.app')
@section('title', 'Surat Jalan')
@section('page-title', 'Manajemen Surat Jalan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0" style="font-size:.85rem;">
        Total <strong>{{ $suratJalans->total() }}</strong> surat jalan
    </p>
    <a href="{{ route('surat-jalan.create') }}" class="btn btn-accent">
        <i class="bi bi-plus-lg me-1"></i> Buat Surat Jalan
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>No. SJ</th>
                    <th>Tanggal</th>
                    <th>No. PO</th>
                    <th>Customer</th>
                    <th>Supir</th>
                    <th style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suratJalans as $sj)
                <tr>
                    <td><code style="font-size:.8rem;">{{ $sj->No_SJ }}</code></td>
                    <td style="font-size:.85rem;">{{ \Carbon\Carbon::parse($sj->Tanggal)->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('purchase-order.show', $sj->No_PO) }}"
                           style="font-size:.8rem;color:var(--accent);text-decoration:none;">
                            {{ $sj->No_PO }}
                        </a>
                    </td>
                    <td>
                        <div style="font-size:.875rem;">{{ $sj->purchaseOrder->customer->Nama ?? '-' }}</div>
                        <div style="font-size:.75rem;color:var(--text-muted);">{{ $sj->purchaseOrder->customer->PIC ?? '' }}</div>
                    </td>
                    <td style="font-size:.85rem;">{{ $sj->supir->Nama_Pegawai ?? '—' }}</td>
                    <td>
                        <a href="{{ route('surat-jalan.show', $sj->No_SJ) }}"
                           class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('surat-jalan.edit', $sj->No_SJ) }}"
                           class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('surat-jalan.destroy', $sj->No_SJ) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus surat jalan ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-inbox" style="font-size:1.5rem;"></i>
                        <p class="mt-1 mb-0">Belum ada surat jalan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
    <div class="text-muted small">
        Menampilkan {{ $suratJalans->firstItem() ?? 0 }} - {{ $suratJalans->lastItem() ?? 0 }} dari total {{ $suratJalans->total() }} barang
    </div>
    <div>
        @if ($suratJalans->hasPages())
            {{ $suratJalans->onEachSide(1)->links('pagination::bootstrap-5') }}
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
