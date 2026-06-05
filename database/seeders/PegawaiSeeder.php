<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pegawais')->insert([
            [
                'Id_Pegawai' => 'IT-001',
                'password' => bcrypt('admin123'), // Password: admin123
                'remember_token' => null,
                'Nama_Pegawai' => 'Super Admin IT',
                'Jabatan' => 'Staf IT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Pegawai' => 'CEO-001',
                'password' => bcrypt('admin123'), // Password: admin123
                'remember_token' => null,
                'Nama_Pegawai' => 'Budi Santoso',
                'Jabatan' => 'Direksi',
                'created_at' => '2026-06-05 08:41:52',
                'updated_at' => '2026-06-05 08:41:52',
            ],
            [
                'Id_Pegawai' => 'MNJ-001',
                'password' => bcrypt('admin123'), // Password: admin123
                'remember_token' => null,
                'Nama_Pegawai' => 'Ahmad Fauzi',
                'Jabatan' => 'Manajer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Pegawai' => 'SEK-001',
                'password' => bcrypt('admin123'), // Password: admin123
                'remember_token' => null,
                'Nama_Pegawai' => 'Sari Dewi Anggraini',
                'Jabatan' => 'Sekretaris',
                'created_at' => '2026-06-05 08:41:52',
                'updated_at' => '2026-06-05 08:41:52',
            ],
            [
                'Id_Pegawai' => 'SEK-002',
                'password' => bcrypt('admin123'), // Password: admin123
                'remember_token' => null,
                'Nama_Pegawai' => 'Rina Kusuma',
                'Jabatan' => 'Sekretaris',
                'created_at' => '2026-06-05 08:41:52',
                'updated_at' => '2026-06-05 08:41:52',
            ],
            [
                'Id_Pegawai' => 'BND-001',
                'password' => bcrypt('admin123'), // Password: admin123
                'remember_token' => null,
                'Nama_Pegawai' => 'Citra Lestari',
                'Jabatan' => 'Bendahara',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Pegawai' => 'STF-001',
                'password' => bcrypt('admin123'), // Password: admin123
                'remember_token' => null,
                'Nama_Pegawai' => 'Wahyu Nugroho',
                'Jabatan' => 'Staf',
                'created_at' => '2026-06-05 08:41:52',
                'updated_at' => '2026-06-05 08:41:52',
            ],
            [
                'Id_Pegawai' => 'STF-002',
                'password' => bcrypt('admin123'), // Password: admin123
                'remember_token' => null,
                'Nama_Pegawai' => 'Fitri Handayani',
                'Jabatan' => 'Staf',
                'created_at' => '2026-06-05 08:41:52',
                'updated_at' => '2026-06-05 08:41:52',
            ],
            [
                'Id_Pegawai' => 'SUP-001',
                'password' => bcrypt('admin123'), // Password: admin123
                'remember_token' => null,
                'Nama_Pegawai' => 'Agus Prasetyo',
                'Jabatan' => 'Pengemudi',
                'created_at' => '2026-06-05 08:41:52',
                'updated_at' => '2026-06-05 08:41:52',
            ],
            [
                'Id_Pegawai' => 'SUP-002',
                'password' => bcrypt('admin123'), // Password: admin123
                'remember_token' => null,
                'Nama_Pegawai' => 'Hendra Wijaya',
                'Jabatan' => 'Pengemudi',
                'created_at' => '2026-06-05 08:41:52',
                'updated_at' => '2026-06-05 08:41:52',
            ],
            [
                'Id_Pegawai' => 'SUP-003',
                'password' => bcrypt('admin123'), // Password: admin123
                'remember_token' => null,
                'Nama_Pegawai' => 'Doni Firmansyah',
                'Jabatan' => 'Pengemudi',
                'created_at' => '2026-06-05 08:41:52',
                'updated_at' => '2026-06-05 08:41:52',
            ],
        ]);
    }
}