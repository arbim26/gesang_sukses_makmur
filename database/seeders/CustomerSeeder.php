<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'Id_Cust'    => 'CUST-001',
                'Nama'       => 'PT. Naura Technologi',
                'PIC'        => 'Bapak Rahmat',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'Id_Cust'    => 'CUST-002',
                'Nama'       => 'PT. Maju Bersama',
                'PIC'        => 'Ibu Dewi Lestari',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'Id_Cust'    => 'CUST-003',
                'Nama'       => 'CV. Teknik Mandiri',
                'PIC'        => 'Bapak Joko Widodo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
