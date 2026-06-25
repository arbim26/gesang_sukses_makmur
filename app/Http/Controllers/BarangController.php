<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::paginate(10);
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('barang.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Kode_Barang' => 'required|unique:barangs,Kode_Barang|max:20',
            'Nama_Barang' => 'required|max:100',
            'Jenis'       => 'nullable|max:50',
            'Unit_Price'  => 'required|numeric|min:0',
            'Unit_Means'  => 'nullable|max:20',
        ]);

        Barang::create($request->only('Kode_Barang', 'Nama_Barang', 'Jenis', 'Unit_Price', 'Unit_Means'));

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    public function edit(string $hash)
    {
        $barang = Barang::findOrFail(decode_id($hash));
        return view('barang.form', compact('barang'));
    }

    public function update(Request $request, string $hash)
    {
        $request->validate([
            'Nama_Barang' => 'required|max:100',
            'Jenis'       => 'nullable|max:50',
            'Unit_Price'  => 'required|numeric|min:0',
            'Unit_Means'  => 'nullable|max:20',
        ]);

        Barang::findOrFail(decode_id($hash))->update(
            $request->only('Nama_Barang', 'Jenis', 'Unit_Price', 'Unit_Means')
        );

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $barang = Barang::withCount('detailInvoices')->findOrFail($id);

        if ($barang->detail_invoices_count > 0) {
            return redirect()->route('barang.index')
                ->with('error', 'Barang tidak dapat dihapus karena sudah digunakan dalam Purchase Order.');
        }

        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}
