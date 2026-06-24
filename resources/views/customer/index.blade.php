@extends('layouts.app')
@section('title', 'Customer')
@section('page-title', 'Manajemen Customer')

@php
    $jabatanAktif = auth('pegawai')->user()->Jabatan;
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0" style="font-size:.85rem;">
        Total <strong>{{ $customers->total() }}</strong> customer terdaftar
    </p>
    @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
    <a href="{{ route('customer.create') }}" class="btn btn-accent">
        <i class="bi bi-plus-lg me-1"></i> Tambah Customer
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>ID Customer</th>
                    <th>Nama Perusahaan</th>
                    <th>PIC</th>
                    @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
                    <th style="width:130px;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $c)
                <tr>
                    <td><code style="font-size:.8rem;">{{ $c->Id_Cust }}</code></td>
                    <td>{{ $c->Nama }}</td>
                    <td>{{ $c->PIC }}</td>
                    @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
                    <td>
<<<<<<< HEAD
<<<<<<< HEAD
                        <a href="{{ route('customer.show', $c->Id_Cust) }}"
                           class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-eye"></i>
                        </a>
=======
>>>>>>> f51e716 (add JWT and Multi Role)
=======
>>>>>>> 295042f63e0e6b961cd858a8aef381f99c0de7e1
                        <a href="{{ route('customer.edit', $c->Id_Cust) }}"
                           class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('customer.destroy', $c->Id_Cust) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus customer ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted py-4">
                        <i class="bi bi-inbox" style="font-size:1.5rem;"></i>
                        <p class="mt-1 mb-0">Belum ada data customer.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
    <div class="text-muted small">
        Menampilkan {{ $customers->firstItem() ?? 0 }} - {{ $customers->lastItem() ?? 0 }} dari total {{ $customers->total() }} barang
    </div>
    <div>
        @if ($customers->hasPages())
            {{ $customers->onEachSide(1)->links('pagination::bootstrap-5') }}
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
