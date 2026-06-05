<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    // Daftar inisial kode untuk generate ID otomatis
    private $jabatanPrefix = [
        'Staf IT'    => 'IT',
        'CEO'        => 'CEO',
        'Manajer'    => 'MNJ',
        'Sekretaris' => 'SEK',
        'Bendahara'  => 'BND',
        'Staf'       => 'STF',
        'Pengemudi'  => 'SUP', // Tetap SUP sesuai pola data awal seeder/SQL (Supir)
    ];

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
            'password'     => 'required|min:6', 
            'Jabatan'      => 'required|in:Staf IT,Direksi,Manajer,Sekretaris,Bendahara,Staf,Pengemudi',
        ]);

        // dd($request);

        $data = $request->only('Id_Pegawai', 'Nama_Pegawai', 'Jabatan');
        $data['password'] = bcrypt($request->password);

        Pegawai::create($data);

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
            'password'     => 'nullable|min:6',
            'Jabatan'      => 'required|in:Staf IT,Direksi,Manajer,Sekretaris,Bendahara,Staf,Pengemudi',
        ]);

        $pegawai = Pegawai::findOrFail($id);
        
        $data = $request->only('Nama_Pegawai', 'Jabatan');
        
        // Update password hanya jika kolom diisi pada form
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $pegawai->update($data);

        return redirect()->route('pegawai.index')
            ->with('success', 'Pegawai berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        // Proteksi Utama Backend: Cek jika ID yang akan dihapus adalah user yang sedang login
        if (auth()->check() && $id === auth()->user()->Id_Pegawai) {
            return redirect()->route('pegawai.index')
                ->with('error', 'Anda tidak diperbolehkan menghapus akun Anda sendiri yang sedang aktif digunakan.');
        }
    
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
                ->with('error', 'Pegawai tidak dapat dihapus karena masih terkait data transaksi.');
        }
    
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
    }

    /**
     * API Endpoint untuk mengambil ID Pegawai baru secara otomatis
     */
    public function generateId(Request $request)
    {
        $jabatan = $request->query('jabatan');
        
        if (!array_key_exists($jabatan, $this->jabatanPrefix)) {
            return response()->json(['id' => '']);
        }

        $prefix = $this->jabatanPrefix[$jabatan];

        // Cari ID terakhir di database yang berawalan dengan prefix terkait (Contoh: 'STF-%')
        $lastPegawai = Pegawai::where('Id_Pegawai', 'like', $prefix . '-%')
            ->orderBy('Id_Pegawai', 'desc')
            ->first();

        if ($lastPegawai) {
            // Mengambil angka urutan dari string ID (Misal 'STF-002' dipecah mengambil '002')
            $lastNumber = (int) substr($lastPegawai->Id_Pegawai, strpos($lastPegawai->Id_Pegawai, '-') + 1);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        // Format angka menjadi 3 digit (Contoh: 1 -> 001)
        $newId = $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return response()->json(['id' => $newId]);
    }
}