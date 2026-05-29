@extends('layouts.app')
@section('title', 'Tambah Detail Barang — ' . $po->No_PO)
@section('page-title', 'Tambah Detail Barang')

@section('content')
<div class="mb-3">
    <a href="{{ route('purchase-order.show', $po->No_PO) }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke PO {{ $po->No_PO }}
    </a>
</div>

{{-- Info ringkas PO --}}
<div class="card mb-3" style="border-left:3px solid var(--accent);">
    <div class="card-body py-2 px-3">
        <div class="d-flex flex-wrap gap-4" style="font-size:.85rem;">
            <div>
                <span class="text-muted">No. PO</span><br>
                <code style="font-size:.8rem;">{{ $po->No_PO }}</code>
            </div>
            <div>
                <span class="text-muted">Customer</span><br>
                <span style="font-weight:500;">{{ $po->customer->Nama ?? '-' }}</span>
            </div>
            <div>
                <span class="text-muted">Tanggal PO</span><br>
                {{ \Carbon\Carbon::parse($po->PO_Date)->format('d M Y') }}
            </div>
            <div class="ms-auto text-end">
                <span class="text-muted" style="font-size:.75rem;">Grand Total saat ini</span><br>
                <span style="font-weight:600;color:var(--accent);">Rp {{ number_format($po->Grand_Total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success d-flex align-items-center gap-2 py-2" style="font-size:.85rem;">
    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
</div>
@endif
@if($errors->any())
<div class="alert alert-danger py-2" style="font-size:.85rem;">
    <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<div class="row g-3">
    {{-- Form Tambah --}}
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><span><i class="bi bi-plus-circle me-2"></i>Tambah Baris Detail</span></div>
            <div class="card-body p-4">
                <form action="{{ route('purchase-order.detail.store', $po->No_PO) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Barang <span class="text-danger">*</span></label>
                        <select name="No_Barang" id="barangSel"
                            class="form-select @error('No_Barang') is-invalid @enderror" required>
                            <option value="">— Pilih Barang —</option>
                            @foreach($barangs as $b)
                                <option value="{{ $b->Kode_Barang }}"
                                    data-price="{{ $b->Unit_Price }}"
                                    data-unit="{{ $b->Unit_Means }}"
                                    {{ old('No_Barang') == $b->Kode_Barang ? 'selected' : '' }}>
                                    {{ $b->Nama_Barang }}
                                    @if($b->Unit_Means) ({{ $b->Unit_Means }}) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('No_Barang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Unit Price</label>
                        <div class="input-group">
                            <span class="input-group-text" style="font-size:.8rem;">Rp</span>
                            <input type="number" id="unitPriceDisplay"
                                class="form-control" value="0" readonly
                                style="background:var(--surface);color:var(--text-muted);">
                        </div>
                        <div id="unitInfo" class="form-text"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Qty <span class="text-danger">*</span></label>
                        <input type="number" name="Qty" id="qtyInp"
                            class="form-control @error('Qty') is-invalid @enderror"
                            value="{{ old('Qty', 1) }}" min="1" required>
                        @error('Qty')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Metode</label>
                        <input type="text" name="Metode"
                            class="form-control @error('Metode') is-invalid @enderror"
                            value="{{ old('Metode') }}"
                            placeholder="Contoh: Transfer, Cash, Kredit, dll.">
                        @error('Metode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Preview Amount --}}
                    <div class="p-3 rounded mb-4" style="background:var(--surface);border:1px solid var(--border);">
                        <div class="d-flex justify-content-between" style="font-size:.85rem;">
                            <span class="text-muted">Amount</span>
                            <span id="lblAmount" style="font-weight:600;color:var(--accent);">Rp 0</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-accent w-100">
                        <i class="bi bi-plus-lg me-1"></i> Tambah ke PO
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Daftar detail yang sudah ada --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <span><i class="bi bi-list-ul me-2"></i>Detail Barang ({{ $po->details->count() }} item)</span>
            </div>
            <div class="card-body p-0">
                @if($po->details->isEmpty())
                <div class="text-center text-muted py-4">
                    <i class="bi bi-inbox" style="font-size:1.5rem;"></i>
                    <p class="mt-1 mb-0" style="font-size:.85rem;">Belum ada detail barang.</p>
                </div>
                @else
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th class="text-center" style="width:60px;">Qty</th>
                            <th class="text-end" style="width:120px;">Unit Price</th>
                            <th class="text-end" style="width:130px;">Amount</th>
                            <th style="width:110px;">Metode</th>
                            <th style="width:40px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($po->details as $d)
                        <tr>
                            <td style="font-size:.875rem;">
                                <div style="font-weight:500;">{{ $d->barang->Nama_Barang ?? $d->No_Barang }}</div>
                                <div style="font-size:.75rem;color:var(--text-muted);">{{ $d->No_Barang }}</div>
                            </td>
                            <td class="text-center">{{ $d->Qty }}</td>
                            <td class="text-end" style="font-size:.85rem;">Rp {{ number_format($d->Unit_Price, 0, ',', '.') }}</td>
                            <td class="text-end" style="font-weight:500;">Rp {{ number_format($d->Amount, 0, ',', '.') }}</td>
                            <td>
                                @if($d->Metode)
                                    <span class="badge-pill" style="background:#f3f4f6;color:#374151;font-size:.7rem;">{{ $d->Metode }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('purchase-order.detail.destroy', [$po->No_PO, $d->id]) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus baris ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            @if($po->details->isNotEmpty())
            {{-- Ringkasan total --}}
            <div class="card-footer" style="background:var(--surface);">
                <div class="d-flex justify-content-end gap-4" style="font-size:.85rem;">
                    <div class="text-muted">Sub Total</div>
                    <div style="min-width:130px;text-align:right;">Rp {{ number_format($po->Sub_Total, 0, ',', '.') }}</div>
                </div>
                <div class="d-flex justify-content-end gap-4" style="font-size:.85rem;">
                    <div class="text-muted">PPN ({{ $po->PPN }}%)</div>
                    <div style="min-width:130px;text-align:right;">Rp {{ number_format($po->Grand_Total - $po->Sub_Total, 0, ',', '.') }}</div>
                </div>
                <div class="d-flex justify-content-end gap-4 pt-2" style="border-top:1px solid var(--border);font-weight:600;">
                    <div>Grand Total</div>
                    <div style="min-width:130px;text-align:right;color:var(--accent);">Rp {{ number_format($po->Grand_Total, 0, ',', '.') }}</div>
                </div>
            </div>
            @endif
        </div>

        <div class="mt-3 d-flex gap-2">
            <a href="{{ route('purchase-order.show', $po->No_PO) }}" class="btn btn-accent">
                <i class="bi bi-check-lg me-1"></i> Selesai
            </a>
            <a href="{{ route('purchase-order.index') }}" class="btn btn-outline-secondary">
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const barangSel      = document.getElementById('barangSel');
const unitPriceDisp  = document.getElementById('unitPriceDisplay');
const unitInfo       = document.getElementById('unitInfo');
const qtyInp         = document.getElementById('qtyInp');
const lblAmount      = document.getElementById('lblAmount');

function fmt(n) { return Math.round(n).toLocaleString('id-ID'); }

function updatePreview() {
    const opt   = barangSel.options[barangSel.selectedIndex];
    const price = parseFloat(opt?.dataset?.price || 0);
    const unit  = opt?.dataset?.unit || '';
    const qty   = parseFloat(qtyInp.value) || 0;

    unitPriceDisp.value = price;
    unitInfo.textContent = unit ? `Satuan: ${unit}` : '';
    lblAmount.textContent = 'Rp ' + fmt(price * qty);
}

barangSel.addEventListener('change', updatePreview);
qtyInp.addEventListener('input', updatePreview);
updatePreview();
</script>
@endpush