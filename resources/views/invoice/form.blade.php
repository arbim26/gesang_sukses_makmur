@extends('layouts.app')
@section('title', isset($invoice) ? 'Edit Invoice' : 'Buat Invoice')
@section('page-title', isset($invoice) ? 'Edit Invoice' : 'Buat Invoice Baru')

@section('content')
<div class="mb-3">
    <a href="{{ route('invoice.index') }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar
    </a>
</div>

<form action="{{ isset($invoice) ? route('invoice.update',  encode_id($invoice->No_Invoice)) : route('invoice.store') }}"
      method="POST">
    @csrf
    @if(isset($invoice)) @method('PUT') @endif

    <div class="row g-3">
        {{-- Header Invoice --}}
        <div class="col-md-7">
            <div class="card mb-3">
                <div class="card-header"><span>Header Invoice</span></div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">No. Invoice <span class="text-danger">*</span></label>
                            <input type="text" name="No_Invoice"
                                class="form-control @error('No_Invoice') is-invalid @enderror"
                                value="{{ old('No_Invoice', $invoice->No_Invoice ?? '') }}"
                                {{ isset($invoice) ? 'readonly' : '' }}
                                placeholder="INV-2024-001" required>
                            @error('No_Invoice')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Terbit <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_terbit"
                                class="form-control @error('tanggal_terbit') is-invalid @enderror"
                                value="{{ old('tanggal_terbit', isset($invoice) ? $invoice->tanggal_terbit : date('Y-m-d')) }}" required>
                            @error('tanggal_terbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Purchase Order <span class="text-danger">*</span></label>
                            @if(isset($invoice))
                                <input type="text" class="form-control" value="{{ $invoice->No_PO }}" readonly>
                                <input type="hidden" name="No_PO" value="{{ $invoice->No_PO }}">
                            @else
                                <select name="No_PO" class="form-select @error('No_PO') is-invalid @enderror"
                                    id="selPO" required>
                                    <option value="">— Pilih Purchase Order —</option>
                                    @foreach($purchaseOrders as $po)
                                        <option value="{{ $po->No_PO }}"
                                            data-subtotal="{{ $po->Sub_Total }}"
                                            data-ppn="{{ $po->PPN }}"
                                            {{ old('No_PO') == $po->No_PO ? 'selected' : '' }}>
                                            {{ $po->No_PO }} — {{ $po->customer->Nama ?? '' }}
                                            (Rp {{ number_format($po->Grand_Total, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('No_PO')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Diskon (%)</label>
                            <div class="input-group">
                                <input type="number" name="discount" id="inpDiskon"
                                    class="form-control @error('discount') is-invalid @enderror"
                                    value="{{ old('discount', $invoice->discount ?? 0) }}"
                                    min="0" max="100" step="0.5">
                                <span class="input-group-text" style="font-size:.85rem;border-color:var(--border);">%</span>
                            </div>
                            @error('discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rekening <span class="text-danger">*</span></label>
                            <select name="Acc_No" class="form-select @error('Acc_No') is-invalid @enderror" required>
                                <option value="">— Pilih Rekening —</option>
                                @foreach($rekenings as $r)
                                    <option value="{{ $r->Acc_No }}"
                                        {{ old('Acc_No', $invoice->Acc_No ?? '') == $r->Acc_No ? 'selected' : '' }}>
                                        {{ $r->Bank }} — {{ $r->Acc_No }} ({{ $r->Nama }})
                                    </option>
                                @endforeach
                            </select>
                            @error('Acc_No')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Summary --}}
                    <div class="mt-4 p-3 rounded" style="background:var(--surface);border:1px solid var(--border);">
                        <div class="d-flex justify-content-between mb-1" style="font-size:.85rem;">
                            <span class="text-muted">Sub Total PO</span>
                            <span id="lblSub">Rp —</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1" style="font-size:.85rem;">
                            <span class="text-muted">Setelah Diskon</span>
                            <span id="lblAfterDisc">Rp —</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1" style="font-size:.85rem;">
                            <span class="text-muted">PPN</span>
                            <span id="lblPPN">Rp —</span>
                        </div>
                        <div class="d-flex justify-content-between pt-2" style="border-top:1px solid var(--border);font-weight:600;font-size:1rem;">
                            <span>Grand Total</span>
                            <span id="lblGrand" style="color:var(--accent);">Rp —</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pegawai --}}
        <div class="col-md-5">
            <div class="card">
                <div class="card-header"><span>Pegawai Terkait</span></div>
                <div class="card-body p-4">
                    {{-- INPUT DIREKSI (Pengganti Teks CEO) --}}
                    <div class="mb-3">
                        <label class="form-label">Direksi <span class="text-danger">*</span></label>
                        <select name="Id_CEO" class="form-select @error('Id_CEO') is-invalid @enderror" required>
                            <option value="">— Pilih Direksi —</option>
                            @foreach($petugasDireksi as $p)
                                <option value="{{ $p->Id_Pegawai }}"
                                    {{ old('Id_CEO', $invoice->Id_CEO ?? '') == $p->Id_Pegawai ? 'selected' : '' }}>
                                    {{ $p->Nama_Pegawai }}
                                </option>
                            @endforeach
                        </select>
                        @error('Id_CEO')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    {{-- INPUT SEKRETARIS --}}
                    <div class="mb-3">
                        <label class="form-label">Sekretaris <span class="text-danger">*</span></label>
                        <select name="Id_Sekretaris" class="form-select @error('Id_Sekretaris') is-invalid @enderror" required>
                            <option value="">— Pilih Sekretaris —</option>
                            @foreach($petugasSekretaris as $p)
                                <option value="{{ $p->Id_Pegawai }}"
                                    {{ old('Id_Sekretaris', $invoice->Id_Sekretaris ?? '') == $p->Id_Pegawai ? 'selected' : '' }}>
                                    {{ $p->Nama_Pegawai }}
                                </option>
                            @endforeach
                        </select>
                        @error('Id_Sekretaris')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Preview detail barang dari PO (readonly info) --}}
                    <div id="poPreview" style="display:none;">
                        <hr style="border-color:var(--border);">
                        <p class="text-muted mb-2" style="font-size:.75rem;text-transform:uppercase;letter-spacing:.8px;">
                            Detail Barang PO
                        </p>
                        <div id="poPreviewContent" style="font-size:.8rem;"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="col-12">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-accent">
                    <i class="bi bi-check-lg me-1"></i>
                    {{ isset($invoice) ? 'Simpan Perubahan' : 'Buat Invoice' }}
                </button>
                <a href="{{ route('invoice.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
@if(!isset($invoice))
const poData = @json($purchaseOrders->keyBy('No_PO'));

document.getElementById('selPO').addEventListener('change', function () {
    const po = poData[this.value];
    if (!po) { resetSummary(); return; }
    hitungTotal(po.Sub_Total, po.PPN);
    renderPoDetail(po);
});

document.getElementById('inpDiskon').addEventListener('input', function () {
    const selPO = document.getElementById('selPO');
    const po = poData[selPO.value];
    if (!po) return;
    hitungTotal(po.Sub_Total, po.PPN);
});

function renderPoDetail(po) {
    const div = document.getElementById('poPreviewContent');
    div.innerHTML = (po.details || []).map(d =>
        `<div class="d-flex justify-content-between mb-1">
            <span>${d.barang?.Nama_Barang ?? d.No_Barang} ×${d.Qty}</span>
            <span>Rp ${fmt(d.Amount)}</span>
        </div>`
    ).join('') || '<span class="text-muted">—</span>';
    document.getElementById('poPreview').style.display = 'block';
}
@else
// Edit mode: hitung dari nilai invoice yang sudah ada
const fixedSub = {{ $invoice->purchaseOrder->Sub_Total ?? 0 }};
const fixedPPN = {{ $invoice->purchaseOrder->PPN ?? 11 }};
document.getElementById('inpDiskon').addEventListener('input', () => hitungTotal(fixedSub, fixedPPN));
hitungTotal(fixedSub, fixedPPN);
@endif

function hitungTotal(sub, ppnRate) {
    const disc      = parseFloat(document.getElementById('inpDiskon').value) || 0;
    const afterDisc = sub * (1 - disc / 100);
    const ppnAmt    = afterDisc * (ppnRate / 100);
    const grand     = afterDisc + ppnAmt;

    document.getElementById('lblSub').textContent       = 'Rp ' + fmt(sub);
    document.getElementById('lblAfterDisc').textContent = 'Rp ' + fmt(afterDisc);
    document.getElementById('lblPPN').textContent       = 'Rp ' + fmt(ppnAmt);
    document.getElementById('lblGrand').textContent     = 'Rp ' + fmt(grand);
}

function resetSummary() {
    ['lblSub','lblAfterDisc','lblPPN','lblGrand'].forEach(id =>
        document.getElementById(id).textContent = 'Rp —');
    document.getElementById('poPreview').style.display = 'none';
}

function fmt(n) { return Math.round(n).toLocaleString('id-ID'); }
</script>
@endpush