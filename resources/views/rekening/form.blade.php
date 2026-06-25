@extends('layouts.app')
@section('title', isset($rekening) ? 'Edit Rekening' : 'Tambah Rekening')
@section('page-title', isset($rekening) ? 'Edit Rekening' : 'Tambah Rekening')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="mb-3">
            <a href="{{ route('rekening.index') }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar
            </a>
        </div>
        <div class="card">
            <div class="card-header">
                <span>{{ isset($rekening) ? 'Edit Data Rekening' : 'Formulir Rekening Baru' }}</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ isset($rekening)? route('rekening.update', encode_id($rekening->Acc_No))
                    : route('rekening.store') }}"
                    method="POST">
                    @csrf
                    @if(isset($rekening)) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label">No. Rekening <span class="text-danger">*</span></label>
                        <input type="text" name="Acc_No"
                            class="form-control @error('Acc_No') is-invalid @enderror"
                            value="{{ old('Acc_No', $rekening->Acc_No ?? '') }}"
                            placeholder="Contoh: 1234567890"
                            {{ isset($rekening) ? 'readonly' : '' }} required>
                        @error('Acc_No')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Bank <span class="text-danger">*</span></label>
                        <input type="text" name="Bank"
                            class="form-control @error('Bank') is-invalid @enderror"
                            value="{{ old('Bank', $rekening->Bank ?? '') }}"
                            placeholder="Contoh: BCA, Mandiri, BNI" required>
                        @error('Bank')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Atas Nama <span class="text-danger">*</span></label>
                        <input type="text" name="Nama"
                            class="form-control @error('Nama') is-invalid @enderror"
                            value="{{ old('Nama', $rekening->Nama ?? '') }}"
                            placeholder="Nama pemilik rekening" required>
                        @error('Nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-accent">
                            <i class="bi bi-check-lg me-1"></i>
                            {{ isset($rekening) ? 'Simpan Perubahan' : 'Tambah Rekening' }}
                        </button>
                        <a href="{{ route('rekening.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
