@extends('layouts.app')
@section('title', 'Barang')
@section('page-title', 'Manajemen Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0" style="font-size:.85rem;">
        Total <strong>{{ $barangs->total() }}</strong> barang
    </p>
    <a href="{{ route('barang.create') }}" class="btn btn-accent">
        <i class="bi bi-plus-lg me-1"></i> Tambah Barang
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Unit Price</th>
                    <th style="width:130px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $b)
                <tr>
                    <td><code style="font-size:.8rem;">{{ $b->Kode_Barang }}</code></td>
                    <td>{{ $b->Nama_Barang }}</td>
                    <td>
                        <span style="font-weight:500;">
                            Rp {{ number_format($b->Unit_Price, 0, ',', '.') }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('barang.edit', $b->Kode_Barang) }}"
                           class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('barang.destroy', $b->Kode_Barang) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus barang ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="bi bi-inbox" style="font-size:1.5rem;"></i>
                        <p class="mt-1 mb-0">Belum ada data barang.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $barangs->links() }}</div>
@endsection
