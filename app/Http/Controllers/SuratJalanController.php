<?php

namespace App\Http\Controllers;

use App\Models\SuratJalan;
use App\Models\PurchaseOrder;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class SuratJalanController extends Controller
{
    public function index()
    {
        $suratJalans = SuratJalan::with([
            'purchaseOrder.customer',
            'supir',
        ])->latest('Tanggal')->paginate(10);

        return view('surat-jalan.index', compact('suratJalans'));
    }

    public function create()
    {
        return view('surat-jalan.form', $this->formData());
    }

    public function store(Request $request)
    {
        $request->validate([
            'No_SJ'      => 'required|unique:surat_jalans,No_SJ|max:30',
            'No_PO'      => 'required|exists:purchase_orders,No_PO',
            'Tanggal'    => 'required|date',
            'Id_Supir'   => 'required|exists:pegawais,Id_Pegawai',
            'Keterangan' => 'nullable|string',
        ]);

        // PO harus sudah punya Invoice sebelum Surat Jalan dibuat
        $po = PurchaseOrder::withCount('invoices')->findOrFail($request->No_PO);
        if ($po->invoices_count === 0) {
            return back()->withInput()
                ->withErrors(['No_PO' => 'Purchase Order ini belum memiliki Invoice. Buat Invoice terlebih dahulu.']);
        }

        // Satu PO hanya boleh punya satu Surat Jalan
        if (SuratJalan::where('No_PO', $request->No_PO)->exists()) {
            return back()->withInput()
                ->withErrors(['No_PO' => 'Surat Jalan untuk Purchase Order ini sudah pernah dibuat.']);
        }

        SuratJalan::create($request->only('No_SJ', 'No_PO', 'Tanggal', 'Id_Supir', 'Keterangan'));

        return redirect()->route('surat-jalan.index')
            ->with('success', 'Surat Jalan berhasil dibuat.');
    }

    public function show(string $id)
    {
        $suratJalan = SuratJalan::with([
            'purchaseOrder.customer',
            'purchaseOrder.details.barang',
            'purchaseOrder.invoices.rekening',
            'supir',
        ])->findOrFail($id);

        return view('surat-jalan.show', compact('suratJalan'));
    }

    public function edit(string $id)
    {
        $suratJalan = SuratJalan::findOrFail($id);
        return view('surat-jalan.form', array_merge(
            compact('suratJalan'),
            $this->formData($suratJalan->No_PO)
        ));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'Tanggal'    => 'required|date',
            'Id_Supir'   => 'required|exists:pegawais,Id_Pegawai',
            'Keterangan' => 'nullable|string',
        ]);

        // No_PO tidak boleh diubah setelah SJ dibuat
        SuratJalan::findOrFail($id)->update(
            $request->only('Tanggal', 'Id_Supir', 'Keterangan')
        );

        return redirect()->route('surat-jalan.show', $id)
            ->with('success', 'Surat Jalan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        SuratJalan::findOrFail($id)->delete();

        return redirect()->route('surat-jalan.index')
            ->with('success', 'Surat Jalan berhasil dihapus.');
    }

    public function print(string $id)
    {
        $suratJalan = SuratJalan::with([
            'purchaseOrder.customer',
            'purchaseOrder.details.barang',
            'supir',
        ])->findOrFail($id);

        return view('surat-jalan.surat_jalan_print', compact('suratJalan'));
    }

    // ── Helper ─────────────────────────────────────────────────
    private function formData(?string $currentNoPO = null): array
    {
        // Hanya PO yang sudah punya Invoice dan belum punya SJ
        $poQuery = PurchaseOrder::with('customer')
            ->whereHas('invoices')
            ->whereDoesntHave('suratJalan');

        if ($currentNoPO) {
            $poQuery->orWhere('No_PO', $currentNoPO);
        }

        return [
            'purchaseOrders' => $poQuery->latest('PO_Date')->get(),
            'petugasSupir'   => Pegawai::where('Jabatan', 'Supir')->orderBy('Nama_Pegawai')->get(),
        ];
    }
}