@extends('layouts.app')
@section('title', 'Pegawai')
@section('page-title', 'Manajemen Pegawai')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0" style="font-size:.85rem;">
        Total <strong>{{ $pegawais->total() }}</strong> pegawai terdaftar
    </p>
    <a href="{{ route('pegawai.create') }}" class="btn btn-accent">
        <i class="bi bi-plus-lg me-1"></i> Tambah Pegawai
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>ID Pegawai</th>
                    <th>Nama Pegawai</th>
                    <th>Jabatan</th>
                    <th style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pegawais as $p)
                <tr>
                    <td><code style="font-size:.8rem;">{{ $p->Id_Pegawai }}</code></td>
                    <td>{{ $p->Nama_Pegawai }}</td>
                    <td>
                        @php
                            $colors = [
                                'CEO'        => 'background:#fef3c7;color:#d97706;',
                                'Sekretaris' => 'background:#eef2ff;color:#4f46e5;',
                                'Supir'      => 'background:#ecfdf5;color:#059669;',
                                'Staff'      => 'background:#f3f4f6;color:#374151;',
                            ];
                        @endphp
                        <span class="badge-pill" style="{{ $colors[$p->Jabatan] ?? '' }}">
                            {{ $p->Jabatan }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('pegawai.show', $p->Id_Pegawai) }}"
                           class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('pegawai.edit', $p->Id_Pegawai) }}"
                           class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('pegawai.destroy', $p->Id_Pegawai) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus pegawai ini?')">
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
                        <p class="mt-1 mb-0">Belum ada data pegawai.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $pegawais->links() }}
</div>
@endsection
