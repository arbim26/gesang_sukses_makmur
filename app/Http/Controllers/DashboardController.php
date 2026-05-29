<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Barang;
use App\Models\SuratJalan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik jumlah
        $totalInvoice = Invoice::count();
        $totalCustomer = Customer::count();
        $totalBarang = Barang::count();
        $totalSuratJalan = SuratJalan::count();

        // Data terbaru (limit 5)
        $recentInvoices = Invoice::orderBy('tanggal_terbit', 'desc')
                                 ->orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();

        $recentSJ = SuratJalan::orderBy('Tanggal', 'desc')
                              ->orderBy('created_at', 'desc')
                              ->limit(5)
                              ->get();

        return view('dashboard', compact(
            'totalInvoice',
            'totalCustomer',
            'totalBarang',
            'totalSuratJalan',
            'recentInvoices',
            'recentSJ'
        ));
    }
}