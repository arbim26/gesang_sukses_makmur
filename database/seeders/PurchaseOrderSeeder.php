<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PurchaseOrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('purchase_orders')->insert([
            // PO untuk invoice di foto (PT. Naura Technologi - Nov 2025)
            [
                'No_PO'         => 'PO-N-GSM/11/25/020',
                'Id_Cust'       => 'CUST-001',
                'PO_Date'       => '2025-11-20',
                'Delivery_date' => '2025-11-28',
                'Sub_Total'     => 34200000.00,
                'PPN'           => 0.00,   // sesuai invoice (tidak ada PPN)
                'Grand_Total'   => 34200000.00,
                'Note'          => 'Proses Machining: Plate Besar dan Plate Kecil',
                'attachment'    => null,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            // PO tambahan contoh
            [
                'No_PO'         => 'PO-MB-GSM/12/25/001',
                'Id_Cust'       => 'CUST-002',
                'PO_Date'       => '2025-12-01',
                'Delivery_date' => '2025-12-15',
                'Sub_Total'     => 15000000.00,
                'PPN'           => 11.00,
                'Grand_Total'   => 16650000.00,
                'Note'          => 'Bracket Custom dan Shaft Presisi',
                'attachment'    => null,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'No_PO'         => 'PO-TM-GSM/01/26/001',
                'Id_Cust'       => 'CUST-003',
                'PO_Date'       => '2026-01-05',
                'Delivery_date' => '2026-01-20',
                'Sub_Total'     => 10000000.00,
                'PPN'           => 11.00,
                'Grand_Total'   => 11100000.00,
                'Note'          => 'Dies Stamping 2 Set',
                'attachment'    => null,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ]);
    }
}
