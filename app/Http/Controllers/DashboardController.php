<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Barang;
use App\Models\PurchaseOrder;
use App\Models\SuratJalan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $pegawai = Auth::guard('pegawai')->user();

        // ── Statistik ──────────────────────────────────────────────
        $totalInvoice    = Invoice::count();
        $totalCustomer   = Customer::count();
        $totalBarang     = Barang::count();
        $totalpo         = PurchaseOrder::count();
        $totalSuratJalan = SuratJalan::count();

        // ── Mengambil Grand Total dari Tabel PO ─────────────────────
        // Catatan: Ganti 'grand_total' sesuai dengan nama kolom nominal uang di database Anda
        $grandTotalPO    = PurchaseOrder::sum('grand_total'); 

        // ── Recent Invoices ────────────────────────────────────────
        $recentInvoices = Invoice::orderBy('tanggal_terbit', 'desc')
            ->take(5)
            ->get(['No_Invoice', 'tanggal_terbit']);

        // ── Recent Surat Jalan ─────────────────────────────────────
        $recentSJ = SuratJalan::orderBy('Tanggal', 'desc')
            ->take(5)
            ->get(['No_SJ', 'Tanggal']);

        // ── Grafik Invoice per Bulan (12 bulan terakhir) ───────────
        $chartLabels = [];
        $chartData   = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->translatedFormat('M Y');
            $chartData[]   = Invoice::whereYear('tanggal_terbit', $month->year)
                                    ->whereMonth('tanggal_terbit', $month->month)
                                    ->count();
        }

        // ── Pie Chart: Proporsi Dokumen (Invoice vs Surat Jalan) ───
        $pieLabels = ['Invoice', 'Surat Jalan','Total Barang','Purchase Order'];
        $pieData   = [$totalInvoice, $totalSuratJalan, $totalBarang, $totalpo];

        // ── Activity Feed (gabungan invoice + SJ terbaru) ──────────
        $invoiceActivities = Invoice::orderBy('tanggal_terbit', 'desc')
            ->take(5)
            ->get(['No_Invoice', 'tanggal_terbit'])
            ->map(fn($inv) => [
                'type'  => 'invoice',
                'label' => 'Invoice ' . $inv->No_Invoice . ' dibuat',
                'time'  => Carbon::parse($inv->tanggal_terbit),
            ]);

        $sjActivities = SuratJalan::orderBy('Tanggal', 'desc')
            ->take(5)
            ->get(['No_SJ', 'Tanggal'])
            ->map(fn($sj) => [
                'type'  => 'sj',
                'label' => 'Surat Jalan ' . $sj->No_SJ . ' dibuat',
                'time'  => Carbon::parse($sj->Tanggal),
            ]);

        $activityFeed = $invoiceActivities
            ->concat($sjActivities)
            ->sortByDesc('time')
            ->take(8)
            ->values();

        // Ditambahkan 'totalpo' dan 'grandTotalPO' agar bisa digunakan di view blade
        return view('dashboard', compact(
            'pegawai',
            'totalInvoice',
            'totalCustomer',
            'totalBarang',
            'totalpo',
            'totalSuratJalan',
            'grandTotalPO',
            'recentInvoices',
            'recentSJ',
            'chartLabels',
            'chartData',
            'pieLabels',
            'pieData',
            'activityFeed',
        ));
    }
}