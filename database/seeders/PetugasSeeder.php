<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PetugasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pegawais')->insert([
            // CEO
            [
                'Id_Pegawai'   => 'CEO-001',
                'Nama_Pegawai' => 'Budi Santoso',
                'Jabatan'      => 'CEO',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            // Sekretaris
            [
                'Id_Pegawai'   => 'SEK-001',
                'Nama_Pegawai' => 'Sari Dewi Anggraini',
                'Jabatan'      => 'Sekretaris',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'Id_Pegawai'   => 'SEK-002',
                'Nama_Pegawai' => 'Rina Kusuma',
                'Jabatan'      => 'Sekretaris',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            // Supir
            [
                'Id_Pegawai'   => 'SUP-001',
                'Nama_Pegawai' => 'Agus Prasetyo',
                'Jabatan'      => 'Supir',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'Id_Pegawai'   => 'SUP-002',
                'Nama_Pegawai' => 'Hendra Wijaya',
                'Jabatan'      => 'Supir',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'Id_Pegawai'   => 'SUP-003',
                'Nama_Pegawai' => 'Doni Firmansyah',
                'Jabatan'      => 'Supir',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            // Staff
            [
                'Id_Pegawai'   => 'STF-001',
                'Nama_Pegawai' => 'Wahyu Nugroho',
                'Jabatan'      => 'Staff',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'Id_Pegawai'   => 'STF-002',
                'Nama_Pegawai' => 'Fitri Handayani',
                'Jabatan'      => 'Staff',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
