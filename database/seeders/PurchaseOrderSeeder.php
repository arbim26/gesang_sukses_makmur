<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseOrderSeeder extends Seeder
{
    public function run(): void
    {
        // ── Data detail per PO ──────────────────────────────
        // [Kode_Barang, Qty, Metode]
        $poDetails = [
            'PO-2026-001' => [
                ['BRG-001', 20,  'Transfer'],
                ['BRG-002', 50,  'Transfer'],
                ['BRG-003', 10,  'Transfer'],
            ],
            'PO-2026-002' => [
                ['BRG-005', 100, 'Cash'],
                ['BRG-010', 30,  'Cash'],
            ],
            'PO-2026-003' => [
                ['BRG-004', 5,   'Kredit'],
                ['BRG-006', 20,  'Kredit'],
                ['BRG-009', 15,  'Kredit'],
            ],
            'PO-2026-004' => [
                ['BRG-008', 3,   'Transfer'],
                ['BRG-007', 200, 'Transfer'],
            ],
            'PO-2026-005' => [
                ['BRG-001', 30,  'Transfer'],
                ['BRG-002', 80,  'Transfer'],
            ],
            'PO-2026-006' => [
                ['BRG-003', 25,  'Cash'],
                ['BRG-007', 500, 'Cash'],
            ],
            'PO-2026-007' => [
                ['BRG-004', 8,   'Transfer'],
                ['BRG-006', 10,  'Transfer'],
            ],
            'PO-2026-008' => [
                ['BRG-005', 50,  'Kredit'],
                ['BRG-008', 2,   'Kredit'],
                ['BRG-010', 20,  'Kredit'],
            ],
        ];

        // Ambil harga barang
        $harga = DB::table('barangs')->pluck('Unit_Price', 'Kode_Barang');

        // ── Header PO ──────────────────────────────────────
        $pos = [
            [
                'No_PO'         => 'PO-2026-001',
                'Id_Cust'       => 'CUST-001',
                'PO_Date'       => '2026-01-10',
                'Delivery_date' => '2026-01-20',
                'Note'          => 'Pengiriman ke gudang utama Surabaya',
            ],
            [
                'No_PO'         => 'PO-2026-002',
                'Id_Cust'       => 'CUST-002',
                'PO_Date'       => '2026-01-18',
                'Delivery_date' => '2026-01-25',
                'Note'          => null,
            ],
            [
                'No_PO'         => 'PO-2026-003',
                'Id_Cust'       => 'CUST-003',
                'PO_Date'       => '2026-02-05',
                'Delivery_date' => '2026-02-15',
                'Note'          => 'Prioritas — proyek gedung kantor',
            ],
            [
                'No_PO'         => 'PO-2026-004',
                'Id_Cust'       => 'CUST-001',
                'PO_Date'       => '2026-02-14',
                'Delivery_date' => '2026-02-21',
                'Note'          => null,
            ],
            [
                'No_PO'         => 'PO-2026-005',
                'Id_Cust'       => 'CUST-004',
                'PO_Date'       => '2026-03-03',
                'Delivery_date' => '2026-03-10',
                'Note'          => 'Untuk proyek perumahan cluster B',
            ],
            [
                'No_PO'         => 'PO-2026-006',
                'Id_Cust'       => 'CUST-005',
                'PO_Date'       => '2026-03-20',
                'Delivery_date' => '2026-03-28',
                'Note'          => null,
            ],
            [
                'No_PO'         => 'PO-2026-007',
                'Id_Cust'       => 'CUST-002',
                'PO_Date'       => '2026-04-07',
                'Delivery_date' => '2026-04-14',
                'Note'          => 'Finishing interior gedung',
            ],
            [
                'No_PO'         => 'PO-2026-008',
                'Id_Cust'       => 'CUST-003',
                'PO_Date'       => '2026-04-22',
                'Delivery_date' => '2026-05-02',
                'Note'          => null,
            ],
        ];

        foreach ($pos as $po) {
            $details = $poDetails[$po['No_PO']];

            // Hitung Sub_Total dari detail
            $subTotal = 0;
            foreach ($details as [$kode, $qty]) {
                $subTotal += $harga[$kode] * $qty;
            }

            $ppn        = 11;
            $grandTotal = round($subTotal * (1 + $ppn / 100), 2);

            DB::table('purchase_orders')->insert([
                'No_PO'         => $po['No_PO'],
                'Id_Cust'       => $po['Id_Cust'],
                'PO_Date'       => $po['PO_Date'],
                'Delivery_date' => $po['Delivery_date'],
                'Sub_Total'     => $subTotal,
                'PPN'           => $ppn,
                'Grand_Total'   => $grandTotal,
                'Note'          => $po['Note'],
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            // Insert detail
            foreach ($details as [$kode, $qty, $metode]) {
                $unitPrice = $harga[$kode];
                DB::table('detail_invoices')->insert([
                    'No_PO'      => $po['No_PO'],
                    'No_Barang'  => $kode,
                    'Qty'        => $qty,
                    'Unit_Price' => $unitPrice,
                    'Amount'     => $unitPrice * $qty,
                    'Metode'     => $metode,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
