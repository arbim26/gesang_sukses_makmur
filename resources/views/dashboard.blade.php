@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    /* Hanya style minimal untuk activity dot & hover effect */
    .activity-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 5px;
    }
    .info-box {
        transition: transform .18s ease, box-shadow .18s ease;
    }
    .info-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,.08);
    }
    .quick-btn {
        display: inline-flex;
        align-items: center;
        gap: .55rem;
        padding: .55rem 1rem;
        border-radius: 8px;
        font-size: .82rem;
        font-weight: 500;
        transition: opacity .15s;
    }
    .quick-btn:hover { opacity: .85; text-decoration: none; }
    .table-small td, .table-small th {
        font-size: 0.82rem;
        padding: 0.6rem 0.75rem;
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    {{-- Info Box (Statistik) --}}
    <div class="row mb-4">
        @php
            $stats = [
                ['icon'=>'fas fa-receipt', 'label'=>'Total Invoice', 'value'=>$totalInvoice, 'color'=>'#4f46e5', 'route'=>'invoice.index'],
                ['icon'=>'fas fa-users',   'label'=>'Customer',     'value'=>$totalCustomer, 'color'=>'#0891b2', 'route'=>'customer.index'],
                ['icon'=>'fas fa-box',     'label'=>'Barang',       'value'=>$totalBarang,   'color'=>'#059669', 'route'=>'barang.index'],
                ['icon'=>'fas fa-truck',   'label'=>'Surat Jalan',  'value'=>$totalSuratJalan, 'color'=>'#d97706', 'route'=>'surat-jalan.index'],
            ];
        @endphp
        @foreach($stats as $s)
        <div class="col-md-3 col-sm-6 col-12">
            <a href="{{ route($s['route']) }}" class="text-decoration-none">
                <div class="info-box mb-3 shadow-sm p-3" style="border-left: 4px solid {{ $s['color'] }};">
                    <span class="info-box-icon" style="background: {{ $s['color'] }}20; color: {{ $s['color'] }};">
                        <i class="{{ $s['icon'] }}"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">{{ $s['label'] }}</span>
                        <span class="info-box-number">{{ number_format($s['value']) }}</span>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    {{-- Grafik: Invoice per Bulan (Bar) + Proporsi Data (Doughnut) --}}
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Invoice per Bulan</h3>
                    <div class="card-tools">
                        <span class="badge badge-secondary">12 bulan terakhir</span>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="invoiceChart" style="height:240px; width:100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Proporsi Data</h3>
                </div>
                <div class="card-body d-flex flex-column align-items-center">
                    <canvas id="pieChart" style="width:160px; height:160px;"></canvas>
                    <div class="d-flex flex-wrap justify-content-center gap-3 mt-3">
                        @php
                            $pieColors = ['#4f46e5','#0891b2','#059669','#d97706'];
                        @endphp
                        @foreach($pieLabels as $i => $label)
                        <span class="d-flex align-items-center gap-1">
                            <span style="width:12px;height:12px;border-radius:2px;background:{{ $pieColors[$i] }};"></span>
                            <small>{{ $label }}</small>
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel & Aktivitas Terbaru --}}
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Invoice Terbaru</h3>
                    <div class="card-tools">
                        <a href="{{ route('invoice.index') }}" class="btn btn-tool">Lihat semua →</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-sm table-small mb-0">
                        <thead>
                            <tr>
                                <th>No. Invoice</th>
                                <th>Tanggal</th>
                                <th>Grand Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentInvoices as $inv)
                            <tr>
                                <td>
                                    <a href="{{ route('invoice.show', encode_id($inv->No_Invoice)) }}" class="text-primary">
                                        {{ $inv->No_Invoice }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($inv->tanggal_terbit)->format('d M Y') }}</td>
                                <td>Rp {{ number_format($grandTotalPO, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">Belum ada invoice.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Surat Jalan Terbaru</h3>
                    <div class="card-tools">
                        <a href="{{ route('surat-jalan.index') }}" class="btn btn-tool">Lihat semua →</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-sm table-small mb-0">
                        <thead>
                            <tr><th>No. SJ</th><th>Tanggal</th></tr>
                        </thead>
                        <tbody>
                            @forelse($recentSJ as $sj)
                            <tr>
                                <td><code>{{ $sj->No_SJ }}</code></td>
                                <td>{{ \Carbon\Carbon::parse($sj->Tanggal)->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="text-center text-muted py-3">Belum ada surat jalan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Aktivitas Terbaru</h3>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($activityFeed as $act)
                        <div class="list-group-item d-flex align-items-start gap-2 py-2">
                            <div class="activity-dot" style="background:{{ $act['type'] === 'invoice' ? '#4f46e5' : '#0891b2' }}; margin-top:0.5rem;"></div>
                            <div class="flex-grow-1">
                                <p class="mb-0" style="font-size:0.82rem; font-weight:500;">{{ $act['label'] }}</p>
                                <small class="text-muted">{{ $act['time']->diffForHumans() }}</small>
                            </div>
                            <span class="badge" style="background:{{ $act['type'] === 'invoice' ? '#eef2ff' : '#ecfeff' }}; color:{{ $act['type'] === 'invoice' ? '#4f46e5' : '#0891b2' }};">
                                {{ $act['type'] === 'invoice' ? 'Invoice' : 'Surat Jalan' }}
                            </span>
                        </div>
                        @empty
                        <div class="list-group-item text-center text-muted py-3">Belum ada aktivitas.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Bar chart: Invoice per bulan
    const barCtx = document.getElementById('invoiceChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Jumlah Invoice',
                data: @json($chartData),
                backgroundColor: 'rgba(79,70,229,.2)',
                borderColor: '#4f46e5',
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.y} invoice`
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } }, grid: { color: 'rgba(0,0,0,.05)' } },
                x: { ticks: { font: { size: 10 } }, grid: { display: false } }
            }
        }
    });

    // Doughnut chart: Proporsi data
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: @json($pieLabels),
            datasets: [{
                data: @json($pieData),
                backgroundColor: ['#4f46e5','#0891b2','#059669','#d97706'],
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.parsed}`
                    }
                }
            },
            cutout: '60%',
        }
    });
});
</script>
@endpush