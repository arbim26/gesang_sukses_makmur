<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::paginate(10);
        return view('pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        return view('pegawai.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Id_Pegawai'   => 'required|unique:pegawais,Id_Pegawai|max:20',
            'Nama_Pegawai' => 'required|max:100',
            'Jabatan'      => 'required|in:CEO,Sekretaris,Supir,Staff',
        ]);

        Pegawai::create($request->only('Id_Pegawai', 'Nama_Pegawai', 'Jabatan'));

        return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $pegawai = Pegawai::with([
            'invoicesSebagaiCEO.purchaseOrder.customer',
            'invoicesSebagaiSekretaris.purchaseOrder.customer',
            'suratJalans.purchaseOrder.customer',
        ])->findOrFail($id);

        return view('pegawai.show', compact('pegawai'));
    }

    public function edit(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.form', compact('pegawai'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'Nama_Pegawai' => 'required|max:100',
            'Jabatan'      => 'required|in:CEO,Sekretaris,Supir,Staff',
        ]);

        Pegawai::findOrFail($id)->update($request->only('Nama_Pegawai', 'Jabatan'));

        return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pegawai = Pegawai::withCount([
            'invoicesSebagaiCEO',
            'invoicesSebagaiSekretaris',
            'suratJalans',
        ])->findOrFail($id);

        $terkait = $pegawai->invoices_sebagai_c_e_o_count
                 + $pegawai->invoices_sebagai_sekretaris_count
                 + $pegawai->surat_jalans_count;

        if ($terkait > 0) {
            return redirect()->route('pegawai.index')
                ->with('error', 'Pegawai tidak dapat dihapus karena masih terkait dengan data transaksi.');
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil dihapus.');
    }
}
