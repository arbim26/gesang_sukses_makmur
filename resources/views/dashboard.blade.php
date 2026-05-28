@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    @php
        $stats = [
            ['icon'=>'bi-receipt','label'=>'Total Invoice','value'=>$totalInvoice ?? 0,'color'=>'#4f46e5','bg'=>'#eef2ff'],
            ['icon'=>'bi-people','label'=>'Customer','value'=>$totalCustomer ?? 0,'color'=>'#0891b2','bg'=>'#ecfeff'],
            ['icon'=>'bi-box-seam','label'=>'Barang','value'=>$totalBarang ?? 0,'color'=>'#059669','bg'=>'#ecfdf5'],
            ['icon'=>'bi-truck','label'=>'Surat Jalan','value'=>$totalSuratJalan ?? 0,'color'=>'#d97706','bg'=>'#fffbeb'],
        ];
    @endphp
    @foreach($stats as $s)
    <div class="col-sm-6 col-lg-3">
        <div class="card" style="border-color:{{ $s['bg'] }};">
            <div class="card-body p-3 d-flex align-items-center gap-3">
                <div style="width:42px;height:42px;border-radius:10px;background:{{ $s['bg'] }};
                     display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi {{ $s['icon'] }}" style="font-size:1.15rem;color:{{ $s['color'] }};"></i>
                </div>
                <div>
                    <p class="mb-0" style="font-size:.72rem;text-transform:uppercase;letter-spacing:.8px;color:#6b7280;">
                        {{ $s['label'] }}
                    </p>
                    <p class="mb-0" style="font-size:1.4rem;font-weight:600;line-height:1.2;">
                        {{ number_format($s['value']) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Recent invoices --}}
<div class="row g-3">
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header">
                <span>Invoice Terbaru</span>
                <a href="{{ route('invoice.index') }}" style="font-size:.8rem;color:var(--accent);text-decoration:none;">
                    Lihat semua →
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No. Invoice</th>
                            <th>Tanggal</th>
                            <th>Grand Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentInvoices ?? [] as $inv)
                        <tr>
                            <td>
                                <a href="{{ route('invoice.show', $inv->No_Invoice) }}"
                                   style="text-decoration:none;color:var(--accent);font-size:.85rem;">
                                    {{ $inv->No_Invoice }}
                                </a>
                            </td>
                            <td style="font-size:.85rem;">
                                {{ \Carbon\Carbon::parse($inv->Tanggal)->format('d M Y') }}
                            </td>
                            <td style="font-size:.85rem;font-weight:500;">
                                Rp {{ number_format($inv->Grand_Total, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3" style="font-size:.85rem;">
                                Belum ada invoice.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header">
                <span>Surat Jalan Terbaru</span>
                <a href="{{ route('surat-jalan.index') }}" style="font-size:.8rem;color:var(--accent);text-decoration:none;">
                    Lihat semua →
                </a>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr><th>No. SJ</th><th>Tanggal</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentSJ ?? [] as $sj)
                        <tr>
                            <td style="font-size:.85rem;"><code>{{ $sj->No_SJ }}</code></td>
                            <td style="font-size:.85rem;">
                                {{ \Carbon\Carbon::parse($sj->Tanggal)->format('d M Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted py-3" style="font-size:.85rem;">
                                Belum ada surat jalan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
