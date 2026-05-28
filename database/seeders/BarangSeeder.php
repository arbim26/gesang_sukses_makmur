<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('barangs')->insert([
            [
                'Kode_Barang' => 'BRG-001',
                'Nama_Barang' => 'Pipa PVC 4 Inch',
                'Jenis'       => 'Material Bangunan',
                'Unit_Price'  => 85000,
                'Unit_Means'  => 'batang',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'Kode_Barang' => 'BRG-002',
                'Nama_Barang' => 'Semen Portland 50kg',
                'Jenis'       => 'Material Bangunan',
                'Unit_Price'  => 65000,
                'Unit_Means'  => 'sak',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'Kode_Barang' => 'BRG-003',
                'Nama_Barang' => 'Besi Hollow 40x40',
                'Jenis'       => 'Material Besi',
                'Unit_Price'  => 120000,
                'Unit_Means'  => 'batang',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'Kode_Barang' => 'BRG-004',
                'Nama_Barang' => 'Cat Tembok 25kg',
                'Jenis'       => 'Material Finishing',
                'Unit_Price'  => 450000,
                'Unit_Means'  => 'kaleng',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'Kode_Barang' => 'BRG-005',
                'Nama_Barang' => 'Kabel NYM 3x2.5mm',
                'Jenis'       => 'Elektrikal',
                'Unit_Price'  => 35000,
                'Unit_Means'  => 'meter',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'Kode_Barang' => 'BRG-006',
                'Nama_Barang' => 'Keramik 60x60 Putih',
                'Jenis'       => 'Material Bangunan',
                'Unit_Price'  => 95000,
                'Unit_Means'  => 'dus',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'Kode_Barang' => 'BRG-007',
                'Nama_Barang' => 'Baut Hex M12x50',
                'Jenis'       => 'Fastener',
                'Unit_Price'  => 3500,
                'Unit_Means'  => 'pcs',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'Kode_Barang' => 'BRG-008',
                'Nama_Barang' => 'Pompa Air 0.5 HP',
                'Jenis'       => 'Mekanikal',
                'Unit_Price'  => 850000,
                'Unit_Means'  => 'unit',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'Kode_Barang' => 'BRG-009',
                'Nama_Barang' => 'Triplek 12mm 244x122',
                'Jenis'       => 'Material Kayu',
                'Unit_Price'  => 175000,
                'Unit_Means'  => 'lembar',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'Kode_Barang' => 'BRG-010',
                'Nama_Barang' => 'Stop Kontak Tanam 2P',
                'Jenis'       => 'Elektrikal',
                'Unit_Price'  => 25000,
                'Unit_Means'  => 'pcs',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
