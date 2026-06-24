<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('barangs')->insert([
            [
                'Kode_Barang' => 'BRG-001',
                'Nama_Barang' => 'Plate Besar',
                'Jenis'       => 'Proses Machining',
                'Unit_Price'  => 3000000.00,
                'Unit_Means'  => 'Pcs',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'Kode_Barang' => 'BRG-002',
                'Nama_Barang' => 'Plate Kecil',
                'Jenis'       => 'Proses Machining',
                'Unit_Price'  => 1800000.00,
                'Unit_Means'  => 'Pcs',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'Kode_Barang' => 'BRG-003',
                'Nama_Barang' => 'Bracket Custom',
                'Jenis'       => 'Proses Machining',
                'Unit_Price'  => 2500000.00,
                'Unit_Means'  => 'Pcs',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'Kode_Barang' => 'BRG-004',
                'Nama_Barang' => 'Shaft Presisi',
                'Jenis'       => 'Precision Part',
                'Unit_Price'  => 1500000.00,
                'Unit_Means'  => 'Pcs',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'Kode_Barang' => 'BRG-005',
                'Nama_Barang' => 'Dies Stamping',
                'Jenis'       => 'Dies',
                'Unit_Price'  => 5000000.00,
                'Unit_Means'  => 'Set',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
        ]);
    }
}
