@extends('layouts.app')
@section('title', 'Detail Rekening')
@section('page-title', 'Detail Rekening')

@section('content')
<div class="mb-3">
    <a href="{{ route('rekening.index') }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar
    </a>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <span><i class="bi bi-bank me-2"></i>Informasi Rekening</span>
                <a href="{{ route('rekening.edit', $rekening->Acc_No) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
            <div class="card-body">
                <dl style="font-size:.875rem;">
                    <dt class="text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">No. Rekening</dt>
                    <dd><code>{{ $rekening->Acc_No }}</code></dd>

                    <dt class="text-muted mt-3" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Bank</dt>
                    <dd>
                        <span class="badge-pill" style="background:#eff6ff;color:#2563eb;">
                            {{ $rekening->Bank }}
                        </span>
                    </dd>

                    <dt class="text-muted mt-3" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Atas Nama</dt>
                    <dd style="font-weight:500;">{{ $rekening->Nama }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span><i class="bi bi-receipt me-2"></i>Invoice yang Menggunakan Rekening Ini</span>
                <span class="badge-pill" style="background:#eef2ff;color:#4f46e5;">
                    {{ $rekening->invoices->count() }}
                </span>
            </div>
            <div class="card-body p-0">
                @if($rekening->invoices->isEmpty())
                <p class="text-center text-muted py-4 mb-0" style="font-size:.85rem;">
                    <i class="bi bi-inbox" style="font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>
                    Belum ada invoice yang menggunakan rekening ini.
                </p>
                @else
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No Invoice</th>
                            <th>No PO</th>
                            <th>Tanggal</th>
                            <th>Diskon</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekening->invoices as $inv)
                        <tr>
                            <td><code style="font-size:.8rem;">{{ $inv->No_Invoice }}</code></td>
                            <td><code style="font-size:.8rem;">{{ $inv->No_PO }}</code></td>
                            <td style="font-size:.85rem;">{{ $inv->tanggal_terbit }}</td>
                            <td style="font-size:.85rem;">{{ $inv->discount }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
