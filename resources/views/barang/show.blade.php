@extends('layouts.app')
@section('title', 'Detail Barang')
@section('page-title', 'Detail Barang')

@section('content')
<div class="mb-3">
    <a href="{{ route('barang.index') }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar
    </a>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <span><i class="bi bi-box-seam me-2"></i>Informasi Barang</span>
                <a href="{{ route('barang.edit', $barang->Kode_Barang) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
            <div class="card-body">
                <dl style="font-size:.875rem;">
                    <dt class="text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Kode Barang</dt>
                    <dd><code>{{ $barang->Kode_Barang }}</code></dd>

                    <dt class="text-muted mt-3" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Nama Barang</dt>
                    <dd style="font-weight:500;">{{ $barang->Nama_Barang }}</dd>

                    @if($barang->Jenis)
                    <dt class="text-muted mt-3" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Jenis</dt>
                    <dd>{{ $barang->Jenis }}</dd>
                    @endif

                    <dt class="text-muted mt-3" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Unit Price</dt>
                    <dd style="font-size:1.1rem;font-weight:600;color:#4f46e5;">
                        Rp {{ number_format($barang->Unit_Price, 0, ',', '.') }}
                    </dd>

                    @if($barang->Unit_Means)
                    <dt class="text-muted mt-3" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Satuan</dt>
                    <dd>{{ $barang->Unit_Means }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span><i class="bi bi-receipt me-2"></i>Riwayat Penggunaan</span>
                <span class="badge-pill" style="background:#eef2ff;color:#4f46e5;">
                    {{ $barang->detailInvoices->count() }}
                </span>
            </div>
            <div class="card-body p-0">
                @if($barang->detailInvoices->isEmpty())
                <p class="text-center text-muted py-4 mb-0" style="font-size:.85rem;">
                    <i class="bi bi-inbox" style="font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>
                    Barang belum pernah digunakan dalam invoice.
                </p>
                @else
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No Invoice</th>
                            <th>Qty</th>
                            <th>Harga Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($barang->detailInvoices->take(10) as $d)
                        <tr>
                            <td><code style="font-size:.8rem;">{{ $d->No_Invoice }}</code></td>
                            <td>{{ $d->Qty ?? '-' }}</td>
                            <td>Rp {{ number_format($d->Harga ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
