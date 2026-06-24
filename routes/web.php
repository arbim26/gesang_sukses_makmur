<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\DetailInvoiceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SuratJalanController;
use Illuminate\Support\Facades\Route;

// ── Auth (Publik / Guest) ────────────────────────────────────────────────
Route::middleware('guest:pegawai')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/', [IndexController::class, 'index'])->name('index');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth:pegawai');


Route::middleware('auth:pegawai')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::middleware(['jabatan:Sekretaris,Bendahara,Staf,Manajer,Direksi'])->group(function () {
        Route::get('pegawai/generate-id', [PegawaiController::class, 'generateId'])->name('pegawai.generate-id');
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('rekening', RekeningController::class);

        Route::resource('customer', CustomerController::class);
        Route::resource('barang', BarangController::class);

        Route::resource('purchase-order', PurchaseOrderController::class);
        Route::get('purchase-order/{purchase_order}/detail/create',  [PurchaseOrderController::class, 'detailCreate'])->name('purchase-order.detail.create');
        Route::post('purchase-order/{purchase_order}/detail',        [PurchaseOrderController::class, 'detailStore'])->name('purchase-order.detail.store');
        Route::delete('purchase-order/{purchase_order}/detail/{detail}', [PurchaseOrderController::class, 'detailDestroy'])->name('purchase-order.detail.destroy');
        
        Route::resource('invoice', InvoiceController::class);
        Route::resource('detail-invoice', DetailInvoiceController::class);
        Route::get('invoice/{invoice}/print', [InvoiceController::class, 'print'])->name('invoice.print');
    });

    Route::middleware(['jabatan:Direksi,Pengemudi,Sekretaris,Manajer'])->group(function () {
        Route::resource('surat-jalan', SuratJalanController::class);
        Route::get('surat-jalan/{suratJalan}/print', [SuratJalanController::class, 'print'])->name('surat-jalan.print');
    });

});