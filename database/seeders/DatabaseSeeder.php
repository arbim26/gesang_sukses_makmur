<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan penting — tabel dengan FK harus di-seed setelah tabel induknya
        $this->call([
            RekeningSeeder::class,       // independen
            PegawaiSeeder::class,        // independen
            CustomerSeeder::class,       // independen
            BarangSeeder::class,         // independen
            PurchaseOrderSeeder::class,  // butuh customers + barangs (seeder ini juga insert detail_invoices)
            InvoiceSeeder::class,        // butuh purchase_orders + petugas + rekenings
            SuratJalanSeeder::class,     // butuh purchase_orders + petugas
        ]);
    }
}
