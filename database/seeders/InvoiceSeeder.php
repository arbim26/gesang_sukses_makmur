<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('invoices')->insert([
            // Invoice sesuai foto
            [
                'No_Invoice'     => 'INV-N-GSM/11/25/020',
                'No_PO'          => 'PO-N-GSM/11/25/020',
                'tanggal_terbit' => '2025-11-28',
                'discount'       => 0.00,
                'Id_CEO'         => 'PGW-001',  // Syamsul Bahri Fitriyanto (Direksi)
                'Id_Sekretaris'  => 'PGW-002',  // Rina Agustina (Sekretaris)
                'Acc_No'         => '4205563240',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            // Invoice kedua contoh
            [
                'No_Invoice'     => 'INV-MB-GSM/12/25/001',
                'No_PO'          => 'PO-MB-GSM/12/25/001',
                'tanggal_terbit' => '2025-12-16',
                'discount'       => 5.00,
                'Id_CEO'         => 'PGW-001',
                'Id_Sekretaris'  => 'PGW-002',
                'Acc_No'         => '4205563240',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            // Invoice ketiga contoh
            [
                'No_Invoice'     => 'INV-TM-GSM/01/26/001',
                'No_PO'          => 'PO-TM-GSM/01/26/001',
                'tanggal_terbit' => '2026-01-21',
                'discount'       => 0.00,
                'Id_CEO'         => 'PGW-001',
                'Id_Sekretaris'  => 'PGW-002',
                'Acc_No'         => '1234567890',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
        ]);
    }
}
