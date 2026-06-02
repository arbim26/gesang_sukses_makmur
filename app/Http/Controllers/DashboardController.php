<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Barang;
use App\Models\SuratJalan;

class DashboardController extends Controller
{
    public function index()
    {
        $pegawai = Auth::guard('pegawai')->user();

        // Statistik
        $totalInvoice = Invoice::count();
        $totalCustomer = Customer::count();
        $totalBarang = Barang::count();
        $totalSuratJalan = SuratJalan::count();

        // Data terbaru (5 terakhir berdasarkan Tanggal)
        $recentInvoices = Invoice::orderBy('tanggal_terbit', 'desc')
            ->take(5)
            ->get(['No_Invoice', 'tanggal_terbit']);

        $recentSJ = SuratJalan::orderBy('Tanggal', 'desc')
            ->take(5)
            ->get(['No_SJ', 'Tanggal']);

        return view('dashboard', compact(
            'pegawai',
            'totalInvoice',
            'totalCustomer',
            'totalBarang',
            'totalSuratJalan',
            'recentInvoices',
            'recentSJ'
        ));
    }

}