<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    public function index()
    {
        $rekenings = Rekening::paginate(10);
        return view('rekening.index', compact('rekenings'));
    }

    public function create()
    {
        return view('rekening.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Acc_No' => 'required|unique:rekenings,Acc_No|max:30',
            'Bank'   => 'required|max:100',
            'Nama'   => 'required|max:100',
        ]);

        Rekening::create($request->only('Acc_No', 'Bank', 'Nama'));

        return redirect()->route('rekening.index')
            ->with('success', 'Rekening berhasil ditambahkan.');
    }

    public function edit(string $hash)
    {
        $rekening = Rekening::findOrFail(decode_id($hash));
        return view('rekening.form', compact('rekening'));
    }

    public function update(Request $request, string $hash)
    {
        $request->validate([
            'Bank' => 'required|max:100',
            'Nama' => 'required|max:100',
        ]);

        Rekening::findOrFail(decode_id($hash))->update($request->only('Bank', 'Nama'));

        return redirect()->route('rekening.index')
            ->with('success', 'Rekening berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $rekening = Rekening::withCount('invoices')->findOrFail($id);

        if ($rekening->invoices_count > 0) {
            return redirect()->route('rekening.index')
                ->with('error', 'Rekening tidak dapat dihapus karena masih digunakan pada Invoice.');
        }

        $rekening->delete();

        return redirect()->route('rekening.index')
            ->with('success', 'Rekening berhasil dihapus.');
    }
}
