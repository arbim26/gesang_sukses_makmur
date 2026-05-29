<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SuratJalanController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ── Master Data ────────────────────────────────────────────
Route::resource('pegawai',  PegawaiController::class);
Route::resource('customer', CustomerController::class);
Route::resource('barang',   BarangController::class);
Route::resource('rekening', RekeningController::class);

// ── Transaksi ──────────────────────────────────────────────
Route::resource('purchase-order', PurchaseOrderController::class);
Route::resource('invoice',        InvoiceController::class);
Route::get('invoice/{invoice}/print', [InvoiceController::class, 'print'])->name('invoice.print');
Route::resource('surat-jalan',    SuratJalanController::class);
Route::get('surat-jalan/{suratJalan}/print', [SuratJalanController::class, 'print'])->name('surat-jalan.print');