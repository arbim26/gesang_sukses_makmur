<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuratJalanSeeder extends Seeder
{
    public function run(): void
    {
        // Surat Jalan dibuat setelah Invoice diterbitkan
        // Tidak semua PO langsung ada SJ (PO-007 & PO-008 masih proses)
        $suratJalans = [
            [
                'No_SJ'      => 'SJ-2026-001',
                'No_PO'      => 'PO-2026-001',
                'Tanggal'    => '2026-01-23',
                'Id_Supir'   => 'SUP-001',
                'Keterangan' => 'Pengiriman ke gudang PT Maju Bersama Sejahtera, Jl. Raya Surabaya No.45',
            ],
            [
                'No_SJ'      => 'SJ-2026-002',
                'No_PO'      => 'PO-2026-002',
                'Tanggal'    => '2026-01-28',
                'Id_Supir'   => 'SUP-002',
                'Keterangan' => 'Pengiriman ke CV Karya Mandiri, Jl. Industri Blok C No.12',
            ],
            [
                'No_SJ'      => 'SJ-2026-003',
                'No_PO'      => 'PO-2026-003',
                'Tanggal'    => '2026-02-18',
                'Id_Supir'   => 'SUP-001',
                'Keterangan' => 'Prioritas — proyek gedung kantor PT Sumber Rejeki Abadi',
            ],
            [
                'No_SJ'      => 'SJ-2026-004',
                'No_PO'      => 'PO-2026-004',
                'Tanggal'    => '2026-02-25',
                'Id_Supir'   => 'SUP-003',
                'Keterangan' => null,
            ],
            [
                'No_SJ'      => 'SJ-2026-005',
                'No_PO'      => 'PO-2026-005',
                'Tanggal'    => '2026-03-13',
                'Id_Supir'   => 'SUP-002',
                'Keterangan' => 'Proyek perumahan cluster B — UD Jaya Teknik',
            ],
            [
                'No_SJ'      => 'SJ-2026-006',
                'No_PO'      => 'PO-2026-006',
                'Tanggal'    => '2026-03-31',
                'Id_Supir'   => 'SUP-001',
                'Keterangan' => null,
            ],
            // PO-007 dan PO-008 belum ada SJ (Invoice baru terbit)
        ];

        foreach ($suratJalans as $sj) {
            DB::table('surat_jalans')->insert(array_merge($sj, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
