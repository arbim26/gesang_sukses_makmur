<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Customer;
use App\Models\Barang;
use App\Models\DetailInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('customer')
            ->latest('PO_Date')
            ->paginate(10);

        return view('purchase-order.index', compact('purchaseOrders'));
    }

    public function create()
    {
        return view('purchase-order.form', $this->formData());
    }

    public function store(Request $request)
    {
        $request->validate([
            'No_PO'                       => 'required|unique:purchase_orders,No_PO|max:30',
            'Id_Cust'                     => 'required|exists:customers,Id_Cust',
            'PO_Date'                     => 'required|date',
            'Delivery_date'               => 'nullable|date|after_or_equal:PO_Date',
            'Note'                        => 'nullable|string',
            'details'                     => 'required|array|min:1',
            'details.*.No_Barang'         => 'required|exists:barangs,Kode_Barang',
            'details.*.Qty'               => 'required|integer|min:1',
            'details.*.Metode'            => 'required|in:Transfer,Cash,Kredit',
        ]);

        DB::transaction(function () use ($request) {
            // Hitung Sub_Total dari detail
            [$subTotal, $detailRows] = $this->buildDetails($request->details);

            $ppn        = 11;
            $grandTotal = round($subTotal * (1 + $ppn / 100), 2);

            $po = PurchaseOrder::create([
                'No_PO'         => $request->No_PO,
                'Id_Cust'       => $request->Id_Cust,
                'PO_Date'       => $request->PO_Date,
                'Delivery_date' => $request->Delivery_date,
                'Sub_Total'     => $subTotal,
                'PPN'           => $ppn,
                'Grand_Total'   => $grandTotal,
                'Note'          => $request->Note,
            ]);

            foreach ($detailRows as $row) {
                DetailInvoice::create(array_merge($row, ['No_PO' => $po->No_PO]));
            }
        });

        return redirect()->route('purchase-order.index')
            ->with('success', 'Purchase Order berhasil dibuat.');
    }

    public function show(string $id)
    {
        $po = PurchaseOrder::with([
            'customer',
            'details.barang',
            'invoices.rekening',
            'invoices.ceo',
            'invoices.sekretaris',
            'suratJalan.supir',
        ])->findOrFail($id);

        return view('purchase-order.show', compact('po'));
    }

    public function edit(string $id)
    {
        $po = PurchaseOrder::with('details')->findOrFail($id);

        // Tidak boleh edit PO yang sudah punya Invoice
        if ($po->invoices()->exists()) {
            return redirect()->route('purchase-order.show', $id)
                ->with('error', 'Purchase Order yang sudah memiliki Invoice tidak dapat diubah.');
        }

        return view('purchase-order.form', array_merge(compact('po'), $this->formData()));
    }

    public function update(Request $request, string $id)
    {
        $po = PurchaseOrder::findOrFail($id);

        if ($po->invoices()->exists()) {
            return redirect()->route('purchase-order.show', $id)
                ->with('error', 'Purchase Order yang sudah memiliki Invoice tidak dapat diubah.');
        }

        $request->validate([
            'Id_Cust'             => 'required|exists:customers,Id_Cust',
            'PO_Date'             => 'required|date',
            'Delivery_date'       => 'nullable|date|after_or_equal:PO_Date',
            'Note'                => 'nullable|string',
            'details'             => 'required|array|min:1',
            'details.*.No_Barang' => 'required|exists:barangs,Kode_Barang',
            'details.*.Qty'       => 'required|integer|min:1',
            'details.*.Metode'    => 'required|in:Transfer,Cash,Kredit',
        ]);

        DB::transaction(function () use ($request, $po) {
            [$subTotal, $detailRows] = $this->buildDetails($request->details);

            $ppn        = 11;
            $grandTotal = round($subTotal * (1 + $ppn / 100), 2);

            $po->update([
                'Id_Cust'       => $request->Id_Cust,
                'PO_Date'       => $request->PO_Date,
                'Delivery_date' => $request->Delivery_date,
                'Sub_Total'     => $subTotal,
                'PPN'           => $ppn,
                'Grand_Total'   => $grandTotal,
                'Note'          => $request->Note,
            ]);

            // Hapus detail lama, insert ulang
            $po->details()->delete();
            foreach ($detailRows as $row) {
                DetailInvoice::create(array_merge($row, ['No_PO' => $po->No_PO]));
            }
        });

        return redirect()->route('purchase-order.show', $po->No_PO)
            ->with('success', 'Purchase Order berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $po = PurchaseOrder::withCount(['invoices', 'suratJalan'])->findOrFail($id);

        if ($po->invoices_count > 0 || $po->surat_jalan_count > 0) {
            return redirect()->route('purchase-order.index')
                ->with('error', 'Purchase Order tidak dapat dihapus karena memiliki Invoice atau Surat Jalan.');
        }

        DB::transaction(function () use ($po) {
            $po->details()->delete();
            $po->delete();
        });

        return redirect()->route('purchase-order.index')
            ->with('success', 'Purchase Order berhasil dihapus.');
    }

    // ── Helper: hitung totals & siapkan baris detail ────────
    private function buildDetails(array $details): array
    {
        $subTotal   = 0;
        $detailRows = [];

        foreach ($details as $d) {
            $barang     = Barang::findOrFail($d['No_Barang']);
            $amount     = $d['Qty'] * $barang->Unit_Price;
            $subTotal  += $amount;

            $detailRows[] = [
                'No_Barang'  => $d['No_Barang'],
                'Qty'        => $d['Qty'],
                'Unit_Price' => $barang->Unit_Price,
                'Amount'     => $amount,
                'Metode'     => $d['Metode'],
            ];
        }

        return [$subTotal, $detailRows];
    }

    private function formData(): array
    {
        return [
            'customers' => Customer::orderBy('Nama')->get(),
            'barangs'   => Barang::orderBy('Nama_Barang')->get(),
        ];
    }
}
