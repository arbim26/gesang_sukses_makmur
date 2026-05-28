@extends('layouts.app')
@section('title', 'Detail Customer')
@section('page-title', 'Detail Customer')

@section('content')
<div class="mb-3">
    <a href="{{ route('customer.index') }}" class="text-muted" style="font-size:.85rem;text-decoration:none;">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke daftar
    </a>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <span><i class="bi bi-people me-2"></i>Informasi Customer</span>
                <a href="{{ route('customer.edit', $customer->Id_Cust) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
            <div class="card-body">
                <dl style="font-size:.875rem;">
                    <dt class="text-muted" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">ID Customer</dt>
                    <dd><code>{{ $customer->Id_Cust }}</code></dd>

                    <dt class="text-muted mt-3" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">Nama Perusahaan</dt>
                    <dd style="font-weight:500;">{{ $customer->Nama }}</dd>

                    <dt class="text-muted mt-3" style="font-size:.7rem;text-transform:uppercase;letter-spacing:.8px;">PIC</dt>
                    <dd>{{ $customer->PIC }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span><i class="bi bi-file-earmark-text me-2"></i>Purchase Order</span>
                <span class="badge-pill" style="background:#eef2ff;color:#4f46e5;">
                    {{ $customer->purchaseOrders->count() }}
                </span>
            </div>
            <div class="card-body p-0">
                @if($customer->purchaseOrders->isEmpty())
                <p class="text-center text-muted py-4 mb-0" style="font-size:.85rem;">
                    <i class="bi bi-inbox" style="font-size:1.5rem;display:block;margin-bottom:.5rem;"></i>
                    Belum ada purchase order.
                </p>
                @else
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No PO</th>
                            <th>Tanggal</th>
                            <th>Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customer->purchaseOrders as $po)
                        <tr>
                            <td><code style="font-size:.8rem;">{{ $po->No_PO }}</code></td>
                            <td style="font-size:.85rem;">{{ $po->Tanggal ?? '-' }}</td>
                            <td style="font-size:.85rem;">{{ $po->invoices->count() }} invoice</td>
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
