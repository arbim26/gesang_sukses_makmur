<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pegawais')->insert([
            [
                'Id_Pegawai'     => 'PGW-001',
                'password'       => Hash::make('password123'),
                'remember_token' => null,
                'Nama_Pegawai'   => 'Syamsul Bahri Fitriyanto',
                'Jabatan'        => 'Direksi',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'Id_Pegawai'     => 'PGW-002',
                'password'       => Hash::make('password123'),
                'remember_token' => null,
                'Nama_Pegawai'   => 'Rina Agustina',
                'Jabatan'        => 'Sekretaris',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'Id_Pegawai'     => 'PGW-003',
                'password'       => Hash::make('password123'),
                'remember_token' => null,
                'Nama_Pegawai'   => 'Budi Santoso',
                'Jabatan'        => 'Manajer',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'Id_Pegawai'     => 'PGW-004',
                'password'       => Hash::make('password123'),
                'remember_token' => null,
                'Nama_Pegawai'   => 'Ahmad Fauzi',
                'Jabatan'        => 'Staf IT',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'Id_Pegawai'     => 'PGW-005',
                'password'       => Hash::make('password123'),
                'remember_token' => null,
                'Nama_Pegawai'   => 'Hendra Kusuma',
                'Jabatan'        => 'Pengemudi',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'Id_Pegawai'     => 'PGW-006',
                'password'       => Hash::make('password123'),
                'remember_token' => null,
                'Nama_Pegawai'   => 'Siti Marlina',
                'Jabatan'        => 'Bendahara',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
        ]);
    }
}
