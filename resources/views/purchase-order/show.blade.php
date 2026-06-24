@extends('layouts.app')
@section('title', 'Detail PO ' . $po->No_PO)
@section('page-title', 'Detail Purchase Order')

@php
    $jabatanAktif = auth('pegawai')->user()->Jabatan;
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ route('purchase-order.index') }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar
    </a>
    @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
    <div class="d-flex gap-2">
        @if(!$po->invoices->count())
        <a href="{{ route('purchase-order.edit', $po->No_PO) }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-pencil me-1"></i> Edit PO
        </a>
        @endif
        @if($po->invoices->count() && !$po->suratJalan)
        <a href="{{ route('surat-jalan.create') }}" class="btn btn-sm btn-accent">
            <i class="bi bi-truck me-1"></i> Buat Surat Jalan
        </a>
        @endif
        @if(!$po->invoices->count())
        <a href="{{ route('invoice.create') }}" class="btn btn-sm btn-accent">
            <i class="bi bi-receipt me-1"></i> Buat Invoice
        </a>
        @endif
    </div>
    @endif
</div>

<div class="row g-3">
    {{-- ── Kolom Kiri: Info PO ─────────────────────────────── --}}
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header"><span><i class="bi bi-file-earmark-text me-2"></i>Info Purchase Order</span></div>
            <div class="card-body">
                <dl style="font-size:.875rem;">
                    <dt class="text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">No. PO</dt>
                    <dd><code>{{ $po->No_PO }}</code></dd>

                    <dt class="text-muted mt-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Customer</dt>
                    <dd>
                        <div style="font-weight:500;">{{ $po->customer->Nama ?? '-' }}</div>
                        <div style="color:var(--text-muted);font-size:.8rem;">{{ $po->customer->PIC ?? '' }}</div>
                    </dd>

                    <dt class="text-muted mt-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Tanggal PO</dt>
                    <dd>{{ \Carbon\Carbon::parse($po->PO_Date)->format('d F Y') }}</dd>

                    <dt class="text-muted mt-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Delivery Date</dt>
                    <dd>{{ $po->Delivery_date ? \Carbon\Carbon::parse($po->Delivery_date)->format('d F Y') : '—' }}</dd>

                    @if($po->Note)
                    <dt class="text-muted mt-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Catatan</dt>
                    <dd style="font-size:.85rem;">{{ $po->Note }}</dd>
                    @endif

                    <dt class="text-muted mt-2" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Status</dt>
                    <dd>
                        @if($po->suratJalan)
                            <span class="badge-pill" style="background:#ecfdf5;color:#059669;"><i class="bi bi-check-circle me-1"></i>Selesai</span>
                        @elseif($po->invoices->count() > 0)
                            <span class="badge-pill" style="background:#fef3c7;color:#d97706;"><i class="bi bi-receipt me-1"></i>Diinvoice</span>
                        @else
                            <span class="badge-pill" style="background:#f3f4f6;color:#6b7280;"><i class="bi bi-clock me-1"></i>Baru</span>
                        @endif
                    </dd>
                </dl>
            </div>
        </div>

        {{-- Totals --}}
        <div class="card">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;">
                    <span class="text-muted">Sub Total</span>
                    <span>Rp {{ number_format($po->Sub_Total, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2" style="font-size:.85rem;">
                    <span class="text-muted">PPN ({{ $po->PPN }}%)</span>
                    <span>Rp {{ number_format($po->Grand_Total - $po->Sub_Total, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between pt-2" style="border-top:1px solid var(--border);font-size:1rem;font-weight:600;">
                    <span>Grand Total</span>
                    <span style="color:var(--accent);">Rp {{ number_format($po->Grand_Total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Kolom Kanan: Detail & Transaksi ─────────────────── --}}
    <div class="col-md-8">

        {{-- Detail Barang ─────────────────────────────────── --}}
        <div class="card mb-3">
            <div class="card-header">
                <span><i class="bi bi-list-ul me-2"></i>Detail Barang</span>
                @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
                @if(!$po->invoices->count())
                <button class="btn btn-sm btn-accent" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Barang
                </button>
                @endif
                @endif
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Amount</th>
                            <th>Metode Pengerjaan</th>
                            @if(!$po->invoices->count())
                            <th style="width:90px;"></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody id="tblDetailBody">
                        @forelse($po->details as $d)
                        <tr id="row-{{ $d->id }}">
                            <td style="font-size:.875rem;">
                                <div style="font-weight:500;">{{ $d->barang->Nama_Barang ?? $d->No_Barang }}</div>
                                <code style="font-size:.7rem;color:var(--text-muted);">{{ $d->No_Barang }}</code>
                            </td>
                            <td class="text-center">{{ $d->Qty }}</td>
                            <td class="text-end">Rp {{ number_format($d->Unit_Price, 0, ',', '.') }}</td>
                            <td class="text-end" style="font-weight:500;">Rp {{ number_format($d->Amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge-pill" style="background:#f3f4f6;color:#374151;font-size:.7rem;">
                                    {{ $d->Metode }}
                                </span>
                            </td>
                            @if(!$po->invoices->count())
                            <td>
                                {{-- Tombol Edit --}}
                                <button class="btn btn-sm btn-outline-secondary me-1 btn-edit-detail"
                                        data-id="{{ $d->id }}"
                                        data-barang="{{ $d->No_Barang }}"
                                        data-nama="{{ $d->barang->Nama_Barang ?? $d->No_Barang }}"
                                        data-qty="{{ $d->Qty }}"
                                        data-price="{{ $d->Unit_Price }}"
                                        data-metode="{{ $d->Metode }}"
                                        title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                {{-- Tombol Hapus --}}
                                <form action="{{ route('purchase-order.detail.destroy', [$po->No_PO, $d->id]) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus barang ini dari PO?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr id="rowEmpty">
                            <td colspan="{{ $po->invoices->count() ? 5 : 6 }}"
                                class="text-center text-muted py-4" style="font-size:.85rem;">
                                <i class="bi bi-inbox" style="font-size:1.5rem;display:block;margin-bottom:.4rem;"></i>
                                Belum ada barang. Klik <strong>Tambah Barang</strong> untuk mulai.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Invoice terkait --}}
        <div class="card mb-3">
            <div class="card-header">
                <span><i class="bi bi-receipt me-2"></i>Invoice</span>
                @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
                @if(!$po->invoices->count())
                <a href="{{ route('invoice.create') }}" class="btn btn-sm btn-accent">
                    <i class="bi bi-plus-lg me-1"></i> Buat Invoice
                </a>
                @endif
                @endif
            </div>
            <div class="card-body p-0">
                @if($po->invoices->isEmpty())
                <p class="text-center text-muted py-3 mb-0" style="font-size:.85rem;">Belum ada invoice untuk PO ini.</p>
                @else
                <table class="table mb-0">
                    <thead><tr><th>No. Invoice</th><th>Tanggal</th><th>CEO</th><th>Rekening</th></tr></thead>
                    <tbody>
                        @foreach($po->invoices as $inv)
                        <tr>
                            <td>
                                <a href="{{ route('invoice.show', $inv->No_Invoice) }}"
                                   style="font-size:.8rem;color:var(--accent);text-decoration:none;">
                                    {{ $inv->No_Invoice }}
                                </a>
                            </td>
                            <td style="font-size:.85rem;">{{ \Carbon\Carbon::parse($inv->tanggal_terbit)->format('d M Y') }}</td>
                            <td style="font-size:.85rem;">{{ $inv->ceo->Nama_Pegawai ?? '—' }}</td>
                            <td style="font-size:.85rem;">{{ $inv->rekening->Bank ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>

        {{-- Surat Jalan --}}
        <div class="card">
            <div class="card-header">
                <span><i class="bi bi-truck me-2"></i>Surat Jalan</span>
                @if($po->invoices->count() && !$po->suratJalan)
                <a href="{{ route('surat-jalan.create') }}" class="btn btn-sm btn-accent">
                    <i class="bi bi-plus-lg me-1"></i> Buat SJ
                </a>
                @endif
            </div>
            <div class="card-body p-0">
                @if(!$po->suratJalan)
                <p class="text-center text-muted py-3 mb-0" style="font-size:.85rem;">Belum ada surat jalan.</p>
                @else
                @php $sj = $po->suratJalan @endphp
                <table class="table mb-0">
                    <thead><tr><th>No. SJ</th><th>Tanggal</th><th>Supir</th><th>Keterangan</th></tr></thead>
                    <tbody>
                        <tr>
                            <td>
                                <a href="{{ route('surat-jalan.show', $sj->No_SJ) }}"
                                   style="font-size:.8rem;color:var(--accent);text-decoration:none;">
                                    {{ $sj->No_SJ }}
                                </a>
                            </td>
                            <td style="font-size:.85rem;">{{ \Carbon\Carbon::parse($sj->Tanggal)->format('d M Y') }}</td>
                            <td style="font-size:.85rem;">{{ $sj->supir->Nama_Pegawai ?? '—' }}</td>
                            <td style="font-size:.85rem;">{{ $sj->Keterangan ?? '—' }}</td>
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>{{-- /col-md-8 --}}
</div>

{{-- ══════════════════════════════════════════════════════════
     MODAL: Tambah Barang
═══════════════════════════════════════════════════════════ --}}
@if(!$po->invoices->count())
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;border:1px solid var(--border);">
            <div class="modal-header" style="border-bottom:1px solid var(--border);">
                <h6 class="modal-title" id="modalTambahLabel" style="font-weight:600;">
                    <i class="bi bi-plus-circle me-2" style="color:var(--accent);"></i>
                    Tambah Barang ke PO
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('purchase-order.detail.store', $po->No_PO) }}" method="POST" id="formTambah">
                @csrf
                <div class="modal-body p-4">

                    {{-- Pilih Barang --}}
                    <div class="mb-3">
                        <label class="form-label">Barang <span class="text-danger">*</span></label>
                        <select name="No_Barang" id="selBarangTambah" class="form-select" required>
                            <option value="">— Pilih Barang —</option>
                            @foreach($barangs as $b)
                            <option value="{{ $b->Kode_Barang }}"
                                    data-price="{{ $b->Unit_Price }}"
                                    data-unit="{{ $b->Unit_Means ?? 'pcs' }}">
                                {{ $b->Nama_Barang }}
                                <span style="color:var(--text-muted);">({{ $b->Kode_Barang }})</span>
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-3 mb-3">
                        {{-- Qty --}}
                        <div class="col-5">
                            <label class="form-label">Qty <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="Qty" id="inpQtyTambah"
                                       class="form-control" value="1" min="1" required>
                                <span class="input-group-text" id="lblUnitTambah"
                                      style="font-size:.8rem;border-color:var(--border);">pcs</span>
                            </div>
                        </div>
                        {{-- Unit Price (readonly, dari master) --}}
                        <div class="col-7">
                            <label class="form-label">Unit Price</label>
                            <div class="input-group">
                                <span class="input-group-text" style="font-size:.8rem;border-color:var(--border);">Rp</span>
                                <input type="text" id="inpPriceTambah" class="form-control"
                                       placeholder="—" readonly
                                       style="background:var(--surface);color:var(--text-muted);">
                            </div>
                        </div>
                    </div>

                    {{-- Metode --}}
                    <div class="mb-3">
                        <label class="form-label">Metode Pengerjaan <span class="text-danger">*</span></label>
                        <input type="text" name="Metode" id="inpMetodeTambah"
                               class="form-control" placeholder="Contoh: Borongan, Harian, Lembur, dll."
                               required>
                    </div>

                    {{-- Preview Amount --}}
                    <div class="p-3 rounded" style="background:var(--surface);border:1px solid var(--border);">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted" style="font-size:.85rem;">Subtotal Baris</span>
                            <span id="lblAmountTambah" style="font-weight:700;color:var(--accent);">Rp —</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid var(--border);">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-accent">
                        <i class="bi bi-plus-lg me-1"></i> Tambahkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════
     MODAL: Edit Detail
═══════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;border:1px solid var(--border);">
            <div class="modal-header" style="border-bottom:1px solid var(--border);">
                <h6 class="modal-title" id="modalEditLabel" style="font-weight:600;">
                    <i class="bi bi-pencil me-2" style="color:var(--accent);"></i>
                    Edit Detail Barang
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEdit" method="POST">
                @csrf @method('PUT')
                <div class="modal-body p-4">

                    {{-- Nama barang (readonly) --}}
                    <div class="mb-3">
                        <label class="form-label">Barang</label>
                        <input type="text" id="editNamaBarang" class="form-control"
                               readonly style="background:var(--surface);">
                        <input type="hidden" name="No_Barang" id="editNoBarang">
                        <input type="hidden" name="No_PO"     value="{{ $po->No_PO }}">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-5">
                            <label class="form-label">Qty <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="Qty" id="editQty"
                                       class="form-control" min="1" required>
                                <span class="input-group-text" id="editUnit"
                                      style="font-size:.8rem;border-color:var(--border);">pcs</span>
                            </div>
                        </div>
                        <div class="col-7">
                            <label class="form-label">Unit Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text" style="font-size:.8rem;border-color:var(--border);">Rp</span>
                                <input type="number" name="Unit_Price" id="editPrice"
                                       class="form-control" min="0" step="0.01" required>
                            </div>
                        </div>
                    </div>

                    {{-- Metode --}}
                    <div class="mb-3">
                        <label class="form-label">Metode Pengerjaan <span class="text-danger">*</span></label>
                        <input type="text" name="Metode" id="editMetode"
                               class="form-control" placeholder="Contoh: Borongan, Harian, Lembur, dll."
                               required>
                    </div>

                    {{-- Preview Amount --}}
                    <div class="p-3 rounded" style="background:var(--surface);border:1px solid var(--border);">
                        <div class="d-flex justify-content-between">
                            <span class="text-muted" style="font-size:.85rem;">Subtotal Baris</span>
                            <span id="lblAmountEdit" style="font-weight:700;color:var(--accent);">Rp —</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid var(--border);">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-accent">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
const barangs    = @json($barangs ?? collect());
const barangMap  = {};
barangs.forEach(b => barangMap[b.Kode_Barang] = b);

/* ── Helper ── */
function fmt(n) { return Math.round(n).toLocaleString('id-ID'); }

/* ── Modal Tambah ── */
const selBarangTambah = document.getElementById('selBarangTambah');
const inpQtyTambah    = document.getElementById('inpQtyTambah');

if (selBarangTambah) {
    selBarangTambah.addEventListener('change', function () {
        const b = barangMap[this.value];
        if (!b) return;
        document.getElementById('inpPriceTambah').value = fmt(b.Unit_Price);
        document.getElementById('lblUnitTambah').textContent = b.Unit_Means || 'pcs';
        hitungTambah();
    });

    inpQtyTambah.addEventListener('input', hitungTambah);

    function hitungTambah() {
        const b   = barangMap[selBarangTambah.value];
        const qty = parseInt(inpQtyTambah.value) || 0;
        if (!b) return;
        document.getElementById('lblAmountTambah').textContent = 'Rp ' + fmt(b.Unit_Price * qty);
    }

    const radios = document.querySelectorAll('#formTambah .metode-radio');
    const labels = document.querySelectorAll('#formTambah .metode-lbl');

    // Reset modal saat dibuka
    document.getElementById('modalTambah').addEventListener('show.bs.modal', () => {
        document.getElementById('formTambah').reset();
        document.getElementById('inpPriceTambah').value   = '';
        document.getElementById('lblUnitTambah').textContent = 'pcs';
        document.getElementById('lblAmountTambah').textContent = 'Rp —';
        document.getElementById('inpMetodeTambah').value = '';
    });
}

/* ── Modal Edit ── */
if (document.getElementById('editQty')) {
    document.getElementById('editQty').addEventListener('input', hitungEdit);
    document.getElementById('editPrice').addEventListener('input', hitungEdit);

    function hitungEdit() {
        const qty   = parseFloat(document.getElementById('editQty').value) || 0;
        const price = parseFloat(document.getElementById('editPrice').value) || 0;
        document.getElementById('lblAmountEdit').textContent = 'Rp ' + fmt(qty * price);
    }
}

document.querySelectorAll('.btn-edit-detail').forEach(btn => {
    btn.addEventListener('click', function () {
        const id     = this.dataset.id;
        const barang = this.dataset.barang;
        const nama   = this.dataset.nama;
        const qty    = this.dataset.qty;
        const price  = this.dataset.price;
        const metode = this.dataset.metode;

        // Set action form ke detail-invoice/{id} (PUT)
        document.getElementById('formEdit').action = '/detail-invoice/' + id;

        document.getElementById('editNamaBarang').value = nama;
        document.getElementById('editNoBarang').value   = barang;
        document.getElementById('editQty').value        = qty;
        document.getElementById('editPrice').value      = price;

        document.getElementById('editMetode').value = metode;

        // Hitung amount
        document.getElementById('lblAmountEdit').textContent =
            'Rp ' + fmt(parseFloat(qty) * parseFloat(price));

        new bootstrap.Modal(document.getElementById('modalEdit')).show();
    });
});
</script>
@endpush