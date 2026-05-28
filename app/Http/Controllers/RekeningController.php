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

    public function show(string $id)
    {
        $rekening = Rekening::findOrFail($id);
        return view('rekening.show', compact('rekening'));
    }

    public function edit(string $id)
    {
        $rekening = Rekening::findOrFail($id);
        return view('rekening.form', compact('rekening'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'Bank' => 'required|max:100',
            'Nama' => 'required|max:100',
        ]);

        Rekening::findOrFail($id)->update($request->only('Bank', 'Nama'));

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
