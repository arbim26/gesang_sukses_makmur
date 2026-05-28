@extends('layouts.app')
@section('title', 'Detail Pegawai')
@section('page-title', 'Detail Pegawai')

@section('content')
<div class="mb-3">
    <a href="{{ route('pegawai.index') }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar
    </a>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">
                <span><i class="bi bi-person-badge me-2"></i>Informasi Pegawai</span>
                <a href="{{ route('pegawai.edit', $pegawai->Id_Pegawai) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
            <div class="card-body">
                <dl style="font-size:.875rem;">
                    <dt class="text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">ID Pegawai</dt>
                    <dd><code>{{ $pegawai->Id_Pegawai }}</code></dd>

                    <dt class="text-muted mt-3" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Nama</dt>
                    <dd style="font-weight:500;">{{ $pegawai->Nama_Pegawai }}</dd>

                    <dt class="text-muted mt-3" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Jabatan</dt>
                    <dd>
                        @php
                            $colors = [
                                'CEO'        => 'background:#fef3c7;color:#d97706;',
                                'Sekretaris' => 'background:#eef2ff;color:#4f46e5;',
                                'Supir'      => 'background:#ecfdf5;color:#059669;',
                                'Staff'      => 'background:#f3f4f6;color:#374151;',
                            ];
                        @endphp
                        <span class="badge-pill" style="{{ $colors[$pegawai->Jabatan] ?? '' }}">
                            {{ $pegawai->Jabatan }}
                        </span>
                    </dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        @if(in_array($pegawai->Jabatan, ['CEO', 'Sekretaris']))
        <div class="card mb-3">
            <div class="card-header">
                <span><i class="bi bi-receipt me-2"></i>Invoice Terkait</span>
                <span class="badge-pill" style="background:#eef2ff;color:#4f46e5;">
                    {{ $pegawai->invoicesSebagaiCEO->count() + $pegawai->invoicesSebagaiSekretaris->count() }}
                </span>
            </div>
            <div class="card-body p-0">
                @php
                    $invoices = $pegawai->Jabatan === 'CEO'
                        ? $pegawai->invoicesSebagaiCEO
                        : $pegawai->invoicesSebagaiSekretaris;
                @endphp
                @if($invoices->isEmpty())
                <p class="text-center text-muted py-3 mb-0" style="font-size:.85rem;">Belum ada invoice.</p>
                @else
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No Invoice</th>
                            <th>No PO</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices->take(10) as $inv)
                        <tr>
                            <td><code style="font-size:.8rem;">{{ $inv->No_Invoice }}</code></td>
                            <td><code style="font-size:.8rem;">{{ $inv->No_PO }}</code></td>
                            <td style="font-size:.85rem;">{{ $inv->tanggal_terbit }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
        @endif

        @if($pegawai->Jabatan === 'Supir')
        <div class="card">
            <div class="card-header">
                <span><i class="bi bi-truck me-2"></i>Surat Jalan</span>
                <span class="badge-pill" style="background:#ecfdf5;color:#059669;">
                    {{ $pegawai->suratJalans->count() }}
                </span>
            </div>
            <div class="card-body p-0">
                @if($pegawai->suratJalans->isEmpty())
                <p class="text-center text-muted py-3 mb-0" style="font-size:.85rem;">Belum ada surat jalan.</p>
                @else
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No SJ</th>
                            <th>No PO</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pegawai->suratJalans->take(10) as $sj)
                        <tr>
                            <td><code style="font-size:.8rem;">{{ $sj->No_SJ }}</code></td>
                            <td><code style="font-size:.8rem;">{{ $sj->No_PO }}</code></td>
                            <td style="font-size:.85rem;">{{ $sj->Tanggal }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
        @endif

        @if($pegawai->Jabatan === 'Staff')
        <div class="card">
            <div class="card-body text-center py-5 text-muted">
                <i class="bi bi-person-check" style="font-size:2rem;"></i>
                <p class="mt-2 mb-0">Pegawai Staff tidak memiliki transaksi langsung.</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
