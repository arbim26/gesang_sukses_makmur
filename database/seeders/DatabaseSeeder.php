<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Urutan seeder wajib mengikuti dependency foreign key:
     *
     * 1. rekenings          → tidak ada FK
     * 2. pegawais           → tidak ada FK
     * 3. customers          → tidak ada FK
     * 4. barangs            → tidak ada FK
     * 5. purchase_orders    → FK ke customers
     * 6. invoices           → FK ke purchase_orders, pegawais, rekenings
     * 7. detail_invoices    → FK ke purchase_orders, barangs
     * 8. surat_jalans       → FK ke purchase_orders, pegawais
     */
    public function run(): void
    {
        $this->call([
            RekeningSeeder::class,
            PegawaiSeeder::class,
            CustomerSeeder::class,
            BarangSeeder::class,
            PurchaseOrderSeeder::class,
            InvoiceSeeder::class,
            DetailInvoiceSeeder::class,
            SuratJalanSeeder::class,
        ]);
    }
}
