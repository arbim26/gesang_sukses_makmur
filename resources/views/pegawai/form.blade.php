@extends('layouts.app')
@section('title', isset($pegawai) ? 'Edit Pegawai' : 'Tambah Pegawai')
@section('page-title', isset($pegawai) ? 'Edit Pegawai' : 'Tambah Pegawai')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="mb-3">
            <a href="{{ route('pegawai.index') }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <span>{{ isset($pegawai) ? 'Edit Data Pegawai' : 'Formulir Pegawai Baru' }}</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ isset($pegawai)
                    ? route('pegawai.update', ($pegawai->Id_Pegawai))
                    : route('pegawai.store') }}"encode_id
                    method="POST">
                    @csrf
                    @if(isset($pegawai)) @method('PUT') @endif

                    {{-- 1. Input ID Pegawai --}}
                    <div class="mb-3">
                        <label class="form-label">Nomor Induk Pegawai <span class="text-danger">*</span></label>
                        <input type="text" name="Id_Pegawai"
                            class="form-control @error('Id_Pegawai') is-invalid @enderror"
                            value="{{ old('Id_Pegawai', $pegawai->Id_Pegawai ?? '') }}"
                            placeholder="Nomor Induk Pegawai"
                            {{ isset($pegawai) ? 'readonly' : '' }} required>
                        @error('Id_Pegawai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if(!isset($pegawai))
                        {{-- <small class="text-muted">Format: IT-XXX / CEO-XXX / MNJ-XXX / SEK-XXX / BND-XXX / STF-XXX / SUP-XXX</small> --}}
                        @endif
                    </div>

                    {{-- 2. Input Nama Pegawai --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Pegawai <span class="text-danger">*</span></label>
                        <input type="text" name="Nama_Pegawai"
                            class="form-control @error('Nama_Pegawai') is-invalid @enderror"
                            value="{{ old('Nama_Pegawai', $pegawai->Nama_Pegawai ?? '') }}"
                            placeholder="Nama lengkap pegawai" required>
                        @error('Nama_Pegawai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- 3. Input Password (Baru) --}}
                    <div class="mb-3">
                        <label class="form-label">
                            Password 
                            @if(!isset($pegawai)) <span class="text-danger">*</span> @endif
                        </label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="{{ isset($pegawai) ? 'Kosongkan jika tidak ingin mengubah' : 'Masukkan password login' }}"
                            @if(!isset($pegawai)) required @endif>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if(isset($pegawai))
                        <small class="text-muted">Isi hanya jika ingin mengganti password pegawai ini.</small>
                        @endif
                    </div>

                    {{-- 4. Select Jabatan --}}
                    <div class="mb-4">
                        <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <select name="Jabatan" class="form-select @error('Jabatan') is-invalid @enderror" required>
                            <option value="">— Pilih Jabatan —</option>
                            @foreach(['Staf IT', 'Direksi', 'Manajer', 'Sekretaris', 'Bendahara', 'Staf', 'Pengemudi'] as $jab)
                                <option value="{{ $jab }}"
                                    {{ old('Jabatan', $pegawai->Jabatan ?? '') == $jab ? 'selected' : '' }}>
                                    {{ $jab }}
                                </option>
                            @endforeach
                        </select>
                        @error('Jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-accent">
                            <i class="bi bi-check-lg me-1"></i>
                            {{ isset($pegawai) ? 'Simpan Perubahan' : 'Tambah Pegawai' }}
                        </button>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection