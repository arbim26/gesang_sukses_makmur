<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DetailInvoiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('detail_invoices')->insert([
            // Detail invoice sesuai foto (INV-N-GSM/11/25/020)
            [
                'No_PO'      => 'PO-N-GSM/11/25/020',
                'No_Barang'  => 'BRG-001',             // Plate Besar
                'Qty'        => 6,
                'Unit_Price' => 3000000.00,
                'Amount'     => 18000000.00,            // 6 x 3.000.000
                'Metode'     => 'Proses Machining',     // proses = metode
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'No_PO'      => 'PO-N-GSM/11/25/020',
                'No_Barang'  => 'BRG-002',             // Plate Kecil
                'Qty'        => 9,
                'Unit_Price' => 1800000.00,
                'Amount'     => 16200000.00,            // 9 x 1.800.000
                'Metode'     => 'Proses Machining',     // proses = metode
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Detail invoice kedua (PO-MB-GSM/12/25/001)
            [
                'No_PO'      => 'PO-MB-GSM/12/25/001',
                'No_Barang'  => 'BRG-003',             // Bracket Custom
                'Qty'        => 4,
                'Unit_Price' => 2500000.00,
                'Amount'     => 10000000.00,
                'Metode'     => 'Proses Machining',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'No_PO'      => 'PO-MB-GSM/12/25/001',
                'No_Barang'  => 'BRG-004',             // Shaft Presisi
                'Qty'        => 5,
                'Unit_Price' => 1000000.00,
                'Amount'     => 5000000.00,
                'Metode'     => 'Precision Part',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Detail invoice ketiga (PO-TM-GSM/01/26/001)
            [
                'No_PO'      => 'PO-TM-GSM/01/26/001',
                'No_Barang'  => 'BRG-005',             // Dies Stamping
                'Qty'        => 2,
                'Unit_Price' => 5000000.00,
                'Amount'     => 10000000.00,
                'Metode'     => 'Dies',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
