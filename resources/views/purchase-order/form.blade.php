@extends('layouts.app')
@section('title', isset($po) ? 'Edit Purchase Order' : 'Buat Purchase Order')
@section('page-title', isset($po) ? 'Edit Purchase Order' : 'Buat Purchase Order Baru')

@section('content')
<div class="mb-3">
    <a href="{{ route('purchase-order.index') }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar
    </a>
</div>

<form action="{{ isset($po) ? route('purchase-order.update', $po->No_PO) : route('purchase-order.store') }}"
      method="POST">
    @csrf
    @if(isset($po)) @method('PUT') @endif

    <div class="row g-3">
        {{-- Header PO --}}
        <div class="col-md-5">
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
                        <textarea name="Note" class="form-control" rows="2"
                            placeholder="Catatan tambahan...">{{ old('Note', $po->Note ?? '') }}</textarea>
                    </div>

                    {{-- Summary --}}
                    <div class="mt-4 p-3 rounded" style="background:var(--surface);border:1px solid var(--border);">
                        <div class="d-flex justify-content-between mb-1" style="font-size:.85rem;">
                            <span class="text-muted">Sub Total</span>
                            <span id="lblSubTotal">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1" style="font-size:.85rem;">
                            <span class="text-muted">PPN (11%)</span>
                            <span id="lblPPN">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between" style="font-size:1rem;font-weight:600;">
                            <span>Grand Total</span>
                            <span id="lblGrandTotal" style="color:var(--accent);">Rp 0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Barang --}}
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <span>Detail Barang</span>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btnTambah">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Baris
                    </button>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0" id="detailTable">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th style="width:80px;">Qty</th>
                                <th style="width:130px;">Unit Price</th>
                                <th style="width:130px;">Amount</th>
                                <th style="width:110px;">Metode</th>
                                <th style="width:40px;"></th>
                            </tr>
                        </thead>
                        <tbody id="detailBody">
                            @php $existingDetails = old('details', isset($po) ? $po->details->map(fn($d) => [
                                'No_Barang'  => $d->No_Barang,
                                'Qty'        => $d->Qty,
                                'Unit_Price' => $d->Unit_Price,
                                'Amount'     => $d->Amount,
                                'Metode'     => $d->Metode,
                            ])->toArray() : []) @endphp

                            @if(empty($existingDetails))
                                @php $existingDetails = [['No_Barang'=>'','Qty'=>1,'Unit_Price'=>0,'Amount'=>0,'Metode'=>'Transfer']] @endphp
                            @endif

                            @foreach($existingDetails as $i => $d)
                            <tr>
                                <td>
                                    <select name="details[{{ $i }}][No_Barang]"
                                        class="form-select form-select-sm barang-sel" required>
                                        <option value="">— Pilih —</option>
                                        @foreach($barangs as $b)
                                            <option value="{{ $b->Kode_Barang }}"
                                                data-price="{{ $b->Unit_Price }}"
                                                {{ ($d['No_Barang'] ?? '') == $b->Kode_Barang ? 'selected' : '' }}>
                                                {{ $b->Nama_Barang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="details[{{ $i }}][Qty]"
                                        class="form-control form-control-sm qty-inp"
                                        value="{{ $d['Qty'] ?? 1 }}" min="1" required>
                                </td>
                                <td>
                                    <input type="number" name="details[{{ $i }}][Unit_Price]"
                                        class="form-control form-control-sm price-inp"
                                        value="{{ $d['Unit_Price'] ?? 0 }}" readonly>
                                </td>
                                <td>
                                    <input type="number" name="details[{{ $i }}][Amount]"
                                        class="form-control form-control-sm amount-inp"
                                        value="{{ $d['Amount'] ?? 0 }}" readonly>
                                </td>
                                <td>
                                    <select name="details[{{ $i }}][Metode]" class="form-select form-select-sm">
                                        @foreach(['Transfer','Cash','Kredit'] as $m)
                                            <option {{ ($d['Metode'] ?? 'Transfer') == $m ? 'selected' : '' }}>{{ $m }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-hapus">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="col-12">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-accent">
                    <i class="bi bi-check-lg me-1"></i>
                    {{ isset($po) ? 'Simpan Perubahan' : 'Buat Purchase Order' }}
                </button>
                <a href="{{ route('purchase-order.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
const barangsMap = @json($barangs->keyBy('Kode_Barang'));
let rowIdx = {{ count($existingDetails ?? [1]) }};
const PPN_RATE = 0.11;

function metodeOptions(selected = 'Transfer') {
    return ['Transfer','Cash','Kredit'].map(m =>
        `<option${m === selected ? ' selected' : ''}>${m}</option>`
    ).join('');
}

function barangOptions() {
    return Object.values(barangsMap).map(b =>
        `<option value="${b.Kode_Barang}" data-price="${b.Unit_Price}">${b.Nama_Barang}</option>`
    ).join('');
}

document.getElementById('btnTambah').addEventListener('click', () => {
    const i = rowIdx++;
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td><select name="details[${i}][No_Barang]" class="form-select form-select-sm barang-sel" required>
            <option value="">— Pilih —</option>${barangOptions()}
        </select></td>
        <td><input type="number" name="details[${i}][Qty]" class="form-control form-control-sm qty-inp" value="1" min="1" required></td>
        <td><input type="number" name="details[${i}][Unit_Price]" class="form-control form-control-sm price-inp" value="0" readonly></td>
        <td><input type="number" name="details[${i}][Amount]" class="form-control form-control-sm amount-inp" value="0" readonly></td>
        <td><select name="details[${i}][Metode]" class="form-select form-select-sm">${metodeOptions()}</select></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger btn-hapus"><i class="bi bi-x"></i></button></td>`;
    document.getElementById('detailBody').appendChild(tr);
    bindRow(tr);
    hitungSemua();
});

function bindRow(tr) {
    tr.querySelector('.barang-sel').addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        tr.querySelector('.price-inp').value = opt.dataset.price || 0;
        hitungRow(tr);
    });
    tr.querySelector('.qty-inp').addEventListener('input', () => hitungRow(tr));
    tr.querySelector('.btn-hapus').addEventListener('click', () => { tr.remove(); hitungSemua(); });
}

function hitungRow(tr) {
    const qty   = parseFloat(tr.querySelector('.qty-inp').value)   || 0;
    const price = parseFloat(tr.querySelector('.price-inp').value) || 0;
    tr.querySelector('.amount-inp').value = qty * price;
    hitungSemua();
}

function hitungSemua() {
    let sub = 0;
    document.querySelectorAll('.amount-inp').forEach(a => sub += parseFloat(a.value) || 0);
    const ppn   = sub * PPN_RATE;
    const grand = sub + ppn;
    document.getElementById('lblSubTotal').textContent   = 'Rp ' + fmt(sub);
    document.getElementById('lblPPN').textContent        = 'Rp ' + fmt(ppn);
    document.getElementById('lblGrandTotal').textContent = 'Rp ' + fmt(grand);
}

function fmt(n) { return Math.round(n).toLocaleString('id-ID'); }

// Bind existing rows
document.querySelectorAll('#detailBody tr').forEach(bindRow);
hitungSemua();
</script>
@endpush
