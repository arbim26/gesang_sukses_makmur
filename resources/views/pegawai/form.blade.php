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
                    ? route('pegawai.update', $pegawai->Id_Pegawai)
                    : route('pegawai.store') }}"
                    method="POST">
                    @csrf
                    @if(isset($pegawai)) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label">ID Pegawai <span class="text-danger">*</span></label>
                        <input type="text" name="Id_Pegawai"
                            class="form-control @error('Id_Pegawai') is-invalid @enderror"
                            value="{{ old('Id_Pegawai', $pegawai->Id_Pegawai ?? '') }}"
                            placeholder="Contoh: CEO-001, SEK-001, SUP-001, STF-001"
                            {{ isset($pegawai) ? 'readonly' : '' }} required>
                        @error('Id_Pegawai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if(!isset($pegawai))
                        <small class="text-muted">Format: CEO-XXX / SEK-XXX / SUP-XXX / STF-XXX</small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Pegawai <span class="text-danger">*</span></label>
                        <input type="text" name="Nama_Pegawai"
                            class="form-control @error('Nama_Pegawai') is-invalid @enderror"
                            value="{{ old('Nama_Pegawai', $pegawai->Nama_Pegawai ?? '') }}"
                            placeholder="Nama lengkap pegawai" required>
                        @error('Nama_Pegawai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <select name="Jabatan" class="form-select @error('Jabatan') is-invalid @enderror" required>
                            <option value="">— Pilih Jabatan —</option>
                            @foreach(['CEO','Sekretaris','Supir','Staff'] as $jab)
                                <option value="{{ $jab }}"
                                    {{ old('Jabatan', $pegawai->Jabatan ?? '') == $jab ? 'selected' : '' }}>
                                    {{ $jab }}
                                </option>
                            @endforeach
                        </select>
                        @error('Jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

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
