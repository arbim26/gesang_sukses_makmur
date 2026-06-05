@extends('layouts.app')
@section('title', 'Purchase Order')
@section('page-title', 'Manajemen Purchase Order')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0" style="font-size:.85rem;">
        Total <strong>{{ $purchaseOrders->total() }}</strong> purchase order
    </p>
    <a href="{{ route('purchase-order.create') }}" class="btn btn-accent">
        <i class="bi bi-plus-lg me-1"></i> Buat PO
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>No. PO</th>
                    <th>Tanggal PO</th>
                    <th>Customer</th>
                    <th>Delivery Date</th>
                    <th class="text-end">Grand Total</th>
                    <th>Status</th>
                    <th style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchaseOrders as $po)
                <tr>
                    <td><code style="font-size:.8rem;">{{ $po->No_PO }}</code></td>
                    <td style="font-size:.85rem;">{{ \Carbon\Carbon::parse($po->PO_Date)->format('d M Y') }}</td>
                    <td>
                        <div style="font-weight:500;font-size:.875rem;">{{ $po->customer->Nama ?? '-' }}</div>
                        <div style="font-size:.75rem;color:var(--text-muted);">{{ $po->customer->PIC ?? '' }}</div>
                    </td>
                    <td style="font-size:.85rem;">
                        {{ $po->Delivery_date ? \Carbon\Carbon::parse($po->Delivery_date)->format('d M Y') : '—' }}
                    </td>
                    <td class="text-end" style="font-weight:500;">
                        Rp {{ number_format($po->Grand_Total, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($po->suratJalan)
                            <span class="badge-pill" style="background:#ecfdf5;color:#059669;">Selesai</span>
                        @elseif($po->invoices->count() > 0)
                            <span class="badge-pill" style="background:#fef3c7;color:#d97706;">Diinvoice</span>
                        @else
                            <span class="badge-pill" style="background:#f3f4f6;color:#6b7280;">Baru</span>
                        @endif
                    </td>
                    <td>
                        {{-- Tombol Detail --}}
                        <a href="{{ route('purchase-order.show', $po->No_PO) }}"
                           class="btn btn-sm btn-outline-primary me-1 mb-1"
                           title="Lihat Detail">
                            <i class="bi bi-eye"></i>
                        </a>

                        {{-- Tombol Preview (Menggunakan Custom Trigger) --}}
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
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-inbox" style="font-size:1.5rem;"></i>
                        <p class="mt-1 mb-0">Belum ada purchase order.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
    <div class="text-muted small">
        Menampilkan {{ $purchaseOrders->firstItem() ?? 0 }} - {{ $purchaseOrders->lastItem() ?? 0 }} dari total {{ $purchaseOrders->total() }} barang
    </div>
    <div>
        @if ($purchaseOrders->hasPages())
            {{ $purchaseOrders->onEachSide(1)->links('pagination::bootstrap-5') }}
        @else
            <nav aria-label="Page navigation">
                <ul class="pagination mb-0">
                    <li class="page-item disabled"><span class="page-link">Previous</span></li>
                    <li class="page-item active"><span class="page-link">1</span></li>
                    <li class="page-item disabled"><span class="page-link">Next</span></li>
                </ul>
            </nav>
        @endif
    </div>
</div>


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
.custom-modal-title {
    margin: 0; font-size: 1.15rem; font-weight: 600;
}
.custom-modal-close-btn {
    background: none; border: none; font-size: 1.6rem; line-height: 1; color: #aaa; cursor: pointer;
}
.custom-modal-close-btn:hover { color: #333; }
.custom-modal-body {
    position: relative;
    padding: 0;
    overflow: auto;
    background: #f8f9fa;
    height: 550px; /* Tinggi box kontainer internal */
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
#previewImageWrap {
    padding: 1.5rem; text-align: center; height: 100%; overflow: auto;
}
#previewImage {
    max-height: 480px; max-width: 100%; object-fit: contain; border-radius: 4px;
    transition: transform 0.15s ease-in-out;
}
.custom-unsupported-wrap {
    height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2rem;
}
@keyframes customModalFadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
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
    currentZoom += amount;
    if (currentZoom < 0.4) currentZoom = 0.4;
    if (currentZoom > 2.5) currentZoom = 2.5;
    const img = document.getElementById('previewImage');
    if (img) {
        img.style.transform = `scale(${currentZoom})`;
    }
}

// Buka Modal Secara Manual
function openCustomPreview(fileUrl, fileName) {
    const modal = document.getElementById('customPreviewModal');
    if (!modal) return;

    // Tampilkan overlay dasar modal
    modal.style.display = 'flex';
    
    // Reset View State
    document.getElementById('previewSpinner').style.display = 'flex';
    document.getElementById('previewPdfWrap').style.display = 'none';
    document.getElementById('previewImageWrap').style.display = 'none';
    document.getElementById('previewUnsupported').style.display = 'none';
    
    const zoomControls = document.getElementById('zoomControls');
    if (zoomControls) zoomControls.classList.add('d-none');

    document.getElementById('previewFileName').innerText = fileName;
    document.getElementById('previewDownloadBtn').href = fileUrl;
    document.getElementById('previewUnsupportedDownload').href = fileUrl;
    
    resetZoom();

    const extension = fileName.split('.').pop().toLowerCase();

    // Jalur 1: File PDF
    if (extension === 'pdf') {
        const iframe = document.getElementById('previewPdfFrame');
        if (iframe) {
            iframe.src = fileUrl;
            iframe.onload = function() {
                document.getElementById('previewSpinner').style.display = 'none';
                document.getElementById('previewPdfWrap').style.display = 'block';
            };
        }
    } 
    // Jalur 2: Gambar-gambar
    else if (['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'].includes(extension)) {
        const img = document.getElementById('previewImage');
        if (img) {
            img.onload = function() {
                document.getElementById('previewSpinner').style.display = 'none';
                document.getElementById('previewImageWrap').style.display = 'block';
                if (zoomControls) zoomControls.classList.remove('d-none');
            };
            img.src = fileUrl;
            // Backup jika gambar sudah ter-cache browser
            if (img.complete) img.onload();
        }
    } 
    // Jalur 3: Ekstensi Excel / Lainnya (Langsung lempar download)
    else {
        document.getElementById('previewSpinner').style.display = 'none';
        document.getElementById('previewUnsupported').style.display = 'flex';
    }
}

// Tutup Modal Secara Manual
function closeCustomPreview() {
    const modal = document.getElementById('customPreviewModal');
    if (modal) {
        modal.style.display = 'none';
    }
    // Hentikan dokumen src agar tidak bocor memory / suara di background
    document.getElementById('previewPdfFrame').src = '';
    document.getElementById('previewImage').src = '';
}

// Menutup modal jika user mengklik area abu-abu di luar kotak modal
window.onclick = function(event) {
    const modal = document.getElementById('customPreviewModal');
    if (event.target === modal) {
        closeCustomPreview();
    }
}
</script>
@endpush