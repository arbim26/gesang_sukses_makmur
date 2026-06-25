@extends('layouts.app')
@section('title', 'Pegawai')
@section('page-title', 'Manajemen Pegawai')

@php
    $jabatanAktif = auth('pegawai')->user()->Jabatan;
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0" style="font-size:.85rem;">
        Total <strong>{{ $pegawais->total() }}</strong> pegawai terdaftar
    </p>
    @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
    <a href="{{ route('pegawai.create') }}" class="btn btn-accent">
        <i class="bi bi-plus-lg me-1"></i> Tambah Pegawai
    </a>
    @endif
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>ID Pegawai</th>
                    <th>Nama Pegawai</th>
                    <th>Jabatan</th>
                    @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
                    <th style="width:160px;">Aksi</th>
                    @endif
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
                                'Direksi'    => 'background:#fef3c7;color:#d97706;', 
                                'Manajer'    => 'background:#fae8ff;color:#a21caf;',
                                'Sekretaris' => 'background:#eef2ff;color:#4f46e5;',
                                'Staf'       => 'background:#f3f4f6;color:#374151;',
                                'Pengemudi'  => 'background:#ecfdf5;color:#059669;',
                            ];
                        @endphp
                        <span class="badge-pill" style="{{ $colors[$p->Jabatan] ?? 'background:#f3f4f6;color:#374151;' }}">
                            {{ $p->Jabatan }}
                        </span>
                    </td>
                    @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
                    <td>
                        <a href="{{ route('pegawai.edit',  encode_id($p->Id_Pegawai)) }}"
                           class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @if(auth()->check() && auth()->user()->Id_Pegawai === $p->Id_Pegawai)
                            <span class="badge bg-light text-muted small" style="padding: 5px 10px; border: 1px solid var(--border);">
                                <i class="bi bi-person-fill-lock me-1"></i> Anda
                            </span>
                        @else
                            <form action="{{ route('pegawai.destroy', $p->Id_Pegawai) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus pegawai ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                    @endif
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

<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
    <div class="text-muted small">
        {{-- Memperbaiki teks informasi keterangan dari "barang" menjadi "pegawai" --}}
        Menampilkan {{ $pegawais->firstItem() ?? 0 }} - {{ $pegawais->lastItem() ?? 0 }} dari total {{ $pegawais->total() }} pegawai
    </div>
    <div>
        @if ($pegawais->hasPages())
            {{ $pegawais->onEachSide(1)->links('pagination::bootstrap-5') }}
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jabatanSelect = document.querySelector('select[name="Jabatan"]');
        const idInput = document.querySelector('input[name="Id_Pegawai"]');
    
        // Fitur auto-generate ID hanya bekerja jika input ID TIDAK berstatus 'readonly' (Mode Tambah Baru)
        if (jabatanSelect && idInput && !idInput.hasAttribute('readonly')) {
            jabatanSelect.addEventListener('change', function () {
                const jabatanValue = this.value;
    
                if (!jabatanValue) {
                    idInput.value = '';
                    return;
                }
    
                // Lakukan request ke backend controller menggunakan Fetch API
                fetch(`{{ route('pegawai.generate-id') }}?jabatan=${encodeURIComponent(jabatanValue)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.id) {
                            idInput.value = data.id;
                        }
                    })
                    .catch(error => {
                        console.error('Gagal generate ID:', error);
                    });
            });
        }
    });
    </script>
@endpush