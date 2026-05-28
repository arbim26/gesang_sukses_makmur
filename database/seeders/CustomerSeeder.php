<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'Id_Cust'    => 'CUST-001',
                'Nama'       => 'PT Maju Bersama Sejahtera',
                'PIC'        => 'Bambang Suryadi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Cust'    => 'CUST-002',
                'Nama'       => 'CV Karya Mandiri',
                'PIC'        => 'Dewi Lestari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Cust'    => 'CUST-003',
                'Nama'       => 'PT Sumber Rejeki Abadi',
                'PIC'        => 'Hasan Basri',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Cust'    => 'CUST-004',
                'Nama'       => 'UD Jaya Teknik',
                'PIC'        => 'Sumarno',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Id_Cust'    => 'CUST-005',
                'Nama'       => 'PT Nusantara Konstruksi',
                'PIC'        => 'Yuliana Putri',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
