@extends('layouts.app')
@section('title', 'Rekening')
@section('page-title', 'Manajemen Rekening')

@php
    $jabatanAktif = auth('pegawai')->user()->Jabatan;
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0" style="font-size:.85rem;">
        Total <strong>{{ $rekenings->total() }}</strong> rekening terdaftar
    </p>
    @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
    <a href="{{ route('rekening.create') }}" class="btn btn-accent">
        <i class="bi bi-plus-lg me-1"></i> Tambah Rekening
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>No. Rekening</th>
                    <th>Bank</th>
                    <th>Atas Nama</th>
                    @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
                    <th style="width:160px;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($rekenings as $r)
                <tr>
                    <td><code style="font-size:.8rem;">{{ $r->Acc_No }}</code></td>
                    <td>
                        <span class="badge-pill" style="background:#eff6ff;color:#2563eb;">
                            {{ $r->Bank }}
                        </span>
                    </td>
                    <td>{{ $r->Nama }}</td>
                    @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
                    <td>
                        <a href="{{ route('rekening.edit', encode_id($r->Acc_No)) }}"
                           class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('rekening.destroy', $r->Acc_No) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus rekening ini?')">
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
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="bi bi-inbox" style="font-size:1.5rem;"></i>
                        <p class="mt-1 mb-0">Belum ada data rekening.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
    <div class="text-muted small">
        Menampilkan {{ $rekenings->firstItem() ?? 0 }} - {{ $rekenings->lastItem() ?? 0 }} dari total {{ $rekenings->total() }} barang
    </div>
    <div>
        @if ($rekenings->hasPages())
            {{ $rekenings->onEachSide(1)->links('pagination::bootstrap-5') }}
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
