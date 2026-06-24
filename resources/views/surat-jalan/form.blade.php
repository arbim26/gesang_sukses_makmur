@extends('layouts.app')
@section('title', isset($suratJalan) ? 'Edit Surat Jalan' : 'Buat Surat Jalan')
@section('page-title', isset($suratJalan) ? 'Edit Surat Jalan' : 'Buat Surat Jalan Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="mb-3">
            <a href="{{ route('surat-jalan.index') }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar
            </a>
        </div>
        <div class="card">
            <div class="card-header">
                <span>{{ isset($suratJalan) ? 'Edit Surat Jalan' : 'Formulir Surat Jalan Baru' }}</span>
            </div>
            <div class="card-body p-4">
<form action="{{ isset($suratJalan) ? route('surat-jalan.update', encode_id($suratJalan->No_SJ)) : route('surat-jalan.store') }}"
                      method="POST">
                    @csrf
                    @if(isset($suratJalan)) @method('PUT') @endif

                    <div class="mb-3">
                        <label class="form-label">No. Surat Jalan <span class="text-danger">*</span></label>
                        <input type="text" name="No_SJ"
                            class="form-control @error('No_SJ') is-invalid @enderror"
                            value="{{ old('No_SJ', $suratJalan->No_SJ ?? '') }}"
                            {{ isset($suratJalan) ? 'readonly' : '' }}
                            placeholder="SJ-2024-001" required>
                        @error('No_SJ')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Purchase Order <span class="text-danger">*</span></label>
                        @if(isset($suratJalan))
                            <input type="text" class="form-control"
                                value="{{ $suratJalan->No_PO }} — {{ $suratJalan->purchaseOrder->customer->Nama ?? '' }}"
                                readonly>
                            <input type="hidden" name="No_PO" value="{{ $suratJalan->No_PO }}">
                        @else
                            <select name="No_PO" class="form-select @error('No_PO') is-invalid @enderror" required>
                                <option value="">— Pilih Purchase Order —</option>
                                @foreach($purchaseOrders as $po)
                                    <option value="{{ $po->No_PO }}"
                                        {{ old('No_PO') == $po->No_PO ? 'selected' : '' }}>
                                        {{ $po->No_PO }} — {{ $po->customer->Nama ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('No_PO')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Hanya PO yang sudah memiliki Invoice dan belum memiliki Surat Jalan.</small>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="Tanggal"
                            class="form-control @error('Tanggal') is-invalid @enderror"
                            value="{{ old('Tanggal', isset($suratJalan) ? $suratJalan->Tanggal : date('Y-m-d')) }}" required>
                        @error('Tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Supir <span class="text-danger">*</span></label>
                        <select name="Id_Supir" class="form-select @error('Id_Supir') is-invalid @enderror" required>
                            <option value="">— Pilih Supir —</option>
                            
                            @foreach($petugasSupir as $p)
                                <option value="{{ $p->Id_Pegawai }}"
                                    {{ old('Id_Supir', $suratJalans->Id_Supir ?? '') == $p->Id_Pegawai ? 'selected' : '' }}>
                                    {{ $p->Nama_Pegawai }} ({{ $p->Id_Pegawai }})
                                </option>
                            @endforeach
                        </select>
                        @error('Id_Supir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Keterangan</label>
                        <textarea name="Keterangan" class="form-control" rows="2"
                            placeholder="Catatan pengiriman...">{{ old('Keterangan', $suratJalan->Keterangan ?? '') }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-accent">
                            <i class="bi bi-check-lg me-1"></i>
                            {{ isset($suratJalan) ? 'Simpan Perubahan' : 'Buat Surat Jalan' }}
                        </button>
                        <a href="{{ route('surat-jalan.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
