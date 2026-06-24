@extends('layouts.app')
@section('title', 'Purchase Order')
@section('page-title', 'Manajemen Purchase Order')

@php
    $jabatanAktif = auth('pegawai')->user()->Jabatan;
@endphp

@section('content')

{{-- ════════════════════════════════════════════════
     FILTER & SORT BAR
     ════════════════════════════════════════════════ --}}
<form method="GET" action="{{ route('purchase-order.index') }}" id="filterForm">
    <input type="hidden" name="sort" value="{{ request('sort', 'PO_Date') }}">
    <input type="hidden" name="dir"  value="{{ request('dir', 'desc') }}">

    <div class="card mb-3">
        <div class="card-body p-3">
            <div class="row g-2 align-items-end">

                {{-- Search --}}
                <div class="col-md-3">
                    <label class="form-label text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">
                        Cari No. PO / Customer
                    </label>
                    <div class="input-group">
                        <span class="input-group-text" style="background:var(--bg-card);border-color:var(--border);">
                            <i class="bi bi-search" style="font-size:.75rem;color:var(--text-muted);"></i>
                        </span>
                        <input type="text" name="search" class="form-control form-control-sm"
                               placeholder="No PO, Nama Customer…"
                               value="{{ request('search') }}"
                               style="border-color:var(--border);">
                    </div>
                </div>

                {{-- Filter: Status --}}
                <div class="col-md-2">
                    <label class="form-label text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">
                        Status
                    </label>
                    <select name="status" class="form-select form-select-sm" style="border-color:var(--border);">
                        <option value="">Semua</option>
                        <option value="baru"      {{ request('status') === 'baru'      ? 'selected' : '' }}>Baru</option>
                        <option value="diinvoice" {{ request('status') === 'diinvoice' ? 'selected' : '' }}>Diinvoice</option>
                        <option value="selesai"   {{ request('status') === 'selesai'   ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                {{-- Filter: Dari Tanggal PO --}}
                <div class="col-md-2">
                    <label class="form-label text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">
                        PO Dari
                    </label>
                    <input type="date" name="dari" class="form-control form-control-sm"
                           value="{{ request('dari') }}"
                           style="border-color:var(--border);">
                </div>

                {{-- Filter: Sampai Tanggal PO --}}
                <div class="col-md-2">
                    <label class="form-label text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">
                        PO Sampai
                    </label>
                    <input type="date" name="sampai" class="form-control form-control-sm"
                           value="{{ request('sampai') }}"
                           style="border-color:var(--border);">
                </div>

                {{-- Filter: Dari Delivery Date --}}
                <div class="col-md-2">
                    <label class="form-label text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">
                        Delivery Dari
                    </label>
                    <input type="date" name="delivery_dari" class="form-control form-control-sm"
                           value="{{ request('delivery_dari') }}"
                           style="border-color:var(--border);">
                </div>

                {{-- Filter: Sampai Delivery Date --}}
                <div class="col-md-2">
                    <label class="form-label text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">
                        Delivery Sampai
                    </label>
                    <input type="date" name="delivery_sampai" class="form-control form-control-sm"
                           value="{{ request('delivery_sampai') }}"
                           style="border-color:var(--border);">
                </div>

                {{-- Tombol aksi --}}
                <div class="col-md-1 d-flex gap-1">
                    <button type="submit" class="btn btn-sm btn-accent w-100" title="Terapkan Filter">
                        <i class="bi bi-funnel-fill"></i>
                    </button>
                    <a href="{{ route('purchase-order.index') }}" class="btn btn-sm w-100"
                       style="border:1px solid var(--border);color:var(--text-muted);" title="Reset Filter">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>

            </div>

            {{-- Active filter badges --}}
            @php
                $labelMap = [
                    'search'          => 'Cari',
                    'status'          => 'Status',
                    'dari'            => 'PO Dari',
                    'sampai'          => 'PO Sampai',
                    'delivery_dari'   => 'Delivery Dari',
                    'delivery_sampai' => 'Delivery Sampai',
                ];
                $activeFilters = array_filter(array_intersect_key(request()->all(), $labelMap));
            @endphp
            @if(count($activeFilters))
            <div class="mt-2 d-flex flex-wrap gap-1 align-items-center">
                <span style="font-size:.7rem;color:var(--text-muted);">Filter aktif:</span>
                @foreach($activeFilters as $key => $val)
                <span class="badge-pill d-flex align-items-center gap-1"
                      style="background:var(--accent-light,#eff6ff);color:var(--accent);font-size:.7rem;padding:.25rem .5rem;border-radius:999px;">
                    {{ $labelMap[$key] }}: {{ $val }}
                    <a href="{{ request()->fullUrlWithQuery([$key => null]) }}"
                       style="color:var(--accent);text-decoration:none;line-height:1;">&times;</a>
                </span>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</form>

{{-- ════════════════════════════════════════════════
     HEADER & TABEL
     ════════════════════════════════════════════════ --}}

@php
    function sortUrlPO(string $col): string {
        $current = request('sort', 'PO_Date');
        $dir     = request('dir', 'desc');
        $newDir  = ($current === $col && $dir === 'desc') ? 'asc' : 'desc';
        return request()->fullUrlWithQuery(['sort' => $col, 'dir' => $newDir, 'page' => 1]);
    }

    function sortIconPO(string $col): string {
        $current = request('sort', 'PO_Date');
        $dir     = request('dir', 'desc');
        if ($current !== $col)
            return '<i class="bi bi-arrow-down-up" style="font-size:.65rem;opacity:.3;"></i>';
        return $dir === 'asc'
            ? '<i class="bi bi-sort-up"   style="font-size:.75rem;color:var(--accent);"></i>'
            : '<i class="bi bi-sort-down" style="font-size:.75rem;color:var(--accent);"></i>';
    }
@endphp

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>
            Daftar Purchase Order
            <span style="font-size:.75rem;color:var(--text-muted);margin-left:.4rem;">
                ({{ $purchaseOrders->total() }} data)
            </span>
        </span>
        @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
        <a href="{{ route('purchase-order.create') }}" class="btn btn-sm btn-accent">
            <i class="bi bi-plus-lg me-1"></i> Buat PO
        </a>
        @endif
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0" style="font-size:.85rem;">
                <thead style="background:var(--bg-subtle,#f9fafb);">
                    <tr>
                        <th>
                            <a href="{{ sortUrlPO('No_PO') }}" class="d-flex align-items-center gap-1"
                               style="color:inherit;text-decoration:none;">
                                No. PO {!! sortIconPO('No_PO') !!}
                            </a>
                        </th>
                        <th>
                            <a href="{{ sortUrlPO('PO_Date') }}" class="d-flex align-items-center gap-1"
                               style="color:inherit;text-decoration:none;">
                                Tanggal PO {!! sortIconPO('PO_Date') !!}
                            </a>
                        </th>
                        <th>Customer</th>
                        <th>
                            <a href="{{ sortUrlPO('Delivery_date') }}" class="d-flex align-items-center gap-1"
                               style="color:inherit;text-decoration:none;">
                                Delivery Date {!! sortIconPO('Delivery_date') !!}
                            </a>
                        </th>
                        <th class="text-end">
                            <a href="{{ sortUrlPO('Grand_Total') }}" class="d-flex align-items-center justify-content-end gap-1"
                               style="color:inherit;text-decoration:none;">
                                Grand Total {!! sortIconPO('Grand_Total') !!}
                            </a>
                        </th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width:160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchaseOrders as $po)
                    <tr>
                        <td><code style="font-size:.8rem;">{{ $po->No_PO }}</code></td>
                        <td style="color:var(--text-muted);">{{ \Carbon\Carbon::parse($po->PO_Date)->format('d M Y') }}</td>
                        <td>
                            <div style="font-weight:500;font-size:.875rem;">{{ $po->customer->Nama ?? '-' }}</div>
                            <div style="font-size:.75rem;color:var(--text-muted);">{{ $po->customer->PIC ?? '' }}</div>
                        </td>
                        <td style="color:var(--text-muted);">
                            {{ $po->Delivery_date ? \Carbon\Carbon::parse($po->Delivery_date)->format('d M Y') : '—' }}
                        </td>
                        <td class="text-end" style="font-weight:700;color:var(--accent);">
                            Rp {{ number_format($po->Grand_Total, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            @if($po->suratJalan)
                                <span class="badge-pill" style="background:#ecfdf5;color:#059669;font-size:.7rem;padding:.2rem .5rem;border-radius:999px;">
                                    <i class="bi bi-check-lg me-1"></i>Selesai
                                </span>
                            @elseif($po->invoices->count() > 0)
                                <span class="badge-pill" style="background:#fef3c7;color:#d97706;font-size:.7rem;padding:.2rem .5rem;border-radius:999px;">
                                    <i class="bi bi-receipt me-1"></i>Diinvoice
                                </span>
                            @else
                                <span class="badge-pill" style="background:#f3f4f6;color:#6b7280;font-size:.7rem;padding:.2rem .5rem;border-radius:999px;">
                                    <i class="bi bi-clock me-1"></i>Baru
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('purchase-order.show', $po->No_PO) }}"
                               class="btn btn-sm btn-outline-primary me-1 mb-1"
                               title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>

                            @if($po->attachment)
                                @php
                                    $ext = strtolower(pathinfo($po->attachment, PATHINFO_EXTENSION));
                                    $fileUrl = asset('storage/' . $po->attachment);
                                    $safeNoPo = str_replace(['/', '\\'], '-', $po->No_PO ?? 'Dokumen');
                                    $fileName = $safeNoPo . '.' . $ext;
                                @endphp
                                <button type="button"
                                        class="btn btn-sm btn-outline-secondary me-1 mb-1"
                                        title="Preview Dokumen"
                                        onclick="openCustomPreview('{{ $fileUrl }}', '{{ $fileName }}')">
                                    <i class="bi bi-file-earmark-text"></i>
                                </button>
                            @endif

                            @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
                                @if(!$po->invoices->count())
                                <a href="{{ route('purchase-order.edit', $po->No_PO) }}"
                                   class="btn btn-sm btn-outline-secondary me-1 mb-1"
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('purchase-order.destroy', $po->No_PO) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus PO ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger mb-1" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4" style="color:var(--text-muted);">
                            <i class="bi bi-inbox" style="font-size:1.5rem;display:block;margin-bottom:.4rem;opacity:.4;"></i>
                            Tidak ada purchase order yang sesuai filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($purchaseOrders->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center"
         style="font-size:.8rem;color:var(--text-muted);">
        <span>
            Menampilkan {{ $purchaseOrders->firstItem() }}–{{ $purchaseOrders->lastItem() }}
            dari {{ $purchaseOrders->total() }} purchase order
        </span>
        {{ $purchaseOrders->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

{{-- Auto-submit dropdown filter --}}
<script>
document.querySelectorAll('#filterForm select').forEach(el => {
    el.addEventListener('change', () => document.getElementById('filterForm').submit());
});
</script>


{{-- ════════════════════════════════════════════════
     MODAL PREVIEW DOKUMEN
     ════════════════════════════════════════════════ --}}
<div id="customPreviewModal" class="custom-modal-overlay" style="display: none;">
    <div class="custom-modal-dialog">
        <div class="custom-modal-content">

            <div class="custom-modal-header">
                <h5 class="custom-modal-title">
                    <i class="bi bi-file-earmark-text me-2 text-primary"></i>Preview: <span id="previewFileName" class="fw-normal text-muted"></span>
                </h5>
                <button type="button" class="custom-modal-close-btn" onclick="closeCustomPreview()">&times;</button>
            </div>

            <div class="custom-modal-body">
                <div id="previewSpinner" class="custom-spinner-wrap">
                    <div class="spinner-border text-primary" role="status"></div>
                    <span class="mt-2 text-muted small">Memuat dokumen...</span>
                </div>
                <div id="previewPdfWrap" style="display: none; height: 100%;">
                    <iframe id="previewPdfFrame" src="" width="100%" height="100%" style="border: none;"></iframe>
                </div>
                <div id="previewImageWrap" style="display: none;">
                    <img id="previewImage" src="" alt="Preview">
                </div>
                <div id="previewUnsupported" class="custom-unsupported-wrap" style="display: none;">
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    <p class="mt-3 mb-2 fw-bold">Preview tidak tersedia untuk format file ini.</p>
                    <p class="text-muted small mb-3">Silakan unduh file secara langsung untuk melihat isinya.</p>
                    <a id="previewUnsupportedDownload" href="#" class="btn btn-primary btn-sm">
                        <i class="bi bi-download me-1"></i> Unduh Dokumen
                    </a>
                </div>
            </div>

            <div class="custom-modal-footer">
                <div id="zoomControls" class="d-none gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="zoomImage(0.15)"><i class="bi bi-zoom-in"></i></button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="zoomImage(-0.15)"><i class="bi bi-zoom-out"></i></button>
                </div>
                <div>
                    <button type="button" class="btn btn-secondary btn-sm me-2" onclick="closeCustomPreview()">Tutup</button>
                    <a id="previewDownloadBtn" href="#" class="btn btn-primary btn-sm">
                        <i class="bi bi-download me-1"></i> Unduh
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
.custom-modal-overlay {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background-color: rgba(0, 0, 0, 0.55);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}
.custom-modal-dialog {
    width: 100%;
    max-width: 850px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    animation: customModalFadeIn 0.25s ease-out;
}
.custom-modal-content {
    display: flex;
    flex-direction: column;
    max-height: 85vh;
}
.custom-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
}
.custom-modal-title { margin: 0; font-size: 1.15rem; font-weight: 600; }
.custom-modal-close-btn {
    background: none; border: none; font-size: 1.6rem; line-height: 1; color: #aaa; cursor: pointer;
}
.custom-modal-close-btn:hover { color: #333; }
.custom-modal-body {
    position: relative;
    padding: 0;
    overflow: auto;
    background: #f8f9fa;
    height: 550px;
}
.custom-modal-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 1rem;
    border-top: 1px solid #dee2e6;
    background: #fff;
}
.custom-spinner-wrap {
    position: absolute; top:0; left:0; width:100%; height:100%;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    background: #f8f9fa; z-index: 5;
}
#previewImageWrap { padding: 1.5rem; text-align: center; height: 100%; overflow: auto; }
#previewImage {
    max-height: 480px; max-width: 100%; object-fit: contain; border-radius: 4px;
    transition: transform 0.15s ease-in-out;
}
.custom-unsupported-wrap {
    height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2rem;
}
@keyframes customModalFadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

@endsection

@push('scripts')
<script>
let currentZoom = 1;

function resetZoom() {
    currentZoom = 1;
    const img = document.getElementById('previewImage');
    if (img) img.style.transform = 'scale(1)';
}

function zoomImage(amount) {
    currentZoom = Math.min(2.5, Math.max(0.4, currentZoom + amount));
    const img = document.getElementById('previewImage');
    if (img) img.style.transform = `scale(${currentZoom})`;
}

function openCustomPreview(fileUrl, fileName) {
    const modal = document.getElementById('customPreviewModal');
    if (!modal) return;
    modal.style.display = 'flex';

    document.getElementById('previewSpinner').style.display    = 'flex';
    document.getElementById('previewPdfWrap').style.display    = 'none';
    document.getElementById('previewImageWrap').style.display  = 'none';
    document.getElementById('previewUnsupported').style.display = 'none';

    const zoomControls = document.getElementById('zoomControls');
    if (zoomControls) zoomControls.classList.add('d-none');

    document.getElementById('previewFileName').innerText          = fileName;
    document.getElementById('previewDownloadBtn').href            = fileUrl;
    document.getElementById('previewUnsupportedDownload').href    = fileUrl;
    resetZoom();

    const ext = fileName.split('.').pop().toLowerCase();

    if (ext === 'pdf') {
        const iframe = document.getElementById('previewPdfFrame');
        iframe.src = fileUrl;
        iframe.onload = function () {
            document.getElementById('previewSpinner').style.display = 'none';
            document.getElementById('previewPdfWrap').style.display = 'block';
        };
    } else if (['jpg','jpeg','png','gif','webp','svg'].includes(ext)) {
        const img = document.getElementById('previewImage');
        img.onload = function () {
            document.getElementById('previewSpinner').style.display   = 'none';
            document.getElementById('previewImageWrap').style.display = 'block';
            if (zoomControls) zoomControls.classList.remove('d-none');
        };
        img.src = fileUrl;
        if (img.complete) img.onload();
    } else {
        document.getElementById('previewSpinner').style.display     = 'none';
        document.getElementById('previewUnsupported').style.display = 'flex';
    }
}

function closeCustomPreview() {
    const modal = document.getElementById('customPreviewModal');
    if (modal) modal.style.display = 'none';
    document.getElementById('previewPdfFrame').src = '';
    document.getElementById('previewImage').src    = '';
}

window.onclick = function (event) {
    const modal = document.getElementById('customPreviewModal');
    if (event.target === modal) closeCustomPreview();
};
</script>
@endpush
