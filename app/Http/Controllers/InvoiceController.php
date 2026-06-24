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

    public function index(Request $request)
    {
    
        $query = Invoice::with([
            'purchaseOrder.customer',
            'purchaseOrder.details',   
            'purchaseOrder.suratJalan',
            'ceo',
            'sekretaris',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('No_Invoice', 'like', "%{$search}%")
                  ->orWhere('No_PO',    'like', "%{$search}%")
                  ->orWhereHas('purchaseOrder.customer', fn($c) =>
                        $c->where('Nama', 'like', "%{$search}%")
                  );
            });
        }
    

        if ($request->filled('surat_jalan')) {
            if ($request->surat_jalan === 'ada') {
                $query->whereHas('purchaseOrder.suratJalan');
            } elseif ($request->surat_jalan === 'belum') {
                $query->whereDoesntHave('purchaseOrder.suratJalan');
            }
        }

        if ($request->filled('dari')) {
            $query->whereDate('tanggal_terbit', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_terbit', '<=', $request->sampai);
        }
    
        $ppnPersen = config('invoice.ppn', 11); 
    
        $collection = $query->get()->map(function ($inv) use ($ppnPersen) {
            $subTotal   = $inv->purchaseOrder->details->sum('Amount');
            $diskon     = $inv->purchaseOrder->Diskon ?? 0;  
            $afterDisc  = $subTotal * (1 - $diskon / 100);
            $grandTotal = $afterDisc * (1 + $ppnPersen / 100);
    

            $inv->computed_grand_total = $grandTotal;
            $inv->computed_sub_total   = $subTotal;
            $inv->computed_after_disc  = $afterDisc;
            $inv->computed_diskon      = $diskon;
            $inv->computed_ppn         = $ppnPersen;
    
            return $inv;
        });
    
        // ── FILTER GRAND TOTAL (opsional: range min/max) ─────────
        if ($request->filled('min_total')) {
            $collection = $collection->filter(
                fn($inv) => $inv->computed_grand_total >= (float) str_replace('.', '', $request->min_total)
            );
        }
        if ($request->filled('max_total')) {
            $collection = $collection->filter(
                fn($inv) => $inv->computed_grand_total <= (float) str_replace('.', '', $request->max_total)
            );
        }
    
        $sort = $request->get('sort', 'tanggal_terbit');
        $dir  = $request->dir === 'asc' ? 'asc' : 'desc';
        $desc = $dir === 'desc';
    
        $collection = match ($sort) {
            'No_Invoice'    => $collection->sortBy('No_Invoice',              SORT_NATURAL, $desc),
            'No_PO'         => $collection->sortBy('No_PO',                   SORT_NATURAL, $desc),
            'grand_total'   => $collection->sortBy('computed_grand_total',    SORT_NUMERIC, $desc),
            default         => $collection->sortBy('tanggal_terbit',          SORT_STRING,  $desc),
        };

        $perPage  = 15;
        $page     = (int) $request->get('page', 1);
        $total    = $collection->count();
        $items    = $collection->values()->forPage($page, $perPage);
    
        $invoices = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    
        return view('invoice.index', compact('invoices', 'ppnPersen'));
    }

    public function create()
    {
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