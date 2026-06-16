<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SuratJalanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('surat_jalans')->insert([
            [
                'No_SJ'      => 'SJ-N-GSM/11/25/020',
                'No_PO'      => 'PO-N-GSM/11/25/020',
                'Tanggal'    => '2025-11-28',
                'Id_Supir'   => 'PGW-005',   // Hendra Kusuma (Pengemudi)
                'Keterangan' => 'Pengiriman Plate Besar 6 Pcs dan Plate Kecil 9 Pcs ke PT. Naura Technologi, Bekasi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'No_SJ'      => 'SJ-MB-GSM/12/25/001',
                'No_PO'      => 'PO-MB-GSM/12/25/001',
                'Tanggal'    => '2025-12-16',
                'Id_Supir'   => 'PGW-005',
                'Keterangan' => 'Pengiriman Bracket Custom 4 Pcs dan Shaft Presisi 5 Pcs ke PT. Maju Bersama',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'No_SJ'      => 'SJ-TM-GSM/01/26/001',
                'No_PO'      => 'PO-TM-GSM/01/26/001',
                'Tanggal'    => '2026-01-21',
                'Id_Supir'   => 'PGW-005',
                'Keterangan' => 'Pengiriman Dies Stamping 2 Set ke CV. Teknik Mandiri',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
