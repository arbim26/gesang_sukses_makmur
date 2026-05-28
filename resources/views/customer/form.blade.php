@extends('layouts.app')
@section('title', isset($customer) ? 'Edit Customer' : 'Tambah Customer')
@section('page-title', isset($customer) ? 'Edit Customer' : 'Tambah Customer')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="mb-3">
            <a href="{{ route('customer.index') }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar
            </a>
        </div>
        <div class="card">
            <div class="card-header">
                <span>{{ isset($customer) ? 'Edit Data Customer' : 'Formulir Customer Baru' }}</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ isset($customer)
                    ? route('customer.update', $customer->Id_Cust)
                    : route('customer.store') }}"
                    method="POST">
                    @csrf
                    @if(isset($customer)) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label">ID Customer <span class="text-danger">*</span></label>
                        <input type="text" name="Id_Cust" class="form-control @error('Id_Cust') is-invalid @enderror"
                            value="{{ old('Id_Cust', $customer->Id_Cust ?? '') }}"
                            placeholder="Contoh: CUST-001"
                            {{ isset($customer) ? 'readonly' : '' }} required>
                        @error('Id_Cust')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">PIC (Person in Charge) <span class="text-danger">*</span></label>
                        <input type="text" name="PIC" class="form-control @error('PIC') is-invalid @enderror"
                            value="{{ old('PIC', $customer->PIC ?? '') }}"
                            placeholder="Nama PIC customer" required>
                        @error('PIC')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-accent">
                            <i class="bi bi-check-lg me-1"></i>
                            {{ isset($customer) ? 'Simpan Perubahan' : 'Tambah Customer' }}
                        </button>
                        <a href="{{ route('customer.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
