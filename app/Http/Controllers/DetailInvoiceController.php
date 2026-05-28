<?php

namespace App\Http\Controllers;

// Detail Invoice (Detail PO) dikelola sepenuhnya melalui PurchaseOrderController.
// Controller ini dipertahankan agar tidak ada error jika masih ada referensi lama,
// tapi semua method redirect ke purchase-order.

use Illuminate\Http\Request;

class DetailInvoiceController extends Controller
{
    public function index(string $poId)
    {
        return redirect()->route('purchase-order.show', $poId);
    }

    public function create(string $poId)
    {
        return redirect()->route('purchase-order.edit', $poId);
    }

    public function store(Request $request, string $poId)
    {
        return redirect()->route('purchase-order.show', $poId);
    }

    public function edit(string $poId, string $detailId)
    {
        return redirect()->route('purchase-order.edit', $poId);
    }

    public function update(Request $request, string $poId, string $detailId)
    {
        return redirect()->route('purchase-order.show', $poId);
    }

    public function destroy(string $poId, string $detailId)
    {
        return redirect()->route('purchase-order.show', $poId);
    }
}
