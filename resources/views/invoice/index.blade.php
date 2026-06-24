@extends('layouts.app')
@section('title', 'Invoice')
@section('page-title', 'Manajemen Invoice')

@php
    $jabatanAktif = auth('pegawai')->user()->Jabatan;
@endphp


@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted mb-0" style="font-size:.85rem;">
            Total <strong>{{ $invoices->total() }}</strong> invoice
        </p>
        @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
        <a href="{{ route('invoice.create') }}" class="btn btn-accent">
            <i class="bi bi-plus-lg me-1"></i> Buat Invoice
        </a>
        @endif
    </div>


     <form method="GET" action="{{ route('invoice.index') }}" id="filterForm">
        <input type="hidden" name="sort" value="{{ request('sort', 'tanggal_terbit') }}">
        <input type="hidden" name="dir"  value="{{ request('dir', 'desc') }}">
    
        <div class="card mb-3">
            <div class="card-body p-3">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">
                            Cari Invoice / PO / Customer
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" style="background:var(--bg-card);border-color:var(--border);">
                                <i class="bi bi-search" style="font-size:.75rem;color:var(--text-muted);"></i>
                            </span>
                            <input type="text" name="search" class="form-control form-control-sm"
                                   placeholder="No Invoice, PO, Nama Customer…"
                                   value="{{ request('search') }}"
                                   style="border-color:var(--border);">
                        </div>
                    </div>
    
                    {{-- Filter: Surat Jalan --}}
                    <div class="col-md-2">
                        <label class="form-label text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">
                            Surat Jalan
                        </label>
                        <select name="surat_jalan" class="form-select form-select-sm" style="border-color:var(--border);">
                            <option value="">Semua</option>
                            <option value="ada"   {{ request('surat_jalan') === 'ada'   ? 'selected' : '' }}>Sudah Ada</option>
                            <option value="belum" {{ request('surat_jalan') === 'belum' ? 'selected' : '' }}>Belum Ada</option>
                        </select>
                    </div>
    
                    {{-- Filter: Dari Tanggal --}}
                    <div class="col-md-2">
                        <label class="form-label text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">
                            Dari Tanggal
                        </label>
                        <input type="date" name="dari" class="form-control form-control-sm"
                               value="{{ request('dari') }}"
                               style="border-color:var(--border);">
                    </div>
    
                    {{-- Filter: Sampai Tanggal --}}
                    <div class="col-md-2">
                        <label class="form-label text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">
                            Sampai Tanggal
                        </label>
                        <input type="date" name="sampai" class="form-control form-control-sm"
                               value="{{ request('sampai') }}"
                               style="border-color:var(--border);">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">
                            Min Total
                        </label>
                        <input type="number" name="min_total" class="form-control form-control-sm"
                               placeholder="0" value="{{ request('min_total') }}"
                               style="border-color:var(--border);">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">
                            Max Total
                        </label>
                        <input type="number" name="max_total" class="form-control form-control-sm"
                               placeholder="∞" value="{{ request('max_total') }}"
                               style="border-color:var(--border);">
                    </div>
    
                    {{-- Tombol aksi --}}
                    <div class="col-md-1 d-flex gap-1">
                        <button type="submit" class="btn btn-sm btn-accent w-100" title="Terapkan Filter">
                            <i class="bi bi-funnel-fill"></i>
                        </button>
                        <a href="{{ route('invoice.index') }}" class="btn btn-sm w-100"
                           style="border:1px solid var(--border);color:var(--text-muted);" title="Reset Filter">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    </div>
    
                </div>
    
                @php
                    $labelMap = [
                        'search'      => 'Cari',
                        'surat_jalan' => 'SJ',
                        'dari'        => 'Dari',
                        'sampai'      => 'Sampai',
                        'min_total'   => 'Min',
                        'max_total'   => 'Max',
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
    
    @php
        function sortUrl(string $col): string {
            $current = request('sort', 'tanggal_terbit');
            $dir     = request('dir', 'desc');
            $newDir  = ($current === $col && $dir === 'desc') ? 'asc' : 'desc';
            return request()->fullUrlWithQuery(['sort' => $col, 'dir' => $newDir, 'page' => 1]);
        }
    
        function sortIcon(string $col): string {
            $current = request('sort', 'tanggal_terbit');
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
                Daftar Invoice
                <span style="font-size:.75rem;color:var(--text-muted);margin-left:.4rem;">
                    ({{ $invoices->total() }} data · PPN {{ $ppnPersen }}%)
                </span>
            </span>
            @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
            <a href="{{ route('invoice.create') }}" class="btn btn-sm btn-accent">
                <i class="bi bi-plus-lg me-1"></i>Tambah Invoice
            </a>
            @endif
        </div>
    
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0" style="font-size:.85rem;">
                    <thead style="background:var(--bg-subtle,#f9fafb);">
                        <tr>
                            <th>
                                <a href="{{ sortUrl('No_Invoice') }}" class="d-flex align-items-center gap-1"
                                   style="color:inherit;text-decoration:none;">
                                    No. Invoice {!! sortIcon('No_Invoice') !!}
                                </a>
                            </th>
                            <th>
                                <a href="{{ sortUrl('tanggal_terbit') }}" class="d-flex align-items-center gap-1"
                                   style="color:inherit;text-decoration:none;">
                                    Tanggal {!! sortIcon('tanggal_terbit') !!}
                                </a>
                            </th>
                            <th>
                                <a href="{{ sortUrl('No_PO') }}" class="d-flex align-items-center gap-1"
                                   style="color:inherit;text-decoration:none;">
                                    No. PO {!! sortIcon('No_PO') !!}
                                </a>
                            </th>
                            <th>Customer</th>
                            <th class="text-end" style="min-width:140px;">
                                <a href="{{ sortUrl('grand_total') }}" class="d-flex align-items-center justify-content-end gap-1"
                                   style="color:inherit;text-decoration:none;">
                                    Grand Total {!! sortIcon('grand_total') !!}
                                </a>
                            </th>
                            <th class="text-center">Surat Jalan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $inv)
                        <tr>
                            <td>
                                <a href="{{ route('invoice.show', $inv->No_Invoice) }}"
                                   style="color:var(--accent);text-decoration:none;font-weight:500;">
                                    {{ $inv->No_Invoice }}
                                </a>
                            </td>
                            <td style="color:var(--text-muted);">
                                {{ \Carbon\Carbon::parse($inv->tanggal_terbit)->format('d M Y') }}
                            </td>
                            <td>
                                <a href="{{ route('purchase-order.show', $inv->No_PO) }}"
                                   style="color:var(--text-secondary,#6b7280);text-decoration:none;font-size:.8rem;">
                                    {{ $inv->No_PO }}
                                </a>
                            </td>
                            <td>
                                <span style="font-weight:500;">{{ $inv->purchaseOrder?->customer?->Nama ?? '—' }}</span>
                                <br>
                                <span style="font-size:.75rem;color:var(--text-muted);">
                                    {{ $inv->purchaseOrder?->customer?->PIC ?? '' }}
                                </span>
                            </td>
                            <td class="text-end">
                                {{-- Sub-total & diskon sebagai tooltip kecil --}}
                                @if($inv->computed_diskon > 0)
                                <span style="font-size:.7rem;color:var(--text-muted);display:block;">
                                    Sub: Rp {{ number_format($inv->computed_sub_total, 0, ',', '.') }}
                                    · Diskon {{ $inv->computed_diskon }}%
                                </span>
                                @endif
                                <span style="font-weight:700;color:var(--accent);">
                                    Rp {{ number_format($inv->computed_grand_total, 0, ',', '.') }}
                                </span>
                                <span style="font-size:.7rem;color:var(--text-muted);display:block;">
                                    incl. PPN {{ $inv->computed_ppn }}%
                                </span>
                            </td>
                            <td class="text-center">
                                @if($inv->purchaseOrder?->suratJalan)
                                    <span class="badge-pill"
                                          style="background:#d1fae5;color:#065f46;font-size:.7rem;padding:.2rem .5rem;border-radius:999px;">
                                        <i class="bi bi-check-lg me-1"></i>{{ $inv->purchaseOrder->suratJalan->No_SJ }}
                                    </span>
                                @else
                                    <span class="badge-pill"
                                          style="background:#fef3c7;color:#92400e;font-size:.7rem;padding:.2rem .5rem;border-radius:999px;">
                                        <i class="bi bi-clock me-1"></i>Belum Ada
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('invoice.show', $inv->No_Invoice) }}"
                                   class="btn btn-sm" style="border:1px solid var(--border);font-size:.7rem;padding:.2rem .5rem;">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4" style="color:var(--text-muted);">
                                <i class="bi bi-inbox" style="font-size:1.5rem;display:block;margin-bottom:.4rem;opacity:.4;"></i>
                                Tidak ada invoice yang sesuai filter.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    
    </div>
    
    <script>
    document.querySelectorAll('#filterForm select').forEach(el => {
        el.addEventListener('change', () => document.getElementById('filterForm').submit());
    });
    </script>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
        <div class="text-muted small">
            Menampilkan {{ $invoices->firstItem() ?? 0 }} - {{ $invoices->lastItem() ?? 0 }} dari total {{ $invoices->total() }} barang
        </div>
        <div>
            @if ($invoices->hasPages())
                {{ $invoices->onEachSide(1)->links('pagination::bootstrap-5') }}
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
@endsection
