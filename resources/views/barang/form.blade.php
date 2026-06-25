@extends('layouts.app')
@section('title', isset($barang) ? 'Edit Barang' : 'Tambah Barang')
@section('page-title', isset($barang) ? 'Edit Barang' : 'Tambah Barang')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="mb-3">
            <a href="{{ route('barang.index') }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar
            </a>
        </div>
        <div class="card">
            <div class="card-header">
                <span>{{ isset($barang) ? 'Edit Data Barang' : 'Formulir Barang Baru' }}</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ isset($barang) ? route('barang.update', encode_id($barang->Kode_Barang)) : route('barang.store') }}"
                      method="POST">
                    @csrf
                    @if(isset($barang)) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label">Kode Barang <span class="text-danger">*</span></label>
                        <input type="text" name="Kode_Barang"
                            class="form-control @error('Kode_Barang') is-invalid @enderror"
                            value="{{ old('Kode_Barang', $barang->Kode_Barang ?? '') }}"
                            placeholder="Contoh: BRG-001"
                            {{ isset($barang) ? 'readonly' : '' }} required>
                        @error('Kode_Barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" name="Nama_Barang"
                            class="form-control @error('Nama_Barang') is-invalid @enderror"
                            value="{{ old('Nama_Barang', $barang->Nama_Barang ?? '') }}"
                            placeholder="Nama barang" required>
                        @error('Nama_Barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Unit Price (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" style="font-size:.85rem;border-color:var(--border);">Rp</span>
                            <input type="number" name="Unit_Price" min="0" step="100"
                                class="form-control @error('Unit_Price') is-invalid @enderror"
                                value="{{ old('Unit_Price', $barang->Unit_Price ?? '') }}"
                                placeholder="0" required>
                            @error('Unit_Price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-accent">
                            <i class="bi bi-check-lg me-1"></i>
                            {{ isset($barang) ? 'Simpan Perubahan' : 'Tambah Barang' }}
                        </button>
                        <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
