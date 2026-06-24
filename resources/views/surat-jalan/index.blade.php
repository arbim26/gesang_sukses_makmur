@extends('layouts.app')
@section('title', 'Surat Jalan')
@section('page-title', 'Manajemen Surat Jalan')

@php
    $jabatanAktif = auth('pegawai')->user()->Jabatan;
@endphp

@section('content')

{{-- ════════════════════════════════════════════════
     FILTER & SORT BAR
     ════════════════════════════════════════════════ --}}
<form method="GET" action="{{ route('surat-jalan.index') }}" id="filterForm">
    <input type="hidden" name="sort" value="{{ request('sort', 'Tanggal') }}">
    <input type="hidden" name="dir"  value="{{ request('dir', 'desc') }}">

    <div class="card mb-3">
        <div class="card-body p-3">
            <div class="row g-2 align-items-end">

                {{-- Search --}}
                <div class="col-md-4">
                    <label class="form-label text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">
                        Cari No. SJ / No. PO / Customer
                    </label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text" style="background:var(--bg-card);border-color:var(--border);">
                            <i class="bi bi-search" style="font-size:.75rem;color:var(--text-muted);"></i>
                        </span>
                        <input type="text" name="search" class="form-control form-control-sm"
                               placeholder="No SJ, No PO, Nama Customer…"
                               value="{{ request('search') }}"
                               style="border-color:var(--border);">
                    </div>
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

                {{-- Filter: Supir --}}
                <div class="col-md-3">
                    <label class="form-label text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">
                        Supir
                    </label>
                    <select name="supir" class="form-select form-select-sm" style="border-color:var(--border);">
                        <option value="">Semua Supir</option>
                        @foreach($supirs ?? [] as $supir)
                            <option value="{{ $supir->id }}" {{ request('supir') == $supir->id ? 'selected' : '' }}>
                                {{ $supir->Nama_Pegawai }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol aksi --}}
                <div class="col-md-1 d-flex gap-1">
                    <button type="submit" class="btn btn-sm btn-accent w-100" title="Terapkan Filter">
                        <i class="bi bi-funnel-fill"></i>
                    </button>
                    <a href="{{ route('surat-jalan.index') }}" class="btn btn-sm w-100"
                       style="border:1px solid var(--border);color:var(--text-muted);" title="Reset Filter">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>

            </div>

            {{-- Active filter badges --}}
            @php
                $labelMap = [
                    'search' => 'Cari',
                    'dari'   => 'Dari',
                    'sampai' => 'Sampai',
                    'supir'  => 'Supir',
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
     TABEL DENGAN SORTABLE HEADER
     ════════════════════════════════════════════════ --}}

@php
    function sortUrlSJ(string $col): string {
        $current = request('sort', 'Tanggal');
        $dir     = request('dir', 'desc');
        $newDir  = ($current === $col && $dir === 'desc') ? 'asc' : 'desc';
        return request()->fullUrlWithQuery(['sort' => $col, 'dir' => $newDir, 'page' => 1]);
    }

    function sortIconSJ(string $col): string {
        $current = request('sort', 'Tanggal');
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
            Daftar Surat Jalan
            <span style="font-size:.75rem;color:var(--text-muted);margin-left:.4rem;">
                ({{ $suratJalans->total() }} data)
            </span>
        </span>
        @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
        <a href="{{ route('surat-jalan.create') }}" class="btn btn-sm btn-accent">
            <i class="bi bi-plus-lg me-1"></i> Buat Surat Jalan
        </a>
        @endif
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0" style="font-size:.85rem;">
                <thead style="background:var(--bg-subtle,#f9fafb);">
                    <tr>
                        <th>
                            <a href="{{ sortUrlSJ('No_SJ') }}" class="d-flex align-items-center gap-1"
                               style="color:inherit;text-decoration:none;">
                                No. SJ {!! sortIconSJ('No_SJ') !!}
                            </a>
                        </th>
                        <th>
                            <a href="{{ sortUrlSJ('Tanggal') }}" class="d-flex align-items-center gap-1"
                               style="color:inherit;text-decoration:none;">
                                Tanggal {!! sortIconSJ('Tanggal') !!}
                            </a>
                        </th>
                        <th>
                            <a href="{{ sortUrlSJ('No_PO') }}" class="d-flex align-items-center gap-1"
                               style="color:inherit;text-decoration:none;">
                                No. PO {!! sortIconSJ('No_PO') !!}
                            </a>
                        </th>
                        <th>Customer</th>
                        <th>Supir</th>
                        <th class="text-center" style="width:160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suratJalans as $sj)
                    <tr>
                        <td><code style="font-size:.8rem;">{{ $sj->No_SJ }}</code></td>
                        <td style="color:var(--text-muted);">{{ \Carbon\Carbon::parse($sj->Tanggal)->format('d M Y') }}</td>
                        <td>    
                            <a href="{{ route('purchase-order.show', $sj->No_PO) }}"
                               style="font-size:.8rem;color:var(--accent);text-decoration:none;">
                                {{ $sj->No_PO }}
                            </a>
                        </td>
                        <td>
                            <div style="font-size:.875rem;font-weight:500;">{{ $sj->purchaseOrder->customer->Nama ?? '-' }}</div>
                            <div style="font-size:.75rem;color:var(--text-muted);">{{ $sj->purchaseOrder->customer->PIC ?? '' }}</div>
                        </td>
                        
                        <td style="font-size:.85rem;">{{ $sj->supir->Nama_Pegawai ?? '—' }}</td>
                        <td class="text-center">
                            <a href="{{ route('surat-jalan.show', encode_id($sj->No_SJ)) }}"
                               class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if(in_array($jabatanAktif, ['Sekretaris', 'Staf', 'Manajer']))
                            <a  href="{{ route('surat-jalan.edit', encode_id($sj->No_SJ)) }}"
                               class="btn btn-sm btn-outline-secondary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('surat-jalan.destroy', encode_id($sj->No_SJ)) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus surat jalan ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4" style="color:var(--text-muted);">
                            <i class="bi bi-inbox" style="font-size:1.5rem;display:block;margin-bottom:.4rem;opacity:.4;"></i>
                            Tidak ada surat jalan yang sesuai filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($suratJalans->hasPages())
    <div class="card-footer d-flex justify-content-between align-items-center"
         style="font-size:.8rem;color:var(--text-muted);">
        <span>
            Menampilkan {{ $suratJalans->firstItem() }}–{{ $suratJalans->lastItem() }}
            dari {{ $suratJalans->total() }} surat jalan
        </span>
        {{ $suratJalans->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

{{-- Auto-submit dropdown filter --}}
<script>
document.querySelectorAll('#filterForm select').forEach(el => {
    el.addEventListener('change', () => document.getElementById('filterForm').submit());
});
</script>

@endsection