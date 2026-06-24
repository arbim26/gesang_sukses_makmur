@extends('layouts.app')
@section('title', isset($po) ? 'Edit Purchase Order' : 'Buat Purchase Order')
@section('page-title', isset($po) ? 'Edit Purchase Order' : 'Buat Purchase Order Baru')

@php
$jabatanAktif = auth('pegawai')->user()->Jabatan;
@endphp

@section('content')

<div class="mb-3">
    <a href="{{ route('purchase-order.index') }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar
    </a>
</div>

<form action="{{ isset($po) ? route('purchase-order.update', $po->No_PO) : route('purchase-order.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($po)) @method('PUT') @endif

    <div class="row g-3 justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><span>Header Purchase Order</span></div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label">No. PO <span class="text-danger">*</span></label>
                        <input type="text" name="No_PO"
                            class="form-control @error('No_PO') is-invalid @enderror"
                            value="{{ old('No_PO', $po->No_PO ?? '') }}"
                            placeholder="PO-2024-001"
                            {{ isset($po) ? 'readonly' : '' }} required>
                        @error('No_PO')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Customer <span class="text-danger">*</span></label>
                        <select name="Id_Cust" class="form-select @error('Id_Cust') is-invalid @enderror" required>
                            <option value="">— Pilih Customer —</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->Id_Cust }}"
                                    {{ old('Id_Cust', $po->Id_Cust ?? '') == $c->Id_Cust ? 'selected' : '' }}>
                                    {{ $c->Id_Cust }} — {{ $c->Nama }} ({{ $c->PIC }})
                                </option>
                            @endforeach
                        </select>
                        @error('Id_Cust')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label">Tanggal PO <span class="text-danger">*</span></label>
                            <input type="date" name="PO_Date"
                                class="form-control @error('PO_Date') is-invalid @enderror"
                                value="{{ old('PO_Date', isset($po) ? $po->PO_Date : date('Y-m-d')) }}" required>
                            @error('PO_Date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label">Delivery Date</label>
                            <input type="date" name="Delivery_date"
                                class="form-control @error('Delivery_date') is-invalid @enderror"
                                value="{{ old('Delivery_date', $po->Delivery_date ?? '') }}">
                            @error('Delivery_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="Note" class="form-control" rows="3"
                            placeholder="Catatan tambahan...">{{ old('Note', $po->Note ?? '') }}</textarea>
                    </div>

                    <div class="mt-3">
                        <label class="form-label" for="attachment">Upload Dokumen/Nota PO (PDF, JPG, PNG)</label>
                        <input type="file" name="attachment" id="attachment" class="form-control @error('attachment') is-invalid @enderror">
                        @error('attachment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-3 d-flex gap-2">
                <button type="submit" class="btn btn-accent">
                    <i class="bi bi-arrow-right me-1"></i>
                    {{ isset($po) ? 'Simpan Perubahan' : 'Lanjut ke Detail Barang' }}
                </button>
                <a href="{{ route('purchase-order.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </div>
</form>
@endsection