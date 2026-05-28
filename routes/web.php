<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SuratJalanController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// ── Master Data ────────────────────────────────────────────
Route::resource('pegawai',  PegawaiController::class);
Route::resource('customer', CustomerController::class);
Route::resource('barang',   BarangController::class);
Route::resource('rekening', RekeningController::class);

// ── Transaksi ──────────────────────────────────────────────
Route::resource('purchase-order', PurchaseOrderController::class);
Route::resource('invoice',        InvoiceController::class);
Route::resource('surat-jalan',    SuratJalanController::class);
