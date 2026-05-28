<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        // Setiap PO menghasilkan 1 Invoice (sesuai alur bisnis umum)
        // Discount dalam persen, Grand_Total = Sub_Total PO * (1 - discount/100) * 1.11 PPN
        $invoices = [
            [
                'No_Invoice'    => 'INV-2026-001',
                'No_PO'         => 'PO-2026-001',
                'tanggal_terbit'=> '2026-01-22',
                'discount'      => 5.00,
                'Id_CEO'        => 'CEO-001',
                'Id_Sekretaris' => 'SEK-001',
                'Acc_No'        => 'BCA-001-123456',
            ],
            [
                'No_Invoice'    => 'INV-2026-002',
                'No_PO'         => 'PO-2026-002',
                'tanggal_terbit'=> '2026-01-27',
                'discount'      => 0.00,
                'Id_CEO'        => 'CEO-001',
                'Id_Sekretaris' => 'SEK-001',
                'Acc_No'        => 'BRI-002-654321',
            ],
            [
                'No_Invoice'    => 'INV-2026-003',
                'No_PO'         => 'PO-2026-003',
                'tanggal_terbit'=> '2026-02-17',
                'discount'      => 10.00,
                'Id_CEO'        => 'CEO-001',
                'Id_Sekretaris' => 'SEK-002',
                'Acc_No'        => 'BCA-001-123456',
            ],
            [
                'No_Invoice'    => 'INV-2026-004',
                'No_PO'         => 'PO-2026-004',
                'tanggal_terbit'=> '2026-02-24',
                'discount'      => 0.00,
                'Id_CEO'        => 'CEO-001',
                'Id_Sekretaris' => 'SEK-001',
                'Acc_No'        => 'MANDIRI-003-789012',
            ],
            [
                'No_Invoice'    => 'INV-2026-005',
                'No_PO'         => 'PO-2026-005',
                'tanggal_terbit'=> '2026-03-12',
                'discount'      => 3.00,
                'Id_CEO'        => 'CEO-001',
                'Id_Sekretaris' => 'SEK-002',
                'Acc_No'        => 'BCA-001-123456',
            ],
            [
                'No_Invoice'    => 'INV-2026-006',
                'No_PO'         => 'PO-2026-006',
                'tanggal_terbit'=> '2026-03-30',
                'discount'      => 0.00,
                'Id_CEO'        => 'CEO-001',
                'Id_Sekretaris' => 'SEK-001',
                'Acc_No'        => 'BRI-002-654321',
            ],
            [
                'No_Invoice'    => 'INV-2026-007',
                'No_PO'         => 'PO-2026-007',
                'tanggal_terbit'=> '2026-04-16',
                'discount'      => 5.00,
                'Id_CEO'        => 'CEO-001',
                'Id_Sekretaris' => 'SEK-002',
                'Acc_No'        => 'MANDIRI-003-789012',
            ],
            [
                'No_Invoice'    => 'INV-2026-008',
                'No_PO'         => 'PO-2026-008',
                'tanggal_terbit'=> '2026-05-05',
                'discount'      => 0.00,
                'Id_CEO'        => 'CEO-001',
                'Id_Sekretaris' => 'SEK-001',
                'Acc_No'        => 'BCA-001-123456',
            ],
        ];

        foreach ($invoices as $inv) {
            DB::table('invoices')->insert(array_merge($inv, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
