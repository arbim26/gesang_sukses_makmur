<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\Pegawai;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with([
            'purchaseOrder.customer',
            'ceo', // Menggunakan relasi ke model pegawai
            'sekretaris',
            'rekening',
        ])->latest('tanggal_terbit')->paginate(10);

        return view('invoice.index', compact('invoices'));
    }

    public function create()
    {
        // Hanya PO yang belum punya Invoice yang bisa dipilih
        return view('invoice.form', $this->formData());
    }

    public function store(Request $request)
    {
        $request->validate([
            'No_Invoice'     => 'required|unique:invoices,No_Invoice|max:30',
            'No_PO'          => 'required|exists:purchase_orders,No_PO',
            'tanggal_terbit' => 'required|date',
            'discount'       => 'nullable|numeric|min:0|max:100',
            'Id_CEO'         => 'required|exists:pegawais,Id_Pegawai', // ID Kolom database tetap Id_CEO
            'Id_Sekretaris'  => 'required|exists:pegawais,Id_Pegawai',
            'Acc_No'         => 'required|exists:rekenings,Acc_No',
        ]);

        // Pastikan PO belum punya invoice lain
        if (Invoice::where('No_PO', $request->No_PO)->exists()) {
            return back()->withInput()
                ->withErrors(['No_PO' => 'Purchase Order ini sudah memiliki Invoice.']);
        }

        Invoice::create([
            'No_Invoice'     => $request->No_Invoice,
            'No_PO'          => $request->No_PO,
            'tanggal_terbit' => $request->tanggal_terbit,
            'discount'       => $request->discount ?? 0,
            'Id_CEO'         => $request->Id_CEO,
            'Id_Sekretaris'  => $request->Id_Sekretaris,
            'Acc_No'         => $request->Acc_No,
        ]);

        return redirect()->route('invoice.index')
            ->with('success', 'Invoice berhasil dibuat.');
    }

    public function show(string $id)
    {
        $invoice = Invoice::with([
            'purchaseOrder.customer',
            'purchaseOrder.details.barang',
            'ceo',
            'sekretaris',
            'rekening',
        ])->findOrFail($id);

        // Hitung nilai invoice dari PO (dengan diskon)
        $subTotal   = $invoice->purchaseOrder->Sub_Total;
        $ppn        = $invoice->purchaseOrder->PPN;
        $diskon     = $invoice->discount;
        $afterDisc  = $subTotal * (1 - $diskon / 100);
        $grandTotal = round($afterDisc * (1 + $ppn / 100), 2);

        return view('invoice.show', compact('invoice', 'subTotal', 'ppn', 'diskon', 'afterDisc', 'grandTotal'));
    }

    public function edit(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('invoice.form', array_merge(compact('invoice'), $this->formData($invoice->No_PO)));
    }

    public function update(Request $request, string $id)
    {
        $invoice = Invoice::findOrFail($id);

        $request->validate([
            'tanggal_terbit' => 'required|date',
            'discount'       => 'nullable|numeric|min:0|max:100',
            'Id_CEO'         => 'required|exists:pegawais,Id_Pegawai',
            'Id_Sekretaris'  => 'required|exists:pegawais,Id_Pegawai',
            'Acc_No'         => 'required|exists:rekenings,Acc_No',
        ]);

        // No_PO tidak boleh diubah setelah Invoice dibuat
        $invoice->update([
            'tanggal_terbit' => $request->tanggal_terbit,
            'discount'       => $request->discount ?? 0,
            'Id_CEO'         => $request->Id_CEO,
            'Id_Sekretaris'  => $request->Id_Sekretaris,
            'Acc_No'         => $request->Acc_No,
        ]);

        return redirect()->route('invoice.show', $invoice->No_Invoice)
            ->with('success', 'Invoice berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $invoice = Invoice::findOrFail($id);

        // Cek apakah PO sudah punya Surat Jalan
        if ($invoice->purchaseOrder->suratJalan()->exists()) {
            return redirect()->route('invoice.index')
                ->with('error', 'Invoice tidak dapat dihapus karena Purchase Order-nya sudah memiliki Surat Jalan.');
        }

        $invoice->delete();

        return redirect()->route('invoice.index')
            ->with('success', 'Invoice berhasil dihapus.');
    }

    public function print(string $id)
    {
        $invoice = Invoice::with([
            'purchaseOrder.customer',
            'purchaseOrder.details.barang',
            'ceo',
            'sekretaris',
            'rekening',
        ])->findOrFail($id);

        $subTotal   = $invoice->purchaseOrder->Sub_Total;
        $ppn        = $invoice->purchaseOrder->PPN;
        $diskon     = $invoice->discount;
        $afterDisc  = $subTotal * (1 - $diskon / 100);
        $grandTotal = round($afterDisc * (1 + $ppn / 100), 2);

        return view('invoice.invoice_print', compact('invoice', 'subTotal', 'ppn', 'diskon', 'afterDisc', 'grandTotal'));
    }

    // ── Helper ────────────────────────────────────────────────
    private function formData(?string $currentNoPO = null): array
    {
        $poQuery = PurchaseOrder::with(['customer', 'details.barang'])
            ->whereDoesntHave('invoices');

        if ($currentNoPO) {
            $poQuery->orWhere('No_PO', $currentNoPO);
        }

        return [
            'purchaseOrders'    => $poQuery->latest('PO_Date')->get(),
            // Perubahan: Mencari pegawai yang memiliki Jabatan 'Direksi' sesuai data migration baru
            'petugasDireksi'    => Pegawai::where('Jabatan', 'Direksi')->orderBy('Nama_Pegawai')->get(),
            'petugasSekretaris' => Pegawai::where('Jabatan', 'Sekretaris')->orderBy('Nama_Pegawai')->get(),
            'rekenings'         => Rekening::orderBy('Bank')->get(),
        ];
    }
}